<?PHP
	class MenuModel extends model
	{
		private $areaNames;
		public $items = [];
		
		public function __construct()
		{
			parent::__construct();
			// $areaNames = array($this->getAreaNames());
			$items["Area's"] = [
						'Optie 1' => 'optie1',
						'Optie 2' => 'optie2'
					];
			$this->items = $items;
		}

		public function register() {}

		public function getAreaNames() {
			$testModel = $this->model('DatabaseTestModel');
			$testModel->getAreas();
		}
	}
?>