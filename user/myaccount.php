<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include("../php/config.php");
include("../php/total_products.php");
include("../php/total_products_wishlist.php");
include("../php/check_settings.php");

$error_message = " ";
// Verifică dacă există sesiunea pentru username
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
} else {
  // Dacă nu există sesiune, redirecționează către pagina de autentificare
  header("Location: ../login.php"); // Înlocuiește cu pagina ta de autentificare
  exit();
}
// Interogare pentru a prelua datele din baza de date
$sql = "SELECT * FROM users where id = $id";
$result = $conn->query($sql);


// Preia prima (și singura) înregistrare din rezultatele interogării
$row = $result->fetch_assoc();
$name = $row['name'];
$email = $row['email'];
$username = $row['username'];
$phone = $row['phone'];
$gender = $row['gender'];
$name = $row['name'];
$avatar_href = $row['avatar_href'];
$birthDate = $row['birthDate'];
// Verifică dacă sunt trimise date prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Preiați datele din formular
  $email = isset($_POST['email']) ? $_POST['email'] : null;
  $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
  $gender = isset($_POST['gender']) ? $_POST['gender'] : null;

  $name = isset($_POST['name']) ? $_POST['name'] : null;
  $birthDate = isset($_POST['birthDate']) ? $_POST['birthDate'] : null;
  // Construiește interogarea SQL de actualizare
  $sql = "UPDATE users SET ";

  $set_values = array();
  if ($phone !== null && $phone !== '') {
    $set_values[] = "phone='$phone'";
  }
  if ($gender !== null && $gender !== '') {
    $set_values[] = "gender='$gender'";
  }
  if ($name !== null && $name !== '') {
    $set_values[] = "name='$name'";
  }
  if ($birthDate !== null && $birthDate !== '') {
    $set_values[] = "birthDate='$birthDate'";
  }
  if ($email !== null && $email !== '') {
    $set_values[] = "email='$email'";
  }

  $sql .= implode(", ", $set_values);
  $sql .= " WHERE id=$id"; // Schimbă 'nume_tabel' și 'id' conform nevoilor tale
  // Execută interogarea SQL
  if ($conn->query($sql) === TRUE) {
    $error_message = "<span class='alert alert-success ms-2'>Actualizare realizată cu succes</span>";
  } else {
    $error_message = "<span class='alert alert-danger ms-2'>Eroare la actualizare: . $conn->error</span>";
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

  <div class="shadow-lg p-3 mb-5 bg-body rounded " id="breadcrumb">
    <div class="container">
      <nav aria-label="breadcrumb align-middle ">
        <ol class="breadcrumb">
          <li class="breadcrumb-item align-middle"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item align-middle active" aria-current="page">My Account</li>

        </ol>
      </nav>
    </div>
  </div>


  <!--My account -->

  <div class="container my-account my-4">
    <div class="sidebar rounded">
      <!-- Sidebar content here -->
      <ul class="p-2">
        <a href="shopping.php">
          <li class="p-1"><i class="fa-solid fa-file"></i> <span> Comenzi </span></li>
        </a>
        <a href="vouchers.php">
          <li class="p-1"><i class="fa-solid fa-ticket"></i> <span> Vouchere </span></li>
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

        <a href="../php/logout.php">
          <li class="p-1"><i class="fa-solid fa-right-from-bracket text-danger"></i> Logout</li>
        </a>
      </ul>
    </div>
    <hr class="mx-1">
    <div class="content rounded ">
      <div class="row container">
        <div class="col-md-12 ">
          <h2>Datele contului</h2>
          <hr>
          <div class="row ">
            <div class="col-md-3 d-flex justify-content-center"> <!-- Am adăugat clasele d-flex justify-content-center -->
              <div class="image-avatar">
                <img src="../<?= $avatar_href ?>" alt="avatar" width="102" height="102" class="rounded-circle align-self-center" id="avatarImage" onclick="showUploadForm()">
                <form action="../php/upload-avatar.php" method="post" enctype="multipart/form-data" id="uploadForm" style="display: none;">
                  <input type="file" name="fileToUpload" id="fileToUpload">
                  <input type="submit" value="Încarcă fișierul" name="submit">
                </form>
              </div>
            </div>
            <div class="col-md-9">
              <h6>Alias: <?= $username ?></h6>
              <h6>Nume: <?=$name ?></h6>
              <h6>Email: <?= $email ?></h6>
              <h6>Telefon: <?= $phone ?></h6>
            </div>
            <button class="btn btn-primary my-4" onclick="showModal()">Administreaza cont</button>
            <?= $error_message ?>
          </div>
        </div>
        <h2>Setari siguranta</h2>
        <hr>
        <form action="../php/change-password.php" method="post">
          <label for="current-password">Current Password</label>
          <input class="form-control" type="password" id="passwd" name="current_password"><br>
          <label for="new-password">New Password</label>
          <input class="form-control" type="password" id="passwd" name="new_password"><br>
          <label for="confirm-password">Confirm New Password</label>
          <input class="form-control" type="password" id="passwd" name="confirm_password"><br>
          <button class="btn btn-primary" type="submit">Change password</button>
        </form>
      </div>
    </div>
  </div>




  <div class="modal" tabindex="-1" style="display: none;" id="change-data">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Administrare cont</h5>
          <button type="button" class="btn-close" onclick="closeModal()" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" id="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="mb-3">
                <label for="name" class="form-label">Nume:</label>
                <input class="form-control" type="text" id="name" name="name" value="<?= $name ?>">
              </div>

            <div class="mb-3">
              <label for="email" class="form-label">Adresă de email:</label>
              <input class="form-control" type="email" id="email" name="email" value="<?= $email ?>">
            </div>

            <div class="mb-3">
              <label for="phone" class="form-label">Număr de telefon:</label>
              <input class="form-control" type="text" id="phone" name="phone" value="<?= $phone ?>">
            </div>

            <div class="mb-3">
              <label for="sex">Sex:</label><br>
              <input class="form-check-input" type="radio" id="male" name="gender" value="Male" <?php echo ($gender == 'Male') ? 'checked' : ''; ?>>
              <label for="male" class="form-check-label">Masculin</label>
              <input class="form-check-input" type="radio" id="female" name="gender" value="Female" <?php echo ($gender == 'Female') ? 'checked' : ''; ?>>
              <label for="female" class="form-check-label">Feminin</label>
            </div>

            <div class="mb-3">
              <label for="birthDate" class="form-label">Data nașterii:</label>
              <input class="form-control" type="date" id="birthDate" name="birthDate" value="<?= $birthDate ?>">
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