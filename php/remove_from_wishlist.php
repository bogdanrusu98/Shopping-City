<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include fișierul de configurare al bazei de date și stabilește conexiunea
include("config.php");

// Verifică dacă utilizatorul este autentificat și obține ID-ul acestuia
if(isset($_SESSION['id']) && isset($_POST['product_id'])) {
    $user_id = $_SESSION['id'];
    $product_id = $_POST['product_id'];

    // Interogare pentru ștergerea produsului din coșul utilizatorului
    $sql = "DELETE FROM wishlist WHERE user_id = $user_id AND product_id = $product_id";

    if (mysqli_query($conn, $sql)) {
        // Redirectează utilizatorul înapoi către pagina coșului după ștergere
        header("Location: ../favorites.php");
        exit();
    } else {
        echo "Eroare la ștergerea produsului din wishlist: " . mysqli_error($conn);
    }
} else {
    // Redirectează utilizatorul către pagina de autentificare sau altă pagină, dacă este necesar
    header("Location: login.php");
    exit();
}

// Închide conexiunea cu baza de date
mysqli_close($conn);
?>
