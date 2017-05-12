<?PHP
	class App
	{
		protected $folder;
		
		protected $controller;
		
		protected $method;
		
		protected $params = array();
		
		protected $isError = false;
			
		public function __construct()
		{
			$this->controller = Config::Get('NotfoundController');
			$this->method = Config::Get('DefaultMethod');
			
			//parse the raw url redirected by .htaccess
			$url = $this->parseURL();
			
			//if no controller is given, use home
			if(!isset($url[0]))
			{
				$this->controller = Config::Get('DefaultController');
				$this->controller = strtolower($this->controller);
			}
			
			//convert url[0] to lowercase (the controller or folder)
			$url[0] = strtolower($url[0]);
			
			//check if folder exists in controllers
			if(file_exists('app/controllers/'.$url[0]) && is_dir('app/controllers/'.$url[0]))
			{
				$this->folder = $url[0] . '/';
				unset($url[0]);
				$url = $url ? array_values($url) : [ Config::Get('DefaultController') ];
			}
			
			//convert url[0] to lowercase (the controller), also convert url[1] to lowercase (the method)
			if(isset($url[0])) $url[0] = strtolower($url[0]);
			if(isset($url[1])) $url[1] = strtolower($url[1]);
			
			//check if controller needs rewriting
			foreach(Config::Get('RewriteControllers') as $name => $new)
			{
				if($url[0] == $name)
				{
					$url[0] = $new;
				}
			}
			
			//if controller is given, and the controller exists, use it.
			if(file_exists('app/controllers/'.$this->folder.$url[0].'.php'))
			{
				if(Config::Get('UseAuthSystem') == 1)
				{
					$this->controller = $url[0];
					unset($url[0]);
				}
				else if($url[0] != 'login' && $url[0] != 'logout')
				{
					$this->controller = $url[0];
					unset($url[0]);
				}
			}
			
			//check if controller is the NotfoundController (set in the config.php)
			if($this->controller == Config::Get('NotfoundController'))
			{
				$this->isError = true;
				$this->folder = '';
			}
			
			$controllerName = $this->controller;
			
			//load in the controller and create an instance of it
			require_once 'app/controllers/'.$this->folder.$this->controller.'.php';
			$this->controller = new $this->controller();
			
			//check if a method is given, if not the default is index
			if(isset($url[1]) && method_exists($this->controller, $url[1]) && is_callable($controllerName, $url[1]))
			{
				$this->method = $url[1];
				unset($url[1]);
			}
			else if(!method_exists($this->controller, Config::Get('DefaultMethod'))) //check if the default index method exists
			{
				die('Could not find default method in controller: ' . Config::Get('DefaultMethod'));
			}
			
			//set the left over parameters
			$this->params = $url ? array_values($url) : [];
			
			//check if left over parameters is not smaller than the number of required parameters, and not bigger than the max number of passed parameters
			if(!$this->isError)
			{
				$fct = new ReflectionMethod($this->controller, $this->method);
				
				$minParams = $fct->getNumberOfRequiredParameters();
				$maxParams = $fct->getNumberOfParameters();
							
				if(count($this->params) < $minParams || count($this->params) > $maxParams)
				{
					require_once 'app/controllers/'.Config::Get('NotfoundController').'.php';
					$this->controller = Config::Get('NotfoundController');
					$this->controller = new $this->controller();
					$this->method = Config::Get('DefaultMethod');
				}
			}
		}
		
		public function Run()
		{
			//stop outputting html/php and put it in a buffer
			ob_start();
			//call the controller with the method and parameters
			call_user_func_array([$this->controller, $this->method], $this->params);
			//get all buffered contents and stop buffering
			$content = ob_get_contents();
			ob_end_clean();
			//check if should be using a template
			if(Config::Get('UseTemplate') == 1)
			{
				//use template
				$template = new template(Config::Get('Template'));
				$template->render($content);
			}
			else
			{
				//dont use template and just echo everything (used for some modules)
				echo $content;
			}
			//create a template and render it using the content
		}
		
		//remove last '/' if it's there, sanitize the url (remove illegal characters), and right split it on '/'
		protected function parseURL()
		{
			if(isset($_GET['framework_redirected_url_string']))
			{
				return $url = explode('/', filter_var(rtrim($_GET['framework_redirected_url_string'], '/'), FILTER_SANITIZE_URL));
			}
		}
	}
?>