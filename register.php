<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Verifică dacă utilizatorul este autentificat
if (isset($_SESSION['email'])) {
  // Dacă este autentificat, redirecționează-l către o altă pagină
  header("Location: ../index.php");
  exit(); // Asigură-te că scriptul se oprește după redirecționare
}
// Activează afișarea tuturor erorilor
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('php/config.php');
include("php/total_products.php");
include("php/total_products_wishlist.php");
include("php/check_settings.php");


// Verificăm dacă este o cerere POST pentru trimiterea formularului
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Preia datele din formular
  $username = $_POST['username'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirmPassword'];
  $avatar_href = 'uploads/avatar/avatar.png';
  $terms = isset($_POST['terms']) ? 1 : 0;
  $newsletter = isset($_POST['newsletter']) ? 1 : 0;
  if($newsletter == 1) {
 include('php/register_newsletter.php');
  }
  // Verificăm dacă parola și confirmarea parolei coincid
  if ($password !== $confirm_password) {
    $_SESSION['message'] = "<div id='error_message' class='alert alert-danger' role='alert'>Parola și confirmarea parolei nu coincid.</div>";
  } else {
    // Hash parola utilizatorului
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Construim și executăm interogarea SQL pentru a adăuga utilizatorul în baza de date
    $sql = "INSERT INTO users (username, name, email, passwd, avatar_href, terms_agreed) VALUES ('$username', '$name', '$email', '$hashed_password', '$avatar_href', '$terms')";

    if ($conn->query($sql) === TRUE) {
      // Setăm un mesaj de confirmare în sesiune
      $_SESSION['message'] = "<div id='success_message' class='my-4 alert alert-success' role='alert'>Utilizatorul a fost înregistrat cu succes.</div>";
      // Redirecționăm utilizatorul către pagina register.php pentru a evita retrimiterea formularului
      header("Location: register.php");
      exit();
    } else {
      // Afisăm eroarea fără a accesa proprietatea obiectului conexiunii
      $_SESSION['message'] = "<div id='error_message' class='alert alert-danger' role='alert'>Eroare la înregistrarea utilizatorului: " . $conn->error . "</div>";
    }
  }
}
// Închidem conexiunea la baza de date
$conn->close();


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
        <!--ICON-->
        <link rel="icon" type="image/x-icon" href="img/logo-color.png">
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

    /* Stilizare pentru containerul formularului */
    .register-container {
      max-width: 500px;
      margin: 100px auto;
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
            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="profile.php">Profile</a></li>
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

  <div class="shadow-lg p-3 mb-5 bg-body rounded " id="breadcrumb">
    <div class="container">
      <nav aria-label="breadcrumb align-middle ">
        <ol class="breadcrumb">
          <li class="breadcrumb-item align-middle"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item align-middle active" aria-current="page">Create an account</li>

        </ol>
      </nav>
    </div>
  </div>

  <!--Register -->


  <div class="container">
    <div class="register-container  my-4 shadow p-5 mb-5 bg-body rounded">
      <h2 class="mb-4">Register</h2>
      <form action="register.php" method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" onchange="validateUsername()" required>
          <span id="usernameError" style="color: red; display: none;">Numele de utilizator trebuie să aibă cel puțin 6 caractere.</span>

        </div>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter first name" onchange="validatename()" required>
            <span id="nameError" style="color: red; display: none;">Numele trebuie să aibă cel puțin 3 caractere.</span>

          </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" onchange="validatePassword()" required>
          <span id="passwordError" style="color: red; display: none;">Parola trebuie să aibă cel puțin 6 caractere.</span>

        </div>
        <div class="mb-3">
          <label for="confirmPassword" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" onchange="validateConfirmPassword()" required>
          <span id="confirmPasswordError" style="color: red; display: none;">Parola de confirmare trebuie să corespundă cu parola.</span>
        </div>
        <div class="mb-3 form-check">
          <input class="form-check-input" type="checkbox" value="" id="terms" name="terms" required>
          <label class="form-check-label" for="terms">
          Am citit și sunt de acord cu <a href="terms.php" class="text-primary">Termenii și Condițiile</a>, cu <a href="confidentiality.php" class="text-primary">Politica de Confidențialitate</a>. Confirm că am peste 18 ani.
          </label>
        </div>
        <div class="mb-3 form-check">
          <input class="form-check-input" type="checkbox" value="1" name="newsletter" id="newsletter">
          <label class="form-check-label" for="newsletter">
          Vreau să primesc oferte și reduceri prin Newsletterul Shopping City (vei primi un email separat pentru confirmarea înscrierii).          </label>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Register</button>
        <?php
        // Afișăm mesajul de confirmare dacă există în sesiune
        if (isset($_SESSION['message'])) {
          print $_SESSION['message'];
          // Ștergem mesajul de confirmare din sesiune pentru a nu fi afișat din nou
          unset($_SESSION['message']);
        }
        ?>
      </form>
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

  </footer><!-- Bootstrap Bundle cu JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/register_validate.js"></script>
</body>

</html>