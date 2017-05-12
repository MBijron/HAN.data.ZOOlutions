<?PHP
	Database::SetConfigArray($db);
	
	class Database
	{
		private static $cfg;
		
		public static function Get($name)
		{
			if(isset(self::$cfg[$name]))
			{
				return self::$cfg[$name];
			}
			else
			{
				ExceptionHandler::ThrowException('Database Config Property "'.$name.'" does not exist');
			}
		}
		
		public static function setConfigArray($cfgFile)
		{
			if(!isset(self::$cfg))
			{
				self::$cfg = $cfgFile;
			}
			else
			{
				ExceptionHandler::ThrowException('Config was set allready');
			}
		}
	}
?>