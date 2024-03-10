<?php
require_once('config.php');

// Verifică dacă sunt trimise date prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preiați datele din formular
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $checkin = isset($_POST['checkin']) ? $_POST['checkin'] : null;
    $checkout = isset($_POST['checkout']) ? $_POST['checkout'] : null;
    $nume = isset($_POST['nume']) ? $_POST['nume'] : null;
    $prenume = isset($_POST['prenume']) ? $_POST['prenume'] : null;
    $telefon = isset($_POST['telefon']) ? $_POST['telefon'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $cabane = isset($_POST['cabane']) ? $_POST['cabane'] : null;

    // Verificați dacă există mai multe cabane selectate
    if (is_array($cabane) && count($cabane) > 0) {
        // Concatenați valorile cabanelor separate prin virgulă
        $cabane_value = implode(",", $cabane);
    } else {
        // Dacă există doar o singură cabană selectată sau niciuna
        $cabane_value = $cabane;
    }

    // Construiește interogarea SQL de actualizare
    $set_values = array();
    if ($checkin !== null && $checkin !== '') {
        $set_values[] = "checkin='$checkin'";
    } 
    if ($checkout !== null && $checkout !== '') {
        $set_values[] = "checkout='$checkout'";
    }
    if ($nume !== null && $nume !== '') {
        $set_values[] = "nume='$nume'";
    }
    if ($prenume !== null && $prenume !== '') {
        $set_values[] = "prenume='$prenume'";
    }
    if ($telefon !== null && $telefon !== '') {
        $set_values[] = "telefon='$telefon'";
    }
    if ($email !== null && $email !== '') {
        $set_values[] = "email='$email'";
    }
    if ($cabane !== null && $cabane !== '') {
        $set_values[] = "cabane='$cabane_value'";
    }

    $sql = "UPDATE reservations SET " . implode(", ", $set_values) . " WHERE id='$id'";

    // Execută interogarea SQL
    if ($conn->query($sql) === TRUE) {
        echo "Actualizare realizată cu succes.";
    } else {
        echo "Eroare la actualizare: " . $conn->error;
    }
}

// Închideți conexiunea la baza de date
$conn->close();
