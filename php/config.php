
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Bogd@n2044');
define('DB_NAME', 'shopping');

// Conectare la baza de date
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiune la baza de date eșuată: " . $conn->connect_error);
}
?>