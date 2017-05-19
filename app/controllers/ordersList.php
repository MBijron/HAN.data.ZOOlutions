<?PHP
	class ordersList extends Controller
	{	
		public function index()
		{
			$menuModel = $this->model('MenuModel');
			$orderModel = $this->model('OrderModel');
			$this->view('general/menu', ['menu_items' => $menuModel->items]);
			$this->view('general/backtotop');
			$this->view('orders/orderlist', ['orderrequests' => $orderModel->getOrderRequests()]);
			$this->view('general/footer');
			$this->view('general/copyright', ['end_date' => date('Y') + 1]);
		}
		
		public function test()
		{
			krumo($_POST);
			die();
		}
	}
