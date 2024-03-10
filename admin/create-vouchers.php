<?php
// Include fișierul de configurare al bazei de date și stabilește conexiunea
include("../php/config.php");

$error_message = null;
$message = "";

// Verifică dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preia datele din formular

    $discount_amount = $_POST['discount_amount'];
    $expiration_date = $_POST['expiration_date'];


    // Generează un ID unic
    $unique_id = uniqid();

    // Formatează ID-ul unic în seria voucherului dorită
    $voucher_code = chunk_split(substr($unique_id, 0, 19), 4, '-');



    // Verifică dacă seria voucherului este unică în baza de date
    $check_query = "SELECT * FROM vouchers WHERE voucher_code = '$voucher_code'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        echo "Seria voucherului există deja în baza de date.";
    } else {
        // Inserează datele voucherului în baza de date
        $insert_query = "INSERT INTO vouchers (voucher_code, discount_amount, expiration_date) VALUES ('$voucher_code', '$discount_amount', '$expiration_date')";
        if (mysqli_query($conn, $insert_query)) {
            $error_message = "<span class='alert alert-success ms-2'>Voucher creat. $voucher_code</span>";
        } else {
            echo "Eroare la crearea voucherului: " . mysqli_error($conn);
        }
    }

    // Închide conexiunea la baza de date
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Voucher</title>
    <!-- Link către fișierul CSS Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/nav.css">



    <style>
        .my-account {
            display: flex;

        }

        .sidebar {
            width: 200px;
            /* Lățimea sidebar-ului */
            color: black;
            /* Culoarea textului din sidebar */
            background-color: #f2f2f2;

        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: bold;
            color: black;
        }

        .sidebar ul li i {
            font-size: 30px;
            color: #abd373;
        }

        .sidebar ul li:hover {
            background-color: lightgrey;
            color: white !important;
        }

        .sidebar ul li a {
            color: black;
            text-decoration: none;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f2f2f2;
            /* Culoarea de fundal a conținutului principal */
        }

        .image-avatar {
            position: relative;
            display: inline-block;
        }

        @media only screen and (max-width: 578px) {
            .container.my-account {
                flex-direction: column;
                /* Schimbă direcția flexbox la coloană */
            }

            .sidebar {
                margin-top: 1rem;
                margin-bottom: 1rem;
                order: 2;
                /* Schimbă ordinea sidebar-ului */
                width: 100%;
                /* Ocupă întreaga lățime pe ecranele mici */
                overflow: hidden;
            }

            .content {
                order: 1;
                /* Schimbă ordinea conținutului */
            }

            .my-account {
                height: auto;
            }
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
        <h1>Căutare Voucher</h1>
        <input style="max-width: 600px;" type="text" id="searchInput" class="form-control mx-auto" placeholder="Introduceți numele...">
        <button class="btn btn-primary mt-2" onclick="searchName()">Caută</button>
    </div>

    </div>
    <button class="w-100 btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#addItem">Creeaza voucher</button> <?= $message ?>
    <div id="searchResult" class="mx-5">
    </div>

    <?= $error_message ?>

    <div class="container">

    </div>









    <!-- Modal pentru adaugarea de produse -->
    <div class="modal fade" id="addItem" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockModalLabel">Creeaza voucher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="my-4" method="post" id="myForm1">
                        <div class="mb-3">
                            <label for="valoare">Valoare Voucher:</label><br>
                            <input type="text" class="form-control" id="discount_amount" name="discount_amount"><br>
                        </div>
                        <div class="mb-3">
                            <label for="expiration_date">Data Expirării:</label><br>
                            <input type="date" class="form-control" id="expiration_date" name="expiration_date"><br><br>
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
                var searchInput = document.getElementById("searchInput").value;
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("searchResult").innerHTML = xhr.responseText;
                    }
                };
                xhr.open("GET", "../php/admin-search-vouchers.php?q=" + searchInput, true);
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
</body>

</html>