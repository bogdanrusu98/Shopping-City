<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificați dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$message = '';

// Includeți fișierul de configurare al bazei de date și stabiliți conexiunea
include("../php/config.php");
include("../php/check_settings.php");
include("../php/total_products.php");
include("../php/total_products_wishlist.php");

// Verificați dacă utilizatorul este autentificat
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
} else {
    header('Location: ../login.php');
    exit();
}

// Verificăm dacă există parametrii în URL
if (isset($_GET['orderID']) && isset($_GET['message'])) {
    // Salvăm valorile în variabile
    $orderID = $_GET['orderID'];
    $message = $_GET['message'];
    $total_amount = $_GET['total_amount'];
    $address_f = $_GET['address_f'];
    $address_d = $_GET['address_d'];
    $payment = $_GET['payment'];

} else {
    // Dacă nu sunt parametrii în URL, afișăm un mesaj de eroare sau redirecționăm utilizatorul
    echo "Eroare: Nu s-au primit parametrii necesari.";
}




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
            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="../settings.php">Settings</a></li>
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




  <h3 class="text-center"><?=$message?></h3>
  <h6 class="text-center text-muted">Vezi mai jos detaliile comenzii</h6>
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header"><i class="fa-regular fa-credit-card me-3"></i> Detalii plata</h5>
                <div class="card-body">
                    <p class="ps-5 card-text"><strong>Modalitate de plata:</strong> <?=$payment?></p>
                    <div class="ms-5 card">
                        <div class="card-body selected text-dark">
                            <strong>Ce urmeaza:</strong> Vei plati produsele in momentul livrarii produselor.
                        </div>
                    </div>
                </div>
            </div>

            <div class="card my-3">
                <h5 class="card-header"><i class="fa-solid fa-truck me-3"></i> Detalii transport</h5>
                <div class="card-body">
                  <?php
                  if ($type_d = 'F') {
                    $contact = "SELECT * FROM addresses WHERE id = $address_d";
                    $result = mysqli_query($conn, $contact);
              if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $id_type = $row['id_type'];
  
                      // Extrage prețul și cantitatea produsului curent
                          $user_name = $row['user_name']; 
                          $telefon = $row['telefon']; 
                          $city = $row['city']; 
                          $county = $row['county']; 
                  
                          $address = $row['address']; 
                  } } else {
                    
                    
                    $contact = "SELECT * FROM companies WHERE company_id = $address_d";
                    $result = mysqli_query($conn, $contact);
              if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $id_type = $row['id_type'];
  
                      // Extrage prețul și cantitatea produsului curent
   
  
                          $user_name = $row['company_name']; 
                    $fiscal_code = $row['fiscal_code']; 
                    $country = $row['country']; 
                    $registration_number = $row['registration_number']; 
                    $city = $row['city']; 
                    $telefon = $row['phone_number']; 
                    $county = $row['county']; 
                    $address = $row['address']; 
                  }}
    
                    
                  }
      }
  
  
      
      if ($type_f = 'F') {
        $contact = "SELECT * FROM addresses WHERE id = $address_f";
        $result = mysqli_query($conn, $contact);
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $id_type = $row['id_type'];
  
          // Extrage prețul și cantitatea produsului curent
              $user_name_f = $row['user_name']; 
              $telefon_f = $row['telefon']; 
              $city_f = $row['city']; 
              $county_f = $row['county']; 
      
              $address_f = $row['address']; 
      } } else {
        
        
        $contact = "SELECT * FROM companies WHERE company_id = $address_f";
        $result = mysqli_query($conn, $contact);
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $id_type = $row['id_type'];
  
          // Extrage prețul și cantitatea produsului curent
  
              $user_name_f = $row['company_name']; 
        $fiscal_code_f = $row['fiscal_code']; 
        $country_f = $row['country']; 
        $registration_number_f = $row['registration_number']; 
        $city_f = $row['city']; 
        $telefon_f = $row['phone_number']; 
        $county_f = $row['county']; 
        $address_f = $row['address']; 
      }}}}
                  ?>
                    <p class="ps-5 card-text"><strong>Adresa de livrare:</strong> <?=$address. ', ' . $city. ', ' . $county?></p>
                    <div class="ms-5 card">
                        <div class="card-body text-dark" style="background-color: #abd373;">
                            <strong class="text-dark"><i class="fa-solid fa-info me-3 text-dark fw-3" style="font-size: 18px"></i></strong> Vei fi notificat pe SMS si email cand produsele au fost predate curierului.
                        </div>
                    </div>
                </div>
            </div>


            <div class="card my-3">
                <h5 class="card-header"><i class="fa-solid fa-bag-shopping me-3"></i> Detalii produse</h5>
                <div class="card-body">
                   <div class="row">
            <?php
            // Interogare pentru a obține produsele din coș pentru utilizatorul curent
              $sql = "SELECT c.*, p.name, p.rating, p.price, p.imageHref 
              FROM cart c 
              INNER JOIN products p ON c.productID = p.productID 
              WHERE c.userID = $userID";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                  // Extrage prețul și cantitatea produsului curent
                      $name = $row['name'];
                      $imageHref = $row['imageHref'];
                      $product_id = $row['productID'];
                      $quantity = $row['quantity'];
                      $price = $row['price'];
                      
                      $addProduct = "INSERT INTO ordered_products (order_id, product_id, quantity, price) 
                      VALUES ('$orderID', '$product_id', '$quantity', '$price')";

                      // Executați interogarea și verificați rezultatul
                      if (mysqli_query($conn, $addProduct)) {
                          $message = "Comanda dvs. a fost plasată cu succes!";
                          
                      } else {
                          $message = "Eroare la plasarea comenzii. Vă rugăm să încercați din nou.";
                      }
    
            ?>

                    <div class="col-md-2 my-2">
                    <div class="card" >
                    <img src="../<?=$imageHref?>" width="300" height="200" class="card-img-top product-image" alt="<?php echo $row['name']; ?>">

                    <div class="card-body">
                        <h6 class="card-title text-center" style="display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;"><?=$name?></h5>
                    </div>
                    </div>
                    </div>

                        <?php

  }}

                ?>

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



</body>

</html>
