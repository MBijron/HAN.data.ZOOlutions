<?PHP
class sitemap extends Controller
{	
	public function index($name = '', $otherName = '')
	{
		$this->disableTemplate();
		header('Content-type: application/xml');
		$sitemapModel = $this->model('SitemapModel');
		$this->view('sitemap/index', [
			'sitemap_items' => $sitemapModel->items
		]);
	}
}