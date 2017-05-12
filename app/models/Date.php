<?PHP
	class DateModel extends model
	{
		public $items = [];
		
		public function __construct()
		{
			parent::__construct();
			$this->renderModels();
		}
		
		public function register()
		{
			
		}
		
		private function renderModels()
		{
			$items['home'] = 'Home';
			$this->items = $items;
		}
	}