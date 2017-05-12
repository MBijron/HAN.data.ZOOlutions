<?PHP
	class Login extends Controller
	{	
		public function index($name = '', $otherName = '')
		{
			$securityModel = $this->model('SecurityModel');
			$menuModel = $this->model('MenuModel');
			$dateModel = $this->model('DateModel');
			$authModel = $this->model('AuthModel');
			$this->view('general/menu', ['menu_items' => $menuModel->renderItems(), 'logged_in' => $authModel->isLoggedIn()]);
			$this->view('general/backtotop');
			$error = isset($_SESSION['loginError']) ? $_SESSION['loginError'] : false;
			if(isset($_SESSION['loginError'])) unset($_SESSION['loginError']);
			$this->view('auth/login', ['token' => $securityModel->generateToken(), 'error' => $error, 'logged_in' => $authModel->isLoggedIn()]);
			$this->view('general/footer');
			$this->view('general/copyright', ['end_date' => $dateModel->CopyrightEnd]);
		}
		
		public function start()
		{
			if(isset($_SESSION['loginError'])) unset($_SESSION['loginError']);
			if($this->validateToken())
			{
				$authModel = $this->model('AuthModel');
				if(isset($_POST['username']) && isset($_POST['password']) && $authModel->isValidUser($_POST['username'], $_POST['password']))
				{
					$authModel->login($_POST['username'], $_POST['password']);
					$this->redirect(Config::Get('DefaultController'));
				}
				else
				{
					$_SESSION['loginError'] = true;
					$this->redirect('login');
				}
			}
		}
	}
?>