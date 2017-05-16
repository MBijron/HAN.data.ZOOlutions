<?php
	class makeOrder extends Controller {

		public function index() {
			$areaModel = $this->model('AreaModel');
			$makeOrderModel = $this->model('makeOrderModel');
			$menuModel = $this->model('MenuModel');

			$areas = $areaModel->getAreas();
			$food = $makeOrderModel->getFood();

			$this->view('general/menu', ['menu_items' => $menuModel->items]);
			$this->view('makeOrder/index', ['areas' => $areas, 'food' => $food]);
		}
	}
?>