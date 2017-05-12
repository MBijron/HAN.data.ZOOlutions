<?PHP
	Resources::setJsBundle($js_bundle);
	Resources::setCssBundle($css_bundle);
	Resources::setLibBundle($library_bundle);
	Resources::LibraryBundle();
		
	foreach(Resources::CssBundle() as $css)
	{
		if(!file_exists('public/css/'.$css.'.css'))
		{
			ExceptionHandler::ThrowException('Could not find resource: /public/css/'.$css.'.css', true);
		}
	}
	foreach(Resources::JsBundle() as $js)
	{
		if(!file_exists('public/js/'.$js.'.js'))
		{
			ExceptionHandler::ThrowException('Could not find resource: /public/js/'.$js.'.js', true);
		}
	}
	foreach(Resources::LibraryBundle() as $lib)
	{
		if(!file_exists('public/libraries/'. $lib))
		{
			ExceptionHandler::ThrowException('Could not find library: /public/libraries/'.$lib, true);
		}
	}
	
	class Resources
	{
		private static $js;
		private static $css;
		private static $lib;
		
		public static function CssBundle()
		{
			return self::$css;
		}
		
		public static function JsBundle()
		{
			return self::$js;
		}
		
		public static function LibraryBundle()
		{
			return self::$lib;
		}
		
		public static function getLibraryResources($lib)
		{
			$dir = 'public/libraries/'.$lib;
			if(!file_exists($dir.'/items.xml'))
			{
				ExceptionHandler::ThrowException('library "'.$lib.'" is missing items.xml at root level<br />' . $dir.'/items.xml');
			}
			$items = [];
			$reader = new XmlReader();
			if(!$reader->open($dir.'/items.xml'))
			{
				ExceptionHandler::ThrowException('Failed to open file!');
			}
			$reader->read();
			$reader->read();
			while($reader->next('item'))
			{
				if(!file_exists($dir.'/'.$reader->readString()))
				{
					ExceptionHandler::ThrowException('library file "'.$dir.'/'.$reader->readString().'" inside library "'. $lib.'" was not found');
				}
				if($reader->getAttribute('type') == null)
				{
					ExceptionHandler::ThrowException('file "'.$dir.'" has no attribute type in the xml for library "'.$lib.'"');
				}
				$items[$lib.'/'.$reader->readString()] = $reader->getAttribute('type');
			}
			return $items;
		}
		
		public static function AddLib($lib)
		{
			if(!file_exists('public/libraries/'. $lib))
			{
				ExceptionHandler::ThrowException('Could not find library: /public/libraries/'.$lib);
			}
			array_push(self::$lib, $lib);
		}
		
		public static function AddJs($js)
		{
			if(!file_exists('public/js/'.$js.'.js'))
			{
				ExceptionHandler::ThrowException('Could not find resource: /public/js/'.$js.'.js');
			}
			array_push(self::$js, $js);
			return self;
		}
		
		public static function AddCss($css)
		{
			if(!file_exists('public/css/'.$css.'.css'))
			{
				ExceptionHandler::ThrowException('Could not find resource: /public/css/'.$css.'.css');
			}
			array_push(self::$css, $css);
			return self;
		}
		
		public static function setJsBundle($jsFile)
		{
			if(!isset(self::$js))
			{
				self::$js = $jsFile;
			}
			else
			{
				ExceptionHandler::ThrowException('js bundle was set allready');
			}
		}
		
		public static function setCssBundle($cssFile)
		{
			if(!isset(self::$css))
			{
				self::$css = $cssFile;
			}
			else
			{
				ExceptionHandler::ThrowException('css bundle was set allready');
			}
		}
		
		public static function setLibBundle($library)
		{
			if(!isset(self::$lib))
			{
				self::$lib = $library;
			}
			else
			{
				ExceptionHandler::ThrowException('library bundle was set allready');
			}
		}
	}
?>