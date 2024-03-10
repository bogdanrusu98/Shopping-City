<?php
$resultSort = '';
// Verifică dacă există parametrul de sortare în URL
if (isset($_GET['sort'])) {
    // Preia valoarea parametrului de sortare din URL
    $sortOption = $_GET['sort'];

    // Inițializează variabila pentru stocarea rezultatelor sortate
    $sortedProductsHTML = '';

    // Construiește interogarea SQL în funcție de opțiunea de sortare
    switch ($sortOption) {
        case 'pretCrescator':
            $resultSort = 'ORDER BY price ASC';
            $sql = "SELECT * FROM products ORDER BY price ASC";
            break;
        case 'pretDescrescator':
            $resultSort = 'ORDER BY price DESC';
            $sql = "SELECT * FROM products ORDER BY price DESC";
            break;
        case 'nume':
            $resultSort = 'ORDER BY name ASC';

            $sql = "SELECT * FROM products ORDER BY name ASC";
            break;
        default:
            // Sortare după relevanță sau altă opțiune implicită
            $resultSort = '';
            $sql = "SELECT * FROM products";
    }

    // Execută interogarea și prelucrează rezultatele
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // Construiește HTML-ul pentru produsele sortate
        while ($row = mysqli_fetch_assoc($result)) {
        }
    } else {
        // Dacă nu sunt produse disponibile
        $sortedProductsHTML = '<p>Nu s-au găsit produse.</p>';
    }

    // Returnează HTML-ul cu produsele sortate
    echo $sortedProductsHTML;

    // Eliberează resursele
    mysqli_free_result($result);
}
