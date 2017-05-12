<?PHP
class SecurityModel extends model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function register()
	{
		
	}
	
	public function generateToken()
	{
		$token = bin2hex(openssl_random_pseudo_bytes(16));
		$_SESSION['token'] = $token;
		return $token;
	}
}