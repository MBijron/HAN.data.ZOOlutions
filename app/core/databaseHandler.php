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
			//$authModel = $this->model('AuthModel');
			//if($authModel != null && $authModel->isLoggedIn() && $authModel != '')
			//{
			//	$query = "EXECUTE AS USER = '" . $_SESSION['user']->EMAILADDRESS . "' " . $query;
			//}
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
	
	protected function model($model)
	{
		if(file_exists('app/models/'.$model.'.php'))
		{
			require_once 'app/models/'.$model.'.php';
			return new $model();
		}
		else
		{
			ExceptionHandler::ThrowException('Could not load model: app/models/'.$model.'.php');
		}
	}
}