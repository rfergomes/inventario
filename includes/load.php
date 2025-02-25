<?php
// -----------------------------------------------------------------------
// START SESSION
// -----------------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();

// -----------------------------------------------------------------------
// ENABLE CODE DEBUG WITH "TRUE" OR "FALSE"
// -----------------------------------------------------------------------
define('APP_DEBUG', true);  // Alterado de false para true
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// -----------------------------------------------------------------------
// DEFINE DEFAULT TIMEZONE
// -----------------------------------------------------------------------
setlocale(LC_TIME, 'pt_BR.UTF-8', 'Portuguese_Brazil');
date_default_timezone_set('America/Fortaleza');

// -----------------------------------------------------------------------
// DEFINE SEPARATOR ALIASES
// -----------------------------------------------------------------------
define("DS", DIRECTORY_SEPARATOR);

// -----------------------------------------------------------------------
// DEFINE ROOT PATHS
// -----------------------------------------------------------------------
define('SITE_ROOT', realpath(__DIR__));
define("LIB_PATH_INC", SITE_ROOT . DS);

// -----------------------------------------------------------------------
// LOAD REQUIRED FILES
// -----------------------------------------------------------------------
$includes = ['config', 'functions', 'session', 'upload', 'database', 'sql'];
foreach ($includes as $file) {
    require_once LIB_PATH_INC . $file . '.php';
}
?>
