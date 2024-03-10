<?php

// Interogare SQL pentru a număra recenziile pentru produsul dat
$sql = "SELECT COUNT(*) AS totalReviews FROM reviews WHERE productID = $productID";

// Executați interogarea și obțineți rezultatul
$result = $conn->query($sql);

// Verificați dacă există rezultate și afișați numărul total de recenzii pentru produs
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalReviews = $row["totalReviews"];
}

$sql = "SELECT AVG(rating) AS averageRating FROM reviews WHERE productID = $productID";

// Executăm interogarea și obținem rezultatul
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Extragem rândul rezultatului
    $row = $result->fetch_assoc();
    
    // Calculăm media rating-urilor pentru produsul dat
    $averageRating = $row["averageRating"];
    if ($averageRating !== null) {
        $averageRatingFormatted = number_format($averageRating, 2);
    } else {
        $averageRatingFormatted = 0; // sau orice alt text de substituire
    }
}

$productRatingStars = '';
// Pentru fiecare stea, până la 5
for ($i = 1; $i <= 5; $i++) {
    // Verifică dacă indexul stelei este mai mic sau egal cu ratingul mediu
    if ($i <= $averageRating) {
        // Dacă da, adaugă o stea plină
        $productRatingStars .= '<i class="fas fa-star"></i>';
    } else {
        // Altfel, adaugă o stea goală
        $productRatingStars .= '<i class="far fa-star"></i>';
    }
}
