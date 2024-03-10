<?php


// Interogare pentru a selecta toate înregistrările din tabelul reviews pentru un anumit produs
$sql_reviews = "SELECT * FROM reviews WHERE productID = $productID";

// Executăm interogarea pentru a obține toate recenziile pentru produsul dat
$result_reviews = mysqli_query($conn, $sql_reviews);

// Inițializăm variabilele pentru a calcula ratingul mediu
$total_rating = 0;
$num_reviews = mysqli_num_rows($result_reviews);

// Verificăm dacă există recenzii pentru produsul dat
if ($num_reviews > 0) {
    // Calculăm suma totală a ratingurilor
    while ($row_review = mysqli_fetch_assoc($result_reviews)) {
        $total_rating += $row_review['rating'];
    }

    // Calculăm ratingul mediu
    $avg_rating = $total_rating / $num_reviews;
} else {
    // Setăm ratingul mediu la 0 dacă nu există recenzii
    $avg_rating = 0;
}

// Actualizăm ratingul produsului în baza de date
$sql_update_rating = "UPDATE products SET rating = $avg_rating WHERE productID = $productID";

// Executăm interogarea de actualizare
if (mysqli_query($conn, $sql_update_rating)) {
    echo "Ratingul produsului a fost actualizat cu succes.";
} else {
    echo "Eroare la actualizarea ratingului produsului: " . mysqli_error($conn);
}

// Eliberăm resursele
mysqli_free_result($result_reviews);
mysqli_close($conn);
