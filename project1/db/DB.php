<?php

namespace Noonehardy\Project1\Data;

use PDO, PDOException;

class DB {
    private ?PDO $con = null;    
    /**
     * query
     *
     * @param  string $queryString
     * @param  array $bind {
     *   id: string | int | null
     * }
     * @return bool
     */
    public static function query(string $queryString, array $bind = array()): bool | string {
        $db = 'm295';
        $user = 'root';
        $pass = '';

        // Verbindung aufbauen
        $con = new PDO("mysql:host=localhost;dbname=$db", $user, $pass);
        $statement = $con->prepare($queryString);

        try {
            /* 
            foreach ($bind as $key => $value) {
                $statement->bindValue($key, $value);
            }
            $statement->execute(); */
            $statement->execute($bind);
            $con = null;
            if(str_contains($queryString, "DELETE") || str_contains($queryString, "UPDATE") || str_contains($queryString, "INSERT")) {
                return true;
            } else {
                return json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
            }
        } catch (PDOException $e) {
            $con = null;
            return false;
        }
    }

    public static function checkDB(string $db) : void {
        $user = "root";
        $password = "";
        $dbExists = false;

        $con = new PDO("mysql:host=localhost", $user, $password);

        $sql = "SHOW DATABASES LIKE '$db'";
        $statement = $con->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $con = null;

        if (count($data) == 1) {
            $dbExists = true;
        }

        if ($dbExists) {
            $con = new PDO("mysql:host=localhost;dbname=$db", $user, $password);
            $sql = "SHOW TABLES LIKE 'cars'";
            $statement = $con->prepare($sql);
            $statement->execute();
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            $con = null;

            if (count($data) != 1) {
                $dbExists = false;
            }
        }

        if (!$dbExists) {
            $sql = file_get_contents(__DIR__.'/dbcreate.sql');
            $con = new PDO("mysql:host=localhost", $user, $password);

            $statement = $con->prepare(strval($sql));
            $statement->execute();
            $con = null;
        }
    }
}
?>