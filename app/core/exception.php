<?PHP
class ExceptionHandler
{
	public static function ThrowException($message, $ignoreFirstCall = false)
	{
		$backtrace = debug_backtrace();
		if(count($backtrace) > 1 && !$ignoreFirstCall)
		{
			$content = $message . ' in <b>' . $backtrace[1]['file'] . '</b> on line <b>'. $backtrace[1]['line'] . '</b>';
			/* for($i = 2; $i < count($backtrace); $i++)
			{
				$content .= '</ br>    in <b>' . $backtrace[$i]['file'] . '</b> on line <b>'. $backtrace[$i]['line'] . '</b>';
			} */
			die($content);
		}
		else
		{
			$content = $message . ' in <b>' . $backtrace[0]['file'] . '</b> on line <b>'. $backtrace[0]['line'] . '</b>';
			die($content);
		}
	}
}