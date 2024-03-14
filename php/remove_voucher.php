<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('config.php');

// Verifică dacă solicitarea AJAX conține o acțiune specificată și voucher_id
if (isset($_POST['action']) && isset($_POST['voucher_id']) && $_POST['action'] === 'remove_voucher') {
    if (isset($_SESSION['id'])) {
        $userID = $_SESSION['id'];
        $voucher_id = $_POST['voucher_id'];

        // Presupunem că există un câmp în baza de date care indică dacă voucherul este aplicat sau nu
        $sql = "UPDATE vouchers SET on_cart = 0 WHERE voucher_id = '$voucher_id'";
        mysqli_query($conn, $sql);

        // Recalculează totalul coșului după eliminarea voucherului
        $total = 0;
        $cartQuery = "SELECT c.quantity, p.price FROM cart c JOIN products p ON c.productID = p.productID WHERE c.userID = '$userID'";
        $result = mysqli_query($conn, $cartQuery);
        while ($row = mysqli_fetch_assoc($result)) {
            $total += $row['quantity'] * $row['price'];
        }

        // Elimină discountul voucherului și actualizează totalul în sesiune
        unset($_SESSION['voucher_discount']);
        $_SESSION['cart_total'] = $total;

        // Redirect sau răspuns AJAX
        echo json_encode(array("status" => "success", "message" => "Voucher eliminat cu succes."));
    } else {
        echo 'Eroare: Nu există o sesiune activă!';
    }
} else {
    echo 'Eroare: Acțiune invalidă sau date incomplete!';
}
?>
