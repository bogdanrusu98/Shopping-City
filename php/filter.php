<?php
include("config.php");
// Verifică dacă există parametrii pentru filtrare în URL
if (isset($_GET['minPrice']) || isset($_GET['maxPrice']) || isset($_GET['category'])) {
    // Inițializează variabilele pentru filtre
    $minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : null;
    $maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : null;
    $category = isset($_GET['category']) ? $_GET['category'] : null;

    // Inițializează variabila pentru sortare
    $resultSort = '';

    // Verifică dacă există parametrii pentru sortare în URL
    if (isset($_GET['sort'])) {
        $sortOption = $_GET['sort'];
        // Implementați logica pentru sortare în funcție de opțiunea selectată
        // Atribuiți valoarea corespunzătoare variabilei $resultSort
        // Exemplu:
        // if ($sortOption == 'price_low_to_high') {
        //     $resultSort = 'ORDER BY price ASC';
        // } elseif ($sortOption == 'price_high_to_low') {
        //     $resultSort = 'ORDER BY price DESC';
        // }
    }

    // Construiește interogarea SQL pentru filtrare
    $sql = "SELECT * FROM products WHERE 1=1";

    // Adaugă condițiile de filtrare în funcție de parametrii primiți
    if ($minPrice !== null) {
        $sql .= " AND price >= " . mysqli_real_escape_string($conn, $minPrice);
    }
    if ($maxPrice !== null) {
        $sql .= " AND price <= " . mysqli_real_escape_string($conn, $maxPrice);
    }
    if ($category !== null) {
        $sql .= " AND category = '" . mysqli_real_escape_string($conn, $category) . "'";
    }

    // Adaugă sortarea dacă este necesară
    $sql .= " " . $resultSort;

    // Execută interogarea SQL pentru filtrare
    $result = mysqli_query($conn, $sql);

    // Verifică dacă există rezultate
    if (mysqli_num_rows($result) > 0) {
        // Inițializează variabila pentru a stoca HTML-ul rezultatelor filtrate
        $filteredProductsHTML = '';

        // Construiește HTML-ul pentru produsele filtrate
        while ($row = mysqli_fetch_assoc($result)) {
            // Aici puteți construi HTML-ul pentru fiecare produs și adăugați-l la variabila $filteredProductsHTML
            $filteredProductsHTML .= '<div class="product">' . $row['name'] . '</div>';
        }

        // Returnează HTML-ul cu produsele filtrate
        echo $filteredProductsHTML;
    } else {
        // Dacă nu s-au găsit produse conform criteriilor de filtrare
        echo '<p>Nu s-au găsit produse conform criteriilor de filtrare.</p>';
    }

    // Eliberează resursele
    mysqli_free_result($result);
}
?>
