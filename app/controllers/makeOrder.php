<?php
	class makeOrder extends Controller {

		public function index() {
			$areaModel = $this->model('AreaModel');
			$areas = $areaModel->getAreas();
			$menuModel = $this->model('MenuModel');
			$this->view('general/menu', ['menu_items' => $menuModel->items]);
			$this->view('makeOrder/index', ['areas' => $areas]);
		}

	}
?>