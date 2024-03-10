<?php
// Verifică dacă există sesiunea pentru username
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
} else {
  $id = 0;
}
$sql = "SELECT COUNT(*) AS totalProductsWishlist FROM wishlist WHERE user_id = $id";

// Executați interogarea și obțineți rezultatul
$result = $conn->query($sql);

// Verificați dacă există rezultate și afișați numărul total de recenzii pentru produs
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $totalProductsWishlist = $row["totalProductsWishlist"];
}
