<?php
require_once('config.php');

// Preiați interogarea de căutare de la parametrul GET
$q = isset($_GET['q']) ? $_GET['q'] : '';

// Interogarea pentru a căuta informațiile în baza de date
$sql = "SELECT * FROM vouchers WHERE voucher_id LIKE '%$q%' OR voucher_code LIKE '%$q%' OR user_id LIKE '%$q%'";
$result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Afișați rezultatele sub formă de tabel
            echo "<table border='1' class='table table-striped my-3 align-middle'>
            <thead class='table-dark align-middle'>
            <tr>
        
            <th><a href='?sort=voucher_id&q=$q'>ID voucher</a></th><script>console.log($q)</script>
            <th><a href='?sort=voucher_code&q=$q'>Cod Voucher</a></th>
            <th><a href='?sort=discount_amount&q=$q'>Discount</a></th>
            <th><a href='?sort=expiration_date&q=$q'>Data expirare</a></th>
            <th><a href='?sort=is_active&q=$q'>Activ</a></th>
            <th><a href='?sort=user_id&q=$q'>user_id</a></th>
            <th></th>
            <th>Actiuni</th>
            <th></th>
            </tr>
            </thead>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['voucher_id'] . "</td>";
                echo "<td>" . $row['voucher_code'] . "</td>";
                echo "<td>" . $row['discount_amount'] . "</td>";
                echo "<td>" . $row['expiration_date'] . "</td>";
                echo "<td>" . $row['is_active'] . "</td>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td><button class='btn btn-primary' onclick='toggleMessage(\"message_" . $row['voucher_id'] . "\")'><i class='fa-solid fa-eye'></i> Mesaj</button></td>";
                echo "<td><button class='btn btn-danger' onclick='deleteRecord(" . $row['voucher_id'] . ")'><i class='fa-solid fa-trash-can'></i> Șterge</button></td>";
                echo "<td><button type='button' class='btn btn-warning'  onclick='goProduct(" . $row['voucher_id'] . ")' data-bs-toggle='modal' data-bs-target='#exampleModal'><i class='fa-solid fa-pen'></i> Editeaza</button></td>";
               
        
        echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Niciun rezultat găsit";
        }
        $conn->close();
        
