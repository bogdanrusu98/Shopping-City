<?php
$total = null;
// Verificați dacă utilizatorul este autentificat și obțineți ID-ul acestuia
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];

    // Interogare pentru a obține produsele din coș pentru utilizatorul curent
    $sql = "SELECT c.*, p.name, p.rating, p.price, p.imageHref 
        FROM cart c 
        INNER JOIN products p ON c.productID = p.productID 
        WHERE c.userID = $userID";

    $result = mysqli_query($conn, $sql);




    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Extrage prețul și cantitatea produsului curent
            $price = $row['price'];
            $quantity = $row['quantity'];

            // Calculează subtotalul pentru acest produs
            $subtotal = $price * $quantity;

            // Adaugă subtotalul la totalul general
            $total += $subtotal;
        }
    }
}
