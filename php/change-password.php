<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

include("config.php");

// Verifică dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_password'];

    // Verifică dacă câmpurile sunt completate
    if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        echo "Toate câmpurile sunt obligatorii.";
    } else {
        // Presupunem că $userId este ID-ul utilizatorului curent
        $userId = $_SESSION['id']; 

        // Obține parola actuală a utilizatorului din baza de date
        $query = "SELECT passwd FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verifică dacă parola actuală este corectă
        if (password_verify($currentPassword, $user['passwd'])) {
            // Verifică dacă noua parolă și confirmarea acesteia se potrivesc
            if ($newPassword === $confirmNewPassword) {
                // Actualizează parola în baza de date
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE users SET passwd = ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("si", $newPasswordHash, $userId);
                $updateStmt->execute();

                if ($updateStmt->affected_rows === 1) {
                    echo "Parola a fost schimbată cu succes.";
                } else {
                    echo "Eroare la actualizarea parolei.";
                }
            } else {
                echo "Noua parolă și confirmarea acesteia nu se potrivesc.";
            }
        } else {
            echo "Parola actuală introdusă nu este corectă.";
        }
    }
}