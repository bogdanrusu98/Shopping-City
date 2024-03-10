<?php
// Verificați dacă există o sesiune pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("config.php");

// Verificați dacă utilizatorul este autentificat
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $productID = $_POST['productID']; // Presupunând că productID este trimis prin POST
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Dacă cantitatea nu este definită, folosește 1 ca valoare implicită

    // Verificați dacă cantitatea este mai mare decât cea din stoc
    $sql_check_stock = "SELECT stockQuantity FROM products WHERE productID = '$productID'";
    $result_check_stock = mysqli_query($conn, $sql_check_stock);

    if (!$result_check_stock) {
        die("Eroare la interogarea stocului: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result_check_stock) > 0) {
        $row_stock = mysqli_fetch_assoc($result_check_stock);
        $stockQuantity = $row_stock['stockQuantity'];

        if ($quantity > $stockQuantity) {
            die("Cantitatea cerută este mai mare decât stocul disponibil!");
        }
    }

    // Verificați dacă produsul există deja în coșul de cumpărături al utilizatorului
    $sql_check_cart = "SELECT * FROM cart WHERE userID = '$id' AND productID = '$productID'";
    $result_check_cart = mysqli_query($conn, $sql_check_cart);
    $count_cart_items = mysqli_num_rows($result_check_cart);

    if ($count_cart_items > 0) {
        // Produsul există deja în coș, așa că actualizați doar cantitatea
        $row = mysqli_fetch_assoc($result_check_cart);
        $current_quantity = $row['quantity'];
        $new_quantity = $current_quantity + $quantity;

        // Actualizați cantitatea în coșul de cumpărături
        $sql_update_cart = "UPDATE cart SET quantity = '$new_quantity' WHERE userID = '$id' AND productID = '$productID'";
        if (mysqli_query($conn, $sql_update_cart)) {
            header("Location: ../cart/products.php");
            exit();
        } else {
            echo "Eroare la actualizarea cantității în coș: " . mysqli_error($conn);
        }
    } else {
        // Produsul nu există încă în coș, așa că adăugați-l
        // Executare instrucțiune SQL pentru inserarea în tabela cart
        $sql_insert_cart = "INSERT INTO cart (userID, productID, quantity) VALUES ('$id', '$productID', '$quantity')";
        if (mysqli_query($conn, $sql_insert_cart)) {
            header("Location: ../cart/products.php");
            exit();
        } else {
            echo "Eroare la adăugarea produsului în coș: " . mysqli_error($conn);
        }
    }
} else {
    echo "Trebuie să fiți autentificat pentru a adăuga produse în coș!";
}

// Închideți conexiunea la baza de date
mysqli_close($conn);
