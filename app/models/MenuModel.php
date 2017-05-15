<?PHP
	class MenuModel extends model
	{
		public $items = [];
		
		public function __construct()
		{
			parent::__construct();

			$this->showAreas();
		}

		public function register() {}

		public function getAreaNames() {
			$testModel = $this->model('DatabaseTestModel');
			return $testModel->getAreas();
		}

		public function showAreas() {
			$areas = $this->getAreaNames();

			foreach ($areas as $obj) {
				$areaNames["Animals/$obj->AREANAME"] = "$obj->AREANAME";
			}

			$items = [
				"Area's" => $areaNames,
				'Make Order' => 'makeOrder',
				'Invoices' => 'invoices',
				'Orders list' => 'ordersList',
				'Orders at Suppliers' => 'ordersAtSuppliers'
			];
			$this->items = $items;
		}
	}
?>