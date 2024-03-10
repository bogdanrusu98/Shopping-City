<?php
// Verificarea cantității din coș înainte de plasarea comenzii
include("config.php");
// 1. Obține cantitatea din coș pentru fiecare produs și compară cu stocul disponibil
foreach ($_SESSION['cart'] as $productID => $quantity) {
    // 2. Obține stocul disponibil pentru produsul curent din baza de date
    $sql = "SELECT stockQuantity FROM products WHERE productID = $productID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stock_available = $row['stock'];

        // 3. Verifică dacă cantitatea din coș depășește stocul disponibil
        if ($quantity > $stock_available) {
            // Cantitatea din coș depășește stocul disponibil pentru acest produs
            echo "Cantitatea pentru produsul cu ID-ul $productID depășește stocul disponibil.";
            // Poți afișa un mesaj și poți redirecționa utilizatorul către pagina coșului sau altă pagină relevantă
            exit(); // Oprire prelucrare, deoarece nu putem plasa comanda
        }
    } else {
        // Nu s-a găsit stoc disponibil pentru produsul curent, gestionează eroarea cum consideri necesar
    }
}

// 4. Dacă toate verificările sunt trecute, poți plasa comanda și redirecționa utilizatorul către pagina de checkout
header("Location: ../cart/checkout.php");
exit();

