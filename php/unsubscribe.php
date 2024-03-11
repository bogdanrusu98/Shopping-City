<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
// Include configurația bazei de date și inițializează conexiunea cu baza de date
include('config.php');

// Verifică dacă există sesiunea pentru username
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
  } else {
    // Dacă nu există sesiune, redirecționează către pagina de autentificare
    header("Location: ../login.php"); // Înlocuiește cu pagina ta de autentificare
    exit();
  }

// Interogare pentru a prelua datele din baza de date
$sql = "SELECT * FROM users where id = $id";
$result = $conn->query($sql);


// Preia prima (și singura) înregistrare din rezultatele interogării
$row = $result->fetch_assoc();
$email = $row['email'];

// Încearcă să efectuezi ștergerea din baza de date
$sql = "DELETE FROM newsletter_subscribers WHERE email = '$email'";
if ($conn->query($sql) === TRUE) {
    echo "Te-ai dezabonat cu succes de la newsletter!";
} else {
    echo "Eroare la dezabonare: " . $conn->error;
}
?>
