<?php

namespace Noonehardy\Project1\App\Rent;

use Noonehardy\Project1\App\Car\Car;
use Noonehardy\Project1\Data\DB;

class Rent
{
    public function __construct($method = '', $parameter = '')
    {
        if ($method != '') {
            if ($parameter != '') {
                if (method_exists($this, $method)) {
                    $this->$method($parameter);
                }
            } else {
                if (method_exists($this, $method)) {
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
            $sql = "SELECT * FROM rental WHERE id = :id";
            $bind = array(":id" => $id);
        } else {
            $sql = "SELECT * FROM rental";
            $bind = array();
        }

        $data = json_decode(DB::query($sql, $bind));
        if ($id > 0) {
            if ($data != false) {
                $data = $data[0];
            } else {
                $data = "Keine Vermietung mit dieser ID gefunden";
            }
        }

        echo "<pre>";
        print_r($data);
        echo "</pre>";
        echo "<pre>";
        var_dump($_SESSION);
        echo "</pre>";
    }

    public function delete($id)
    {
        if ($_SESSION["RIGHTS"] == 1) {
            $id = intval($id);
            $id = is_int($id) ? $id : 0;
            $id = isset($id) ? $id : 0;
            $id = !is_null($id) ? $id : 0;

            $sql = "SELECT * FROM rental WHERE id = :id";
            $bind = array(":id" => $id);
            $result = json_decode(DB::query($sql, $bind));
            if (!$result || $id == 0) {
                echo "Rental $id existiert nicht.<br>";
                return false;
            }
            $rental = $result[0];

            $sql = "DELETE FROM rental WHERE id = :id;";
            if (DB::query($sql, $bind)) {
                echo "<pre>";
                print_r($rental);
                echo "</pre><br>";

                echo "Rental $id erfolgreich gelöscht.<br>";
            } else {
                echo "Rental $id konnte nicht gelöscht werden.<br>";
            }
        } else {
            echo "Sie haben keine Berechtigungen um dies zu tun";
        }
    }
    public function insert()
    {
        if ($_SESSION["RIGHTS"] == 1) {
            $sql = "INSERT INTO rental (";
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
                echo "Rental konnte nicht erstellt werden.<br>";
            } else {
                echo "Rental erfolgreich erstellt";
            }
        } else {
            echo "Sie haben keine Berechtigungen um dies zu tun";
        }
    }

    public function update($id)
    {
        if ($_SESSION["RIGHTS"] == 1) {
            $sql = "UPDATE rental SET ";
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

    public function rent($id)
    {
        $customer_id = explode("_", $id)[1];
        $id = explode("_", $id)[0];
        $cars = Car::freeCars();
        $ids = array();
        foreach ($cars as $car) {
            $ids[] = $car->id;
        }

        $sql = "SELECT * FROM customers WHERE id = :id";
        $bind = array(":id" => $customer_id);
        $result = json_decode(DB::query($sql, $bind));
        if (!$result || $id == 0) {
            echo "Customer $id existiert nicht.<br>";
            return false;
        }

        print_r($ids);
        echo $id;

        if (is_int(array_search($id, $ids))) {
            $sql = "INSERT INTO rental (car_id, customer_id, start_date, end_date, createDate, active) VALUES ($id, $customer_id, DATE(NOW()), NULL, NOW(), 1)";
            $result = DB::query($sql);
            if ($result == false) {
                echo "Auto kann nicht gemietet werden.<br>";
            } else {
                echo "Auto gemietet";
            }
        } else {
            echo "Auto ist nicht verfügbar";
        }
    }

    public function rueckgabe($id)
    {
        $sql = "SELECT car_id FROM rental WHERE end_date IS NULL AND start_date IS NOT NULL";
        $cars = json_decode(DB::query($sql));
        
        $ids = array();
        foreach ($cars as $car) {
            $ids[] = $car->car_id;
        }

        if (is_int(array_search($id, $ids))) {
            $sql = "UPDATE rental SET active = 0 WHERE car_id = $id AND end_date IS NULL AND start_date IS NOT NULL";
            $result = DB::query($sql);
            if ($result) {
                echo "Auto zurückgegeben";
            } else {
                echo "Auto konnte nicht zurückgegeben werden";
            }
        } else {
            echo "Auto ist nicht ausgeliehen";
        }
    }
}

?>