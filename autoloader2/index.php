<?php

require_once 'Autoloader.php';
Autoloader::register();

$class = isset($_GET['class']) ? $_GET['class'] : 'klasse1';
$method = isset($_GET['method']) ? $_GET['method'] : 'getData';
$p = isset($_GET['p']) ? $_GET['p'] : 0;

$klasse = new $class($method, $p);
?>