<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Includeți fișierul de configurare al bazei de date și stabiliți conexiunea
include("php/config.php");
include("php/check_settings.php");
include("php/total_products.php");
include("php/total_products_wishlist.php");
include("php/sort.php");



// Verificați dacă parametrul de căutare este setat în URL
if (isset($_GET['search_query'])) {
    // Preiați termenul de căutare din URL și scăpați de caracterele speciale
    $search_query = mysqli_real_escape_string($conn, $_GET['search_query']);

    // Interogare SQL pentru a căuta în baza de date
    $sql = "SELECT * FROM products WHERE name LIKE '%$search_query%' OR description LIKE '%$search_query%' OR category LIKE '%$search_query' $resultSort";
    $result = mysqli_query($conn, $sql);

    // Numărul de rezultate găsite
    $num_results = mysqli_num_rows($result);

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

        <link rel="stylesheet" href="css/nav.css">
                <!--ICON-->
                <link rel="icon" type="image/x-icon" href="img/logo-color.png">
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


            <div class="row">
                <div class="col-md-2">


                    <!-- Formular pentru filtre -->
                    <form method="post" class="mb-4" id="filter" action="php/filter.php">
                        <!-- Filtru pentru preț -->
                        <label for="maxPrice" class="form-label">Price Range</label>
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="minPrice" name="minPrice" placeholder="Min">
                            </div>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="maxPrice" name="maxPrice" placeholder="Max">
                            </div>
                        </div>


                        <!-- Filtru pentru categorie -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <?php
                                // Interogare pentru a selecta toate categoriile distincte din baza de date
                                $categories = "SELECT DISTINCT category FROM products ORDER BY category ASC";
                                $results = mysqli_query($conn, $categories);

                                // Verifică dacă există rezultate și adaugă opțiunile în meniul dropdown
                                if (mysqli_num_rows($results) > 0) {
                                    while ($row = mysqli_fetch_assoc($results)) {
                                        $category = $row['category'];
                                        echo "<option value='$category'>$category</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>


                        <!-- Buton pentru aplicarea filtrelor -->
                        <button class="btn btn-primary">Apply Filters</button>
                    </form>



                </div>



                <div class="col-md-10">
                    <div id="results">
                        <h5><?= $num_results ?> rezultate gasite pentru <strong>"<?= $search_query ?>"</strong>.</h5>
                    </div>
                    <span class="fw-bold">Ordoneaza dupa:</span>
                    <form action="php/sort.php" method="post" class="mb-3" id="sortForm">
                        <select id="selectSortare" class="form-select" style="width:auto" name="selectSortare">
                            <option value="relevanta" selected>Relevanta</option>
                            <option value="pretCrescator">Preț - crescător</option>
                            <option value="pretDescrescator">Preț - descrescător</option>
                            <option value="nume">Nume</option>
                        </select>
                    </form>

                    <div class="row" id="productsContainer">
                        <?php

                        // Verificați dacă există rezultate
                        if (mysqli_num_rows($result) > 0) {

                            // Afișați rezultatele căutării
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <div class="col-md-3 mb-4">
                                    <div class="card products">
                                        <a href="product.php?id=<?php echo $row['productID']; ?>">
                                            <img src="<?php echo '', $row['imageHref'] ?>" class="card-img-top" width="300" height="200" alt="Product Image">
                                        </a>
                                        <div class="card-body">
                                            <a href="product.php?id=<?php echo $row['productID']; ?>">
                                                <h5 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo $row['name']; ?></h5>
                                            </a>
                                            <span class="product-rating">
                                                <?php
                                                // Afișează ratingul sub formă de stele
                                                $rating = $row['rating'];
                                                for ($i = 0; $i < $rating; $i++) {
                                                    echo '<i class="fas fa-star"></i>';
                                                }
                                                // Completează ratingul cu stele goale dacă este necesar
                                                for ($i = $rating; $i < 5; $i++) {
                                                    echo '<i class="far fa-star"></i>';
                                                }
                                                ?>
                                            </span>
                                            <p class="card-text text-danger fs-6"><?php echo $row['price']; ?> Lei</p>
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
                    <?php
                            }
                        } else {
                            echo "Nu s-au găsit rezultate pentru căutarea: " . $search_query;
                        }

                        // Eliberați resursele rezultatului și închideți conexiunea
                        mysqli_free_result($result);
                        mysqli_close($conn);
                    }
                    ?>

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
            document.addEventListener('DOMContentLoaded', function() {
                // Preia elementul select pentru sortare
                const selectSortare = document.getElementById('selectSortare');

                // Ascultă evenimentul de schimbare în opțiunea select de sortare
                selectSortare.addEventListener('change', function() {
                    // Preia valoarea opțiunii selectate
                    const selectedValue = this.value;

                    // Actualizează URL-ul cu valoarea selectată
                    const url = new URL(window.location.href);
                    url.searchParams.set('sort', selectedValue); // Setează parametrul 'sort' în URL

                    // Redirecționează către noul URL actualizat
                    window.location.href = url.toString();
                });

                // Verifică dacă există un parametru 'sort' în URL
                const urlParams = new URLSearchParams(window.location.search);
                const sortParam = urlParams.get('sort');

                // Setează opțiunea selectată în funcție de valoarea parametrului 'sort' din URL
                if (sortParam) {
                    selectSortare.value = sortParam;
                }
            });


document.addEventListener('DOMContentLoaded', function() {
    // Preia formularul de filtrare
    const filterForm = document.getElementById('filter');

    // Ascultă evenimentul de submit al formularului
    filterForm.addEventListener('submit', function(event) {
        // Opriți acțiunea implicită de submit a formularului
        event.preventDefault();

        // Preiați valorile introduse în formular pentru preț minim și maxim
        const minPrice = document.getElementById('minPrice').value;
        const maxPrice = document.getElementById('maxPrice').value;

        // Preiați categoria selectată în formular
        const category = document.getElementById('category').value;

        // Construiți URL-ul către filter.php cu parametrii necesari
        const url = `php/filter.php?minPrice=${minPrice}&maxPrice=${maxPrice}&category=${category}`;

        // Redirecționați către filter.php cu parametrii
        window.location.href = url;
    });
});


        </script>


    </body>

    </html>