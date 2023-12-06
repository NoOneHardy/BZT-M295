<?php
// phpinfo();
$varEins = 13;
$varZwei = 65;
echo $varEins + $varZwei;
echo "<br>";

if ($varEins > $varZwei) {
    echo "1: $varEins";
    echo "<br>";
    echo "2: $varZwei";
    echo "<br>";
} else {
    echo "2: $varZwei";
    echo "<br>";
    echo "1: $varEins";
    echo "<br>";
}

switch ($varEins) {
    case 1:
        echo "Hello World";
        echo "<br>";
        break;
    case 2:
        echo "Good Bye World";
        echo "<br>";
        break;
}

for ($int = 0; $int < $varZwei; $int++) {
    $varEins += $int;
} 

echo $varEins;
echo "<br>";
$varDrei = array($varEins, $varZwei);

foreach ($varDrei as $number) {
    echo $number * 2;
    echo "<br>";
}

$jsonobj = '{"Peter":35,"Ben":37,"Joe":43}';

$obj = json_decode($jsonobj);
var_dump($obj);
echo "<br>";

$array = array("Test", "Test2");

foreach ($array as $string) {
    echo $string;
    echo "<br>";
}

?>