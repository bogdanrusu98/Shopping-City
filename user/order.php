<?php
// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$error_message = " ";
$newStatus = '';
// Verifică dacă există sesiunea pentru username
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
}
// Conectarea la baza de date și alte fișiere necesare
include '../php/config.php';
include("../php/total_products.php");
include("../php/total_products_wishlist.php");
include("../php/check_settings.php");


// Verificăm dacă există parametrii în URL
if (isset($_GET['order_id'])) {
    // Salvăm valorile în variabile
    $order_id = $_GET['order_id'];
}


// Interogare pentru a obține produsele din coș pentru utilizatorul curent
$sql = "SELECT * FROM orders WHERE order_id = $order_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
    // Extrage prețul și cantitatea produsului curent
        $order_date = $row['order_date'];
        setlocale(LC_TIME, 'ro_RO.UTF-8');
        $order_date_obj = new DateTime($order_date);
        $order_date = $order_date_obj->format('j F Y - H:i');
        $total_amount = $row['total_amount'];
        $status = $row['status'];
        $address_f = $row['address_f'];
        $address_d = $row['address_d'];
        $payment = $row['payment'];
        $type_d = $row['type_d'];
        $type_f = $row['type_f'];

    }}





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

    .content {
      background-color: #f2f2f2;
      /* Culoarea de fundal a conținutului principal */
    }

    .image-avatar {
      position: relative;
      display: inline-block;
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


  <div class="my-account my-4">
   
    <!-- Content -->
    <div class="content  container rounded">
      <div class="row container p-3">
        <div class="col-md-12">
                   <div class="mb-5 rounded " id="breadcrumb">
        <div class="">
        <nav aria-label="breadcrumb ">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="shopping.php">Comenzile mele</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detalii comanda</li>

    </ol>
    </nav>
        </div>
        </div>
          <h4 class="mb-3">Comanda #<?=$order_id?></h4>
        </div>
      

      <div class="card">
            <div class="card-body">
                <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        Plasata pe:
                    </div>
                    <div class="col-md-6">
                        <strong><?=$order_date?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        Total
                    </div>
                    <div class="col-md-6">
                        <strong><?=$total_amount. ' lei'?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
// Verificare pentru persoane fizice sau juridice folosind $type_d și $type_f
if ($type_d == 'F') {
    // Interogare pentru persoane fizice utilizând $address_d
    $contact = "SELECT * FROM addresses WHERE id = $address_d";
    $result = mysqli_query($conn, $contact);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_type = $row['id_type'];
            $user_name = $row['user_name']; 
            $telefon = $row['telefon']; 
            $city = $row['city']; 
            $county = $row['county']; 
            $address = $row['address']; 
        }
    }
} else {
    // Interogare pentru companii utilizând $address_d
    $contact = "SELECT * FROM companies WHERE company_id = $address_d";
    $result = mysqli_query($conn, $contact);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_type = $row['id_type'];
            $user_name = $row['company_name']; 
            $fiscal_code = $row['fiscal_code']; 
            $country = $row['country']; 
            $registration_number = $row['registration_number']; 
            $city = $row['city']; 
            $telefon = $row['phone_number']; 
            $county = $row['county']; 
            $address = $row['address']; 
        }
    }
}

if ($type_f == 'F') {
    // Interogare pentru persoane fizice utilizând $address_f
    $contact = "SELECT * FROM addresses WHERE id = $address_f";
    $result = mysqli_query($conn, $contact);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_type = $row['id_type'];
            $user_name_f = $row['user_name']; 
            $telefon_f = $row['telefon']; 
            $city_f = $row['city']; 
            $county_f = $row['county']; 
            $address_f = $row['address']; 
        }
    }
} else {
    // Interogare pentru companii utilizând $address_f
    $contact = "SELECT * FROM companies WHERE company_id = $address_f";
    $result = mysqli_query($conn, $contact);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_type = $row['id_type'];
            $user_name_f = $row['company_name']; 
            $fiscal_code_f = $row['fiscal_code']; 
            $country_f = $row['country']; 
            $registration_number_f = $row['registration_number']; 
            $city_f = $row['city']; 
            $telefon_f = $row['phone_number']; 
            $county_f = $row['county']; 
            $address_f = $row['address']; 
        }
    }
}
?>

    <h4 class="mb-3 mt-3">Produse vandute</h4>
      <div class="card">
        <?php
        if ($status == "New") {
            $newStatus = "Comanda plasată";
            $imagePath = "../img/icons/orderPlaced.jpg";
        } elseif ($status == "processing") {
            $newStatus = "În procesare";
            $imagePath = "../img/icons/processing.jpg"; // Schimbă calea către imaginea corespunzătoare
        } elseif ($status == "shipping") {
            $newStatus = "În drum spre tine";
            $imagePath = "../img/icons/shipping.jpg"; // Schimbă calea către imaginea corespunzătoare
        } elseif ($status == "shipped") {
            $newStatus = "Comanda livrată";
            $imagePath = "../img/icons/shipped.jpg"; // Schimbă calea către imaginea corespunzătoare
        }elseif ($status == "canceled") {
          $newStatus = "Comanda anulata";
          $imagePath = "../img/icons/canceled.jpg"; // Schimbă calea către imaginea corespunzătoare
      } else {
            // Setează un text și o imagine default în caz că statusul nu este recunoscut
            echo "Status necunoscut";
            $imagePath = "../img/icons/default.jpg"; // Schimbă calea către o imagine default
        }
        ?>
     <div class="d-flex align-items-center">
    <img src="<?=$imagePath?>" width="100" class="me-3">
    <span style="color: #abd373" class="fs-5 fw-bold"><?=$newStatus?></span>
</div>

  
    </div>

            <div class="row">
              <div class="col-md-4 card p-3">
                  <span class="fw-bold my-2">Modalitate livrare:</span>
                  <span class="mb-2">Livrare prin curier</span>
                  <span class="text-muted">Pentru:</span>
                  <span class=""><?=$user_name . ', ' . $telefon?></span>
                  <span class="text-muted">Adresa:</span>
                  <span class=""><?=$address . ', ' . $city . ', ' . $county?></span>
              </div>
              <div class="col-md-4 card p-3">
              
             
                  <span class="fw-bold my-2">Date facturare</span>
                  <span class="text-muted">Pentru:</span>
                  <span class=""><?=$user_name_f . ', ' . $telefon_f?></span>
                  <span class="text-muted">Adresa:</span>
                  <span class=""><?=$address_f . ', ' . $city_f . ', ' . $county_f?></span>
              

              </div>
              <div class="col-md-4 card p-3">
              <span class="fw-bold">Modalitate de plata:</span>
              <span><?=$payment?></span>
              <p class="mt-4">Valoare totala: <?=$total_amount?></p>

              </div>
            </div>




            <?php
                // Definirea interogării SQL
                $sql = "SELECT op.*, p.name, p.imageHref, p.price, p.productID
                FROM ordered_products op
                INNER JOIN products p ON op.product_id = p.productID
                WHERE op.order_id = $order_id";


                // Executarea interogării și preluarea rezultatelor
                $result = mysqli_query($conn, $sql);

                // Verificarea dacă interogarea a returnat rezultate
                if ($result) {
                    // Verificarea dacă sunt rânduri returnate
                    if (mysqli_num_rows($result) > 0) {
                        // Iterarea prin fiecare rând din rezultat
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Aici poți utiliza datele din fiecare rând
                            $name = $row['name'];
                            $imageHref = $row['imageHref'];
                            $product_id = $row['productID'];
                            $quantity = $row['quantity'];
                            $price = $row['price'];

                            ?>
        
        
        <div class="card my-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                    <a href="../product.php?id=<?php echo $row['productID']; ?>">
                        <img src="../<?=$imageHref?>"height="50" width="50">
                    </a>
                        <span class="ms-3"><?=$name?></span>
                    </div>
                    <div class="col-md-3 float-end">
                        <span class="float-end">Total: <?php  
                        $total = 0;// Extrage prețul și cantitatea produsului curent
                            $price = $row['price'];
                            $quantity = $row['quantity'];

                            // Calculează subtotalul pentru acest produs
                            $subtotal = $price * $quantity;

                            // Adaugă subtotalul la totalul general
                            $total += $subtotal;
                            echo $total . ' lei';?></span><br>
                        <p class="float-end"><?=$quantity?> buc</p><br>
                    </div>
            </div></div>
        </div>
        

        







                            <?php
                            // Poți face orice dorești cu aceste date
                        }
                    } else {
                        // Nu s-au găsit înregistrări pentru order_id-ul dat
                    }
                } else {
                    // Afiseaza mesajul de eroare daca interogarea a esuat
                    echo "Eroare la executarea interogării: " . mysqli_error($conn);
                }

            ?>
<div class="align-end">
    <div class="row justify-content-end">
        <div class="col-md-3 text-end">
            Total produse:
        </div>
        <div class="col-md-2 text-end">
            <?=$total_amount .' lei'?>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-md-3 text-end">
            Cost livrare
        </div>
        <div class="col-md-2 text-end">
            0 lei
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-md-3 text-danger fw-bold text-end">
            Total de plata:
        </div>
        <div class="col-md-2 fw-bold text-end">
            <?=$total_amount .' lei'?>
        </div>
    </div>
</div>


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