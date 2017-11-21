<?php
session_start();
/*session_unset();
session_destroy();
session_start();*/
// Get Env variable to automatically include environment config
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'local'));

// show errors when working on local
if(APPLICATION_ENV === 'local'){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

require '../lib/Auth.php';
require '../vendor/autoload.php';
require '../configs/'.strtolower(APPLICATION_ENV).'.config.php';
// Setup custom Twig view
// $twigView = new \Slim\Views\Twig();


$app = new \Slim\Slim(array(
    'mode' => 'development'
    // 'view' => $twigView,
    // 'templates.path' => '../templates/',
));

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true
    ));
});

// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});


// Automatically load router files
$routers = glob('../routers/*.router.php');
foreach ($routers as $router) {
    require $router;
}

$app->run();


