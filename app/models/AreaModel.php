<?PHP
	class AreaModel extends model
	{
		public $items = [];
		
		public function __construct()
		{
			parent::__construct();
		}
		
		public function register()
		{
			
		}

		public function getAreas() {
			$query = "SELECT * FROM AREA";
			return $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		}
	}
?>