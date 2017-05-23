<?PHP
	class Login extends Controller
	{	
		public function index($name = '', $otherName = '')
		{
			if ($_GET['logout'] == 'true') {
				unset($_SESSION['user']);
			}

			$securityModel = $this->model('SecurityModel');
			$dateModel = $this->model('DateModel');
			$authModel = $this->model('AuthModel');
			$error = isset($_SESSION['loginError']) ? $_SESSION['loginError'] : false;
			if(isset($_SESSION['loginError'])) unset($_SESSION['loginError']);
			$this->view('auth/login', ['token' => $securityModel->generateToken(), 'error' => $error, 'logged_in' => $authModel->isLoggedIn()]);
		}
		
		public function start()
		{
			if(isset($_SESSION['loginError'])) unset($_SESSION['loginError']);
			if($this->validateToken())
			{
				$authModel = $this->model('AuthModel');
				if(isset($_POST['emailaddress']) && isset($_POST['password']) && $authModel->isValidUser($_POST['emailaddress'], $_POST['password']))
				{
					$authModel->login($_POST['emailaddress'], $_POST['password']);
					$this->redirect(Config::Get('DefaultController'));
				}
				else
				{
					$_SESSION['loginError'] = true;
					$this->redirect('login?logout=false');
				}
			}
		}
	}
?>