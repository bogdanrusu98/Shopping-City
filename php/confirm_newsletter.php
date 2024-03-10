<?php
include 'config.php';

if (isset($_GET['code'])) {
    $confirmation_code = $_GET['code'];

     // Interogare pentru a verifica dacă produsul se află în tabela de dorințe (wishlist) pentru utilizatorul curent
     $sql_check_confirmation_code = "SELECT * FROM newsletter_subscribers WHERE confirmation_code = '$confirmation_code'";
     $result_check_wishlist = mysqli_query($conn, $sql_check_confirmation_code);

     if (mysqli_num_rows($result_check_wishlist) > 0) {
         // Actualizarea înregistrării din baza de date la confirmarea abonamentului
         $sql = "UPDATE newsletter_subscribers SET confirmed = 1 WHERE confirmation_code = '$confirmation_code'";
         if ($conn->query($sql) === TRUE) {
             echo "Abonamentul la newsletter a fost confirmat cu succes!";
         } else {
             echo "Eroare la confirmarea abonamentului.";
         }
     }else{
        echo "Codul este incorect. Contacteaza suport clienti.";
     }

}
?>
