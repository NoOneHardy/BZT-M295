<?php

namespace Noonehardy\Project1\App\Customer;

use Noonehardy\Project1\data\DB;

class Customer
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
            $sql = "SELECT * FROM customers WHERE id = :id";
            $bind = array(":id" => $id);
        } else {
            $sql = "SELECT * FROM customers";
            $bind = array();
        }

        $data = json_decode(DB::query($sql, $bind));
        if ($id > 0) {
            if ($data != false) {
                $data = $data[0];
            } else {
                $data = "Kein Kunde mit dieser ID gefunden";
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

            $sql = "SELECT * FROM customers WHERE id = :id";
            $bind = array(":id" => $id);
            $result = json_decode(DB::query($sql, $bind));
            if (!$result || $id == 0) {
                echo "Customer $id existiert nicht.<br>";
                return false;
            }
            $customer = $result[0];

            $sql = "DELETE FROM customers WHERE id = :id;";
            if (DB::query($sql, $bind)) {
                echo "<pre>";
                print_r($customer);
                echo "</pre><br>";

                echo "Customer $id erfolgreich gelöscht.<br>";
            } else {
                echo "Customer $id konnte nicht gelöscht werden.<br>";
            }
        } else {
            echo "Sie haben keine Berechtigungen um dies zu tun";
        }
    }
    public function insert()
    {
        if ($_SESSION["RIGHTS"] == 1) {
            $sql = "INSERT INTO customers (";
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
                echo "Customer konnte nicht erstellt werden.<br>";
            } else {
                echo "Customer erfolgreich erstellt";
            }
        } else {
            echo "Sie haben keine Berechtigungen um dies zu tun";
        }
    }

    public function update($id)
    {
        if ($_SESSION["RIGHTS"] == 1) {
            $sql = "UPDATE customers SET ";
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
}

?>