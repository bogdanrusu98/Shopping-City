<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifică dacă sesiunea nu este deja pornită
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include("../php/config.php");
include("../php/total_products.php");
include("../php/total_products_wishlist.php");


$error_message = "";

// Verifică dacă există sesiunea pentru username
if (isset($_GET['id'])) {
  $productID = $_GET['id'];
}


$sql = "SELECT * FROM products WHERE productID = $productID";
$result = $conn->query($sql);

// Verifică dacă există rezultate
if ($result->num_rows > 0) {
  // Preia prima (și singura) înregistrare din rezultatele interogării
  $row = $result->fetch_assoc();
  $productID = $row['productID'];
  $name = $row['name'];
  $description = $row['description'];
  $imageHref = $row['imageHref'];
  $price = $row['price'];
  $category = $row['category'];;
  $stockQuantity = $row['stockQuantity'];;
}



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


  <!--Quill -->
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.snow.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.js"></script>


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
    .editor-container {
      width: 400px;
      margin: 20px auto;
    }
    textarea {
      width: 100%;
      height: 200px;
      padding: 10px;
      margin-bottom: 10px;
    }
  </style>
  <!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/dphia909nnnrxny7iltrwnyxx7u62ht0wdo9hmviei90lkt7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
  });
</script>
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
          <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="#">Log In</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" style="color: grey; font-size: 14px;" href="#">Create Account</a></li>
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
                <a class="nav-link rounded px-3" aria-current="page" href="../index.php">Home</a>
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
          <li class="breadcrumb-item align-middle"><a href="../search_results.php?search_query=">Category</a></li>
          <li class="breadcrumb-item align-middle active" aria-current="page"><a href="../search_results.php?search_query=<?= $category ?>"><?= $category ?></a></li>

        </ol>
      </nav>
    </div>
  </div>





  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6">
        <img src="<?php echo '../' . $imageHref ?>" width="400" height="400" class="rounded mx-auto d-block img-thumbnail" alt="Product Image"><button class="btn btn-warning float-end" id="change-image"><i class="fa-solid fa-pen-to-square"></i></button><br>
        <a class="btn btn-primary my-4 w-100" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
          Descriere
        </a>
        
      </div>
      <div class="col-md-6">
        <h2 class="mb-4"><?= $name ?> <button class="btn btn-warning" id="change-name" data-bs-toggle="modal" data-bs-target="#nameModal">
            <i class="fa-solid fa-pen-to-square"></i>
          </button></h2>
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
        </p>


        <p class="mb-2"><strong>Preț:</strong> <?= $price ?> Lei <button class="btn btn-warning" id="change-price" data-bs-toggle="modal" data-bs-target="#priceModal"><i class="fa-solid fa-pen-to-square"></i></button></p>
        <p class="mb-4"><strong>Stoc:</strong>


          <?php
          // Verificăm stocul și afișăm corespunzător
          if ($stockQuantity == 0) {
            echo "<span class='text-danger fw-bold'>Indisponibil</span>";
          } else {
            echo "Disponibil";
          }
          ?>

          <button class="btn btn-warning" id="change-stock" data-bs-toggle="modal" data-bs-target="#stockModal">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
        </p>
        <div class="mb-4">
          <label for="quantity" class="form-label">Cantitate:</label>
          <input type="number" id="quantity" class="form-control" value="1" min="1" readonly>
        </div>
        <!-- form_cart.php -->
        <form method="POST" action="php/add_to_cart.php">
          <input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">
          <input type="submit" class="btn btn-primary" name="add_to_cart" value="Adaugă în coș" disabled>
        </form>


        <hr>
        <div class="row text-center align-items-center">
          <div class="col-md-4 feature-box">
            <i class="fa-solid fa-truck feature-icon"></i>
            <p class="feature-description">Free Delivery</p>
          </div>
          <div class="col-md-4 feature-box">
            <i class="fa-solid fa-headset feature-icon"></i>
            <p class="feature-description">24/7 Support <br> Dedicated Support</p>
          </div>
          <div class="col-md-4 feature-box">
            <i class="fa-solid fa-lock feature-icon"></i>
            <p class="feature-description">Secure Payment <br> Best Payment Method</p>
          </div>
        </div>

        <hr>
      </div>
    </div>

    
      <div class="collapse" id="collapseExample">
              <div class="card card-body overflow-auto">
                <p class="mb-3"><?= $description ?> <button class="btn btn-warning" id="change-description" data-bs-toggle="modal" data-bs-target="#descriptionModal"><i class="fa-solid fa-pen-to-square"></i></button></p>
              </div>
            </div>
  </div>





  <!-- Modal pentru editarea numelui -->
  <div class="modal fade" id="nameModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="stockModalLabel">Modificare Titlu Produs</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../php/update_quantity.php?productID=<?php echo $productID; ?>" id="myForm1" method="post">
            <!-- Câmpuri de editare pentru stoc -->
            <label for="newStock">Titlu Nou:</label>
            <input type="text" id="newStock" class="form-control" name="name" value="<?= $name ?>">
        </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anulează</button>
          <button type="button" class="btn btn-primary" id="saveStockChanges" onclick="submitForm('myForm1')">Salvează Modificările</button>
        </div>
      </div>
    </div>
  </div>












  <!-- Modal pentru editarea descrierii -->
  <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="stockModalLabel">Modificare Descriere</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../php/update_quantity.php?productID=<?php echo $productID; ?>" id="myForm2" method="post">
            <textarea placeholder="Textarea" class="form-control" name="description" value="<?= $description ?>"></textarea>
            <input type="hidden" id="newStock" name="stock" class="form-control" value="">

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anulează</button>
          <button type="button" class="btn btn-primary" id="saveStockChanges" onclick="submitForm('myForm2')">Salvează Modificările</button>
        </div>
      </div>
    </div>
  </div>



  <!-- Modal pentru editarea stocului -->
  <div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="stockModalLabel">Modificare Stoc</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../php/update_quantity.php?productID=<?php echo $productID; ?>" id="myForm3" method="post">
            <!-- Câmpuri de editare pentru stoc -->
            <label for="newStock">Stoc Nou:</label>
            <input type="number" id="newStock" name="stock" class="form-control" value="<?= $stockQuantity ?>">

        </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anulează</button>
          <button type="button" class="btn btn-primary" id="saveStockChanges" onclick="submitForm('myForm3')">Salvează Modificările</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal pentru editarea pretului -->
  <div class="modal fade" id="priceModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="stockModalLabel">Modificare Pret</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../php/update_quantity.php?productID=<?php echo $productID; ?>" id="myForm4" method="post">
            <!-- Câmpuri de editare pentru stoc -->
            <label for="newStock">Noul pret:</label>
            <input type="number" id="newStock" name="price" class="form-control" value="<?= $price ?>">

        </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anulează</button>
          <button type="button" class="btn btn-primary" id="saveStockChanges" onclick="submitForm('myForm4')">Salvează Modificările</button>
        </div>
      </div>
    </div>
  </div>








  <?php
  // Verifică dacă există un mesaj de succes sau de eroare în URL și afișează un toast corespunzător
  if (isset($_GET['message'])) {
    $toastMessage = $_GET['message'];
    echo "<div class='toast bg-success text-white show position-fixed bottom-0 end-0' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='toast-header'>
              <strong class='me-auto'>Mesaj</strong>
              <button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
            <div class='toast-body'>
              $toastMessage
            </div>
          </div>";
  } elseif (isset($_GET['error'])) {
    $toastError = $_GET['error'];
    echo "<div class='toast bg-danger text-white' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='toast-header'>
              <strong class='me-auto'>Eroare</strong>
              <button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
            <div class='toast-body'>
              $toastError
            </div>
          </div>";
  }
  ?>







  <!--Footer-->
  <footer class="footer my-4">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5>Despre Noi</h5>
          <p> </p>
        </div>
        <div class="col-md-4">
          <h5>Informații de Contact</h5>
          <ul class="list-unstyled">
            <li>Adresă: </li>
            <li>Telefon: </li>
            <li>Email: </li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5>Link-uri Utile</h5>
          <ul class="list-unstyled">
            <li><a href="confidentiality.html">Politica de Confidențialitate</a></li>
            <li><a href="terms.html">Termeni și Condiții</a></li>
            <li><a href="cookies.html">Politica de Cookie-uri</a></li>
          </ul>
        </div>
      </div>
      <h5 class="text-center">Rețele Sociale</h5>
      <div class="social-buttons">
        <a href="#" target="_blank"><i class="fab fa-facebook-square"></i></a>
        <a href="#" target="_blank"><i class="fab fa-instagram-square"></i></a>
        <a href="#" target="_blank"><i class="fab fa-whatsapp-square"></i></a>
      </div>
    </div>

  </footer>
  <!-- Bootstrap Bundle cu JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Gestionarea evenimentului de clic pentru butonul de salvare din modal
    document.getElementById('saveStockChanges').addEventListener('click', function() {
      // Puteți completa acest bloc cu logica pentru a salva modificările de stoc în sistemul dvs.
      // De asemenea, puteți închide modalul după salvare dacă este necesar:
      var modal = document.getElementById('stockModal');
      var bootstrapModal = bootstrap.Modal.getInstance(modal);
      bootstrapModal.hide();
    });
  </script>
  <!-- Script JavaScript pentru inițializarea editorului Quill -->
  <script>
    function submitForm(formId) {
      var form = document.getElementById(formId);
      if (form) {
        form.submit();
      } else {
        console.error("Formularul cu ID-ul specificat nu a fost găsit.");
      }
    }
  </script>



  <script>
    function showToast(message) {
      // Creează un element pentru toast
      var toastElement = document.createElement("div");
      toastElement.className = "toast";
      toastElement.setAttribute("role", "alert");
      toastElement.setAttribute("aria-live", "assertive");
      toastElement.setAttribute("aria-atomic", "true");

      // Creează conținutul toast-ului
      var toastContent = document.createElement("div");
      toastContent.className = "toast-body";
      toastContent.textContent = message;

      // Adaugă conținutul la elementul toast
      toastElement.appendChild(toastContent);

      // Adaugă toast-ul la containerul de toast
      var toastContainer = document.getElementById("toastContainer");
      toastContainer.appendChild(toastElement);

      // Inițializează toast-ul Bootstrap
      var toast = new bootstrap.Toast(toastElement);

      // Arată toast-ul
      toast.show();

      // Șterge toast-ul după ce este afișat
      toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
      });
    }

    // Apel pentru a afișa un toast cu mesajul specificat
    showToast("Cantitatea a fost actualizată cu succes!");

    // Trimite o cerere AJAX către update_quantity.php
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Dacă cererea a fost completată cu succes, preia mesajul și afișează-l într-un toast
        showToast(this.responseText);
      }
    };
    xhttp.open("GET", "product.php", true);
    xhttp.send();
  </script>









  <script>
    var quill = new Quill('#editor-container', {
      theme: 'snow', // Utilizează tema snow pentru editor
      modules: {
        toolbar: [
          [{
            'font': []
          }],
          [{
            'size': ['small', false, 'large', 'huge']
          }],
          ['bold', 'italic', 'underline', 'strike'],
          [{
            'color': []
          }, {
            'background': []
          }],
          [{
            'align': []
          }],
          [{
            'list': 'ordered'
          }, {
            'list': 'bullet'
          }],
          ['link', 'image'], // Adaugă buton pentru linkuri și imagini
          ['clean']
        ]
      },
      placeholder: 'Scrie ceva aici...' // Textul placeholder pentru editor
    });
  </script>



</body>

</html>