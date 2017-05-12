<?PHP
	class template extends smartyEngine
	{
		protected $template;
		private $specialVars;
		
		public function __construct($template)
		{
			parent::__construct();
			if(file_exists('app/templates/'.$template.'.tpl'))
			{
				$this->template = $template;
			}
			else
			{
				ExceptionHandler::ThrowException('template app/templates/'.$template.'.tpl was not found');
			}
			$this->smarty->template_dir = 'app/templates';
			$this->smarty->assign('title', Config::Get('Title'));
			$this->smarty->assign('keywords', Config::Get('Keywords'));
			$this->smarty->assign('description', Config::Get('Description'));
			$this->smarty->assign('css', $this->renderCss());
			$this->smarty->assign('js', $this->renderJs());
			$this->smarty->assign('library_files', $this->renderLibs());
			$this->initSpecvars();
		}
		
		private function initSpecvars()
		{
			$this->specialVars = [
				'PHP_GENERATE_TIME' => function()
				{
					$time = explode(' ', microtime());
					$time = $time[1] + $time[0];
					$total_time = round(($time - START_PAGE_GENERATION), 4);
					return $total_time;
				}
			];
		}
		
		private function renderLibs()
		{
			$content = '';
			foreach(Resources::LibraryBundle() as $library)
			{
				foreach(Resources::getLibraryResources($library) as $lib => $type)
				{
					$link = Config::Get('linkPrefix').'public/libraries/'.$lib;
					$link = str_replace(' ', '%20', $link);
					switch($type)
					{
					case 'css':
						$content .= '<link rel="stylesheet" type="text/css" href="'.$link.'">';
					break;
					case 'js':
						$content .= '<script src="'.$link.'"></script>';
					break;
					default:
						ExceptionHandler::ThrowException('type "'.$type.'" for "'.$lib.'" is not known');
					}
				}
			}
			return $content;
		}
		
		private function renderCss()
		{
			$content = '';
			foreach(Resources::CssBundle() as $css)
			{
				$link = Config::Get('linkPrefix').'public/css/'.$css.'.css';
				$link = str_replace(' ', '%20', $link);
				$content .= '<link rel="stylesheet" type="text/css" href="'.$link.'">';
			}
			return $content;
		}
		
		private function renderJs()
		{
			$content = '';
			foreach(Resources::JsBundle() as $js)
			{
				$link = Config::Get('linkPrefix').'public/js/'.$js.'.js';
				$link = str_replace(' ', '%20', $link);
				$content .= '<script src="'.$link.'"></script>';
			}
			return $content;
		}

		public function render($content)
		{
			$this->smarty->assign('content', $content);
			$output = $this->smarty->fetch($this->template.'.tpl');
			foreach($this->specialVars as $name => $replacement)
			{
				$output = str_replace('['.$name.']', $replacement(), $output);
			}
			echo $output;
		}
	}
?>