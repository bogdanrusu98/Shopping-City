<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifică dacă utilizatorul este autentificat
if (!isset($_SESSION['id'])) {
    // Redirecționează utilizatorul către pagina de autentificare sau afișează un mesaj de eroare
    header("Location: ../login.php");
    exit(); // Oprește execuția scriptului pentru a preveni procesarea ulterioară
}

// Verifică dacă a fost trimis un ID de voucher pentru ștergere
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Include fișierul de configurare pentru conectarea la baza de date
    include 'config.php';

    // Previne injecțiile SQL și filtrează id-ul voucherului trimis
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Construiește și execută interogarea SQL pentru ștergere
    $delete_query = "DELETE FROM addresses WHERE id = '$id' AND user_id = '{$_SESSION['id']}'";
    if (mysqli_query($conn, $delete_query)) {
        // Redirectează utilizatorul înapoi la pagina principală sau afișează un mesaj de succes
        header("Location: ../user/addresses.php?delete_success=true");
        $error_message = "error oare?";
        exit();
    } else {
        // Afișează un mesaj de eroare în caz de eșec la ștergere
        echo "Eroare la ștergerea voucherului: " . mysqli_error($conn);
    }

    // Închide conexiunea la baza de date
    mysqli_close($conn);
} else {
    // Redirecționează utilizatorul către o pagină de eroare sau afișează un mesaj corespunzător
    header("Location: error.php");
    exit(); // Oprește execuția scriptului pentru a preveni procesarea ulterioară
}
