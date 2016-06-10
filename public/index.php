<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

//FIXME Костыль для Селениума, может можно как-то изящнее?
if (isset($_SERVER['HTTP_HOST']) and $_SERVER['HTTP_HOST'] == 'hasht') {
    defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));
} else {
    defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
}

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/models'),
    realpath(APPLICATION_PATH . '/views'),
    get_include_path(),
)));

if (!in_array(strtolower(ini_get('short_open_tag')), ['1', 'on'])) {
    die("Option short_open_tag in php.ini must be enabled (1 or 'on')");
}
// Work options check end


require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);

$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
Zend_Registry::set('config', $config);

if ($config->use_zip_extraction and !class_exists('ZipArchive')) {
    die("ERROR: Class ZipArchive not found! See http://php.net/manual/ru/book.zip.php");
}

mb_internal_encoding("UTF-8");


/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();