<?php
class Autoloader {
    public static function register() {
        spl_autoload_register(function ($class) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
        });
    }
}

Autoloader::register();
$object = new MyClass();

echo "<pre>";
print_r($object);
echo "</pre>";
?>