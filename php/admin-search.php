<?php
require_once('config.php');


// Preiați interogarea de căutare de la parametrul GET
$q = isset($_GET['q']) ? $_GET['q'] : '';
$table = $_GET['table']; // preia numele tabelului din cererea AJAX
$column = $_GET['column']; // preia numele tabelului din cererea AJAX
$column2 = $column;


// Interogarea pentru a căuta informațiile în baza de date
$sql = "SELECT * FROM $table WHERE $column2 LIKE '%$q%'";
$result = $conn->query($sql);

        if ($result->num_rows > 0) {
            if ($table === 'indexes') {
                // Afișează altceva în loc de tabel pentru indexes
                // Afișează rezultatele sub formă de tabel
                echo "<table border='1' class='table table-striped my-3 align-middle'>
                <thead class='table-dark align-middle'>
                <tr>
            
                <th><a href='?sort=id&q=$q'>ID produs</a></th><script>console.log($q)</script>
                <th><a href='?sort=name&q=$q'>Nume</a></th>
                <th>Actiuni</th>
                <th></th>

                </tr>
                </thead>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td><button class='btn btn-danger me-3' onclick='deleteRecord(" . $row['id'] . ")'><i class='fa-solid fa-trash-can'></i> Șterge</button>";
                }
                    echo "</tr>";
                echo "</table>";
            } elseif ($table === 'products') {
                // Afișează rezultatele sub formă de tabel
                echo "<table border='1' class='table table-striped my-3 align-middle'>
                <thead class='table-dark align-middle'>
                <tr>
            
                <th><a href='?sort=productID&q=$q'>ID produs</a></th><script>console.log($q)</script>
                <th><a href='?sort=name&q=$q'>Nume</a></th>
                <th><a href='?sort=price&q=$q'>Pret</a></th>
                <th><a href='?sort=stockQuantitye&q=$q'>Stoc disponibil</a></th>
                <th><a href='?sort=rating&q=$q'>Rating</a></th>
                <th><a href='?sort=category&q=$q'>Categorie</a></th>
                <th><a href='?sort=imageHref&q=$q'>Img Href</a></th>
                <th></th>
                <th>Actiuni</th>
                <th></th>
                </tr>
                </thead>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['productID'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['stockQuantity'] . "</td>";
                    echo "<td>" . $row['rating'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td> <img width='100px' height='100px' src='../" . $row['imageHref'] . "'onclick='openImageInNewWindow(this.src)'</img>". "</td>";
                    echo "<td><button class='btn btn-primary' onclick='toggleMessage(\"message_" . $row['productID'] . "\")'><i class='fa-solid fa-eye'></i> Mesaj</button></td>";
                    echo "<td><button class='btn btn-danger' onclick='deleteRecord(" . $row['productID'] . ")'><i class='fa-solid fa-trash-can'></i> Șterge</button></td>";
                    echo "<td><button type='button' class='btn btn-warning'  onclick='goProduct(" . $row['productID'] . ")' data-bs-toggle='modal' data-bs-target='#exampleModal'><i class='fa-solid fa-pen'></i> Editeaza</button></td>";
                
                }
            echo "</tr>";
                
                echo "</table>";
                
            
            }else{
                    // Afișează rezultatele sub formă de tabel
                    echo "<table border='1' class='table table-striped my-3 align-middle'>
                    <thead class='table-dark align-middle'>
                    <tr>
                
                    <th><a href='?sort=id&q=$q'>ID comanda</a></th><script>console.log($q)</script>
                    <th><a href='?sort=name&q=$q'>Nume</a></th>
                    <th><a href='?sort=id&q=$q'>Adresa Livrare</a></th>
                    <th><a href='?sort=name&q=$q'>Adresa Facturare</a></th>
                    <th><a href='?sort=id&q=$q'>Status</a></th>
                    <th><a href='?sort=name&q=$q'>Plata</a></th>
                    <th><a href='?sort=name&q=$q'>Suma totala</a></th>
                    <th>Actiuni</th>
                    <th></th>
    
                    </tr>
                    </thead>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['address_d'] . "</td>";
                        echo "<td>" . $row['address_f'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['payment'] . "</td>";
                        echo "<td>" . $row['total_amount'] . "</td>";
                        echo "<td><button type='button' class='btn btn-warning'  onclick='goProduct(" . $row['order_id'] . ")' data-bs-toggle='modal' data-bs-target='#exampleModal'><i class='fa-solid fa-pen'></i> Editeaza</button></td>";
                    }
                        echo "</tr>";
                    echo "</table>";
            }
            echo "</table>";

        $conn->close();
        }