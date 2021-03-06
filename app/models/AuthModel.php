<?PHP
class AuthModel extends model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function register()
	{
		
	}
	
	public function isValidUser($emailaddress, $password)
	{
		// $password = hash('sha512', $password);
		$prepared = [$password, $emailaddress];
		$query = "SELECT COUNT(*) FROM EMPLOYEE WHERE password=? AND emailaddress=?";
		$result = $this->database->executeQuery($query, $prepared);
		$usersFound = $result->fetchColumn();
		if($usersFound > 0)
		{
			return true;
		}
		return false;
	}
	
	public function login($emailaddress, $password)
	{
		// $password = hash('sha512', $password);
		$prepared = [$password, $emailaddress];
		$query = "	SELECT EMPLOYEEID, EMPLOYEE.ROLEID, ROLE.ROLENAME, AREAID, EMAILADDRESS, FIRSTNAME, LASTNAME, USERLEVEL
					FROM EMPLOYEE
					INNER JOIN ROLE ON EMPLOYEE.ROLEID = ROLE.ROLEID
					WHERE password=? AND emailaddress=?";
		$result = $this->database->executeQuery($query, $prepared);
		$user = $result->fetch(PDO::FETCH_OBJ);
		$userLevel = $user->USERLEVEL;
		
		$this->createUser($userLevel, $user);
		$this->onLogin();
	}
	
	public function logout()
	{
		$this->onLogout();
		if(isset($_SESSION['user']))
			unset($_SESSION['user']);
	}
	
	public function getUserLevel()
	{
		if(isset($_SESSION['user']) && isset($_SESSION['user']->userLevel) && is_numeric($_SESSION['user']->userLevel))
		{
			return $_SESSION['user']->userLevel;
		}
		return 0;
	}
	
	public function isLoggedIn()
	{
		return isset($_SESSION['user']);
	}
	
	public function createUser($userLevel, $userObject = null)
	{
		if(is_numeric($userLevel))
		{
			if(isset($userObject))
			{
				$userObject->userLevel = $userLevel;
			}
			else
			{
				$userObject = new stdClass();
				$userObject->userLevel = $userLevel;
			}
			$_SESSION['user'] = $userObject;
		}
		else
		{
			ExceptionHandler::ThrowException('userLevel has to be an numeric');
		}
	}
	
	public function getCurrentUser()
	{ 
		if($this->isLoggedIn())
		{
			return [
				'naam' => $_SESSION['user']->name,
				'tussenvoegsel' => $_SESSION['user']->prefix ? $_SESSION['user']->prefix : '-',
				'achternaam' => $_SESSION['user']->lastname,
				'geboortedatum' => $_SESSION['user']->date_of_birth,
				'geslacht' => $_SESSION['user']->sex ? 'man' : 'vrouw',
				'gebruikersnaam' => $_SESSION['user']->username,
				'werknemer nummer' => $_SESSION['user']->employee_number
			];
		}
	}
	
	public function onLogin()
	{
		
	}
	
	public function onLogout()
	{
	}
}