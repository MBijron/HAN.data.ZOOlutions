<?PHP
	class Logout extends Controller
	{	
		public function index($name = '', $otherName = '')
		{
			$authModel = $this->model('AuthModel');
			$authModel->logout();
			$this->redirect(Config::Get('DefaultController'));
		}
	}
?>