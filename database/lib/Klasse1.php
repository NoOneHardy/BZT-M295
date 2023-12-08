<?php
class Klasse1 {
    public function __construct($method, $p) {
        echo "Ich bin Klasse 1 : " . $this->$method($p) . "<br>";
        echo "Methode: $method()<br>";
        echo "Parameter: $p<br>";
    }

    public function getData() {
        $sql = "SELECT * FROM cars";
        $data = DB::query($sql, array());
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function __destruct() {

    }
}
?>