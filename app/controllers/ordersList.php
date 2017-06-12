<?PHP
	class ordersList extends Controller
	{	
		public function index()
		{
			$menuModel = $this->model('MenuModel');
			$orderModel = $this->model('OrderModel');
			$this->view('general/menu', ['menu_items' => $menuModel->items, 'userInfo' => $_SESSION['user']]);
			$this->view('general/backtotop');
			$this->view('orders/orderlist', ['orderrequests' => $orderModel->getOrderRequests()]);
			$this->view('general/footer');
			$this->view('general/copyright', ['end_date' => date('Y') + 1]);
		}
		
		public function details($id)
		{
			$menuModel = $this->model('MenuModel');
			$orderModel = $this->model('OrderModel');
			$this->view('general/menu', ['menu_items' => $menuModel->items, 'userInfo' => $_SESSION['user']]);
			$this->view('general/backtotop');
			$this->view('orders/orderdetails', ['orderrequestrows' => $orderModel->getOrderRequestDetails($id), 'orderrequest' => $orderModel->getOrderRequest($id)]);
			$this->view('general/footer');
			$this->view('general/copyright', ['end_date' => date('Y') + 1]);
		}
		
		public function combined()
		{
			if(isset($_POST) && count($_POST) > 0)
			{
				$roleModel = $this->model('RoleModel');
				$orderCombinedModel = $this->model('OrderCombinedModel');
				$sortedPostData = $orderCombinedModel->sortPostData();
				$orderArray = $orderCombinedModel->getSupplierList($sortedPostData);

				// $orderCombinedModel->RemoveFoodFromOrderRequest($sortedPostData);

				foreach($orderArray as $name => $items)
				{
					$orderCombinedModel->createOrder($name, $items);
				}

				$orderCombinedModel->RemoveFoodFromOrderRequest($sortedPostData);
			}

			$menuModel = $this->model('MenuModel');
			$orderModel = $this->model('OrderModel');
			$this->view('general/menu', ['menu_items' => $menuModel->items, 'userInfo' => $_SESSION['user']]);
			$this->view('general/backtotop');
			$this->view('orders/combinedorders', ['orderrequests' => $orderModel->getCombinedOrderRequestDetails(), 'suppliers' => $orderModel->getSuppliers(), 'orderdate' => date('Y-m-d', strtotime(date('Y-m-d') . ' +1 Weekday'))]);
			$this->view('general/footer');
			$this->view('general/copyright', ['end_date' => date('Y') + 1]);
		}
	}
