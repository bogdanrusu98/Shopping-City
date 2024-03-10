<?php
// Interogare pentru a prelua datele din baza de date
$sql = "SELECT * FROM index_settings";
$result = $conn->query($sql);

// Verifică dacă există rezultate
if ($result->num_rows > 0) {
  // Preia prima (și singura) înregistrare din rezultatele interogării
  $row = $result->fetch_assoc();
  
  $footer_about = $row['footer_about'];
  $contact_address = $row['contact_address'];
  $contact_phone = $row['contact_phone'];
  $contact_email = $row['contact_email'];
  $social_facebook = $row['social_facebook'];
  $social_instagram = $row['social_instagram'];
  $social_whatsapp = $row['social_whatsapp'];

}
?>