<?php
// HTTP
define('HTTP_SERVER', 'http://'.$_SERVER['SERVER_NAME'].'/');
define('HTTP_IMAGE', 'http://'.$_SERVER['SERVER_NAME'].'/image/');
define('HTTP_ADMIN', 'http://'.$_SERVER['SERVER_NAME'].'/admin/');

// HTTPS
define('HTTPS_SERVER', 'https://'.$_SERVER['SERVER_NAME'].'/');
define('HTTPS_IMAGE', 'https://'.$_SERVER['SERVER_NAME'].'/image/');

// DIR
define('DIR_APPLICATION', dirname(__FILE__).'/catalog/');
define('DIR_SYSTEM', dirname(__FILE__).'/system/');
define('DIR_DATABASE', dirname(__FILE__).'/system/database/');
define('DIR_LANGUAGE', dirname(__FILE__).'/catalog/language/');
define('DIR_TEMPLATE', dirname(__FILE__).'/catalog/view/theme/');
define('DIR_CONFIG', dirname(__FILE__).'/system/config/');
define('DIR_IMAGE', dirname(__FILE__).'/image/');
define('DIR_CACHE', dirname(__FILE__).'/system/cache/');
define('DIR_DOWNLOAD', dirname(__FILE__).'/download/');
define('DIR_LOGS', dirname(__FILE__).'/system/logs/');

// DB
define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', $_SERVER['DB1_HOST']);
define('DB_USERNAME', $_SERVER['DB1_USER']);
define('DB_PASSWORD', $_SERVER['DB1_PASS']);
define('DB_DATABASE', $_SERVER['DB1_NAME']);
define('DB_PREFIX', '');

?>