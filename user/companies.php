<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Verifică dacă există sesiunea pentru id
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
}


// Conectarea la baza de date
include '../php/config.php';
include("../php/total_products.php");
include("../php/total_products_wishlist.php");
include("../php/check_settings.php");


$error_message = "";

// Verifică dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Preia datele din formular
  $company_name = $_POST['company_name'];
  $country = $_POST['country'];
  $fiscal_code = $_POST['fiscal_code'];
  $registration_number = $_POST['registration_number'];
  $bank_name = $_POST['bank_name'];
  $iban = $_POST['iban'];
  $county = $_POST['county'];
  $city = $_POST['city'];
  $address = $_POST['address'];


  // Interogare pentru a adăuga datele în baza de date
  $insert_query = "INSERT INTO companies (user_id, company_name, country, fiscal_code, registration_number, bank_name, iban, county, city, address) 
                     VALUES ('$id', '$company_name', '$country', '$fiscal_code', '$registration_number', '$bank_name', '$iban', '$county', '$city', '$address')";

  // Execută interogarea și verifică rezultatul
  if (mysqli_query($conn, $insert_query)) {
    // Afișează mesajul de succes sau redirecționează către o altă pagină
    $error_message = "<span class='alert alert-success'>Persoana juridica adaugata!</span>";
    header("Location: companies.php");
  } else {
    // Afișează mesajul de eroare în cazul în care interogarea nu a putut fi executată
    echo "Eroare la adăugarea datelor în baza de date: " . mysqli_error($conn);
    $error_message = "<span class='alert alert-danger'>Eroare: </span>" . mysqli_error($conn);
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

    select {
      max-height: 200px;
    }

    .user-info {
      display: flex;
      align-items: center;
      /* Aliniază vertical conținutul */
      font-size: 16px;
    }

    .user-info i {
      margin-right: 5px;
      /* Adaugă un mic spațiu între icon și text */
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
            <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="settings.php">Settings</a></li>
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


  <div class="container my-account my-4">
    <!-- Sidebar -->
    <div class="sidebar rounded">
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
          <li class="p-1 selected"><i class="fa-solid fa-building"></i> Date de facturare</li>
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
          <h4>Data facturare</h4>
          <button class="btn btn-primary my-4" onclick="showModal()">Adaugă companie</button>
          <br>
          <?= $error_message ?>
        </div>
      </div>

      <hr class="my-4">



      <div class="row">
        <?php
        $sql = "SELECT * FROM companies WHERE user_id = '$id'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <div class="col-md-4 my-2">
              <div class="card">
                <div class="card-body">
                  <div class="user-info card-title fw-bold">
                    <i class="fa-solid fa-building"  style="color:#abd373; font-size: 20px;"></i>
                    <span><?php echo $row['company_name'] . ' <br /> ' . $row['country'] . ' - ' .$row['fiscal_code']; ?></span>
                  </div>
                  <p class="card-text text-muted"><?php echo $row['registration_number'], ', ', $row['address'], ', ', $row['city'], ', ', $row['county'], ', ', $row['bank_name'], ', ', $row['iban']; ?></p>
                  <form method="post" action="../php/delete_address.php">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <button type="submit" class="btn btn-danger">Șterge</button>
                  </form>
                </div>
              </div>
            </div>

        <?php
          }
        } else {
          echo "<p>Nu ai adaugat nicio persoana juridica pana acum.</p>";
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
          <h5 class="modal-title">Adaugă persoana juridica</h5>
          <button type="button" class="btn-close" onclick="closeModal()" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form method="post" id="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


            <div class="row mb-3">
              <h6 class="fw-bold my-2">Detalii companie</h6>
              <div class="col-md-6">
                <label for="judet" class="form-label">Nume firma</label>
                <input type="text" class="form-control" id="company_name" name="company_name" required>
                <span class="help-block text-danger" style="display: none;">Acest câmp este necesar</span>
              </div>
              <div class="col-md-2">
                <label for="localitate" class="form-label">&nbsp </label>
                <select class="form-control small-select"  id="country" name="country">
                    <option value="RO">RO</option>
                </select>
                <span class="help-block text-danger" style="display: none;">Acest câmp este necesar</span>
              </div>
              <div class="col-md-4">
                <label for="localitate" class="form-label">CUI</label>
                <input type="text" class="form-control" id="fiscal_code" name="fiscal_code" required>
                <span class="help-block text-danger" style="display: none;">Acest câmp este necesar</span>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label for="judet" class="form-label">Numar de inregistrare in Registrul Comertului</label>
                <input type="text" class="form-control" id="registration_number" name="registration_number" required>
                <span class="help-block text-danger" style="display: none;">Acest câmp este necesar</span>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="judet" class="form-label">Banca</label>
                <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                <span class="help-block text-danger" style="display: none;">Acest câmp este necesar</span>
              </div>
              <div class="col-md-6">
                <label for="localitate" class="form-label">Cont IBAN</label>
                <input type="text" class="form-control" id="iban" name="iban" required>
                <span class="help-block text-danger" style="display: none;">Acest câmp este necesar</span>

              </div>
            </div>

            <div class="row mb-3">
              <h6 class="fw-bold my-2">Sediu  social</h6>
              <div class="col-md-6">
                <label for="judet" class="form-label">Județ:</label>
                <select class="form-select" id="county" name="county" required>
                  <option value="" selected>Alege județul</option>
                  <option value="Alba">Alba</option>
                  <option value="Arad">Arad</option>
                  <option value="Argeș">Argeș</option>
                  <option value="Bacău">Bacău</option>
                  <option value="Bihor">Bihor</option>
                  <option value="Bistrița-Năsăud">Bistrița-Năsăud</option>
                  <option value="Botoșani">Botoșani</option>
                  <option value="Brăila">Brăila</option>
                  <option value="Brașov">Brașov</option>
                  <option value="București">București</option>
                  <option value="Buzău">Buzău</option>
                  <option value="Călărași">Călărași</option>
                  <option value="Caraș-Severin">Caraș-Severin</option>
                  <option value="Cluj">Cluj</option>
                  <option value="Constanța">Constanța</option>
                  <option value="Covasna">Covasna</option>
                  <option value="Dâmbovița">Dâmbovița</option>
                  <option value="Dolj">Dolj</option>
                  <option value="Galați">Galați</option>
                  <option value="Giurgiu">Giurgiu</option>
                  <option value="Gorj">Gorj</option>
                  <option value="Harghita">Harghita</option>
                  <option value="Hunedoara">Hunedoara</option>
                  <option value="Ialomița">Ialomița</option>
                  <option value="Iași">Iași</option>
                  <option value="Ilfov">Ilfov</option>
                  <option value="Maramureș">Maramureș</option>
                  <option value="Mehedinți">Mehedinți</option>
                  <option value="Mureș">Mureș</option>
                  <option value="Neamț">Neamț</option>
                  <option value="Olt">Olt</option>
                  <option value="Prahova">Prahova</option>
                  <option value="Satu Mare">Satu Mare</option>
                  <option value="Sălaj">Sălaj</option>
                  <option value="Sibiu">Sibiu</option>
                  <option value="Suceava">Suceava</option>
                  <option value="Teleorman">Teleorman</option>
                  <option value="Timiș">Timiș</option>
                  <option value="Tulcea">Tulcea</option>
                  <option value="Vaslui">Vaslui</option>
                  <option value="Vâlcea">Vâlcea</option>
                  <option value="Vrancea">Vrancea</option>
                </select>
                <span class="help-block text-danger" style="display: none;">Acest câmp este necesar</span>


              </div>
              <div class="col-md-6">
                <label for="localitate" class="form-label">Localitate:</label>
                <input type="text" class="form-control" id="city" name="city" required>
                <span class="help-block text-danger" style="display: none;">Acest câmp este necesar</span>

              </div>
            </div>
            <div class="mb-3">
              <label for="adresa" class="form-label">Adresă:</label>
              <input type="text" class="form-control" id="address" name="address" required>
              <span class="help-block text-danger" style="display: none;">Acest câmp este necesar</span>

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
      // Preia toate câmpurile obligatorii din formular
      var requiredFields = document.querySelectorAll('[required]');

      // Verifică fiecare câmp obligatoriu
      for (var i = 0; i < requiredFields.length; i++) {
        // Dacă un câmp obligatoriu nu are valoare, afișează un mesaj de eroare și oprește trimiterea formularului
        if (requiredFields[i].value.trim() === '') {
          // Afișează un mesaj de eroare

          // Modifică stilul pentru toate elementele cu clasa helpblock
          var helpblocks = document.querySelectorAll('.help-block');
          for (var j = 0; j < helpblocks.length; j++) {
            helpblocks[j].style.display = 'inline-block';
          }

          return; // Oprește trimiterea formularului
        }
      }

      // Toate câmpurile sunt completate, se poate trimite formularul
      document.getElementById("myForm").submit(); // Acesta va trimite datele formularului
    }
  </script>
  <!-- Adaugă script-ul jQuery și Bootstrap JS la sfârșitul documentului pentru performanță -->
</body>

</html>