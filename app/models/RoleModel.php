<?PHP
class RoleModel extends Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function register()
	{
		
	}
	
	public function permission($user)
	{
		return "EXECUTE AS USER = '" . $user . "'";
	}
} 