<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include fișierul de configurare al bazei de date și stabilește conexiunea
include("config.php");

// Verifică dacă utilizatorul este autentificat și obține ID-ul acestuia
if(isset($_SESSION['id']) && isset($_POST['productID'])) {
    $userID = $_SESSION['id'];
    $productID = $_POST['productID'];

    // Interogare pentru ștergerea produsului din coșul utilizatorului
    $sql = "DELETE FROM cart WHERE userID = $userID AND productID = $productID";

    if (mysqli_query($conn, $sql)) {
        // Redirectează utilizatorul înapoi către pagina coșului după ștergere
        header("Location: ../cart/products.php");
        exit();
    } else {
        echo "Eroare la ștergerea produsului din coș: " . mysqli_error($conn);
    }
} else {
    // Redirectează utilizatorul către pagina de autentificare sau altă pagină, dacă este necesar
    header("Location: login.php");
    exit();
}

// Închide conexiunea cu baza de date
mysqli_close($conn);
?>
