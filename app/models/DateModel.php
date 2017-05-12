<?PHP
	class DateModel extends model
	{
		public $CopyrightEnd;
		
		public function __construct()
		{
			parent::__construct();
			$this->CopyrightEnd = date('Y');
		}
		
		public function register()
		{
			
		}
	}