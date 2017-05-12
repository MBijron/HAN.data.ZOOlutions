<?PHP
	
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	define('START_PAGE_GENERATION', $time);

	require_once('app/init.php');
	
	$app = new App();
	$app->Run();
?>