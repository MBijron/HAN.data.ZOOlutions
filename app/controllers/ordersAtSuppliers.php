<?php
	class ordersAtSuppliers extends Controller {

		public function index() {
			if (!isset($_SESSION['user'])) {
				header("Location: /login?logout=false");
			}

			$menuModel = $this->model('MenuModel');
			$ordersAtSuppliersModel = $this->model('ordersAtSuppliersModel');

			$orders = $ordersAtSuppliersModel->getOrdersAtSuppliers();

			$this->view('general/menu', ['menu_items' => $menuModel->items]);
			$this->view('ordersAtSuppliers/index', ['orders' => $orders]);
			$this->view('general/footer');
			$this->view('general/copyright', ['end_date' => date('Y') + 1]);
		}

	}
?>