<?php
	class makeOrder extends Controller {

		public function index() {
			if (isset($_GET['test'])) {
				echo "HALOOOOAOFAOSFOAF";
			}

			$areaModel = $this->model('AreaModel');
			$makeOrderModel = $this->model('makeOrderModel');
			$menuModel = $this->model('MenuModel');

			$areas = $areaModel->getAreas();
			$food = $makeOrderModel->getFood();

			$this->view('general/menu', ['menu_items' => $menuModel->items]);
			$this->view('makeOrder/index', ['areas' => $areas, 'food' => $food]);
		}

		public function getUnit() {
			$makeOrderModel = $this->model('makeOrderModel');
			echo $makeOrderModel->getUnit($_POST['foodid']);
		}

		// public function addFood() {
		// 	// $foodArray[] = [ 'foodId' => $_POST['foodid'], 'foodname' => $_POST['quantity'] ];
		// 	$foodArray = ['foodid' => 1];
		// 	return "<select name='color4' size='5'>
		// 				foreach ($foodArray as $key => $value) {
		// 					<option value='$key'>$value</option>
		// 				}
		// 			</select>";
		// }
	}
?>