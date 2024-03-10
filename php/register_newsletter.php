<?php

include('config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    if (isset($_POST['lastName'])) {
        $last_name = $_POST['lastName'];
    } else {
        $last_name = null; // sau poți seta o valoare implicită, în funcție de necesitățile tale
    }
    if (isset($_POST['firstName'])) {
        $first_name = $_POST['firstName'];
    } else {
        $first_name = null; // sau poți seta o valoare implicită, în funcție de necesitățile tale
    }
        
     // Interogare pentru a verifica dacă produsul se află în tabela de dorințe (wishlist) pentru utilizatorul curent
     $sql_check_email = "SELECT * FROM newsletter_subscribers WHERE email = '$email'";
     $result_check_wishlist = mysqli_query($conn, $sql_check_email);

     if (mysqli_num_rows($result_check_wishlist) > 0) {
         // Produsul se află în lista de dorințe, deci putem aplica un stil specific butonului de wishlist
         echo "Adresa de email este deja abonata";
        
        }else{


    $confirmation_code = uniqid();

    // Salvarea adresei de e-mail în baza de date
    $sql = "INSERT INTO newsletter_subscribers (email, first_name, last_name, confirmed, confirmation_code) VALUES ('$email', '$first_name', '$last_name', 0, '$confirmation_code')";
    if ($conn->query($sql) === TRUE) {
        // Generarea unui cod de confirmare unic


        // Trimiterea e-mailului de confirmare
        $to = $email;
        $subject = "Confirmare abonament newsletter";
        $message = "Bine ai venit! Pentru a confirma abonamentul la newsletter, accesează acest link: https://projectshopping.infinityfreeapp.com/php/confirm_newsletter.php?code=$confirmation_code";
        $headers = "From: newsletter@projectshopping.infinityfreeapp.com";

        // Trimiterea e-mailului
        mail($to, $subject, $message, $headers);

        echo "Un e-mail de confirmare a fost trimis la adresa $email.";
    } else {
        echo "Eroare la înregistrare.";
    }
}}
?>
