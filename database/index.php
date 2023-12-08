<?php

require_once 'Autoloader.php';
Autoloader::register();
DB::checkDB('m295');

$class = isset($_GET["class"]) ? $_GET["class"] : "klasse2";
$method = isset($_GET["method"]) ? $_GET["method"] : "getData";
$id = isset($_GET["id"]) ? $_GET["id"] : 0;

$klasse = new $class($method, $id);
?>