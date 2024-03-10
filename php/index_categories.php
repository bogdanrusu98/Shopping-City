<?php
// Include fișierul de configurare al bazei de date și stabilește conexiunea
include("config.php");


// Verifică dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preia datele din formular
    $category = $_POST['category'];


    // Verifică dacă seria voucherului este unică în baza de date
    $check_query = "SELECT * FROM indexes WHERE category = '$category'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        echo "Seria voucherului există deja în baza de date.";
    } else {
        // Inserează datele voucherului în baza de date
        $insert_query = "INSERT INTO indexes (category) VALUES ('$category')";
        if (mysqli_query($conn, $insert_query)) {
            echo "Categorie adaugata";
        } else {
            echo "Eroare la crearea voucherului: " . mysqli_error($conn);
        }
    }


}





