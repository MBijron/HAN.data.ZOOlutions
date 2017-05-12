<?PHP
class SitemapModel extends model
{
	private $urlPrefix = 'http://localhost/';
	private $timezoneOffset = '+00:00';
	private $W3CDateTimeFormat = 'Y-m-d\Th:i:s';
	
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
		$items = [
			$this->urlPrefix.'home' => date($this->W3CDateTimeFormat, filemtime('app/controllers/home.php')).$this->timezoneOffset
		];
		$this->items = $items;
	}
}