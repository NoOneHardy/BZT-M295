<?php

session_start();
if (!isset($_SESSION["RIGHTS"])) {
    $_SESSION["RIGHTS"] = 0;
}
// echo $_SESSION["RIGHTS"];

require_once __DIR__ . '/../vendor/autoload.php';

use Steampixel\Route;
use Noonehardy\Project1\Data\DB;

DB::checkDB('m295');

Route::add('/', function () {
    echo "Welcome :-)";
});
Route::add('/([a-zA-Z0-9]*)', function ($class) {
    $class = "Noonehardy\\Project1\\App\\$class\\$class";
    echo $class;
    if (class_exists($class)) {
        $app = new $class();
    } else {
        $html = file_get_contents(__DIR__ . "/../error/404.php");
        echo $html;
        echo "<code><span>Diese Klasse existiert nicht</span><code>";
    }
});
Route::add('/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)', function ($class, $method) {
    $class = "Noonehardy\\Project1\\App\\$class\\$class";
    if (class_exists($class)) {
        if (method_exists($class, $method)) {
            $app = new $class($method);
        } else {
            $html = file_get_contents(__DIR__ . "/../error/404.php");
            echo $html;
            echo "<code><span>Diese Methode existiert nicht auf der Klasse \"$class\"</span><code>";
        }
    } else {
        $html = file_get_contents(__DIR__ . "/../error/404.php");
        echo $html;
        echo "<code><span>Diese Klasse existiert nicht</span><code>";
    }
});
Route::add('/([a-zA-Z0-9]*)/([a-zA-Z0-9]*)/([a-zA-Z0-9_]*)', function ($class, $method, $parameter) {
    $class = "Noonehardy\\Project1\\App\\$class\\$class";
    if (class_exists($class)) {
        if (method_exists($class, $method)) {
            $app = new $class($method, $parameter);
        } else {
            $html = file_get_contents(__DIR__ . "/../error/404.php");
            echo $html;
            echo "<code><span>Diese Methode existiert nicht auf der Klasse \"$class\"</span><code>";
        }
    } else {
        $html = file_get_contents(__DIR__ . "/../error/404.php");
        echo $html;
        echo "<code><span>Diese Klasse existiert nicht</span><code>";
    }
});
Route::add('/info', function () {
    phpinfo();
}, 'get');
Route::pathNotFound(function () {
    $html = file_get_contents(__DIR__ . "/../error/404.php");
    echo $html;
});

Route::run('/');

// $app = new Car();
//
// oder
//
// $app2 = new Noonehardy\Project1\Car();

?>