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
			$authModel = $this->model('AuthModel');
			if($authModel != null && $authModel->isLoggedIn() && $authModel != '')
			{
				if($_SESSION['user']->ROLENAME == 'Vet')
				{
					$items = [
					"Areas" => $areaNames
					];
				}
				else if($_SESSION['user']->ROLENAME == 'Administration')
				{
					$items = [
					"Areas" => $areaNames,
					'Orders list' => 'ordersList',
					'Orders at Suppliers' => 'ordersAtSuppliers'
					];
				}
				else if($_SESSION['user']->ROLENAME == 'Keeper')
				{
					$items = [
					"Areas" => $areaNames,
					'Orders list' => 'ordersList',
					'Orders at Suppliers' => 'ordersAtSuppliers'
					];
				}
				else if($_SESSION['user']->ROLENAME == 'Headkeeper')
				{
					$items = [
					"Areas" => $areaNames,
					'Make Order' => 'makeOrder',
					'Orders list' => 'ordersList',
					'Orders at Suppliers' => 'ordersAtSuppliers'
					];
				}
				else
				{
					$items = [
					"Areas" => $areaNames,
					'Make Order' => 'makeOrder',
					'Orders list' => 'ordersList',
					'Orders at Suppliers' => 'ordersAtSuppliers'
					];
				}
			}
			
			$this->items = $items;
		}
	}
?>