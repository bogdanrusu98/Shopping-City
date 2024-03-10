<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adaugă Produs</title>
  <!-- Adaugă link-uri către fișierele CSS Bootstrap -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/nav.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light  mb-4 container">
    <div class="container-fluid">
      <a href="index.php"><img src="img/logo.png" alt="" width="200px" height="auto" class="d-inline-block align-text-top"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item ms-5">
            <a class="nav-link" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item ms-5">
            <a class="nav-link" aria-current="page" href="product-page.html">Products</a>
          </li>
          <li class="nav-item ms-5">
            <a class="nav-link" aria-current="page" href="#">About Us</a>
          </li>
          <li class="nav-item ms-5">
            <a class="nav-link" aria-current="page" href="#">FAQs</a>
          </li>
          <li class="nav-item ms-5">
            <a class="nav-link" aria-current="page" href="contact.php">Contact</a>
          </li>
          <li class="nav-item ms-5">
            <a class="nav-link" aria-current="page" href="user/cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  </div>

  <div class="container mt-5">
    <h2>Adaugă Produs Nou</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">Nume Produs</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="description">Descriere</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="price">Preț</label>
        <input type="number" class="form-control" id="price" name="price" required>
      </div>
      <div class="form-group">
        <label for="stockQuantity">Cantitate în Stoc</label>
        <input type="number" class="form-control" id="stockQuantity" name="stockQuantity" required>
      </div>
      <div class="form-group">
        <label for="image">Imagine</label>
        <input type="file" class="form-control-file" id="image" name="image" required accept="image/*">
      </div>
      <div class="form-group">
        <label for="rating">Rating</label>
        <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
      </div>
      <div class="form-group">
        <label for="category">Categorie</label>
        <input type="text" class="form-control" id="category" name="category" required>
      </div>
      <button type="submit" class="btn btn-primary">Adaugă Produs</button>
    </form>
  </div>
  <?php
  // Verifică dacă formularul a fost trimis
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Includeți fișierul de conexiune la baza de date
    include 'php/config.php';

    // Preiați datele din formular
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stockQuantity'];
    $rating = $_POST['rating'];
    $category = $_POST['category'];

    // Verificați dacă fișierul a fost încărcat cu succes
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
      $fileTmpPath = $_FILES['image']['tmp_name'];
      $fileName = $_FILES['image']['name'];
      $fileSize = $_FILES['image']['size'];
      $fileType = $_FILES['image']['type'];
      $fileNameCmps = explode(".", $fileName);
      $fileExtension = strtolower(end($fileNameCmps));

      // Verificați tipurile de fișiere permise
      $allowedExtensions = array('jpg', 'jpeg', 'png');

      if (in_array($fileExtension, $allowedExtensions)) {
        // Generează un nume unic pentru imagine
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = 'uploads/items';
        $dest_path = $uploadFileDir . $newFileName;

        // Mută fișierul încărcat în directorul dorit
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
          // Inserează datele în baza de date
          $sql = "INSERT INTO products (name, description, price, stockQuantity, imageHref, rating, category) 
                        VALUES ('$name', '$description', $price, $stockQuantity, '$dest_path', $rating, '$category')";

          if (mysqli_query($conn, $sql)) {
            echo '<div class="container mt-3 alert alert-success" role="alert">
                            Produsul a fost adăugat cu succes.
                          </div>';
          } else {
            echo '<div class="container mt-3 alert alert-danger" role="alert">
                            Eroare: ' . $sql . "<br>" . mysqli_error($conn) . '
                          </div>';
          }
        } else {
          echo '<div class="container mt-3 alert alert-danger" role="alert">
                        A apărut o eroare la încărcarea imaginii.
                      </div>';
        }
      } else {
        echo '<div class="container mt-3 alert alert-danger" role="alert">
                    Tipul de fișier nu este permis. Se acceptă doar fișiere de tip JPG, JPEG și PNG.
                  </div>';
      }
    } else {
      echo '<div class="container mt-3 alert alert-danger" role="alert">
                A apărut o eroare la încărcarea imaginii.
              </div>';
    }

    // Închideți conexiunea la baza de date
    mysqli_close($conn);
  }
  ?>
</body>

</html>