<?php
// Verificați dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Includeți fișierul de configurare al bazei de date și stabiliți conexiunea
include("../php/config.php");
include("../php/total_products.php");
include("../php/total_products_wishlist.php");
include("../php/check_settings.php");


$display_voucher = "d-none";
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
} else {
    header('Location: ../login.php');
    exit();
}



$total = null;
$price_total = null;
$display = '';
// Verificați dacă utilizatorul este autentificat și obțineți ID-ul acestuia
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];

    // Interogare pentru a obține produsele din coș pentru utilizatorul curent
    $sql = "SELECT c.*, p.name, p.rating, p.price, p.imageHref, p.stockQuantity 
        FROM cart c 
        INNER JOIN products p ON c.productID = p.productID 
        WHERE c.userID = $userID";

    $result = mysqli_query($conn, $sql);
    

?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
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
        
        <link rel="stylesheet" href="../css/nav.css">
        <style>
            .feature-icon {
                font-size: 2.5rem;
                color: #abd373;
                /* Albastru pentru iconuri */
            }

            .feature-description {
                font-size: 1rem;
                color: #333;
                /* Culoare text pentru descriere */
            }

            .feature-box {
                height: 135px;
                padding: 20px;
                /* Spațiu intern pentru cutiile de caracteristici */
                margin-bottom: 20px;
                /* Spațiu între cutiile de caracteristici */
            }
        </style>
    </head>

    <body>
        <div class="container" id="Follow">
            <div class="d-flex justify-content-between align-items-center">
                <p class="fw-lighter mt-3">Follow Us:
                    <a href="#" class="ms-3"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="ms-3"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="ms-3"><i class="fa-brands fa-whatsapp"></i></a>
                </p>
                <div class="dropdown">
                    <a class="dropdown-toggle" style="color: grey; text-decoration: none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        My Account
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if (isset($_SESSION['email'])) { ?>
                            <!-- Dacă utilizatorul este autentificat, afișează alte opțiuni -->
                            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="../user/myaccount.php">Profile</a></li>
                            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="../settings/settings.php">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <form method="post" action="../php/logout.php">
                                <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="../php/logout.php">Log out</a></li>
                            </form>
                        <?php } else { ?>
                            <!-- Dacă utilizatorul nu este autentificat, afișează opțiunile standard de login și creare cont -->
                            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="../login.php">Log In</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="../register.php">Create Account</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <hr class="mb-4">

            <!--Navigation Bar-->

            <nav class="navbar navbar-expand-lg navbar-light mb-4">
                <div class="container-fluid">
                    <a class="navbar-brand" href="../index.php">
                        <img src="../img/logo.png" alt="" width="150px" height="auto" class="d-inline-block align-text-top me-3"> <!-- Am adăugat clasa me-3 pentru un spațiu mic între imagine și buton -->
                    </a>
                    <button class="navbar-toggler button-aer" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Shopping City</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body text-white">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active rounded px-3" aria-current="page" href="../index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link rounded px-3" aria-current="page" href="../categories.php">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link rounded px-3" aria-current="page" href="../about.php">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link rounded px-3" aria-current="page" href="../faq.php">FAQs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link rounded px-3" aria-current="page" href="../contact.php">Contact</a>
                                </li>
                            </ul>
                            <a class="btn btn-primary d-none d-lg-inline-block position-relative me-3" href="products.php">
                                <i class="fa-solid fa-cart-shopping"></i> Cart
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $totalProducts ?>
                                </span>
                            </a>
                            <a class="btn btn-outline-primary text-dark d-none d-lg-inline-block position-relative me-3" href="../favorites.php">
                                <i class="fa-solid fa-heart text-danger"></i> Wishlist
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $totalProductsWishlist ?>
                                </span>
                            </a>

                            <a class="btn btn-outline-primary text-dark ms-auto d-block d-lg-none position-relative mb-3" href="../favorites.php">
                                <i class="fa-solid fa-heart text-danger"></i> Wishlist
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $totalProductsWishlist ?>
                                </span>
                            </a>

                            <a class="btn btn-primary ms-auto d-block d-lg-none position-relative mb-3" href="products.php">
                                <i class="fa-solid fa-cart-shopping"></i> Cart
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $totalProducts ?>
                                </span>
                            </a>
                            <!-- Am adăugat clasele ms-auto d-block d-lg-none pentru a poziționa butonul în dreapta pe dispozitivele mai mici decât lg -->
                            <form class="d-flex" action="../search_results.php" method="GET">
                                <input class="form-control me-2" name="search_query" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
            </nav>
        </div>
        </div>
        <div class="shadow-lg p-3 mb-5 bg-body rounded " id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb align-middle ">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item align-middle"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item align-middle active" aria-current="page">Cart</li>

                    </ol>
                </nav>
            </div>
        </div>



        <div class="container">

            <h4>Cosul meu</h4>


            <div class="row">
                <div class="col-md-8">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Extrage prețul și cantitatea produsului curent
                            $price = $row['price'];
                            $quantity = $row['quantity'];
                            $cartID = $row['cartID'];
                            $stockQuantity = $row['stockQuantity'];
                            // Calculează subtotalul pentru acest produs
                            $subtotal = $price * $quantity;

                            // Adaugă subtotalul la totalul general
                            $total += $subtotal;
                            $price_total = $total;
                            $display = "d-block";
                            $stockQuantity >= $quantity ? $display_stock = 'd-none' : $display_stock = 'd-block';
                    ?>
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <a href="../product.php?id=<?php echo $row['productID']; ?>">
                                            <img src="<?php echo "../" . $row['imageHref'] ?>" class="img-thumbnail rounded-start centered-image" width="150px" alt="...">
                                        </a>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body mt-4">
                                            <a href="../product.php?id=<?php echo $row['productID']; ?>">
                                                <h5 class="card-title fw-bold"><?= $row['name'] ?></h5>
                                            </a>
                                            <div class="text-danger <?=$display_stock?>">Produsul nu se mai afla in stoc. Va rugam sa scoateti produsul din cos inainte de a incerca sa plasati comanda.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card-body">
                                            <h5 class="card-title mb-0 pt-3"><strong><?php  echo $row['price'] . ' lei' ?></strong></h5>
                                            <form id="quantityForm">
                                                <div class="mb-3">
                                                    <label for="quantity" class="form-label">Quantity:</label>
                                                    <input type="number" class="form-control" id="quantity" value="<?= $row['quantity'] ?>" name="quantity" min="1" max="10" onchange="updateCart(<?php echo $row['productID']; ?>, this.value)">
                                                </div>
                                            </form>
                                            <form method="post" action="../php/remove_from_cart.php">
                                                <input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">
                                                <button type="submit" class="btn btn-danger"><i class='fa-solid fa-trash-can'></i> Șterge</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                <?php
                        }
                    } else {
                        echo "<div class=\"cart alert alert-warning alert-dismissible fade show\" role=\"alert\">";
                        echo "   <div class=\"w-100 container\"><h4>Cosul este gol.</h4></div>";
                        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                        echo "</div>";
                        $display = "d-none";
                    }
                }
                ?>
                 <?php

// Verifică dacă formularul a fost trimis
if (isset($_POST['voucher']) && !isset($_SESSION['voucher_discount'])) {
    // Preia datele din formular
    $voucher = $_POST['voucher'];
    $check_query = "SELECT * FROM vouchers WHERE voucher_code = '$voucher' AND user_id = $userID AND on_cart = 0";
    $result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $is_active = $row['is_active'];
        $voucher_id = $row['voucher_id'];
        $voucherDiscount = $row['discount_amount'];
        if($is_active == 1) {
            $sql = "UPDATE vouchers SET on_cart = 1 WHERE voucher_code = '$voucher'";

            // Calculează numărul total de produse în coș pentru utilizatorul curent
    $countQuery = "SELECT COUNT(*) AS productCount FROM cart WHERE userID = '$userID'";
    $countResult = $conn->query($countQuery);
    $row = $countResult->fetch_assoc();
    $productCount = $row['productCount'];

    // Dacă există produse în coș, aplică discountul
    if ($productCount > 0) {
        $individualDiscount = $voucherDiscount / $productCount; // Discountul per produs

        // Actualizează discountul pentru fiecare produs din coș
        $updateQuery = "UPDATE cart SET discount = '$individualDiscount' WHERE userID = '$userID'";
        if ($conn->query($updateQuery) === TRUE) {
            $message_voucher = "Discountul a fost aplicat cu succes pe produse.";
        } else {
            echo "Eroare la actualizarea discountului: " . $conn->error;
        }
    } else {
        echo "Nu există produse în coș.";
    }



            $_SESSION['form_processed'] = true; // Marchează că formularul a fost procesat
           // Execută interogarea pentru a dezactiva voucherul
           mysqli_query($conn, $sql);

           if(isset($voucher)) {
            $sql = "UPDATE cart SET voucher_code = '$voucher' WHERE userID = '$userID'";
            mysqli_query($conn, $sql);
            }

           $display_voucher = 'd-block';
        } else {
            $message_voucher = "Voucher-ul nu mai este activ.";
        }
    } else {
        $message_voucher = "Seria voucherului nu există în baza de date.";
    }
    
}


                                    ?>
                                    <?php
                                        $vouchers_added = '';
                                         // Interogare pentru a verifica dacă voucher_code există în baza de date și nu este deja atribuită unui utilizator
                                        $query = "SELECT * FROM vouchers WHERE user_id = $userID AND on_cart =  1";
                                        $result = mysqli_query($conn, $query);

                                        
                                        if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            $voucher_amount = $row['discount_amount'];

                                            $price_total = $total - $voucher_amount;
                                            if($price_total < 0) {$price_total = 0;}
                                            $display_voucher = "d-block";
                                            $voucher_id = $row['voucher_id'];
                                            $voucher = $row['voucher_code'];
                                        }
                                        ?>
                </div>
                <div class="col-md-4 <?=$display?>">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <h3 class="card-title fw-bold mb-4">Sumar comanda</h3>
                                    <h6 class="card-text">Cost produse: <?= $total ?> lei</h6>
                                    <h6 class="card-text">Cost livrare: 0 lei</h6>
                                    <h6 class="<?php echo isset($voucher_amount) ? $display_voucher : 'd-none'; ?> card-text">Reducere conform voucher: -<?=$voucher_amount?></h6>

                                    <h3 class="card-text fw-bold">Total: <?php echo $price_total . ' lei' ?></h3>
                                    
                                    <form action="../php/checkout.php" method="post">
                                        <input type="hidden" name="voucher_codescu" value="<?=$voucher?>" readonly></input>
                                        <button class="btn btn-primary w-100 my-3" <?php echo $display_stock === 'd-block' ? 'disabled' : ''; ?>>Plaseaza comanda</button>
                                    </form>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card-body">
                                    <h3 class="card-title fw-bold mb-4">Ai un voucher sau un card cadou?</h3>
                                    <form action="<?=$_SERVER['PHP_SELF']?>" class="d-inline <?php echo !isset($voucher_amount) ? 'd-block' : 'd-none'; ?>" method="post">
                                        <input type="text" class="form-control" name="voucher">
                                        <button type="submit" class="btn btn-primary w-100 my-3">Adauga voucher</button>
                                        <div class="text-danger"><?php echo isset($message_voucher) ? $message_voucher : '' ?></div>
                                    </form>
                                   
                                        
                                    <div class="card p-3 <?=$display_voucher?>">
                                        <div class="card-title fw-bold">Voucherele mele:</div>
                                        
                                        <div class="card-text"><?=$voucher?>
                                        <button type="button" id="removeVoucher" value="<?=$voucher_id?>" class="btn-close float-end" aria-label="Close"></button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="toast align-items-center toast-end" id="myToast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">

                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>






        <!--Footer-->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Despre Noi</h5>
                        <p><?php echo "$footer_about" ?> </p>
                    </div>
                    <div class="col-md-4">
                        <h5>Informații de Contact</h5>
                        <ul class="list-unstyled">
                            <li>Adresă: <?php echo "$contact_address" ?></li>
                            <li>Telefon: <?php echo "$contact_phone" ?></li>
                            <li>Email: <?php echo "$contact_email" ?></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Link-uri Utile</h5>
                        <ul class="list-unstyled">
                            <li><a href="confidentiality.php">Politica de Confidențialitate</a></li>
                            <li><a href="terms.php">Termeni și Condiții</a></li>
                            <li><a href="cookies.php">Politica de Cookie-uri</a></li>
                        </ul>
                    </div>
                </div>
                <h5 class="text-center">Rețele Sociale</h5>
                <div class="social-buttons">
                    <a href="<?php echo "$social_facebook" ?>" target="_blank"><i class="fab fa-facebook-square"></i></a>
                    <a href="<?php echo "$social_instagram" ?>" target="_blank"><i class="fab fa-instagram-square"></i></a>
                    <a href="<?php echo "$social_whatsapp" ?>" target="_blank"><i class="fab fa-whatsapp-square"></i></a>
                </div>
            </div>

        </footer>
        <script>

        </script>
        <script>
            // Funcție pentru afișarea toastelelor Bootstrap
            function showToast(status, message) {
                // Selectați elementul toast din HTML
                var toastElement = document.getElementById('myToast');
                var toastBody = toastElement.querySelector('.toast-body');

                // Setează clasa corectă în funcție de status
                toastElement.classList.remove('bg-success', 'bg-danger'); // Elimină clasele anterioare
                toastElement.classList.add(status === 'success' ? 'bg-success' : 'bg-danger');

                // Setează mesajul în corpul toastei
                toastBody.innerHTML = message;

                // Inițializează toastul Bootstrap
                var toast = new bootstrap.Toast(toastElement);

                // Afișează toastul
                toast.show();
            }

            // Afișează toastele la încărcarea paginii
            window.onload = function() {
                <?php
                if (isset($_POST['status']) && isset($_POST['message'])) {
                    echo "showToast('" . $_POST['status'] . "', '" . $_POST['message'] . "');";
                }
                ?>
            };

            // Funcție pentru a actualiza cantitatea în coșul de cumpărături
            function updateCart(productId, newQuantity) {
                $.ajax({
                    url: '../php/update_cart.php',
                    type: 'POST',
                    data: {
                        productID: productId,
                        quantity: newQuantity
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Verificați răspunsul primit
                        if (response.status === 'success') {
                            // Utilizați mesajul din răspuns pentru a afișa un toast de succes
                            showToast('success', response.message);
                            location.reload();
                        } else {
                            // Utilizați mesajul din răspuns pentru a afișa un toast de eroare
                            showToast('error', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            
        </script>
<script>
$(document).ready(function() {
    $('#removeVoucher').on('click', function() {
        var voucher = $('#removeVoucher').val(); // preia valoarea voucherului din câmpul ascuns
        $.ajax({
            url: '../php/remove_voucher.php', // Aici specifici calea către fișierul PHP extern
            type: 'POST', // Poți folosi POST sau GET în funcție de cum ai configurat fișierul PHP
            data: { 
                action: 'remove_voucher', // Acțiunea pentru a indica fișierului PHP ce să facă
                voucher_id: voucher // Trimite valoarea voucherului către fișierul PHP
            },
            success: function(response) {
                // Aici poți trata răspunsul primit de la fișierul PHP
                console.log(response);
                window.location = "products.php";

            },
            error: function(xhr, status, error) {
                // Aici poți trata erorile întâmpinate în timpul solicitării AJAX
                console.error(error);
            }
        });
    });
});
</script>



    </body>

    </html>