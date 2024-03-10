<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include("php/config.php");
include("php/check_settings.php");
include("php/total_products.php");
include("php/total_products_wishlist.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome pentru stele -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <link rel="stylesheet" href="css/nav.css">
  <style>
    .feature-icon {
      font-size: 4rem;
      color: #abd373;
      /* Albastru pentru iconuri */
    }

    .feature-description {
      font-size: 1.2rem;
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

    /* Stilizare pentru datele de contact */
    .contact-info {
      background-color: #f5f5f5;
      padding: 20px;
      border-radius: 5px;
    }

    /* Stilizare pentru titlul datelor de contact */
    .contact-title {
      font-weight: bold;
      margin-bottom: 10px;
    }

    .contact-info h2 {
      font-size: 1.5rem;
    }

    .contact-info p {
      font-size: 1rem;
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
            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="settings.php">Settings</a></li>
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
                <a class="nav-link active rounded px-3" aria-current="page" href="about.php">About Us</a>
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

  <div class="shadow-lg p-3 mb-5 bg-body rounded " id="breadcrumb">
    <div class="container">
      <nav aria-label="breadcrumb align-middle ">
        <ol class="breadcrumb">
          <li class="breadcrumb-item align-middle"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item align-middle active" aria-current="page">About us</li>

        </ol>
      </nav>
    </div>
  </div>

  <!--Contact -->


  <div class="container my-4">
    <h3>Despre Noi</h3>
    <p>Bine ați venit la [Numele Companiei]!</p>

    <p>La [Numele Companiei], ne mândrim cu pasiunea noastră pentru calitate și inovație. De la începuturile noastre umile, ne-am dedicat să oferim clienților noștri cele mai bune produse și servicii.</p>

    <h3>Misiunea Noastră</h3>
    <p>Misiunea noastră la [Numele Companiei] este de a inspira și de a îmbunătăți viața clienților noștri prin produse și servicii inovatoare. Ne străduim să fim lideri în domeniul nostru, să anticipăm nevoile pieței și să oferim soluții care depășesc așteptările.</p>

    <h3>Echipa Noastră</h3>
    <p>La [Numele Companiei], credem că echipa noastră este motorul succesului nostru. Avem o echipă de profesioniști dedicați și talentați, care lucrează împreună pentru a oferi cele mai bune produse și experiențe clienților noștri. Fiecare membru aduce o perspectivă unică și o pasiune pentru excelență.</p>

    <h3>Valorile Noastre</h3>
    <p>Valorile noastre stau la baza tot ceea ce facem. Ne ghidăm activitatea conform următoarelor principii:</p>

    <ul>
      <li><strong>Calitate:</strong> Ne angajăm să oferim produse și servicii de cea mai înaltă calitate.</li>
      <li><strong>Integritate:</strong> Acționăm cu integritate și transparență în toate relațiile noastre.</li>
      <li><strong>Inovație:</strong> Suntem în căutarea inovației și a progresului constant.</li>
      <li><strong>Satisfacția clienților:</strong> Suntem dedicați satisfacției clienților și depășirii așteptărilor lor.</li>
      <li>Ne angajăm să fim un partener de încredere pentru clienții noștri și să creăm valoare pe termen lung pentru comunitatea noastră.</li>

      <li>Pentru mai multe informații despre [Numele Companiei] și serviciile noastre, vă rugăm să ne contactați sau să ne vizitați la sediul nostru.</li>
    </ul>

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

  </footer><!-- Bootstrap Bundle cu JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>