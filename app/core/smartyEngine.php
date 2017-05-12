<?PHP
class smartyEngine
{
	protected $smarty;
	
	function __construct()
	{
		$this->smarty = new Smarty();
		$this->smarty->caching = Config::Get('SmartyCaching');
		$this->smarty->compile_dir = 'app/tmp';
		$this->smarty->assign('php_generate_time', '[PHP_GENERATE_TIME]');
		$this->smarty->assign('url_root', Config::Get('linkPrefix'));
		$this->smarty->registerPlugin('modifier', 'debug', 'krumo');
		$this->smarty->registerPlugin('modifier', 'translate', 'Config::Translate');
		$this->smarty->loadFilter('output', 'trimwhitespace');
	}
	
	public function debug($item)
	{
		krumo($item);
	}
}