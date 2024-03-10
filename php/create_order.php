<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificați dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$message = '';

// Includeți fișierul de configurare al bazei de date și stabiliți conexiunea
include("../php/config.php");
include("../php/check_settings.php");

// Verificați dacă utilizatorul este autentificat
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
} else {
    header('Location: ../login.php');
    exit();
}


// Verificați dacă s-a primit o cerere POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificați dacă s-au primit datele necesare
    if (isset($_POST['total_amount']) && isset($_POST['address_f_f']) || isset($_POST['address_f_j']) && isset($_POST['address_d_f']) || isset($_POST['address_d_j']) && isset($_POST['payment'])) {
        // Preiați datele din cerere
        $total_amount = $_POST['total_amount'];
        $address_f_j = $_POST['address_f_j'];
        $address_f_f = $_POST['address_f_f'];
        $address_d_j = $_POST['address_d_j'];
        $address_d_f = $_POST['address_d_f'];
        $payment = $_POST['payment'];

        if($address_f_j == null) {
            $address_f = $address_f_f;
            $type_f = 'F';
        } else {
            $address_f = $address_f_j;
            $type_f = 'J';
        }
        if($address_d_j == null) {
            $address_d = $address_d_f;
            $type_d = 'F';
        } else {
            $address_d = $address_d_j;
            $type_d = 'J';
        }
// Definiți interogarea SQL pentru inserarea comenzii în baza de date
$sql = "INSERT INTO orders (total_amount, status, user_id, address_f, address_d, payment, type_f, type_d) 
        VALUES ('$total_amount', 'New', '$userID', '$address_f', '$address_d', '$payment', '$type_f', '$type_d')";

// Executați interogarea și verificați rezultatul
if (mysqli_query($conn, $sql)) {
    // Definiți interogarea SQL pentru a obține ultimul order_id
    $orderIDQuery = "SELECT order_id FROM orders WHERE user_id = $userID ORDER BY order_id DESC LIMIT 1";
    $orderIDResult = mysqli_query($conn, $orderIDQuery);

    if ($orderIDResult) {
        $row = mysqli_fetch_assoc($orderIDResult);
        $orderID = $row['order_id'];
        $message = "Comanda dvs. a fost plasată cu succes! #" . $orderID;
                        // Redirecționați utilizatorul către pagina thank-you.php împreună cu valorile corespunzătoare
                        header("Location: ../cart/thank-you.php?orderID=$orderID&total_amount=$total_amount&address_f=$address_f&address_d=$address_d&payment=$payment&message=" . urlencode($message));
                        exit();
    } else {
        $message = "Eroare la plasarea comenzii. Vă rugăm să încercați din nou.";
    }
} else {
    $message = "Eroare la plasarea comenzii. Vă rugăm să încercați din nou.";
}
    }}
 // Interogare pentru a obține produsele din coș pentru utilizatorul curent
                    $sql = "SELECT c.*, p.name, p.rating, p.price, p.imageHref 
                    FROM cart c 
                    INNER JOIN products p ON c.productID = p.productID 
                    WHERE c.userID = $userID";
$result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                        // Extrage prețul și cantitatea produsului curent
                            $name = $row['name'];
                            $imageHref = $row['imageHref'];
                            $product_id = $row['productID'];
                            $quantity = $row['quantity'];
                            $price = $row['price'];
                            
                            
                        
                        }}