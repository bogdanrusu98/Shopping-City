<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include("php/config2.php");
include("php/config.php");
include("php/check_settings.php");


include("php/total_products.php");
include("php/total_products_wishlist.php");

// Interogați baza de date pentru a prelua datele produselor
$sql = "SELECT * FROM products ORDER BY productID DESC LIMIT 4";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

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
  <link rel="icon" type="image/x-icon" href="img/logo-color.png">

  <!--CSS-->
  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="css/cookies.css">


  <script src="js/cookies.js"></script>


  <style>
    .carousel-item {
      height: 70vh;
      /* Înălțimea sliderului, poate fi ajustată conform nevoilor tale */
      position: relative;
      max-width: 100%;
      max-height: 100%;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .btn-shopping {
      margin-top: 20px;
    }

    .carousel-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);

    }

    .carousel-content h2 {
      color: black;
      font-size: 50px;
      font-weight: bold;
      width: 50% !important;
    }

    .carousel-content p {
      font-size: 25px;
      width: 50% !important;
    }

    @media only screen and (max-width: 767px) {

      .carousel-content h2 {
        color: black;
        font-size: 50px;
        font-weight: bold;
        width: 75% !important;
      }

      .carousel-content p {
        font-size: 25px;
        width: 75% !important;
      }
    }

    @media only screen and (max-width: 576px) {

      .carousel-content h2 {

        width: 100% !important;
      }

      .carousel-content p {
        width: 100% !important;
      }
    }
  </style>


</head>

<body>
  <!--Cookies-->
  <div id="cookie-banner" class="cookie-banner">
    <p>This website uses cookies to ensure you get the best experience on our website. <a href="cookies.html">Learn more</a></p>
    <button id="accept-cookies-btn">Accept</button>
  </div>

  <div class="container" id="Follow">
    <div class="d-flex justify-content-between align-items-center">
      <p class="fw-lighter mt-3">Follow Us:
        <a href="<?= $social_facebook ?>" class="ms-3"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="<?= $social_instagram ?>" class="ms-3"><i class="fa-brands fa-instagram"></i></a>
        <a href="<?= $social_whatsapp ?>" class="ms-3"><i class="fa-brands fa-whatsapp"></i></a>
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
                <a class="nav-link active rounded px-3" aria-current="page" href="index.php">Home</a>
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

  <h3 class="text-center">Cookies</h3>

  <div class="container mb-5">

    <p>Ultima actualizare: 08.02.2024

    <h2>Ce sunt cookie-urile?</h2>

    <p>Cookie-urile sunt fișiere mici de text pe care le stochează browser-ul web pe dispozitivul dumneavoastră pentru a salva anumite informații sau preferințe în timpul navigării pe un site web. Acestea sunt utilizate pentru a face experiența de navigare mai eficientă și mai personalizată.</p>

    <h2>Cum folosim cookie-urile?</h2>

    <p>Utilizăm cookie-uri pentru a înțelege modul în care vizitatorii navighează pe site-ul nostru și pentru a îmbunătăți experiența lor. Cookie-urile ne ajută să înțelegem, de exemplu, care sunt paginile cele mai vizitate, cum interacționează vizitatorii cu site-ul și care sunt zonele care necesită îmbunătățiri.</p>

    <ol class="list-group list-group-numbered">Tipuri de cookie-uri pe care le folosim:

      <li class="list-group-item">Cookie-uri necesare: Acestea sunt esențiale pentru funcționarea corectă a site-ului nostru și nu pot fi dezactivate în sistemele noastre. De obicei, sunt setate doar ca răspuns la acțiunile pe care le efectuați și care constituie o solicitare de servicii, cum ar fi setarea preferințelor de confidențialitate, autentificarea sau completarea formularelor. Puteți seta browser-ul să blocheze sau să vă alerteze cu privire la aceste cookie-uri, dar unele părți ale site-ului nu vor funcționa în acest caz.</li>

      <li class="list-group-item">Cookie-uri de performanță: Aceste cookie-uri ne permit să numărăm vizitele și sursele de trafic pentru a putea măsura și îmbunătăți performanța site-ului nostru. Ele ne ajută să aflăm care pagini sunt cele mai populare și care sunt mai puțin populare și să vedem cum navighează vizitatorii pe site.</li>

      <li class="list-group-item">Cookie-uri de funcționalitate: Aceste cookie-uri ne permit să vă oferim funcționalități și personalizări extinse, cum ar fi setarea preferințelor dvs. sau memorarea numelui dvs. de utilizator și a preferințelor alese.</li>

    </ol><br>
    <h2>Cum puteți controla cookie-urile?</h2>

    <p>Puteți controla și/sau șterge cookie-urile în funcție de preferințele dumneavoastră. Detalii găsiți aici: [Link către instrucțiuni de gestionare a cookie-urilor]. De reținut că eliminarea sau blocarea cookie-urilor poate afecta experiența dvs. de navigare și anumite funcționalități ale site-ului nostru pot deveni indisponibile.</p>

    <p>Prin continuarea utilizării site-ului nostru fără a modifica setările browser-ului, sunteți de acord cu utilizarea cookie-urilor noastre conform prezentei politici.</p>

    <h2>Contact</h2>

    <p>Dacă aveți întrebări sau nelămuriri cu privire la această Politică de cookie-uri, vă rugăm să ne contactați la adresa [adresa de contact].</p>




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

  <!-- Adaugă script-ul jQuery și Bootstrap JS la sfârșitul documentului pentru performanță -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function remove_from_wishlist(productID) {
      var tableName = "shopping.products"; // înlocuiește "numele_tabelului" cu numele real al tabelului
      var column = "name";

      $.ajax({
        url: 'php/remove_from_wishlist;',
        type: 'POST',
        data: {
          id: id
        },
        success: function(response) {
          console.log("Id-ul este:" + id),
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
  </script>
</body>

</html>