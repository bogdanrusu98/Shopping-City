<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
include("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['id'])) {
        // Accesează valoarea 'id' din sesiune
        $id = $_SESSION['id'];
    } else {
        // Dacă 'id' nu este setat în sesiune, poți trata această situație
        echo "ID-ul nu este setat în sesiune.";
    }

    // Verifică dacă există fișierul încărcat
    if (isset($_FILES["fileToUpload"])) {
        // Verifică dacă există erori la încărcarea fișierului
        if ($_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
            $target_dir = "../uploads/avatar/"; // Directorul în care dorești să salvezi fișierul
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);


            // Verifică dimensiunea fișierului
            if ($_FILES["fileToUpload"]["size"] > 5000000) { // 5 MB
                echo "Scuze, fișierul este prea mare.";
            } else {
                // Permite doar anumite formate de fișiere
                $allowed_formats = array("jpg", "jpeg", "png", "gif");
                $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if (!in_array($file_extension, $allowed_formats)) {
                    echo "Scuze, doar fișierele JPG, JPEG, PNG și GIF sunt permise.";
                } else {
                    // Încearcă să muți fișierul încărcat în directorul de destinație
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "Fișierul " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " a fost încărcat cu succes.";


                        // Actualizarea bazei de date
                        $file_name = basename($_FILES["fileToUpload"]["name"]);
                        $sql = "UPDATE users SET avatar_href = '$target_file' WHERE id = '$id'";

                        if ($conn->query($sql) === TRUE) {
                            echo "Baza de date a fost actualizată cu succes.";
                        } else {
                            echo "Eroare la actualizarea bazei de date: " . $conn->error;
                        }

                        // Închide conexiunea cu baza de date
                        $conn->close();
                    } else {
                        echo "A apărut o eroare la încărcarea fișierului.";
                    }
                }
            }
        } else {
            echo "A apărut o eroare la încărcarea fișierului.";
        }
    } else {
        echo "Nu s-a încărcat niciun fișier.";
    }
}
