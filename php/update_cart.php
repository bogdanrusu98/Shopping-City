<?php
// Includeți fișierul de configurare al bazei de date și stabiliți conexiunea
include("config.php");

// Verificați dacă există o sesiune pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificați dacă utilizatorul este autentificat
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
} else {
    echo json_encode(array("status" => "error", "message" => "Nu sunteți autentificat!"));
    exit();
}

// Verificați dacă s-a primit o cerere POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificați dacă s-au primit datele necesare
    if (isset($_POST['productID']) && isset($_POST['quantity'])) {
        // Preiați datele din cerere
        $productID = $_POST['productID'];
        $newQuantity = $_POST['quantity'];

        // Verificați dacă cantitatea nouă este validă (mai mare sau egală cu 1)
        if ($newQuantity < 1) {
            echo json_encode(array("status" => "error", "message" => "Cantitatea trebuie să fie mai mare sau egală cu 1!"));
            exit();
        }

        // Verificați cantitatea disponibilă în stoc pentru produsul respectiv
        $stockQuery = "SELECT stockQuantity FROM products WHERE productID = '$productID'";
        $stockResult = mysqli_query($conn, $stockQuery);
        $stockRow = mysqli_fetch_assoc($stockResult);
        $stockAvailable = $stockRow['stockQuantity'];

        // Verificați dacă cantitatea din coș depășește cantitatea disponibilă în stoc
        if ($newQuantity > $stockAvailable) {
            echo json_encode(array("status" => "error", "message" => "Cantitatea depășește stocul disponibil pentru acest produs!"));
            exit();
        }

        // Actualizați cantitatea în coșul de cumpărături pentru utilizatorul curent
        $updateQuery = "UPDATE cart SET quantity = '$newQuantity' WHERE userID = '$userID' AND productID = '$productID'";
        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(array("status" => "success", "message" => "Cantitatea a fost actualizată cu succes!"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Eroare la actualizarea cantității: " . mysqli_error($conn)));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Date incomplete primite!"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Acces interzis!"));
}
