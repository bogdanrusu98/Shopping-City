<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("config.php");


// Verificăm dacă am primit datele din formular
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preiați ID-ul produsului din URL
    $order_id = $_GET['order_id'];

    // Preiați datele din formular


    $status = isset($_POST['status']) ? $_POST['status'] : null;
    /*
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;
*/


    // Construiește interogarea SQL de actualizare
    $sql = "UPDATE orders SET ";

    $set_values = array();
    if ($status !== null && $status !== '') {
        $set_values[] = "status='$status'";
    }
    /*
    if ($description !== null && $description !== '') {
        $set_values[] = "description='$description'";
    }
    if ($name !== null && $name !== '') {
        $set_values[] = "name='$name'";
    }
    if ($price !== null && $price !== '') {
        $set_values[] = "price='$price'";
    }*/
    $sql .= implode(", ", $set_values);
    $sql .= " WHERE order_id = $order_id"; // Schimbă 'nume_tabel' și 'id' conform nevoilor tale



    // După ce setezi mesajul de răspuns
    if ($conn->query($sql) === TRUE) {
        $response = "Datele au fost actualizate cu succes!";
        // Redirecționează către products.php cu mesajul de răspuns în URL
        header("Location: ../admin/order.php?order_id=$order_id&message=" . urlencode($response));
        exit(); // Asigură-te că scriptul se oprește după redirecționare
    } else {
        $response = "Eroare la actualizarea datelor: " . $conn->error;
        // Redirecționează către products.php cu mesajul de eroare în URL
        header("Location: ../admin/order.php?error=" . urlencode($response));
        exit(); // Asigură-te că scriptul se oprește după redirecționare
    }
}
echo $response;

// Închidem conexiunea
$conn->close();
