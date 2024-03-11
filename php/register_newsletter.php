<?php
include('config.php');

$response = array(); // Variabilă pentru stocarea răspunsului către client

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;

    if ($email) {
        // Verificăm dacă adresa de email există deja în baza de date
        $sql_check_email = "SELECT * FROM newsletter_subscribers WHERE email = '$email'";
        $result_check_email = mysqli_query($conn, $sql_check_email);

        if (mysqli_num_rows($result_check_email) > 0) {
            // Adresa de email există deja în baza de date
            $response['status'] = 'error';
            $response['message'] = 'Adresa de email este deja abonată.';
        } else {
            // Adresa de email nu există în baza de date, putem proceda cu înregistrarea

            $confirmation_code = uniqid();

            // Salvăm adresa de email în baza de date
            $sql_insert_subscription = "INSERT INTO newsletter_subscribers (email, name, confirmed, confirmation_code) VALUES ('$email', '$name', 0, '$confirmation_code')";
            if ($conn->query($sql_insert_subscription) === TRUE) {
                // Generăm un cod de confirmare unic și trimitem un e-mail de confirmare
                $to = $email;
                $subject = "Confirmare abonament newsletter";
                $message = "Bine ai venit! Pentru a confirma abonamentul la newsletter, accesează acest link: https://projectshopping.infinityfreeapp.com/php/confirm_newsletter.php?code=$confirmation_code";
                $headers = "From: newsletter@projectshopping.infinityfreeapp.com";

                // Trimiterea e-mailului
                mail($to, $subject, $message, $headers);

                $response['status'] = 'success';
                $response['message'] = "Un e-mail de confirmare a fost trimis la adresa $email.";
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Eroare la înregistrare.';
            }
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Adresa de email lipsește.';
    }

    // Returnăm răspunsul către client sub formă de JSON
    echo json_encode($response);
}
?>
