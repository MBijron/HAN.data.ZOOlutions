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
			$query = "SELECT AREAID, UPPER(LEFT(AREANAME,1))+LOWER(SUBSTRING(AREANAME,2,LEN(AREANAME))) AS AREANAME FROM AREA ORDER BY AREANAME";
			return $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		}
	}
?>