<?php

use PitouFW\Core\Controller;
use PitouFW\Core\Request;
use PitouFW\Core\Router;
use PitouFW\Model\AdminUser;

session_start();
require_once '../config/config.php';
require_once '../vendor/autoload.php';

$bool = PROD_ENV ? 0 : 1;
$econst = PROD_ENV ? 0 : E_ALL;
ini_set('display_errors', $bool);
ini_set('display_startup_errors', $bool);
error_reporting($econst ^ E_DEPRECATED);
date_default_timezone_set('UTC');

define('NAME', 'JustAuthMe Admin');
define('POST', $_SERVER['REQUEST_METHOD'] == 'POST');
define('ROOT', str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']), true);
define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), true);
define('ENTITIES', ROOT.'entities/');
define('CORE', ROOT.'core/');
define('APP', ROOT.'app/');
define('MODELS', APP.'models/');
define('VIEWS', APP.'views/');
define('CONTROLLERS', APP.'controllers/');
define('ASSETS', WEBROOT.'assets/');
define('CSS', ASSETS.'css/');
define('JS', ASSETS.'js/');
define('FONTS', ASSETS.'fonts/');
define('IMG', ASSETS.'img/');
define('VENDORS', ASSETS.'vendors/');

spl_autoload_register(function ($classname) {
    $ext = '.php';
    $split = explode('\\', $classname);
    $namespace = '';
    if (count($split) > 1) {
        $last = count($split) - 1;
        $classname = $split[$last];
        unset($split[$last]);
        $namespace = implode('\\', $split);
    }

    $path = ROOT;
    if ($namespace == 'PitouFW\Model' && file_exists(MODELS.$classname.$ext)) {
        $path .= 'app/models/';
    } elseif ($namespace == 'PitouFW\Entity' && file_exists(ENTITIES.$classname.$ext)) {
        $path .= 'entities/';
    } elseif ($namespace == 'PitouFW\Core' && file_exists(CORE.$classname.$ext)) {
        $path .= 'core/';
    }

    if ($path != ROOT) {
        require_once $path . $classname . $ext;
    }
});

if (!PROD_ENV && PROD_HOST === 'localhost' && !isset($_SESSION['imp'])) {
    $_SESSION['uid'] = 1;
}

if (Request::get()->getArg(0) == 'api' && empty($_POST)) {
    if ($json_data = json_decode(file_get_contents('php://input'), true)) {
        $_POST = $json_data;
    }
}

if (Request::get()->getArg(0) !== 'login' && !AdminUser::isLogged()) {
    header('location: ' . WEBROOT . 'login');
    die;
}

if (Request::get()->getArg(0) !== 'logout' && AdminUser::isLogged() && !AdminUser::hasPermission()) {
    Controller::http403Forbidden();
    die;
}

require_once Router::get()->getPathToRequire();
if (Request::get()->getArg(0) == 'api') {
    Controller::renderView('json/json', false);
}