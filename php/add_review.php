<?php
// Includeți fișierul de configurare al bazei de date și stabiliți conexiunea
include("config.php");

// Verificați dacă există o sesiune pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificați dacă utilizatorul este autentificat și obțineți ID-ul acestuia din sesiune
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
} else {
    // Dacă utilizatorul nu este autentificat, puteți gestiona eroarea sau redirecționa către o pagină de autentificare
    echo "Utilizatorul nu este autentificat.";
    exit();
}

// Preiați informațiile din formularul de recenzie
if (isset($_POST['productID']) && isset($_POST['rating']) && isset($_POST['comment'])) {
    $productID = $_POST['productID'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $review_title = $_POST['review_title'];

    // Construiți interogarea pentru a insera recenzia în baza de date
    $insertQuery = "INSERT INTO reviews (userID, productID, rating, comment, review_title) VALUES ('$userID', '$productID', '$rating', '$comment', '$review_title')";

    // Încercați să executați interogarea
    if (mysqli_query($conn, $insertQuery)) {
        // Dacă inserarea a fost reușită, afișați un mesaj de succes sau redirecționați către o altă pagină
        include("update_rating.php");
        echo "Recenzia a fost adăugată cu succes!";
    } else {
        // Dacă a apărut o eroare la inserare, afișați un mesaj de eroare sau gestionați eroarea în alt mod
        echo "Eroare la adăugarea recenziei: " . mysqli_error($conn);
    }
} else {
    // Dacă nu au fost trimise toate informațiile necesare, afișați un mesaj de eroare sau gestionați lipsa datelor în alt mod
    echo "Nu s-au trimis toate informațiile necesare pentru adăugarea recenziei.";
}
