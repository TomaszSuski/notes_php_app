<?php

declare(strict_types=1);

require_once("src/Utils/debug.php");

$configuration = require_once("src/config/config.php");

// spl_autoload_register(function (string $className) {
//     if (!strpos($className, 'Exception'))
//         {
//         $classPath = str_replace(['App', '\\'], ['', '/'], $className);
  
//         $path = "src$classPath.php";
//         require_once($path);
//         }
// });

spl_autoload_register(function (string $classNamespace){
    $path = str_replace(['\\', 'App/'], ['/', ''], $classNamespace);
    $path = "src/$path.php";
    require_once($path);
});


use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Request;
use App\Exception\AppException;

const DEFAULT_SORT_BY = 'created';
const DEFAULT_SORT_ORDER = 'DESC';
const DEFAULT_PAGE_SIZE = 10;
const DEFAULT_PAGE_NUMBER = 1;

$request = [
    'get'=> $_GET,
    'post' => $_POST
];

$request = new Request($_GET, $_POST, $_SERVER);

try {

AbstractController::initConfiguration($configuration);
(new NoteController($request))->run();

} catch (AppException $ae) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo '<h3>' . $ae->getMessage() . '</h3>';
    
    dump($ae);
    dump($ae->getMessage());
dump($ae->getTraceAsString());

} catch (Throwable $e) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';

    dump($e);
    dump($e->getMessage());
dump($e->getTraceAsString());

}