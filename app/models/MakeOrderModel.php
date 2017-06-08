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
			$query = "	SELECT * FROM FOOD
						ORDER BY FOODNAME";
			return $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		}

		public function getUnits() {
			$query = "	SELECT UNIT FROM UNIT";
			return $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		}

		public function getAllowedUnits($foodId) {
			$query = "	SELECT AU.UNIT, U.CONVERSIONFACTOR
						FROM FOOD F
							INNER JOIN ALLOWEDUNIT AU ON F.FOODID = AU.FOODID
							INNER JOIN UNIT U ON U.UNIT = AU.UNIT
						WHERE F.FOODID = ?";
			return $this->database->executeQuery($query, [$foodId])->fetchAll(PDO::FETCH_OBJ);
		}

		public function makeOrderRequest($userId, $areaId, $ordername, $foodId, $quantity) {
			$query = "	INSERT INTO ORDERREQUEST OUTPUT inserted.ORDERREQUESTID
						VALUES (?, ?, GETDATE(), '0', ?)";
			$orderRequestId = $this->database->executeQuery($query, [$userId, $areaId, $ordername])->fetchColumn();

			for ($i=0; $i < count($foodId); $i++) {
				$insertRows = " INSERT INTO ORDERREQUESTROW
								VALUES (?, ?, 'kg', ?, 0.00)";
				$this->database->executeQuery($insertRows, [$orderRequestId, $foodId[$i], $quantity[$i]]);
			}
		}

		public function getAreaName($areaId) {
			$query = "	SELECT AREANAME FROM AREA WHERE AREAID = ?";
			return $this->database->executeQuery($query, [$areaId])->fetchColumn();
		}
	}
?>