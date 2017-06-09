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
			$AreaModel = $this->model('AreaModel');
			return $AreaModel->getAreas();
		}

		public function showAreas() {
			$areas = $this->getAreaNames();

			foreach ($areas as $obj) {
				$areaNames["Animals/$obj->AREANAME"] = "$obj->AREANAME";
			}

			$items = [
				"Areas" => $areaNames,
				'Make Order' => 'makeOrder',
				'Orders list' => 'ordersList',
				'Orders at Suppliers' => 'ordersAtSuppliers'
			];
			$this->items = $items;
		}
	}
?>