<?php
class DB {
    private $con = null;
    public static function query($queryString, $bind) {
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
            if(str_contains($queryString, "DELETE")) {
                return true;
            } else {
                return json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
            }
        } catch (PDOException $e) {
            $con = null;
            return false;
        }
    }

    public static function checkDB($db) {
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

            $statement = $con->prepare($sql);
            $statement->execute();
            $con = null;
        }
    }
}
?>