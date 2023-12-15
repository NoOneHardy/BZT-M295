<?php

namespace Noonehardy\Project1\App\Car;

use Noonehardy\Project1\Data\DB;
use Valitron\Validator;

class Car
{
    public function __construct(string $method = '', string | int $parameter = '')
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

    public function get(string|int|null $id): void
    {
        $id = !is_null($id) ? $id : 0;
        $id = intval($id);
        $id = is_int($id) ? $id : 0;

        if ($id > 0) {
            $sql = "SELECT * FROM cars WHERE id = :id";
            $bind = array(":id" => $id);
        } else {
            $sql = "SELECT * FROM cars";
            $bind = array();
        }

        $data = json_decode(strval(DB::query($sql, $bind)));
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

    public function delete(string|int|null $id): void
    {
        if ($_SESSION["RIGHTS"] == 0) {
            echo "Sie haben keine Berechtigungen um dies zu tun";
            return;
        }
        $id = !is_null($id) ? $id : 0;
        $id = intval($id);
        $id = is_int($id) ? $id : 0;

        $sql = "SELECT * FROM cars WHERE id = :id";
        $bind = array(":id" => $id);
        $result = json_decode(strval(DB::query($sql, $bind)));
        if (!$result || $id == 0) {
            echo "Car $id existiert nicht.<br>";
            return;
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
    }
    public function insert(): void
    {
        if ($_SESSION["RIGHTS"] == 0) {
            echo "Sie haben keine Berechtigungen um dies zu tun";
            return;
        }

        $data = array();
        $data['name'] = 'Hans Hardegger';
        $data['email'] = 'hans.hardegger@outlook.com';
        $data['password'] = 'SecurePassword123';
        $data['birthdate'] = '2023-12-14';
        $data['saldo'] = '1292';
        $data['beine'] = 10;

        $v = new Validator($data);
        // https://packagist.org/packages/vlucas/valitron

        // String darf nicht leer sein
        $v->rule('required', ['name', 'email', 'password']);
        // String muss zwischen 3 und 255 Zeichen lang sein
        $v->rule('lengthBetween', 'name', 3, 255);
        // String darf nur bestimmte Zeichen enthalten
        $v->rule('regex', 'name', '/^[a-zA-ZöüäÖÄÜéàèÉÀÈ ]+$/');
        
        // Ist die Email gültig?
        $v->rule('email', 'email');
        
        // Ist die Anzahl Beine eine Ganzzahl?
        $v->rule('integer', 'beine');
        $v->rule('min', 'beine', 0);
        $v->rule('max', 'beine', 2147483647);
        // Ist der Saldo eine Kommazahl?
        $v->rule('numeric', 'saldo'); // $v->rule('regex', 'saldo', '/^[0-9]+\.[0-9]+/');

        // Ist das Geburtsdatum ein Datum?
        $v->rule('dateFormat', 'birthdate', 'Y-m-d');
        // Liegt das Geburtsdatum in der Vergangenheit?
        $today = date_create(date('Y-m-d'));
        $tomorrow = date_add($today, date_interval_create_from_date_string('1 day'));
        $v->rule('dateBefore', 'birthdate', $tomorrow);

        if (!$v->validate()) {
            print_r($v->errors());
            return;
        }

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
    }

    public function update(string|int|null $id): void
    {
        if ($_SESSION["RIGHTS"] == 0) {
            echo "Sie haben keine Berechtigungen um dies zu tun";
            return;
        }
        $sql = "UPDATE cars SET ";
        foreach ($_POST as $key => $value) {
            $sql .= "$key='$value',";
        }
        $sql = trim($sql, ",") . " WHERE id = :id";
        $bind = array(":id" => $id);

        echo "<br><pre>";
        print_r(DB::query($sql, $bind));
        echo "</pre><br>";
    }

    public static function freeCars(): array
    {
        $sql = "SELECT * FROM cars WHERE id not IN (SELECT car_id FROM m295.rental WHERE end_date IS NULL);";
        $cars = json_decode(strval(DB::query($sql)));

        return $cars;
    }
}

?>