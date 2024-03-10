<?php
$message = "";
// Verifică dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Includeți fișierul de conexiune la baza de date
    include '../php/config.php';

    // Preiați datele din formular
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stockQuantity'];
    $category = $_POST['category'];

    // Verificați dacă fișierul a fost încărcat cu succes
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Verificați tipurile de fișiere permise
        $allowedExtensions = array('jpg', 'jpeg', 'png');

        if (in_array($fileExtension, $allowedExtensions)) {
            // Generează un nume unic pentru imagine
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../uploads/items/';
            $uploadFileDir2 = 'uploads/items/' . $newFileName;
            $dest_path = $uploadFileDir . $newFileName;

            // Mută fișierul încărcat în directorul dorit
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Inserează datele în baza de date
                $sql = "INSERT INTO products (name, description, price, stockQuantity, imageHref, category) 
                        VALUES ('$name', '$description', $price, $stockQuantity, '$uploadFileDir2', '$category')";

                if (mysqli_query($conn, $sql)) {
                    $message = '<div class="container mt-3 alert alert-success" role="alert">
                            Produsul a fost adăugat cu succes.
                          </div>';
                } else {
                    $message = '<div class="container mt-3 alert alert-danger" role="alert">
                            Eroare: ' . $sql . "<br>" . mysqli_error($conn) . '
                          </div>';
                }
            } else {
                $message = '<div class="container mt-3 alert alert-danger" role="alert">
                        A apărut o eroare la încărcarea imaginii.
                      </div>';
            }
        } else {
            $message = '<div class="container mt-3 alert alert-danger" role="alert">
                    Tipul de fișier nu este permis. Se acceptă doar fișiere de tip JPG, JPEG și PNG.
                  </div>';
        }
    } else {
        $message = '<div class="container mt-3 alert alert-danger" role="alert">
                A apărut o eroare la încărcarea imaginii.
              </div>';
    }

    // Închideți conexiunea la baza de date
    mysqli_close($conn);
}
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

    <div class="container text-center">
        <h1>Căutare Produs</h1>
        <input style="max-width: 600px;" type="text" id="searchInput" class="form-control mx-auto" placeholder="Introduceți numele...">
        <button class="btn btn-primary mt-2" onclick="searchName()">Caută</button>
    </div>

    </div>
    <button class="w-100 btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#addItem">Adauga un produs</button> <?= $message ?>
    <div id="searchResult" class="mx-5">
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