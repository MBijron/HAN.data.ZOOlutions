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

			$this->view('general/menu', ['menu_items' => $menuModel->items]);
			$this->view('makeOrder/index', ['areas' => $areas, 'food' => $food]);
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

				$makeOrderModel = $this->model('makeOrderModel');
				$makeOrderModel->makeOrderRequest($_SESSION['user']->EMPLOYEEID, $ordername, $_POST['foodId'], $_POST['foodQuantity']);

				$this->redirect('ordersList');
			}
		}

		public function getUnit() {
			$makeOrderModel = $this->model('makeOrderModel');
			echo $makeOrderModel->getUnit($_POST['foodid']);
		}
	}
?>