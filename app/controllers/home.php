<?PHP
	class Home extends Controller
	{	
		public function index($name = '', $otherName = '')
		{
			$this->addLibrary('owl carousel');
			$menuModel = $this->model('MenuModel');
			$this->view('general/menu', ['menu_items' => $menuModel->items]);
			$this->view('general/slider');
			// $this->view('general/backtotop');
			// $this->view('home/index');
			// $this->view('general/footer');
			// $this->view('general/copyright', ['end_date' => date('Y') + 1]);
		}
	}
?>