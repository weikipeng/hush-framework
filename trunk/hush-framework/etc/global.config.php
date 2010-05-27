<?php

/**
 * Common Directories
 */
define('__ETC', dirname(__FILE__));
define('__ROOT', realpath(__ETC . '/../'));
define('__LIB_DIR', realpath(__ROOT . '/lib'));
define('__BIN_DIR', realpath(__ROOT . '/bin'));
define('__WEB_DIR', realpath(__ROOT . '/web'));
define('__TPL_DIR', realpath(__ROOT . '/tpl'));
define('__DAT_DIR', realpath(__ROOT . '/dat'));
define('__CACHE_DIR', realpath(__DAT_DIR . '/cache'));

/**
 * Common & Hush libraries paths
 * TODO : should be changed by enviornment change !!!
 */
define('__COMM_LIB_DIR', realpath(__ROOT . '/../apps/lib'));
define('__HUSH_LIB_DIR', realpath(__ROOT . '/../ihush-lib'));

// initialize the include path env
set_include_path('.' . PATH_SEPARATOR . __LIB_DIR . PATH_SEPARATOR . __COMM_LIB_DIR . PATH_SEPARATOR . __HUSH_LIB_DIR . PATH_SEPARATOR . get_include_path());

/**
 * Global environment settings
 * TODO : should be changed by enviornment change !!!
 */
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('PRC');

/**
 * Enviornment settings
 * Include 'dev', 'test', 'www'
 * Impact some variables and debug infomation
 * TODO : should be changed by enviornment change !!!
 */
define('__ENV', 'dev');
