<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("php/config.php");
include("php/check_settings.php");
include("php/total_products.php");
include("php/total_products_wishlist.php");


// Verifică dacă există sesiunea pentru username
if (isset($_GET['id'])) {
    $productID = $_GET['id'];
}

$sql = "SELECT * FROM products WHERE productID = $productID";
$result = $conn->query($sql);

// Verifică dacă există rezultate
if ($result->num_rows > 0) {
    // Preia prima (și singura) înregistrare din rezultatele interogării
    $row = $result->fetch_assoc();
    $productID = $row['productID'];
    $name = $row['name'];
    $description = $row['description'];
    $imageHref = $row['imageHref'];
    $price = $row['price'];
    $category = $row['category'];
    $stockQuantity = $row['stockQuantity'];

    include('php/rating.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Font Awesome pentru stele -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Includerea Font Awesome pentru stelute -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Includerea jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!--ICON-->
        <link rel="icon" type="image/x-icon" href="img/logo-color.png">

    <link rel="stylesheet" href="css/nav.css">
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

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .user-details {
            text-align: center;
        }

        .review-details {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
                        <?php
                        $email = $_SESSION['email'];

                        // Interogare SQL pentru a obține valoarea isAdmin pentru utilizatorul cu adresa de email curentă
                        $adminQuery = "SELECT isAdmin FROM users WHERE email = '$email'";
                        $resultadmin = mysqli_query($conn, $adminQuery);

                        if ($resultadmin && mysqli_num_rows($resultadmin) > 0) {
                            $rowAdmin = mysqli_fetch_assoc($resultadmin);
                            $isAdmin = $rowAdmin['isAdmin'];

                            // Verifică dacă utilizatorul are drepturi de administrator
                            if ($isAdmin == 1) {
                                // Afișează butonul doar pentru utilizatorii cu drepturi de administrator
                                echo '<li><a class="dropdown-item bg-warning" style="font-size: 14px; color: white" href="admin/admin.php">Control Panel</a></li>';
                            }
                        }
                        ?>

                        <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="user/myaccount.php">Profile</a></li>
                        <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="settings/settings.php">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <form method="post" action="php/logout.php">
                            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="php/logout.php">Log out</a></li>
                        </form>
                    <?php } else { ?>
                        <!-- Dacă utilizatorul nu este autentificat, afișează opțiunile standard de login și creare cont -->
                        <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="login.php">Log In</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="register.php">Create Account</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <hr class="mb-4">



        <!--Navigation Bar-->

        <nav class="navbar navbar-expand-lg navbar-light mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="img/logo.png" alt="" width="150px" height="auto" class="d-inline-block align-text-top me-3"> <!-- Am adăugat clasa me-3 pentru un spațiu mic între imagine și buton -->
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
                                <a class="nav-link rounded px-3" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded px-3" aria-current="page" href="categories.php">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded px-3" aria-current="page" href="about.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded px-3" aria-current="page" href="faq.php">FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded px-3" aria-current="page" href="contact.php">Contact</a>
                            </li>
                        </ul>
                        <a class="btn btn-primary d-none d-lg-inline-block position-relative me-3" href="cart/products.php">
                            <i class="fa-solid fa-cart-shopping"></i> Cart
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $totalProducts ?>
                            </span>
                        </a>
                        <a class="btn btn-outline-primary text-dark d-none d-lg-inline-block position-relative me-3" href="favorites.php">
                            <i class="fa-solid fa-heart text-danger"></i> Wishlist
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $totalProductsWishlist ?>
                            </span>
                        </a>

                        <a class="btn btn-outline-primary text-dark ms-auto d-block d-lg-none position-relative mb-3" href="favorites.php">
                            <i class="fa-solid fa-heart text-danger"></i> Wishlist
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $totalProductsWishlist ?>
                            </span>
                        </a>

                        <a class="btn btn-primary ms-auto d-block d-lg-none position-relative mb-3" href="cart/products.php">
                            <i class="fa-solid fa-cart-shopping"></i> Cart
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $totalProducts ?>
                            </span>
                        </a>
                        <!-- Am adăugat clasele ms-auto d-block d-lg-none pentru a poziționa butonul în dreapta pe dispozitivele mai mici decât lg -->
                        <form class="d-flex" action="search_results.php" method="GET">
                            <input class="form-control me-2" name="search_query" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
        </nav>


    </div>
    <!--Breadcrumb-->
    <div class="shadow-lg p-3 mb-5 bg-body rounded " id="breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb align-middle ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item align-middle"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item align-middle"><a href="search_results.php?search_query=">Category</a></li>
                    <li class="breadcrumb-item align-middle active" aria-current="page"><a href="search_results.php?search_query=<?= $category ?>"><?= $category ?></a></li>

                </ol>
            </nav>
        </div>
    </div>

    <!--Product-->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal">
                    <img src="<?= $imageHref ?>" width="400" height="400" class="rounded mx-auto d-block img-thumbnail" alt="Product Image"><br>
                </a>


            </div>
            <div class="col-md-6">
                <h2 class="mb-4"><?= $name ?></h2>
                <a href="#review">
                <span class="product-rating">
                    <?php echo $productRatingStars . ' ' . $averageRatingFormatted . ' ' . '(' . $totalReviews . ' review-uri)' ?>
                </span>
                </a>
                </p>


                <p class="mb-2 text-danger fs-3"><?= $price ?> Lei</p>
                <p class="mb-4"><strong>Stoc:</strong>


                    <?php
                    // Verificăm stocul și afișăm corespunzător
                    if ($stockQuantity == 0) {
                        echo "<span class='text-danger fw-bold'>Indisponibil</span>";
                    } else {
                        echo "Disponibil";
                    }
                    ?>
                </p>
                <!-- form_cart.php -->
                <form method="POST" action="php/add_to_cart.php">
                    <div class="mb-4">
                        <label for="quantity" class="form-label">Cantitate:</label>
                        <input type="number" id="quantity" class="form-control" name="quantity" value="1" min="1">
                    </div>
                    <input type="hidden" name="productID" value="<?php echo $productID; ?>">
                    <div class="d-inline-block position-relative">
                        <?php
                        // Verificăm stocul și afișăm corespunzător
                        if ($stockQuantity == 0) {
                            echo "<button type='submit' class='btn btn-primary me-4 ' name='add_to_cart' value='Adaugă în coș' style='height: 100%; color:#333; 'disabled>Adauga in cos";
                        } else {
                            echo "<button type='submit' class='btn btn-primary me-4 ' name='add_to_cart' value='Adaugă în coș' style='height: 100%; color:#333; '>Adauga in cos";
                        }
                        ?>
                        <i class="btn fa-solid fa-cart-shopping bg-warning p-2 position-absolute" style="top: 0; right: -3px; height: 100%; color:#333; cursor: pointer;" id="cartButton"></i></button>
                    </div>
                </form>
                <!-- Formular pentru adăugarea în wishlist -->
                <form method="POST" action="php/add_to_wishlist.php" class="ms-auto">
                    <input type="hidden" name="productID" value="<?php echo $productID; ?>">
                    <?php
                    // Parcurgem fiecare id de produs
                    // Interogare pentru a verifica dacă produsul se află în tabela de dorințe (wishlist) pentru utilizatorul curent
                    $sql_check_wishlist = "SELECT * FROM wishlist WHERE user_id = '$id' AND product_id = '$productID'";
                    $result_check_wishlist = mysqli_query($conn, $sql_check_wishlist);

                    if (mysqli_num_rows($result_check_wishlist) > 0) {
                        // Produsul se află în lista de dorințe, deci putem aplica un stil specific butonului de wishlist
                        echo "<button class='btn btn-primary me-2 text-danger' name='add_to_wishlist' value='Adaugă în wishlist'><i class='fa-solid fa-heart'></i></button>";
                    } else {
                        // Produsul nu se află în lista de dorințe
                        echo "<button type='submit' class='btn btn-primary me-2' name='add_to_wishlist' value='Adaugă în wishlist'><i class='fa-regular fa-heart'></i></button>
                                          ";
                    }

                    ?>
                </form>






                <hr>
                <div class="row text-center align-items-center">
                    <div class="col-md-4 feature-box">
                        <i class="fa-solid fa-truck feature-icon"></i>
                        <p class="feature-description">Free Delivery</p>
                    </div>
                    <div class="col-md-4 feature-box">
                        <i class="fa-solid fa-headset feature-icon"></i>
                        <p class="feature-description">24/7 Support <br> Dedicated Support</p>
                    </div>
                    <div class="col-md-4 feature-box">
                        <i class="fa-solid fa-lock feature-icon"></i>
                        <p class="feature-description">Secure Payment <br> Best Payment Method</p>
                    </div>
                </div>

                <hr>
            </div>
            <a class="btn btn-primary my-4 w-100" data-bs-toggle="collapse" href="#collapseDescription" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Descriere
                </a>
            <div class="collapse" id="collapseDescription">
                    <div class="card card-body overflow-auto">
                        <p class="mb-3"><?= $description ?></p>
                    </div>
                </div>
        </div>
        <hr class="my-5">
        <h3 class="mb-4">Produse similare</h3>
        <div class="row">
            <?php
            $sql = "SELECT * FROM products WHERE category = '$category' LIMIT 4";
            $result = $conn->query($sql);
            // Verificați dacă există înregistrări în rezultat
            if (mysqli_num_rows($result) > 0) {
                // Iterați prin fiecare înregistrare și afișați cardurile
                while ($row = mysqli_fetch_assoc($result)) {
                    $productID = $row['productID'];
            ?>
                    <!-- Aici poți adăuga produse similare, fiecare într-un col-md-3 pentru a fi afișate 4 pe rând -->
                    <div class="col-md-3 mb-4">
                        <div class="card products">
                            <a href="product.php?id=<?php echo $row['productID']; ?>">
                                <img src="<?php echo $row['imageHref']; ?>" width="300" height="200" class="card-img-top" alt="Product Image">
                            </a>
                            <div class="card-body">
                                <a href="product.php?id=<?php echo $row['productID']; ?>">
                                    <h5 class="card-title" style="    display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;"><?php echo $row['name']; ?></h5>
                                </a>
                                <span class="product-rating">
                                    <?php $row['productID'];
                                    // Afișează ratingul sub formă de stele
                                    $rating = $row['rating'];

                                    // Asigură-te că ratingul este între 0 și 5 și îl aproximează la cel mai apropiat număr întreg
                                    $rating = round(max(0, min(5, $rating)));

                                    // Afiseaza stelele corespunzătoare ratingului aproximat
                                    for ($i = 0; $i < $rating; $i++) {
                                        echo '<i class="fas fa-star"></i>';
                                    }

                                    // Completează ratingul cu o stea goală dacă este necesar
                                    for ($i = $rating; $i < 5; $i++) {
                                        echo '<i class="far fa-star"></i>';
                                    } ?>


                                </span>
                            
                                </p>
                                <p class="card-text text-danger fs-5"><?= $price ?> Lei</p>
                                <div class="d-flex">
                                    <!-- Formular pentru adăugarea în coș -->
                                    <form method="POST" action="php/add_to_cart.php" class="d-inline-block position-relative">
                                        <input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">
                                        <?php
                                        // Verificăm stocul și afișăm corespunzător
                                        if ($row['stockQuantity'] == 0) {
                                            echo "<button type='submit' class='btn btn-primary me-4 ' name='add_to_cart' value='Adaugă în coș' style='height: 100%; color:#333; 'disabled>Adauga in cos";
                                        } else {
                                            echo "<button type='submit' class='btn btn-primary me-4 ' name='add_to_cart' value='Adaugă în coș' style='height: 100%; color:#333; '>Adauga in cos";
                                        }
                                        ?>
                                        <!-- Iconița de coș de cumpărături -->
                                        <i class="btn fa-solid fa-cart-shopping bg-warning p-2 position-absolute" style="top: 0; right: 0px; height: 100%; color:#333; cursor: pointer;" id="cartButton"></i>
                                        </button>
                                    </form>

                                    <!-- Formular pentru adăugarea în wishlist -->
                                    <form method="POST" action="php/add_to_wishlist.php" class="ms-auto">
                                        <input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">
                                        <?php
                                        // Parcurgem fiecare id de produs
                                        $productID = $row['productID'];
                                        // Interogare pentru a verifica dacă produsul se află în tabela de dorințe (wishlist) pentru utilizatorul curent
                                        $sql_check_wishlist = "SELECT * FROM wishlist WHERE user_id = '$id' AND product_id = '$productID'";
                                        $result_check_wishlist = mysqli_query($conn, $sql_check_wishlist);

                                        if (mysqli_num_rows($result_check_wishlist) > 0) {
                                            // Produsul se află în lista de dorințe, deci putem aplica un stil specific butonului de wishlist
                                            echo "<button class='btn btn-primary me-2 text-danger' name='add_to_wishlist' value='Adaugă în wishlist'><i class='fa-solid fa-heart'></i></button>";
                                        } else {
                                            // Produsul nu se află în lista de dorințe
                                            echo "<button type='submit' class='btn btn-primary me-2' name='add_to_wishlist' value='Adaugă în wishlist'><i class='fa-regular fa-heart'></i></button>
                                          ";
                                        }

                                        ?>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Repetă acest bloc pentru fiecare produs similar -->
            <?php
                }
            } else {
                echo "<p>Nu există produse disponibile.</p>";
            }

            ?>
        </div>
    </div>
    <!--Reviews-->
    <div class="review shadow p-3 mb-5 bg-white rounded border" id="review">
        <div class="container">
            <h2>Reviews
                <?php


                echo "<span class='text-muted' style='font-size:17px'>($totalReviews review-uri)</span>";

                ?>
            </h2>
            <div class="row border-top border-bottom py-4">
                <div class="col-md-3 ps-4 text-center text-muted" style="font-size: 50px">

                    <?= $averageRatingFormatted ?>
                </div>
                <div class="col-md-9">
                    <?php
                    if (isset($_GET['id'])) {
                        $productID = $_GET['id'];
                        // Iterăm de la 1 la 5 pentru toate stelele
                        for ($i = 1; $i <= 5; $i++) {
                            // Interogare SQL pentru a număra rating-urile pentru fiecare valoare distinctă
                            $sql = "SELECT COUNT(*) AS numRatings FROM reviews WHERE productID = $productID AND rating = $i";

                            // Executăm interogarea și obținem rezultatul
                            $result = $conn->query($sql);

                            // Obținem numărul de rating-uri pentru valoarea de rating curentă
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $numRatings = $row["numRatings"];
                            } else {
                                $numRatings = 0;
                            }

                            // Calculăm procentul de rating pentru bara de progres
                            $totalRatings = $totalReviews; // Presupunem că 100 este numărul maxim posibil de rating-uri
                            $percentage = ($totalRatings > 0) ? ($numRatings / $totalRatings) * 100 : 0;

                            // Afisăm numărul de rating-uri pentru rating-ul curent și bara de progres Bootstrap
                            echo "$i stele: ($numRatings) <br>";
                            echo '<div class="progress" style="width: 244px;">
                                  <div class="progress-bar" role="progressbar" style="width: ' . $percentage . '%" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>';
                        }
                    }

                    ?>
                </div>
            </div>
            <button class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#reviewModal">Adauga review</button>

            <?php
            // Interogare pentru a prelua recenziile din baza de date
            if (isset($_GET['id'])) {
                // Accesați și stocați valoarea parametrului "id"
                $productID = $_GET['id'];

                $sql = "SELECT * FROM reviews WHERE productID = $productID";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Extrageți informațiile despre utilizator din baza de date
                        $userID = $row['userID'];
                        $reviewDate = $row['created_at'];

                        // Interogare pentru a prelua informațiile despre utilizator
                        $userQuery = "SELECT * FROM users WHERE id = $userID";
                        $userResult = $conn->query($userQuery);

                        if ($userResult->num_rows > 0) {
                            $userRow = $userResult->fetch_assoc();
                            $username = $userRow['username'];
                            $avatar = $userRow['avatar_href']; // presupunând că este calea către avatar în baza de date
                            $name = $userRow['name'];
                        }
            ?>
                        <div class="card w-100 mb-3 ">
                            <div class="card-body" style="font-size:15px">
                                <div class="row">
                                    <div class="col-md-3 col-lg-2">
                                        <!-- Avatarul utilizatorului -->
                                        <img src="<?php echo $avatar; ?>" alt="Avatar" class="avatar">
                                        <h6 class="card-subtitle mb-2 text-muted my-2 fw-bold"><?php echo $name; ?></h6>
                                        <p class="card-text  text-muted" style="font-size:10px;"><?php echo $reviewDate; ?></p>
                                    </div>
                                    <div class="col-md-9 col-lg-10">
                                        <p class="card-text fw-bold mb-1"><?php echo $row['review_title'] ?></p>
                                        <!-- Informații despre utilizator și data recenziei -->
                                        <!-- Detalii despre recenzie -->
                                        <p class="card-text mb-0"><?php
                                                                    // Afișează ratingul sub formă de stele
                                                                    $rating = $row['rating'];
                                                                    for ($i = 0; $i < $rating; $i++) {
                                                                        echo '<i class="fas fa-star"></i>';
                                                                    }
                                                                    // Completează ratingul cu stele goale dacă este necesar
                                                                    for ($i = $rating; $i < 5; $i++) {
                                                                        echo '<i class="far fa-star"></i>';
                                                                    }
                                                                    ?></p>
                                        <p class="card-text"><?php echo $row['comment']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            } else {
                echo "<p>No reviews found</p>";
            }
            $conn->close();
            ?>




        </div>
    </div>








    <!-- Modal pentru reviews -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockModalLabel">Adauga un review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="php/add_review.php" method="post" id="myForm1">
                        <input type="hidden" name="productID" value="<?= $productID ?>">
                        <div class="form-group">
                            <label for="productID">Titlu review</label>
                            <input type="text" class="form-control" id="productID" name="review_title" required>
                        </div>
                        <div class="form-group rating" style="font-size:25px">
                            <i class="far fa-star" data-rating="1"></i>
                            <i class="far fa-star" data-rating="2"></i>
                            <i class="far fa-star" data-rating="3"></i>
                            <i class="far fa-star" data-rating="4"></i>
                            <i class="far fa-star" data-rating="5"></i>
                            <input type="hidden" name="rating" id="rating" value="">

                        </div>
                        <div class="form-group">
                            <label for="comment">Comment:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anulează</button>
                        <button type="button" class="btn btn-primary" id="saveStockChanges" onclick="submitForm('myForm1')">Salvează Modificările</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>




    <!-- Modal pentru img -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 d-none d-md-block">
                            <img src="<?= $imageHref ?>" class="img-fluid">
                        </div>
                        <div class="vr p-0"></div>
                        <div class="col-12 col-sm-12 col-md-8">
                            <img src="<?= $imageHref ?>" class="img-fluid">

                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <div class="d-flex">
                        <!-- Formular pentru adăugarea în coș -->
                        <form method="POST" action="php/add_to_cart.php" class="d-inline-block position-relative me-2">
                            <input type="hidden" name="productID" value="<?php echo $row_product['productID']; ?>">
                            <?php
                            // Verificăm stocul și afișăm corespunzător
                            if ($stockQuantity == 0) {
                                echo "<button type='submit' class='btn btn-primary me-4 ' name='add_to_cart' value='Adaugă în coș' style='height: 100%; color:#333; 'disabled>Adauga in cos";
                            } else {
                                echo "<button type='submit' class='btn btn-primary me-4 ' name='add_to_cart' value='Adaugă în coș' style='height: 100%; color:#333; '>Adauga in cos";
                            }
                            ?>
                            <!-- Iconița de coș de cumpărături -->
                            <i class="btn fa-solid fa-cart-shopping bg-warning p-2 position-absolute" style="top: 0; right: 0px; height: 100%; color:#333; cursor: pointer;" id="cartButton"></i>
                            </button>
                        </form>

                        <!-- Formular pentru adăugarea în wishlist -->
                        <form method="POST" action="php/add_to_wishlist.php" class="ms-auto ">
                            <button type="submit" class="btn btn-primary me-2" name="add_to_wishlist" value="Adaugă în wishlist"><i class="fa-regular fa-heart"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        $(document).ready(function() {
            // Ascultați evenimentul de trimitere a formularului
            $("#myForm1").submit(function(event) {
                event.preventDefault(); // Previne acțiunea implicită a formularului (trimiterea)

                var formData = $(this).serialize(); // Serializați datele din formular pentru trimitere

                // Adăugați rating-ul selectat din formular la datele trimise
                var rating = $(".rating i.fas").length;
                formData += "&rating=" + rating;

                // Trimiteți datele către server prin AJAX
                $.ajax({
                    url: "php/add_review.php",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        // Dacă primiți un răspuns de la server, gestionați-l aici
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Dacă întâmpinați o eroare în timpul solicitării AJAX, gestionați-o aici
                        console.error(error);
                    }
                });
            });

            // Adaugă rating-ul selectat la clic pe o stea
            $(".rating i").click(function() {
                var rating = $(this).attr("data-rating");
                $("#rating").val(rating); // Actualizați valoarea câmpului ascuns "rating" cu rating-ul selectat
                $(".rating i").removeClass("fas").addClass("far"); // Resetează toate stelutele
                $(this).prevUntil().addBack().removeClass("far").addClass("fas"); // Marchează stelutele selectate și cele precedente
            });

        });
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
// Selectează elementul de collapse
var collapseDescription = document.getElementById('collapseDescription');

// Verifică dacă elementul de collapse există în pagina curentă
if (collapseDescription) {
    // Obține toate elementele <img> din interiorul elementului de collapse
    var images = collapseDescription.querySelectorAll('img');

    // Verifică dacă există poze în interiorul elementului de collapse
    if (images.length > 0) {
        // Iterează prin fiecare imagine și adaugă clasa 'img-fluid'
        images.forEach(function(image) {
            image.classList.add('img-fluid'); // Adaugă clasa 'img-fluid' la imagine
        });
    } else {
        console.log('Nu există imagini în interiorul elementului de collapse.');
    }
} else {
    console.log('Elementul de collapse nu a fost găsit.');
}


    </script>
    <!-- Bootstrap Bundle cu JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>