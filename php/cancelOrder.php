<?php
// Conectare la baza de date
include('config.php');
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  // Verifică dacă există sesiunea pentru username
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
  }

// Verificăm dacă s-a trimis o cerere POST pentru anularea comenzii
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificăm dacă s-a trimis un ID de comandă valid
    if (!empty($_GET['order_id'])) {
        // ID-ul comenzii trimis prin metoda GET
        $order_id = $_GET['order_id'];

        echo $order_id;
        // Interogare SQL pentru a actualiza statusul comenzii ca anulată
        $sql = "UPDATE orders SET status = 'canceled' WHERE order_id = $order_id";
        if ($conn->query($sql) === TRUE) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            echo 's';
            die();
        } else {
            echo "Eroare la anularea comenzii: " . $conn->error;
        }
    } else {
        echo "ID-ul comenzii nu a fost furnizat.";
    }
}
?>
