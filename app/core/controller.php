<?PHP
	class controller extends smartyEngine
	{
		public function __construct()
		{
			parent::__construct();
			$this->smarty->template_dir = 'app/views';
			$this->smarty->registerPlugin('function','send_not_found', [$this, 'smarty_send_not_found']);
			$this->smarty->registerPlugin('function', 'render_widget', [$this, 'smarty_render_widget']);
			$this->smarty->registerPlugin('function', 'generate_token', [$this, 'smarty_generate_token']);
			$this->smarty->registerPlugin('block', 'require_user_level', [$this, 'smarty_require_user_level']);
		}
		
		protected function model($model, $params = [])
		{
			if(file_exists('app/models/'.$model.'.php'))
			{
				require_once 'app/models/'.$model.'.php';
				$instance = new $model();
				if(method_exists($instance, 'register'))
				{
					$fct = new ReflectionMethod($instance, 'register');
				
					$minParams = $fct->getNumberOfRequiredParameters();
					$maxParams = $fct->getNumberOfParameters();
					
					if(count($params) >= $minParams && count($params) <= $maxParams)
					{
						call_user_func_array([$instance, 'register'], $params);
						return $instance;
					}
					else
					{
						if(count($params) < $minParams)
							ExceptionHandler::ThrowException('The model "app/models/'.$model.'.php" needs more parametrs to be set');
						else if(count($params) > $maxParams)
							ExceptionHandler::ThrowException('The model "app/models/'.$model.'.php" needs less parametrs to be set');
					}
				}
				else
				{
					ExceptionHandler::ThrowException('the model "app/models/'.$model.'.php" has no "register" function');
				}
			}
			else
			{
				ExceptionHandler::ThrowException('Could not load model "app/models/'.$model.'.php"');
			}
		}
		
		protected function view($view, $data = array())
		{
			if(file_exists('app/views/'.$view.'.tpl'))
			{
				foreach($data as $key => $value)
				{
					$this->smarty->assign($key, $value);
				}
				$this->smarty->display($view.'.tpl');
			}
			else
			{
				ExceptionHandler::ThrowException('Could not load view: app/views/'.$view.'.tpl');
			}
		}
		
		protected function controller($folder, $controller, $method = null, $data = [])
		{
			$folder = $folder ? rtrim($folder, ['/']) . '/' : '';
			$method = $method ? $method: Config::Get('DefaultMethod');
			if(file_exists('app/controllers/'.$folder.$controller.'.php'))
			{
				require_once 'app/controllers/'.$controller.'.php';
				$controllerName = $controller;
				$controller = new $controller();
				if(method_exists($controller, $method) && is_callable($controllerName, $method))
				{
					call_user_func_array([$controller, $method], $data);
				}
				else
				{
					$this->renderNotFound();
				}
			}
			else
			{
				$this->renderNotFound();
			}
		}
		
		protected function renderNotFound()
		{
			$controller = Config::Get('NotfoundController');
			$controllerName = $controller;
			$method = Config::Get('DefaultMethod');
			if(file_exists('app/controllers/'.$controller.'.php'))
			{
				require_once 'app/controllers'.Config::Get('NotfoundController').'.php';
				$controller = new $controller();
				if(method_exists($controller, $method) && is_callable($controllerName, $method))
				{
					call_user_func_array([$controller, $method], []);
				}
				else
				{
					ExceptionHandler::ThrowException('Default method "'.$method.'" was not found for "'.$controllerName.'"');
				}
			}
			else
			{
				ExceptionHandler::ThrowException('Default not found controller \''.$controllerName.'\' was not found');
			}
		}
		
		protected function addSubtitle($subTitle)
		{
			Config::Set('Title', Config::Get('Title') . ' | ' . $subTitle);
		}
		
		protected function setKeywords($keyWords)
		{
			Config::Set('Keywords', $keyWords);
		}
		
		protected function setDescription($description)
		{
			Config::Set('Description', $description);
		}
		
		protected function disableTemplate()
		{
			Config::Set('UseTemplate', 0);
		}
		
		protected function addCss($css)
		{
			Resources::AddCss($css);
		}
		
		protected function addJs($js)
		{
			Resources::AddJs($js);
		}
		
		protected function addLibrary($lib)
		{
			Resources::AddLib($lib);
		}
		
		public function redirect($link)
		{
			header('location: '.Config::Get('linkPrefix').$link);
		}
		
		public function validateToken()
		{
			if(isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'])
			{
				unset($_SESSION['token']);
				return true;
			}
			else
			{
				unset($_SESSION['token']);
				die(Config::Get('tokenError'));
				return false;
			}
		}
		
		public function requireUserLevel($level, $inherit = true, $redirect = false)
		{	
			if(!is_numeric($level))
			{
				ExceptionHandler::ThrowException('Require_user_level requires "level" to be a numeric');
			}
			
			//get model to check if user is logged in
			$authModel = $this->model('AuthModel');
			$userLevel = $authModel->getUserLevel();
			if(($inherrit && $userLevel >= $level) || (!$inherrit && $userLevel == $level))
			{
				return true;
			}
			else
			{
				if($redirect && !$authModel->isLoggedIn())
				{
					$this->redirect('login');
				}
			}
			return false;
		}
		
		public function smarty_render_widget($data)
		{
			if(isset($data['name']))
			{
				if(file_exists('app/widgets/'.$data['name'].'.tpl'))
				{
					foreach($data as $key=>$value)
					{
						if($key != 'name')
						{
							$this->smarty->assign($key, $value);
						}
					}
					return $this->smarty->display('app/widgets/'.$data['name'].'.tpl');
				}
				else
				{
					ExceptionHandler::ThrowException('Widget "'.$data['name'].'" was not found');
				}
			}
			else
			{
				ExceptionHandler::ThrowException('Missing param "name" for getWidgetPath');
			}
		}
		
		public function smarty_send_not_found()
		{
			http_response_code(404);
			header('HTTP/1.0 404 Not Found');
		}
		
		public function smarty_generate_token()
		{
			$token = bin2hex(openssl_random_pseudo_bytes(16));
			$_SESSION['token'] = $token;
			return '<input type="hidden" name="token" value="'.$token.'" />';
		}
		
		public function smarty_require_user_level($params, $content, $smarty, &$repeat)
		{
			if(isset($content))
			{
				//set all arguments to default values
				$level = isset($params['level'])? $params['level'] : null;
				$redirect = isset($params['redirect'])? $params['redirect'] : false;
				$inherit = isset($params['inherit'])? $params['inherit'] : true;
				$conceal = isset($params['conceal'])? $params['conceal'] : false;
				
				//check if the level argument is at least set and numeric
				if($level == null)
				{
					ExceptionHandler::ThrowException('Require_user_level requires at least "level" to be set');
				}
				if(!is_numeric($level))
				{
					ExceptionHandler::ThrowException('Require_user_level requires "level" to be a numeric');
				}
				
				//get model to check if user is logged in
				$authModel = $this->model('AuthModel');
				$hasSufficientPermissions = false;
				if($inherit)
				{
					if($authModel->getUserLevel() >= $level)
						$hasSufficientPermissions = true;
				}
				else
				{
					if($authModel->getUserLevel() == $level)
						$hasSufficientPermissions = true;
				}
				if($hasSufficientPermissions)
				{
					return $content;
				}
				else
				{
					if($redirect)
					{
						if($authModel->isLoggedIn())
						{
							if(!$conceal)
								$this->view('auth/NoSufficientPermissions');
						}
						else
						{
							$this->redirect('login');
						}
					}
					else
					{
						return '';
					}
				}
			}
		}
	}
?>