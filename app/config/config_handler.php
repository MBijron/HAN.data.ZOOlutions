<?PHP
	//$GLOBALS['cfg'] = $cfg;
	
	Config::SetConfigArray($cfg);
		
	class Config
	{
		private static $cfg;
		private static $langArray;
		
		public static function Get($name)
		{
			if(isset(self::$cfg[$name]))
			{
				return self::$cfg[$name];
			}
			else
			{
				ExceptionHandler::ThrowException('Config Property "'.$name.'" does not exist.');
			}
		}
		
		public static function Set($name, $value)
		{
			self::$cfg[$name] = $value;
		}
		
		public static function Translate($item)
		{
			if(!isset(self::$langArray))
			{
				require_once('app/lang/'.self::Get('lang').'.php');
				self::$langArray = $lang;
			}
			if(isset(self::$langArray[$item]))
			{
				return self::$langArray[$item];
			}
			return $item;
		}
		
		public static function setConfigArray($cfgFile)
		{
			if(!isset(self::$cfg))
			{
				self::$cfg = $cfgFile;
			}
			else
			{
				ExceptionHandler::ThrowException('Config was set allready.');
			}
		}
	}
?>