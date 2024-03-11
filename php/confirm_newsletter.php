<?php
include 'config.php';
$response = '';
if (isset($_GET['code'])) {
    $confirmation_code = $_GET['code'];

     // Interogare pentru a verifica dacă produsul se află în tabela de dorințe (wishlist) pentru utilizatorul curent
     $sql_check_confirmation_code = "SELECT * FROM newsletter_subscribers WHERE confirmation_code = '$confirmation_code'";
     $result_check_wishlist = mysqli_query($conn, $sql_check_confirmation_code);

     if (mysqli_num_rows($result_check_wishlist) > 0) {
         // Actualizarea înregistrării din baza de date la confirmarea abonamentului
         $sql = "UPDATE newsletter_subscribers SET confirmed = 1 WHERE confirmation_code = '$confirmation_code'";
         if ($conn->query($sql) === TRUE) {
            $response = "success";
         }
     }else{
        $response = "error";
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




<?php
if($response == "success") {
    ?>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1>Felicitări</h1>
        <h4>Te-ai abonat la newsletter-ul Shopping City</h4>
        <i class="fa-regular fa-paper-plane display-1 my-4" style="color: #abd373"></i><br>
        <a href="../index.php" class="btn btn-primary btn-lg my-2">Start cumpărături</a>
    </div>
</div>

    <?php
} 
if($response == "error") {
?>
    <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1>Off..</h1>
        <h4>Codul este incorect. Contacteaza suport clienti.</h4>
        <i class="fa-regular fa-face-sad-tear display-1 my-4" style="color: #abd373"></i><br>
        <a href="../contact.php" class="btn btn-primary btn-lg my-2">Start cumpărături</a>
    </div>
</div>
<?php
}
?>









</body>

</html>