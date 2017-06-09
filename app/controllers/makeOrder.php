<?php
	class makeOrder extends Controller {

		public function index() {
			if (!isset($_SESSION['user'])) {
				header("Location: /login?logout=false");
			}

			$areaModel = $this->model('AreaModel');
			$menuModel = $this->model('MenuModel');
			$makeOrderModel = $this->model('makeOrderModel');

			$areas = $areaModel->getAreas();
			$food = $makeOrderModel->getFood();
			$units = $makeOrderModel->getUnits();

			$this->view('general/menu', ['menu_items' => $menuModel->items, 'userInfo' => $_SESSION['user'] ]);
			$this->view('makeOrder/index', ['areas' => $areas, 'food' => $food, 'units' => $units ]);
			$this->view('general/footer');
			$this->view('general/copyright', ['end_date' => date('Y') + 1]);
		}

		public function addFood() {
			if ($this->validateToken()) {
				date_default_timezone_set('Europe/Amsterdam');
				$makeOrderModel = $this->model('makeOrderModel');
				if (!isset($_POST['ordername']) || trim($_POST['ordername']) == '') {
					$ordername = $makeOrderModel->getAreaName($_POST['areaSelector']) . " " . date('h:i:s');
				} else {
					$ordername = $_POST['ordername'];
				}

				$makeOrderModel->makeOrderRequest($_SESSION['user']->EMPLOYEEID, $_POST['areaSelector'], $ordername, $_POST['foodId'], $_POST['foodQuantity']);

				$this->redirect('ordersList');
			}
		}

		public function refreshUnits() {
			$makeOrderModel = $this->model('makeOrderModel');
			$allowedUnits = $makeOrderModel->getAllowedUnits($_POST['foodid']);

			$string = "<select class='form-control' id='unitSelector'>";

			foreach ($allowedUnits as $allowedUnit) {
				$string = $string . "<option value='$allowedUnit->UNIT:$allowedUnit->CONVERSIONFACTOR'>" . $allowedUnit->UNIT . "</option>";
			}

			$string = $string . "</select>";

			echo $string;
		}
		
		public function refreshUnitsNoConversion() {
			$makeOrderModel = $this->model('makeOrderModel');
			$allowedUnits = $makeOrderModel->getAllowedUnits($_POST['foodid']);

			$string = "<select class='form-control' id='unitSelector'>";

			foreach ($allowedUnits as $allowedUnit) {
				$string = $string . "<option value='$allowedUnit->UNIT'>" . $allowedUnit->UNIT . "</option>";
			}

			$string = $string . "</select>";

			echo $string;
		}
	}
?>