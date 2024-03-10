<?php
require_once('config.php');

// Verifică dacă parametrii sunt setați și sunt trimiși prin cererea POST
if(isset($_GET['id'], $_GET['table'], $_GET['column'])) {
    // Preiați valorile parametrilor din cererea GET și GET
    $id = $_GET['id'];
    $table = $_GET['table'];
    $column = $_GET['column'];

    // Evitați injecțiile SQL utilizând prepared statements
    $sql = "DELETE FROM $table WHERE $column = ?";

    // Inițializați o declarație preparată
    $stmt = $conn->prepare($sql);

    // Verificați dacă declarația a fost pregătită corect
    if ($stmt) {
        // Legați parametrul ID la declarația preparată
        $stmt->bind_param("i", $id);

        // Executați declarația
        if ($stmt->execute()) {
            // Înregistrarea a fost ștearsă cu succes
            echo "Înregistrarea a fost ștearsă cu succes!";
        } else {
            // În caz de eroare la executarea declarației SQL
            echo "Eroare la ștergere: " . $stmt->error;
        }

        // Închideți declarația
        $stmt->close();
    } else {
        // În caz de eroare la pregătirea declarației SQL
        echo "Eroare la pregătirea declarației SQL: " . $conn->error;
    }
} else {
    // În cazul în care parametrii nu sunt setați corect
    echo "Parametrii lipsesc sau sunt incorecți.";
}

// Închideți conexiunea la baza de date
$conn->close();
?>
