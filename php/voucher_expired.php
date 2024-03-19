<?php
include("config.php");  // Acest fișier ar trebui să conțină informații pentru conectarea la baza de date

// Query pentru a selecta voucherele expirate care sunt încă active
$sql = "UPDATE vouchers SET is_active = 0 WHERE expiration_date < NOW() AND is_active = 1";

if ($conn->query($sql) === TRUE) {
    echo "Voucherele expirate au fost actualizate.";
} else {
    echo "Eroare la actualizarea voucherelor: " . $conn->error;
}

$conn->close();
?>
