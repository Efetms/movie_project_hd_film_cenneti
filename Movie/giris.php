
<?php
include("baglanti.php");

$emailHata = $parolaHata = $parolatkrHata = "";
$parolahata = "";

if (isset($_POST["kaydet"])) {
    $email = $_POST["email"];
    $parola = $_POST["parola"];
    $parolatkr = $_POST["parolatkr"];

    // Her bir alan için boşluk kontrolü
    if (empty($email)) {
        $emailHata = "Bu alan boş bırakılamaz.";
    } else {
        // Veritabanında e-posta kontrolü
        $emailKontrolSorgu = "SELECT * FROM kullanicilar WHERE email = '$email'";
        $emailKontrolSonuc = mysqli_query($baglanti, $emailKontrolSorgu);
        $parolaKontrolSorgu = "SELECT * FROM kullanicilar WHERE parola = '$email'";
        $parolaKontrolSorgu = mysqli_query($baglanti , $parolaKontrolSorgu);
        $kayit_sayisi = mysqli_num_rows($emailKontrolSonuc);
        if (mysqli_num_rows($emailKontrolSonuc) == 0) {
            $emailHata = "Lütfen geçerli bir email adresi giriniz.";
        }
        if($kayit_sayisi > 0)
        {
            $ilgili_kayit = mysqli_fetch_assoc($emailKontrolSonuc);
            $hashlisifre = $ilgili_kayit["parola"];

            if(password_verify($parola,$hashlisifre))
            {
                session_start();
                $_SESSION["email"] = $ilgili_kayit["email"];
                $_SESSION['ad'] = $ilgili_kayit['ad']; // Kullanıcının adı
                $_SESSION['soyad'] = $ilgili_kayit['soyad']; // Kullanıcının soyadı
                $_SESSION['kullanici_id'] = $ilgili_kayit['id'];
                header("location:index.php");
            }
            else{
                $parolaHata = "Lütfen şifrenizi doğru giriniz!";
            }
        }
    }

   
  
   
    if (empty($parola)) {
        $parolaHata = "Bu alan boş bırakılamaz.";
    }
    if (empty($parolatkr)) {
        $parolatkrHata = "Bu alan boş bırakılamaz.";
    }

    // Parolaların eşleşip eşleşmediğini kontrol et
    if ($parola != $parolatkr && empty($parolaHata) && empty($parolatkrHata)) {
        $parolahata = "Parolalar eşleşmiyor.";
    }

    // Tüm alanlar doldurulmuşsa ve parolalar eşleşiyorsa kaydet
    if (empty($emailHata) && empty($parolaHata) && empty($parolatkrHata) && empty($parolahata)) {
        $parolaHash = password_hash($parola, PASSWORD_DEFAULT);

        // Veritabanına kaydetme işlemi
        $ekle = "INSERT INTO kullanicilar (ad, soyad, email, parola) VALUES ('$ad', '$soyad', '$email', '$parolaHash')";
        $calistirekle = mysqli_query($baglanti, $ekle);

    }

    mysqli_close($baglanti);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt ol</title>
    
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<style>
    body{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #111;
    }
    .parola-hata{
        color: red;
        padding: 0px;
        margin: 0px;
        font-size: 13px;
        margin-left: 10px;
    }
</style>
<body>

        



       <!-- Navbar -->
<div class="nav-bar">
  <div class="logo">
     <a href="index.php"> <img src="img/logo.png" alt=""></a>
  </div>
 
  
  <div class="links">
      <ul>
          <li><a href="index.php">Anasayfa</a></li>
          <li><a href="sss.phps">S.S.S</a></li>
          <li><a href="filmler.html">Filmler</a></li>        
            
      </ul>
  </div>
  <div class="login">
      <!-- Giriş Yap Butonu -->
      <a href="giris.php"><button id="giris" data-bs-toggle="modal" data-bs-target="#loginModal">Giriş Yap</button></a>
      <!-- Kayıt Ol Butonu -->
      <a href="kayit.php"><button id="kayit" data-bs-toggle="modal" data-bs-target="#signupModal">Kayıt Ol</button></a>
  </div>
</div>




        
        <div class="container-kayit">
      
<div class="top">
               
                <h2 style="font-size: 26px !important;" >Giriş Yap</h2>

                <div class="logo">
                    <a href="#"> <img src="img/logo.png" alt=""></a>
                 </div>
            </div>
            <form action="giris.php" method="post">
    <div class="kayit-input giris-input">
        <input type="text" placeholder="Email*" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
        <?php if (!empty($emailHata)) echo "<p class='parola-hata'>$emailHata</p>"; ?>

        <input type="password" placeholder="Parola*" name="parola">
        <?php if (!empty($parolaHata)) echo "<p class='parola-hata'>$parolaHata</p>"; ?>
    </div>

    <div class="login" id="kayit-wrap">
        <button id="kayit" class="kayit-btn" name="kaydet">Giriş Yap</button>
    </div>
    <span id="uye-hesap">Bir hesabınız yok mu?</span><span id="uye-btn"><a href="kayit.php">Kayıt Ol</a></span>
</form>
                <div class="footer-bottom">

                    <ul class="social-icons">
                            <li><a href="#"><i class="fi fi-brands-instagram"></i></a></li>
                            <li><a href="#"><i class="fi fi-brands-whatsapp"></i></a></li>
                            <li><a href="#"><i class="fi fi-brands-twitter-alt"></i></a></li>
                            <li><a href="#"><i class="fi fi-brands-facebook"></i></a></li>
                            <li><a href="#"><i class="fi fi-brands-tik-tok"></i></a></li>
                            
                    </ul>
                 </div>
        </div>      
        <div id="loading-container">
    <div class="spinner"></div>
    <p id="loading-text">Giriş Yapılıyor...</p>
</div>



</body>
</html>