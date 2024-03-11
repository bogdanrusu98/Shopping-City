<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$error_message = " ";
// Verifică dacă există sesiunea pentru username
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
}
// Conectarea la baza de date și alte fișiere necesare
include '../php/config.php';
include("../php/total_products.php");
include("../php/total_products_wishlist.php");
include("../php/check_settings.php");


// Verifică dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Preia seria din formular
  $voucher_code = $_POST['voucher_code'];

  // Interogare pentru a verifica dacă voucher_code există în baza de date și nu este deja atribuită unui utilizator
  $query = "SELECT * FROM vouchers WHERE voucher_code = '$voucher_code' AND user_id IS NULL";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    // Dacă seria există în baza de date și nu este atribuită niciunui utilizator, atribuie utilizatorului voucherul
    $row = mysqli_fetch_assoc($result);
    $voucher_id = $row['voucher_id']; // Preia ID-ul voucherului
    $user_id = $_SESSION['id']; // Presupunând că ai stocat ID-ul utilizatorului în sesiune

    // Actualizează înregistrarea din tabela vouchers cu ID-ul utilizatorului
    $update_query = "UPDATE vouchers SET user_id = '$user_id' WHERE voucher_id = '$voucher_id'";
    if (mysqli_query($conn, $update_query)) {
      $error_message = "<span class='alert alert-success'>Voucher adaugat!</span>";
    } else {
      echo "Eroare la atribuirea voucherului: " . mysqli_error($conn);
    }
  } else {
    $error_message = "<span class='alert alert-danger'>Seria introdusă nu exista.</span>";
  }
}









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
  <link rel="icon" type="image/x-icon" href="../img/logo-color.png">

  <!--CSS-->
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
            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="myaccount.php">Profile</a></li>
            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="settings/settings.php">Settings</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <form method="post" action="php/logout.php">
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
            <a class="btn btn-primary d-none d-lg-inline-block position-relative me-3" href="../cart/products.php">
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

            <a class="btn btn-primary ms-auto d-block d-lg-none position-relative mb-3" href="../cart/products.php">
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


  <div class="container my-account my-4">
    <!-- Sidebar -->
    <div class="sidebar rounded">
      <ul class="p-2">
        <a href="shopping.php">
          <li class="p-1"><i class="fa-solid fa-file"></i> <span> Comenzi </span></li>
        </a>
        <a href="vouchers.php">
          <li class="p-1 selected"><i class="fa-solid fa-ticket"></i> <span> Vouchere </span></li>
        </a>
        <a href="#">
          <li class="p-1"><i class="fa-solid fa-wrench text-primary"></i> <span> Service </span></li>
        </a>
        <a href="#">
          <li class="p-1"><i class="fa-solid fa-rotate-left"></i> Retur</li>
        </a>
        <a href="#">
          <li class="p-1"><i class="fa-solid fa-shield"></i> Garantii</li>
        </a>
        <a href="addresses.php">
          <li class="p-1"><i class="fa-solid fa-location-dot"></i> Adrese de livrare</li>
        </a>
        <a href="companies.php">
          <li class="p-1"><i class="fa-solid fa-building"></i> Date de facturare</li>
        </a>

        <a href="#">
          <li class="p-1"><i class="fa-solid fa-right-from-bracket text-danger"></i> Logout</li>
        </a>
      </ul>
    </div>

    <hr class="mx-1">

    <!-- Content -->
    <div class="content rounded">
      <div class="row container">
        <div class="col-md-12">
          <h4>Vouchere & carduri cadou</h4>
          <button class="btn btn-primary my-4" onclick="showModal()">Adaugă voucher nou</button>
          <br>
          <?= $error_message ?>
        </div>
      </div>

      <hr class="my-4">

      <h4>Voucherele mele:</h4>
      <div class="row">
        <?php
        $sql = "SELECT * FROM vouchers WHERE user_id = '$id'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <div class="col-md-4 my-2">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Reducere <?= $row['discount_amount'] ?> lei</h5>
                  <p class="card-text">Serie <?= $row['voucher_code'] ?><br> Expiră pe <?= $row['expiration_date'] ?></p>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<p>Nu există vouchere disponibile.</p>";
        }
        $conn->close();
        ?>
      </div>
    </div>
  </div>











  <div class="modal" tabindex="-1" style="display: none;" id="change-data">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Adauga voucher nou</h5>
          <button type="button" class="btn-close" onclick="closeModal()" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" id="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


            <div class="mb-3">
              <label for="voucher_series" class="form-label">Introdu aici seria:</label>
              <input class="form-control" type="text" id="voucher_code" name="voucher_code">
            </div>

          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeModal()" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitForm()">Save changes</button>
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
    function showUploadForm() {
      var uploadForm = document.getElementById("uploadForm");
      uploadForm.style.display = "block";
    }
    // Funcție pentru a închide modalul
    function closeModal() {
      document.getElementById('change-data').style.display = "none";
    }

    function showModal() {
      var uploadData = document.getElementById("change-data");
      uploadData.style.display = "inline-block";
    }

    // Funcție pentru a trimite datele formularului
    function submitForm() {
      // Aici poți adăuga logica pentru a trimite datele formularului folosind AJAX sau poți folosi form.submit() direct
      document.getElementById("myForm").submit(); // Acesta va trimite datele formularului
    }
  </script>
  <!-- Adaugă script-ul jQuery și Bootstrap JS la sfârșitul documentului pentru performanță -->
</body>

</html>