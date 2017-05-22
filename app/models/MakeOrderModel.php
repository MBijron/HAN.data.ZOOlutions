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
	}
?>