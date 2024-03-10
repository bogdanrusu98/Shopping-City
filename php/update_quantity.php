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
    $productID = $_GET['productID'];

    // Preiați datele din formular


    $stock = isset($_POST['stock']) ? $_POST['stock'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;



    // Construiește interogarea SQL de actualizare
    $sql = "UPDATE products SET ";

    $set_values = array();
    if ($stock !== null && $stock !== '') {
        $set_values[] = "stockQuantity='$stock'";
    }
    if ($description !== null && $description !== '') {
        $set_values[] = "description='$description'";
    }
    if ($name !== null && $name !== '') {
        $set_values[] = "name='$name'";
    }
    if ($price !== null && $price !== '') {
        $set_values[] = "price='$price'";
    }
    $sql .= implode(", ", $set_values);
    $sql .= " WHERE productID = $productID"; // Schimbă 'nume_tabel' și 'id' conform nevoilor tale



    // După ce setezi mesajul de răspuns
    if ($conn->query($sql) === TRUE) {
        $response = "Datele au fost actualizate cu succes!";
        // Redirecționează către products.php cu mesajul de răspuns în URL
        header("Location: ../admin/product.php?id=$productID&message=" . urlencode($response));
        exit(); // Asigură-te că scriptul se oprește după redirecționare
    } else {
        $response = "Eroare la actualizarea datelor: " . $conn->error;
        // Redirecționează către products.php cu mesajul de eroare în URL
        header("Location: ../admin/product.php?error=" . urlencode($response));
        exit(); // Asigură-te că scriptul se oprește după redirecționare
    }
}
echo $response;

// Închidem conexiunea
$conn->close();
