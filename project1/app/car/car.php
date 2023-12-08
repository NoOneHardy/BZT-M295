<?php

namespace Noonehardy\Project1\App\Car;

use Noonehardy\Project1\App\Rent\Rent;
use Noonehardy\Project1\Data\DB;

class Car
{
    public function __construct($method = '', $parameter = '')
    {
        if ($method != '') {
            if ($parameter != '') {
                if (method_exists($this, $method)) {
                    $this->$method($parameter);
                }
            } else {
                $legalMethods = array('freeCars');
                if (array_search($method, $legalMethods) >= 0) {
                    $this->$method();
                } else {
                    $this->get(0);
                }
            }
        } else {
            $this->get(0);
        }
    }

    public function get($id)
    {
        $id = intval($id);
        $id = is_int($id) ? $id : 0;
        $id = isset($id) ? $id : 0;
        $id = !is_null($id) ? $id : 0;

        if ($id > 0) {
            $sql = "SELECT * FROM cars WHERE id = :id";
            $bind = array(":id" => $id);
        } else {
            $sql = "SELECT * FROM cars";
            $bind = array();
        }

        $data = json_decode(DB::query($sql, $bind));
        if ($id > 0) {
            if ($data != false) {
                $data = $data[0];
            } else {
                $data = "Kein Fahrzeug mit dieser ID gefunden";
            }
        }

        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function delete($id)
    {
        if ($_SESSION["RIGHTS"] == 1) {
            $id = intval($id);
            $id = is_int($id) ? $id : 0;
            $id = isset($id) ? $id : 0;
            $id = !is_null($id) ? $id : 0;

            $sql = "SELECT * FROM cars WHERE id = :id";
            $bind = array(":id" => $id);
            $result = json_decode(DB::query($sql, $bind));
            if (!$result || $id == 0) {
                echo "Car $id existiert nicht.<br>";
                return false;
            }
            $car = $result[0];

            $sql = "DELETE FROM cars WHERE id = :id;";
            if (DB::query($sql, $bind)) {
                echo "<pre>";
                print_r($car);
                echo "</pre><br>";

                echo "Car $id erfolgreich gelöscht.<br>";
            } else {
                echo "Car $id konnte nicht gelöscht werden.<br>";
            }
        } else {
            echo "Sie haben keine Berechtigungen um dies zu tun";
        }
    }
    public function insert()
    {
        if ($_SESSION["RIGHTS"] == 1) {
            $sql = "INSERT INTO cars (";
            foreach ($_POST as $key => $value) {
                $sql .= "$key,";
            }
            $sql = trim($sql, ",") . ") VALUES (";

            foreach ($_POST as $key => $value) {
                $sql .= "'$value',";
            }
            $sql = trim($sql, ",");
            $sql .= ")";
            $bind = array();
            if (!DB::query($sql, $bind)) {
                echo "Car konnte nicht erstellt werden.<br>";
            } else {
                echo "Car erfolgreich erstellt";
            }
        } else {
            echo "Sie haben keine Berechtigungen um dies zu tun";
        }
    }

    public function update($id)
    {
        if ($_SESSION["RIGHTS"] == 1) {
            $sql = "UPDATE cars SET ";
            foreach ($_POST as $key => $value) {
                $sql .= "$key='$value',";
            }
            $sql = trim($sql, ",") . " WHERE id = :id";
            $bind = array(":id" => $id);

            echo "<br><pre>";
            print_r(DB::query($sql, $bind));
            echo "</pre><br>";
        } else {
            echo "Sie haben keine Berechtigungen um dies zu tun";
        }
    }

    public static function freeCars() {
        $sql = "SELECT * FROM cars WHERE id not IN (SELECT car_id FROM m295.rental WHERE end_date IS NULL);";
        $cars = json_decode(DB::query($sql));

        return $cars;
    }
}

?>