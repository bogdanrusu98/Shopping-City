<?php
// Verificați dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
// Includeți fișierul de configurare al bazei de date și stabiliți conexiunea
include("../php/config.php");
include("../php/check_settings.php");
include("../php/total_products.php");
include("../php/total_products_wishlist.php");

$addressesDropdown = '';
$addressesDropdown_j = '';

if (isset($_SESSION['id'])) {
  $userID = $_SESSION['id'];
} else {
  header('Location: ../login.php');
  exit();
}
$total = null;
// Verificați dacă utilizatorul este autentificat și obțineți ID-ul acestuia
if (isset($_SESSION['id'])) {
  $userID = $_SESSION['id'];

  // Interogare pentru a obține produsele din coș pentru utilizatorul curent
  $sql = "SELECT c.*, p.name, p.rating, p.price, p.imageHref 
        FROM cart c 
        INNER JOIN products p ON c.productID = p.productID 
        WHERE c.userID = $userID";

  $result = mysqli_query($conn, $sql);
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
  </div>



  <div class="container">

    <h4>Detalii comanda</h4>
    <div class="row justify-content-center"> <!-- Utilizează clasa justify-content-center pentru a centra conținutul pe orizontală -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Adresa livrare</h5>
            <form action="../php/create_order.php" method="post">              <!-- Alte câmpuri pentru adresa de livrare (nume, prenume, etc.) -->
            <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Persoana Fizica</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Persoana Juridica</button>
  </div>
</nav>
  <?php
            // Conectare la baza de date și alte operații de inițializare

            // Presupunând că ai deja o sesiune pornită și ai ID-ul utilizatorului stocat într-o variabilă de sesiune
            $id = $_SESSION['id']; // Schimbă cu variabila ta de sesiune

            // Interogare pentru a selecta adresele utilizatorului curent din baza de date
            $sql = "SELECT * FROM addresses 
            WHERE user_id = $id";
                $result = mysqli_query($conn, $sql);

            // Verifică dacă interogarea a returnat rezultate
            if (mysqli_num_rows($result) > 0) {
              // Extragerea și afișarea adreselelor utilizatorului sub formă de opțiuni pentru meniul dropdown
              while ($row = mysqli_fetch_assoc($result)) {
                $id_type = $row['id_type'];
                $addressesDropdown .= '<option value="' . $row['id'] . '">' . $row['user_name'] . ', ' . $row['telefon'] . ', ' . $row['city'] . ', ' . $row['county'] . ', ' . $row['address'] . '</option>';
              }
            } else {
              // Afișează un mesaj către utilizator în cazul în care nu există adrese salvate
              $addressesDropdown = '<p>Nu există adrese salvate.</p>';
            }


            // Interogare pentru a selecta adresele utilizatorului curent din baza de date
            $sql_j = "SELECT * FROM companies 
            WHERE user_id = $id";
                $result_j = mysqli_query($conn, $sql_j);

            // Verifică dacă interogarea a returnat rezultate
            if (mysqli_num_rows($result_j) > 0) {
              // Extragerea și afișarea adreselelor utilizatorului sub formă de opțiuni pentru meniul dropdown
              while ($row = mysqli_fetch_assoc($result_j)) {
                $id_type = $row['id_type'];
                $addressesDropdown_j .= '<option value="' . $row['company_id'] . '">' . $row['company_name'] . ', ' . $row['fiscal_code'] . ', ' . $row['country']  . $row['registration_number'] . ', ' . $row['county'] . ', ' . $row['city'] . ', ' . $row['address'] . '</option>';
              }
            } else {
              // Afișează un mesaj către utilizator în cazul în care nu există adrese salvate
              $addressesDropdown_j = '<p>Nu există adrese salvate.</p>';
            }


            ?>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    


            <!-- Formular pentru adresa de livrare -->
              <!-- Afișează meniul dropdown cu adresele salvate -->
              <div class="mt-3">
                <label for="delivery_address" class="form-label">Selectați adresa de livrare:</label>
                <select name="address_d_f" class="form-select" id="address_d">
                <option value="null" disabled selected> Alegeti adresa de livrare</option>
                <?php echo $addressesDropdown; ?>
                </select>
              </div>
            
          </div>
 





  
  
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    
 <!-- Formular pentru adresa de livrare -->
              <!-- Afișează meniul dropdown cu adresele salvate -->
              <div class="mb-3 mt-3">
                <label for="delivery_address" class="form-label">Selectați adresa de livrare:</label>
                <select name="address_d_j" class="form-select" id="address_d">
                <option value="null" disabled selected> Alegeti adresa de livrare</option>
                <?php echo $addressesDropdown_j; ?>
                </select>
              </div>
            
          </div>
        </div>
      </div>
    </div>






  </div>
</div>
            

    <div class="row justify-content-center"> <!-- Utilizează clasa justify-content-center pentru a centra conținutul pe orizontală -->
      <div class="col-md-8">

        <div class="card my-4">
          <div class="card-body">
            <h5 class="card-title">Date de facturare</h5>


            <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home-f" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Persoana Fizica</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile-f" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Persoana Juridica</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home-f" role="tabpanel" aria-labelledby="nav-home-tab">
    


            <!-- Formular pentru adresa de livrare -->
              <!-- Afișează meniul dropdown cu adresele salvate -->
              <div class="mt-3">
                <label for="delivery_address" class="form-label">Selectați adresa de facturare:</label>
                <select name="address_f_f" class="form-select" id="address_d">
                <option value="null" disabled selected> Alegeti adresa de facturare</option>
                <?php echo $addressesDropdown; ?>
                </select>
              </div>
            
          </div>
 





  
  
  <div class="tab-pane fade" id="nav-profile-f" role="tabpanel" aria-labelledby="nav-profile-tab">
    
 <!-- Formular pentru adresa de facturare -->
              <!-- Afișează meniul dropdown cu adresele salvate -->
              <div class="mb-3 mt-3">
                <label for="delivery_address" class="form-label">Selectați adresa de facturare:</label>
                <select name="address_f_j" class="form-select" id="address_d">
                <option value="null" disabled selected> Alegeti adresa de facturare</option>

                <?php echo $addressesDropdown_j; ?>
                </select>
              </div>
            
          </div>
        </div>
      </div>
    </div>






  </div>
</div>

    <div class="row justify-content-center"> <!-- Utilizează clasa justify-content-center pentru a centra conținutul pe orizontală -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Metoda de plata</h5>



            <!-- Formular pentru adresa de livrare -->
            
              <!-- Alte câmpuri pentru adresa de livrare (nume, prenume, etc.) -->
              <!-- Afișează meniul dropdown cu adresele salvate -->
              <div class="mb-3">
                <label for="delivery_address" class="form-label">Selectați metoda de plata:</label>
                <select name="payment" class="form-select">
                  <option value="numerar">Numerar</option>

                </select>

              </div>
            
          </div>
        </div>
      </div>
    </div>


    <?php
    $total = null;
    // Verificați dacă utilizatorul este autentificat și obțineți ID-ul acestuia
    if (isset($_SESSION['id'])) {
      $userID = $_SESSION['id'];

      // Interogare pentru a obține produsele din coș pentru utilizatorul curent
      $sql = "SELECT c.*, p.name, p.rating, p.price, p.imageHref 
        FROM cart c 
        INNER JOIN products p ON c.productID = p.productID 
        WHERE c.userID = $userID";

      $result = mysqli_query($conn, $sql);




      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          // Extrage prețul și cantitatea produsului curent
          $price = $row['price'];
          $quantity = $row['quantity'];

          // Calculează subtotalul pentru acest produs
          $subtotal = $price * $quantity;

          // Adaugă subtotalul la totalul general
          $total += $subtotal;
        }
      }
    }
    ?>

    <div class="row justify-content-center"> <!-- Utilizează clasa justify-content-center pentru a centra conținutul pe orizontală -->
      <div class="col-md-8">
        <div class="card my-3">
          <div class="row g-0">
            <div class="col-md-12">
              <div class="card-body">
                <h3 class="card-title fw-bold mb-4">Sumar comanda</h3>
                <h6 class="card-text">Cost produse: <?= $total ?> lei</h6>
                <h6 class="card-text">Cost livrare: 0 lei</h6>
                <h3 class="card-text fw-bold">Total: <?php echo "<input name='total_amount' type='hidden' value='$total'>$total  lei</input>" ?></h3>
                
                  <button class="btn btn-primary w-100 my-3">Plaseaza comanda</button>
                </form>
              </div>
            </div>
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

  <script>
    document.getElementById("address_f").addEventListener("change", function() {
        var selectedOption = this.options[this.selectedIndex];
        var selectedOptionId = selectedOption.value;
        document.getElementById("address_f_id").value = 'f';
    });
    document.getElementById("address_d").addEventListener("change", function() {
        var selectedOption = this.options[this.selectedIndex];
        var selectedOptionId = selectedOption.value;
        document.getElementById("address_d_id").value = selectedOptionId;
    });
</script>

 


</body>

</html>