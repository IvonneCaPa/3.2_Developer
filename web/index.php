<?php
	// error_reporting() muestra todos los errores posibes
	error_reporting(E_ALL);
	// ini_set() Se asegura que se muestren en pantalla
	ini_set('display_errors', 1);
	// date_default_timezone_set() establece la zona horaria en Europa
	date_default_timezone_set('CET');

	/* Declaramos la constante WEB-ROOT */
	define('WEB_ROOT', substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], '/index.php')));
	// Declaramos la constante ROOT_PATH
	define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
	// Declaramos la constant CMS_PATH
	define('CMS_PATH', ROOT_PATH . '/lib/base/');

	// inicio de sesión de usuario. 
	session_start();

	// se incluye el archivo de rutas al root_path
	include(ROOT_PATH . '/config/routes.php');

	/**
	 * Standard framework autoloader
	 * @param string $className
	 */
	function autoloader($className) {
		//  cargar automáticamente clases PHP cuando se necesitan
		if (strlen($className) > 10 && substr($className, -10) == 'Controller') {
			if (file_exists(ROOT_PATH . '/app/controllers/' . $className . '.php') == 1) {
				require_once ROOT_PATH . '/app/controllers/' . $className . '.php';
			}
		}
		else {
			if (file_exists(CMS_PATH . $className . '.php')) {
				require_once CMS_PATH . $className . '.php';
			}
			else if (file_exists(ROOT_PATH . '/lib/' . $className . '.php')) {
				require_once ROOT_PATH . '/lib/' . $className . '.php';
			}
			else {
				require_once ROOT_PATH . '/app/models/'.$className.'.php';
			}
		}
	}

	// activates the autoloader
	spl_autoload_register('autoloader');

	$router = new Router();
	$router->execute($routes);
