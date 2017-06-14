<?PHP
	class ordersList extends Controller
	{	
		public function index()
		{
			$menuModel = $this->model('MenuModel');
			$orderModel = $this->model('OrderModel');
			$combinedOrderModel = $this->model('OrderCombinedModel');
			$this->view('general/menu', ['menu_items' => $menuModel->items, 'userInfo' => $_SESSION['user']]);
			$this->view('general/backtotop');
			$this->view('orders/orderlist', ['orderrequests' => $orderModel->getOrderRequests(), 'can_combine_orders' => $combinedOrderModel->canCombineOrders()]);
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
				$orderCombinedModel = $this->model('OrderCombinedModel');
				$sortedPostData = $orderCombinedModel->sortPostData();
				$orderArray = $orderCombinedModel->getSupplierList($sortedPostData);
				//krumo($sortedPostData);
				//krumo($orderArray);
				
				foreach($orderArray as $supplier => $itemsAtDate)
				{
					foreach($itemsAtDate as $items)
					{
						//krumo($items);
						$orderCombinedModel->createOrder($supplier, $items);
					}
					//$orderCombinedModel->createOrder($name, $items);
				}
				//die();
				$orderCombinedModel->RemoveFoodFromOrderRequest($sortedPostData);
				$this->redirect('ordersAtSuppliers');
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
