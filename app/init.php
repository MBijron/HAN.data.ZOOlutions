<?PHP
	session_start();

	require_once 'core/exception.php';
	require_once 'core/input.php';
	require_once 'config/config.php';
	require_once 'config/config_handler.php';
	
	date_default_timezone_set(Config::Get('Timezone'));
	
	setlocale(LC_TIME, Config::Get('Language'));
	
	if(Config::Get('Stage') == 'staging') error_reporting(Config::Get('StagingErrorLevel'));
	else if(Config::Get('Stage') == 'production') error_reporting(Config::Get('ProductionErrorLevel'));
	
	require_once 'config/resource_bundle.php';
	require_once 'config/resource_bundle_handler.php';
	if(Config::Get('UseDatabase') == 1)
	{
		require_once 'config/config.db.php';
		require_once 'config/config.db_handler.php';
		require_once 'core/databaseHandler.php';
	}
	require_once 'core/app.php';
	require_once 'core/smartyEngine.php';
	require_once 'core/controller.php';
	require_once 'core/model.php';
	require_once 'core/template.php';
	require_once 'libraries/krumo/class.krumo.php';
	require_once 'libraries/smarty/Smarty.class.php';
	require_once 'libraries/YaLinqo/init.php';
?>