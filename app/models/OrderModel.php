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
		$query = 'SELECT * FROM ORDERREQUEST ORDer by ORDERREQUESTDATE DESC';
		$result = $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function getOrderRequest($id)
	{
		$query = 'SELECT O.*, E.FIRSTNAME, E.LASTNAME FROM ORDERREQUEST O INNER JOIN EMPLOYEE E ON O.EMPLOYEEID=E.EMPLOYEEID WHERE O.ORDERREQUESTID=?';
		$result = $this->database->executeQuery($query, [ $id ])->fetchObject();
		return $result;
	}
	
	public function getCombinedOrderRequestDetails()
	{
		$query = 'exec CombineOrderRequests';
		$result = $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function getOrderRequestDetails($id)
	{
		$query = "	SELECT B.FOODID, C.FOODNAME, C.UNIT, B.AMOUNTREQUESTED, A.AREANAME
					FROM ORDERREQUEST ORQ
						INNER JOIN ORDERREQUESTROW B ON ORQ.ORDERREQUESTID = B.ORDERREQUESTID
						INNER JOIN FOOD C ON B.FOODID = C.FOODID
						INNER JOIN EMPLOYEE E ON ORQ.EMPLOYEEID = E.EMPLOYEEID
						LEFT JOIN AREA A ON ORQ.AREAID = A.AREAID
					WHERE B.ORDERREQUESTID = ?";
		$result = $this->database->executeQuery($query, [ $id ])->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function getSuppliers()
	{
		$query = 'SELECT * FROM SUPPLIER';
		$result = $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
}
