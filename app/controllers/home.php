<?PHP
	class Home extends Controller
	{	
		public function index($name = '', $otherName = '')
		{
			if (!isset($_SESSION['user'])) {
				header("Location: /login?logout=false");
			} else {
				$this->addLibrary('owl carousel');
				$menuModel = $this->model('MenuModel');
				$this->view('general/menu', ['menu_items' => $menuModel->items, 'userInfo' => $_SESSION['user'] ]);
				$this->view('general/slider');
			}
		}
	}
?>