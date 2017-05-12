<?PHP
	//set the title of the homepage
	$cfg['Title'] = 'localhost';
	
	//set the meta tag contents
	$cfg['Keywords'] = 'framework, php, design, application, website, tools';
	
	//set the page description
	$cfg['Description'] = 'This is a simple framework to create lighting fast and beautifull websites without too much work.';
	
	//set the default time zone
	$cfg['Timezone'] = 'UTC';
	
	//link prefix
	$cfg['linkPrefix'] = (dirname(dirname(str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '',  str_replace('\\', '/', __DIR__)))) != '\\') ? dirname(dirname(str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '',  str_replace('\\', '/', __DIR__)))) . '/' : '/';
	
	//sitemap prefix
	$cfg['sitemapPrefix'] = 'http://www.localhost/';
	
	//set the production stage
	//stages:
	// staging
	// production
	$cfg['Stage'] = 'staging';
	
	//set error_reporting for staging
	$cfg['StagingErrorLevel'] = E_ALL;
	
	//set error_reporting for production
	$cfg['ProductionErrorLevel'] = 0;
	
	//set default controller
	$cfg['DefaultController'] = 'home';
	
	//set not found controller
	$cfg['NotfoundController'] = 'notfound';
	
	//set default method
	$cfg['DefaultMethod'] = 'index';
	
	//use templates at all
	$cfg['UseTemplate'] = 1;
	
	//set default tempate
	$cfg['Template'] = 'default';
	
	//initialize a database or not
	$cfg['UseDatabase'] = 1;
	
	//rewrite controllerfs
	$cfg['RewriteControllers'] = [
		'sitemap.xml' => 'sitemap'
	];
	
	//language used
	$cfg['Language'] = 'Dutch';
	
	//W3c dateTime format
	$cfg['W3cTimeFormat'] = 'Y-m-d\TH:i:s';
	
	//Timezone offset
	$cfg['TimezoneOffset'] = '+00:00';
	
	//Use auth system
	$cfg['UseAuthSystem'] = 1;
	
	//Smarty caching
	$cfg['SmartyCaching'] = 0;
	
	//invalid token error
	$cfg['tokenError'] = 'the tokens did not match';
	
	//language
	$cfg['lang'] = 'nl_NL';
?>