<?PHP
class OrderModel extends model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function register()
	{
		
	}
	
	public function getOrderRequests()
	{
		$query = 'SELECT * FROM ORDERREQUEST';
		$result = $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
}
