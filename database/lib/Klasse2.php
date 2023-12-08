<?php

class Klasse2 {
    public function __construct($method, $p) {
        echo "Ich bin Klasse 2 : ".$this->$method($p)."<br>";
        echo "Methode: $method()<br>";
        echo "Parameter: $p<br>";
    }

    public function getData($id) {
        $id = intval($id);
        $id = is_int($id) ? $id : 0;
        $id = isset($id) ? $id : 0;
        $id = !is_null($id) ? $id : 0;

        if($id > 0) {
            $sql = "SELECT * FROM cars WHERE id = :id";
            $bind = array(":id" => $id);
        } else {
            $sql = "SELECT * FROM cars";
            $bind = array();
        }
        echo $sql."<br>";

        echo "getData: $id<br>";
        $data = DB::query($sql, $bind);
        if ($id > 0) $data = $data[0];
        echo "<pre>";
        print_r($data);
        echo "</pre>";

    }

    public function delete($id) {
        $id = intval($id);
        $id = is_int($id) ? $id : 0;
        $id = isset($id) ? $id : 0;
        $id = !is_null($id) ? $id : 0;

        $sql = "SELECT * FROM cars WHERE id = :id";
        $bind = array(":id" => $id);
        $result = json_decode(DB::query($sql, $bind));
        if (!$result || $id == 0) {
            echo "Car $id does not exist.<br>";
            return false;
        }
        $car = $result[0];

        $sql = "DELETE FROM cars WHERE id = :id;";
        if(DB::query($sql, $bind)) {
            echo "<pre>";
            print_r($car);
            echo "</pre><br>";

            echo "Car $id successfully deleted<br>";
        } else {
            echo "Could not delete car $id<br>";
        }
    }

    public function insert() {

        $sql = "INSERT INTO cars (";
        foreach($_POST as $key => $value) {
            $sql .= "$key,";
        }
        $sql = trim($sql, ",").") VALUES (";

        foreach($_POST as $key => $value) {
            $sql .= "'$value',";
        }
        $sql = trim($sql, ",");
        $sql .= ")";
        $bind = array();
        if (!DB::query($sql, $bind)) {
            echo "Could not create car.<br>";
        } else {
            echo "Car";
        }
    }

    public function update($id) {
        $sql = "UPDATE cars SET ";
        foreach($_POST as $key => $value) {
            $sql .= "$key='$value',";
        }
        $sql = trim($sql, ",")." WHERE id = :id";
        $bind = array(":id" => $id);

        echo $sql;
        echo "<br><pre>";
        print_r(DB::query($sql, $bind));
        echo "</pre><br>";
    }
}
?>