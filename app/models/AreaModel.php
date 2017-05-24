<?PHP
	class AreaModel extends model
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		public function register()
		{
			
		}

		public function getAreas() {
			$query = "	SELECT * FROM AREA
						ORDER BY AREANAME";
			return $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		}
	}
?>