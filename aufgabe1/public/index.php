<?php

session_start();
if (!isset($_SESSION["RIGHTS"])) {
    $_SESSION["RIGHTS"] = 0;
}

require_once __DIR__ . '/../vendor/autoload.php';

use Steampixel\Route;

Route::add('/', function () {
    echo "Welcome :-)";
});

Route::add('/login', function () {
    $name = isset($_GET["name"]) ? $_GET["name"] : "";
    $pw = isset($_GET["pw"]) ? $_GET["pw"] : "";
    if ($name == $pw && $name == 'admin') {
        $_SESSION["RIGHTS"] = 1;
        echo "Logged in";
    } else {
        echo "Username or password is wrong";
    }
});
Route::add('/logout', function () {
    $_SESSION["RIGHTS"] = 0;
    echo "Logged out";
});

Route::add('/schweizOnly', function () {
    // IP Adresse auslesen
    // $ip = $_SERVER['REMOTE_ADDR'];
    $ip = '194.230.148.154'; // Meine IP
    // $ip = '142.250.203.110'; // YouTube

    // URL erstellen
    $apiURL = "https://ip-api.io/json/$ip";
    // Request initialisieren
    $request = curl_init($apiURL);
    // Returnwert der Request als String zurückgeben
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    // Request ausführen
    $response = curl_exec($request);

    // Response in JSON Format konvertieren
    $info = (array)json_decode($response);

    // Response ausgeben
    echo "<pre>";
    print_r($info);
    echo "</pre>";

    // Überprüfen ob die IP aus der Schweiz ist
    if ($info['country_code'] == 'CH') {
        echo 'SUPER SECRET SWISS INFORMATION';
    } else {
        echo 'This content is only available in Switzerland';
    }
});

Route::run('/');
?>