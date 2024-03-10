<?php
$error_message = "";


error_reporting(E_ALL);
ini_set('display_errors', 1);
// Verifică dacă utilizatorul este autentificat la începutul paginii
session_start();
include("../php/config.php");
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // Dacă nu este autentificat, redirecționează către pagina de login sau altă destinație
    header('Location: login.php');
    exit();
}
$error_message = " ";


// Verifică dacă sunt trimise date prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preiați datele din formular

    $footer_about = isset($_POST['footer_about']) ? $_POST['footer_about'] : null;
    $contact_address = isset($_POST['contact_address']) ? $_POST['contact_address'] : null;
    $contact_phone = isset($_POST['contact_phone']) ? $_POST['contact_phone'] : null;
    $contact_email = isset($_POST['contact_email']) ? $_POST['contact_email'] : null;
    $social_facebook = isset($_POST['social_facebook']) ? $_POST['social_facebook'] : null;
    $social_instagram = isset($_POST['social_instagram']) ? $_POST['social_instagram'] : null;
    $social_whatsapp = isset($_POST['social_whatsapp']) ? $_POST['social_whatsapp'] : null;


    // Construiește interogarea SQL de actualizare
    $sql = "UPDATE index_settings SET ";

    $set_values = array();

    if ($footer_about !== null && $footer_about !== '') {
        $set_values[] = "footer_about='$footer_about'";
    }
    if ($contact_address !== null && $contact_address !== '') {
        $set_values[] = "contact_address='$contact_address'";
    }
    if ($contact_phone !== null && $contact_phone !== '') {
        $set_values[] = "contact_phone='$contact_phone'";
    }
    if ($contact_email !== null && $contact_email !== '') {
        $set_values[] = "contact_email='$contact_email'";
    }
    if ($social_facebook !== null && $social_facebook !== '') {
        $set_values[] = "social_facebook='$social_facebook'";
    }
    if ($social_instagram !== null && $social_instagram !== '') {
        $set_values[] = "social_instagram='$social_instagram'";
    }
    if ($social_whatsapp !== null && $social_whatsapp !== '') {
        $set_values[] = "social_whatsapp='$social_whatsapp'";
    }

    $sql .= implode(", ", $set_values);

    $sql .= " WHERE id=1"; // Schimbă 'nume_tabel' și 'id' conform nevoilor tale
    // Execută interogarea SQL
    if ($conn->query($sql) === TRUE) {
        $error_message = "<span class='alert alert-success ms-2'>Actualizare realizată cu succes</span>";
    } else {
        $error_message = "<span class='alert alert-danger ms-2'>Eroare la actualizare: . $conn->error</span>";
    }
}

// Închideți conexiunea la baza de date
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
    <!-- Link către fișierul CSS Bootstrap -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping Project</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">


    <!--ICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo-color.png">

    <!--CSS-->
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/cookies.css">


    <style>
        /* Stiluri personalizate pentru sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            /* Asigură că sidebarul se va suprapune peste conținutul principal */
            padding: 48px 0;
            /* Padding pentru spațierea elementelor din sidebar */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Umbră pentru stilizare */
            background-color: #f8f9fa;
            /* Culoare de fundal pentru sidebar */
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            /* Înălțimea sidebarului minus paddingul de sus */
            padding-top: 0.5rem;
            /* Spațiere suplimentară pentru elementele din sidebar */
            overflow-x: hidden;
            /* Asigură că overflow-ul orizontal este ascuns */
            overflow-y: auto;
            /* Permite scroll vertical dacă conținutul depășește înălțimea */
        }

        /* Stiluri pentru elementele din sidebar */
        .sidebar .nav-link {
            font-weight: 500;
            /* Greutatea fontului pentru link-uri */
            color: #333;
            /* Culoarea textului pentru link-uri */
        }

        /* Stiluri pentru elementele active din sidebar */
        .sidebar .nav-link.active {
            color: #007bff;
            /* Culoarea textului pentru link-ul activ */
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        td {
            width: auto;
        }
    </style>
</head>

<body>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark col-md-12 mb-5">
        <a class="navbar-brand ms-4" href="admin.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Pagina principală</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="items.php">Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create-vouchers.php">Vouchers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Index</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index-settings.php">Index Settings</a>
                </li>
            </ul>
            <a href="../index.php" class="text-warning ms-auto d-block">Catre site</a>
        </div>
    </nav>




    <h1 class="text-center">Setari website</h1><br>
    <div class="container">
        <form action="index-settings.php" method="POST" class="shadow-lg p-3 mb-5 bg-body rounded">

            <div class="row">
                <h3>Footer</h3>
                <div class="mb-3 col-md-6">
                    <label for="footer_about" class="form-label">Footer - Despre noi</label>
                    <textarea class="form-control" name="footer_about" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <h3>Contact</h3>
                <div class="mb-3 col-md-4">
                    <label for="contact_address" class="form-label">Contact Adresa</label>
                    <input type="text" class="form-control" name="contact_address">
                </div>
                <div class="mb-3 col-md-4">
                    <label for="contact_phone" class="form-label">Contact Numar Telefon</label>
                    <input type="text" class="form-control" name="contact_phone">
                </div>
                <div class="mb-3 col-md-4">
                    <label for="contact_email" class="form-label">Contact Adresa Email</label>
                    <input type="email" class="form-control" name="contact_email">
                </div>
            </div>
            <div class="row">
                <h3>Social Buttons</h3>
                <div class="mb-3 col-md-4">
                    <label for="social_facebook" class="form-label">Social Facebook</label>
                    <input type="text" class="form-control" name="social_facebook">
                </div>
                <div class="mb-3 col-md-4">
                    <label for="social_instagram" class="form-label">Social instagram</label>
                    <input type="text" class="form-control" name="social_instagram">
                </div>
                <div class="mb-3 col-md-4">
                    <label for="social_whatsapp" class="form-label">Social Whatsapp</label>
                    <input type="text" class="form-control" name="social_whatsapp">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <?= $error_message; ?>
    </div>
    </form>


    </div>
























    <!-- Modal pentru adaugarea de produse -->
    <div class="modal fade" id="addItem" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockModalLabel">Adaugare produs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" id="myForm1">
                        <div class="form-group">
                            <label for="name">Nume Produs</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Descriere</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Preț</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="stockQuantity">Cantitate în Stoc</label>
                            <input type="number" class="form-control" id="stockQuantity" name="stockQuantity" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Imagine</label>
                            <input type="file" class="form-control-file" id="image" name="image" required accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="category">Categorie</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anulează</button>
                        <button type="button" class="btn btn-primary" id="saveStockChanges" onclick="submitForm('myForm1')">Salvează Modificările</button>
                    </div>
                </div>
            </div>
        </div>





        <script>
            function searchName() {
                var tableName = "products"; // înlocuiește "numele_tabelului" cu numele real al tabelului
                var column = "name";
                var searchInput = document.getElementById("searchInput").value;
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("searchResult").innerHTML = xhr.responseText;
                    }
                };

                // Verifică dacă URL-ul conține deja parametri
                var url = "../php/admin-search.php?";
                if (searchInput.trim() !== "") {
                    url += "q=" + encodeURIComponent(searchInput) + "&";
                }
                url += "table=" + tableName + "&column=" + column;

                xhr.open("GET", url, true);
                xhr.send();
            }
        </script>

        <script>
            function submitForm(formId) {
                var form = document.getElementById(formId);
                if (form) {
                    form.submit();
                } else {
                    console.error("Formularul cu ID-ul specificat nu a fost găsit.");
                }
            }
        </script>



        <script>
            function goProduct(productID) {
                window.location.href = 'product.php?id=' + productID;
            }

            function openImageInNewWindow(imageSrc) {
                // Deschide imaginea într-o fereastră nouă
                window.open(imageSrc, '_blank');
            }
        </script>

        <script>
            function toggleMessage(messageId) {
                var messageDiv = document.getElementById(messageId);
                if (messageDiv.style.display === 'none') {
                    messageDiv.style.display = 'block';
                } else {
                    messageDiv.style.display = 'none';
                }
            }
        </script>
        <script>
            function deleteRecord(id) {
                var table = "products"; // înlocuiește "numele_tabelului" cu numele real al tabelului
                var column = "productID";

                if (confirm("Sigur doriți să ștergeți această înregistrare?")) {
                    $.ajax({
                        url: '../php/delete-item.php?table=' + table + '&column=' + column,
                        type: 'GET',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            console.log("Id-ul este: " + id);
                            // Dacă ștergerea a fost realizată cu succes, reîmprospătați pagina sau faceți altceva în funcție de necesități
                            alert("Înregistrarea a fost ștearsă cu succes!");
                            window.location.reload(); // Reîncărcați pagina pentru a actualiza lista de rezultate
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            // Afișați un mesaj de eroare sau faceți altceva în funcție de necesități
                        }
                    });
                }
            }
        </script>

        <!-- Scripturile Bootstrap (jQuery și Popper.js) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <!-- Scriptul Bootstrap -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>