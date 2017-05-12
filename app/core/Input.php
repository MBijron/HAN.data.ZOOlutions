<?PHP
class Input
{
	public static function Get($name)
	{
		if(isset($_GET[$name]))
		{
			return filter_var($_GET[$name], FILTER_SANITIZE_STRING);
		}
		else
		{
			ExceptionHandler::ThrowException('Get variable "'.$name.'" does not exist');
		}
	}
	
	public static function Post($name)
	{
		if(isset($_POST[$name]))
		{
			return filter_var($_POST[$name], FILTER_SANITIZE_STRING);
		}
		else
		{
			ExceptionHandler::ThrowException('Post variable "'.$name.'" does not exist');
		}
	}
}