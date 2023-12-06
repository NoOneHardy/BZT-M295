<?php

class Kunde {
    private $name = "";
    private $kundenNr = 0;
    private $geburtsdatum = "";
    private static $anzahlKunden = 0;
    
    public function __construct($name = '', $geburtsdatum = '') {
        $this->name = $name;
        $this->kundenNr = $this::$anzahlKunden + 1;
        $this->geburtsdatum = $geburtsdatum;
        $this::$anzahlKunden++;
    }

    public function __destruct() {
        echo "Kunde gelöscht<br>";
    }

    public function setName($name = '') {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getKundenNr() {
        return $this->kundenNr;
    }

    public function setGeburtsdatum($geburtsdatum = '') {
        $this->geburtsdatum = $geburtsdatum;
    }

    public function getGeburtsdatum() {
        return $this->geburtsdatum;
    }
}

class Mitglied extends Kunde {
    private $treuepunkte = 0;
    private $bonusEinkaeufe = 0;

    public function __construct($name = '',  $geburtsdatum = '') {
        parent::__construct($name, $geburtsdatum);
    }

    public function __destruct() {
        echo "Mitglied gelöscht";
    }

    public function addTreuePunkte($punkte = 0) {
        $this->treuepunkte += $punkte;
    }

    public function bonusEinkauf($preis) {
        if ($this->treuepunkte * 10 > $preis) {
            $this->bonusEinkaeufe++;
            $this->treuepunkte -= $preis * 10;
        } else {
            echo "Dieser Kunde hat nicht genug Treuepunkte";
        }
    }
}

$kunde1 = new Kunde("Hardegger", "2007-06-21");
$kunden = array($kunde1);

$kunde2 = new Kunde("Müller", "1976-02-18");

$kunden[] = $kunde2;

$mitglied1 = new Mitglied("Peter", "1988-09-25");
$mitglied1->addTreuePunkte(1000);
$mitglied1->bonusEinkauf(10);

$kunden[] = $mitglied1;

echo "<pre>";
print_r($kunden);
echo "</pre>";

abstract class aClass {
    public function add($a = 0, $b = 0) {
        return $a + $b;
    }
}

class ClassName extends aClass {
    public function __construct() {
        echo aClass::add(5, 6);
    }
}

$class = new ClassName();
echo "<br>";

interface Template {
    public function add($a, $b);
}

class ClassWithInterface implements Template {
    public function __construct() {
        echo $this->add(19283, 27392) . "<br>";
    }

    public function add($a = 0, $b = 0) {
        return $a + $b;
    }
}

new ClassWithInterface();
?>