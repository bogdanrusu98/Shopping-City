<?php
// Include fișierul de configurare al bazei de date și stabilește conexiunea
include("config.php");

// Verifică dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preia datele din formular
    $seria = $_POST['seria'];
    $valoare = $_POST['valoare'];
    $expiration_date = $_POST['expiration_date'];

    // Verifică dacă seria voucherului este unică în baza de date
    $check_query = "SELECT * FROM vouchers WHERE seria = '$seria'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        echo "Seria voucherului există deja în baza de date.";
    } else {
        // Inserează datele voucherului în baza de date
        $insert_query = "INSERT INTO vouchers (seria, valoare, expiration_date) VALUES ('$seria', '$valoare', '$expiration_date')";
        if (mysqli_query($conn, $insert_query)) {
            echo "Voucherul a fost creat cu succes.";
        } else {
            echo "Eroare la crearea voucherului: " . mysqli_error($conn);
        }
    }

    // Închide conexiunea la baza de date
    mysqli_close($conn);
}

