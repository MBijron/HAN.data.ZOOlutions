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
		
		public function showDatabase()
		{
			krumo($this->database->executeQuery('SELECT * FROM ANIMAL')->fetchAll(PDO::FETCH_OBJ));
			die();
		}


		public function getAreas() {
			krumo($this->database->executeQuery('SELECT * FROM AREA')->fetchAll(PDO::FETCH_OBJ));
		}
	}
?>