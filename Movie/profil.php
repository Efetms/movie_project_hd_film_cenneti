<?php
session_start();
include("baglanti.php");

// Kullanıcı giriş yapmamışsa yönlendir
if (!isset($_SESSION["email"])) {
    header("Location: giris.php");
    exit();
}

$email = $_SESSION["email"];
$ad = $_SESSION["ad"];

// Kullanıcı bilgilerini getir
$sql = "SELECT * FROM kullanicilar WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="profile-container">
    <div class="profile-header">
        <span class="profile-name">Profilim</span>
        <button class="profile-toggle-btn">☰</button>
    </div>
    <div class="profile-menu">
        <ul>
            <li><a href="#favorites">Favorilerim</a></li>
            <li><a href="#comments">Yorumlarım</a></li>
            <li><a href="#account">Hesap Bilgilerim</a></li>
            <li><a href="#watched">İzlediğim Filmler</a></li>
        </ul>
    </div>
</div>
<script>// Profil menüsünü gösterip gizleyen işlev
document.querySelector('.profile-toggle-btn').addEventListener('click', function() {
    const menu = document.querySelector('.profile-menu');
    menu.classList.toggle('show');
});
</script>
</body>
</html>
