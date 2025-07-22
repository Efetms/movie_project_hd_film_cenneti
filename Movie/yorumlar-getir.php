<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Yorum yapmak için giriş yapmalısınız.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $film_id = intval($_POST['film_id']);
    $yorum = mysqli_real_escape_string($baglanti, $_POST['yorum']);
    $kullanici_email = $_SESSION['email']; 
    $yorum_tarihi = date("Y-m-d H:i:s");

    // Kullanıcı ID'sini al
    $kullanici_sorgu = "SELECT id, ad, soyad FROM kullanicilar WHERE email = '$kullanici_email'";
    $kullanici_sonuc = mysqli_query($baglanti, $kullanici_sorgu);
    $kullanici = mysqli_fetch_assoc($kullanici_sonuc);

    if (!$kullanici) {
        echo json_encode(['success' => false, 'message' => 'Kullanıcı bulunamadı!']);
        exit;
    }

    $kullanici_id = $kullanici['id'];
    $kullanici_ad = $kullanici['ad'];
    $kullanici_soyad = $kullanici['soyad'];

    // Yorum veritabanına ekle
    $query = "INSERT INTO yorumlar (kullanici_id, film_id, yorum, yorum_tarihi) 
              VALUES ('$kullanici_id', '$film_id', '$yorum', '$yorum_tarihi')";

    if (mysqli_query($baglanti, $query)) {
        $yorum_id = mysqli_insert_id($baglanti); // Eklenen yorumun ID'sini al
        echo json_encode([
            'success' => true, 
            'kullanici_adi' => $kullanici_ad, 
            'kullanici_soyadi' => $kullanici_soyad, 
            'yorum' => $yorum, 
            'yorum_tarihi' => $yorum_tarihi,
            'film_id' => $film_id,
            'yorum_id' => $yorum_id
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Yorum eklenemedi!']);
    }
    exit;
}
?>