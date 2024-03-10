<?php
session_start(); // Începe sesiunea pentru a accesa variabilele de sesiune

// Verifică dacă utilizatorul este autentificat
if (isset($_SESSION['id'])) {
    include("config.php");

    // Verifică dacă s-a trimis un ID valid de produs pentru wishlist
    if (isset($_POST['productID'])) {
        $productID = $_POST['productID'];
        $userID = $_SESSION['id'];

        // Verifică dacă produsul este deja în wishlist
        $sql_check_wishlist = "SELECT * FROM wishlist WHERE user_id = '$userID' AND product_id = '$productID'";
        $result_check_wishlist = mysqli_query($conn, $sql_check_wishlist);

        if (mysqli_num_rows($result_check_wishlist) > 0) {
            // Produsul există deja în wishlist, deci elimină-l
            $sql_remove_from_wishlist = "DELETE FROM wishlist WHERE user_id = '$userID' AND product_id = '$productID'";
            if ($conn->query($sql_remove_from_wishlist) === TRUE) {
                echo "Produsul a fost eliminat din lista de dorințe!";
            } else {
                echo "Eroare la eliminarea produsului din lista de dorințe: " . $conn->error;
            }
        } else {
            // Produsul nu este în wishlist, deci adaugă-l
            $sql_add_to_wishlist = "INSERT INTO wishlist (user_id, product_id) VALUES ('$userID', '$productID')";
            if ($conn->query($sql_add_to_wishlist) === TRUE) {
                echo "Produsul a fost adăugat în lista de dorințe!";
            } else {
                echo "Eroare la adăugarea produsului în lista de dorințe: " . $conn->error;
            }
        }

        // Redirecționează utilizatorul către pagina de dorințe sau alte acțiuni specifice
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Închide conexiunea la baza de date
    $conn->close();
} else {
    // Redirecționează utilizatorul către pagina de autentificare sau afișează un mesaj că trebuie să fie autentificat
    echo "Utilizatorul nu este logat.";
    exit;
}
