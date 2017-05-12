<?PHP
class databaseHandler
{	
	private static $db;
	
	public function __construct($engine, $host, $port, $dbname,  $username, $password)
	{
		if(!isset(self::$db))
		{
			self::$db = new PDO("sqlsrv:Server=$host;Database=$dbname", $username, $password);
		}
	}
	
	public function executeQuery($query, array $preparedArray = null)
	{
		try
		{
			if(isset($preparedArray))
			{
				$result = self::$db->prepare($query);
				$result->execute($preparedArray);
			}
			else
			{
				$result = self::$db->query($query);
			}
		}
		catch(Exception $e)
		{
			ExceptionHandler::ThrowException('Something went wrong with executing a query');
		}
		return $result;
	}
}