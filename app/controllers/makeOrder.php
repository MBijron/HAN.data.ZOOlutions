<?php
	class makeOrder extends Controller {

		public function index() {
			if (!isset($_SESSION['user'])) {
				header("Location: /login?logout=false");
			}

			$ordername = "";

			$areaModel = $this->model('AreaModel');
			$makeOrderModel = $this->model('makeOrderModel');
			$menuModel = $this->model('MenuModel');

			$areas = $areaModel->getAreas();
			$food = $makeOrderModel->getFood();


			if (isset($_POST['submitOrder'])) {
				date_default_timezone_set('Europe/Amsterdam');

				if (!isset($_POST['ordername']) || trim($_POST['ordername']) == '') {
					$ordername = $makeOrderModel->getAreaName($_POST['areaSelector']) . " " . date('h:i:s');
				} else {
					$ordername = $_POST['ordername'];
				}

				$makeOrderModel->makeOrderRequest($_SESSION['user']->EMPLOYEEID, $ordername, $_POST['foodId'], $_POST['foodQuantity']);

				header("location: /ordersList");
			}
			

			$this->view('general/menu', ['menu_items' => $menuModel->items]);
			$this->view('makeOrder/index', ['areas' => $areas, 'food' => $food]);
		}

		public function getUnit() {
			$makeOrderModel = $this->model('makeOrderModel');
			echo $makeOrderModel->getUnit($_POST['foodid']);
		}
	}
?>