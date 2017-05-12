<?PHP
	class model
	{	
		protected $database;
	
		public function __construct()
		{
			if(Config::Get('UseDatabase') == 1)
			{
				$this->database = new databaseHandler(
					Database::Get('engine'), 
					Database::Get('host'), 
					Database::Get('port'), 
					Database::Get('database'), 
					Database::Get('username'), 
					Database::Get('password')
				);
			}
		}
		
		protected function model($model)
		{
			if(file_exists('app/models/'.$model.'.php'))
			{
				require_once 'app/models/'.$model.'.php';
				return new $model();
			}
			else
			{
				ExceptionHandler::ThrowException('Could not load model: app/models/'.$model.'.php');
			}
		}
	}