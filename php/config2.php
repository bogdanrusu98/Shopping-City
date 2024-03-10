
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DB_SERVER2', 'localhost');
define('DB_USERNAME2', 'root');
define('DB_PASSWORD2', 'Bogd@n2044');
define('DB_NAME2', 'websitesettings');

// Conectare la baza de date
$conn = new mysqli(DB_SERVER2, DB_USERNAME2, DB_PASSWORD2, DB_NAME2);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiune la baza de date eșuată: " . $conn->connect_error);
}
?>