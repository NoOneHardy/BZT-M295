<?php

echo "<h1>Hallo " . htmlspecialchars($_POST["name"]) . "</h1>";
echo "var1 = " . $_GET["var1"];

echo "<h2>GET</h2>";
echo "<pre>";
print_r($_GET);
echo "</pre>";

echo "<h2>POST</h2>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

?>