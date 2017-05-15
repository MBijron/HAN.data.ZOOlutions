<?PHP
	class DatabaseTestModel extends model
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
			return $this->database->executeQuery('SELECT * FROM AREA')->fetchAll(PDO::FETCH_OBJ);
		}
	}
?>