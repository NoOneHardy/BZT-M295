<?php

class Klasse2 {    
    public function __construct($method, $p) {
        echo "Ich bin Klasse 2 : " . $this->$method($p) . "<br>";
        echo "Methode: $method()<br>";
        echo "Parameter: $p<br>";
    }

    public function getData($id) {
        echo "getData: $id<br>";
        $sql = "SELECT * FROM cars WHERE id = $id;";
        $data = DB::query($sql);
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function deleteData($id) {
        echo "getData: $id<br>";
        $sql = "SELECT * FROM cars WHERE id = $id";
        $car = DB::query($sql);

        $sql = "DELETE FROM cars WHERE id = $id;";
        $data = DB::query($sql);
        
        echo "<pre>";
        print_r($car);
        echo "</pre>";

        echo "Erfolgreich gelöscht!";
    }
}

?>

