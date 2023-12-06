<?php
class DB {
    private $con = null;
    private static $array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    public static function query($queryString) {
        $db = 'm295';
        $user = 'root';
        $pass = '';

        // Verbindung aufbauen
        $con = new PDO("mysql:host=localhost;dbname=$db", $user, $pass);
        $statement = $con->prepare($queryString);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo "<pre>";
        print_r($data);
        echo "</pre>";
        
        return json_encode($data);
    }
}
?>