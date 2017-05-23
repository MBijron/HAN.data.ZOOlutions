<?PHP
	class MakeOrderModel extends model
	{		
		public function __construct()
		{
			parent::__construct();
		}
		
		public function register()
		{
			
		}

		public function getFood() {
			$query = "SELECT * FROM FOOD";
			return $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		}

		public function getUnit($foodid) {
			$query = "	SELECT UNIT FROM FOOD WHERE FOODID = ?";
			return $this->database->executeQuery($query, [$foodid])->fetchColumn();
		}

		public function makeOrderRequest($userId, $ordername, $foodId, $quantity) {
			$query = "	INSERT INTO ORDERREQUEST OUTPUT inserted.ORDERREQUESTID
						VALUES (?, GETDATE(), '0', ?)";
			$orderRequestId = $this->database->executeQuery($query, [$userId, $ordername])->fetchColumn();

			for ($i=0; $i < count($foodId); $i++) {
				$insertRows = " INSERT INTO ORDERREQUESTROW
								VALUES (?, ? ,?)";
				$this->database->executeQuery($insertRows, [$orderRequestId, $foodId[$i], $quantity[$i]]);
			}
		}

		public function getAreaName($areaId) {
			$query = "	SELECT AREANAME FROM AREA WHERE AREAID = ?";
			return $this->database->executeQuery($query, [$areaId])->fetchColumn();
		}
	}
?>