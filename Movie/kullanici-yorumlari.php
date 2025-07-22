<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION['kullanici_id'])) {
    echo json_encode(['success' => false, 'message' => 'Oturum açılmamış!']);
    exit;
}

$kullanici_id = $_SESSION['kullanici_id'];

// Yorumları ve kullanıcı adı/soyadını çek
$sorgu = "SELECT y.id AS yorum_id, y.film_id, y.yorum, y.yorum_tarihi, k.ad AS kullanici_adi, k.soyad AS kullanici_soyadi 
          FROM yorumlar y
          INNER JOIN kullanicilar k ON y.kullanici_id = k.id
          WHERE y.kullanici_id = $kullanici_id
          ORDER BY y.yorum_tarihi DESC";

$sonuc = mysqli_query($baglanti, $sorgu);

if (!$sonuc) {
    echo json_encode(['success' => false, 'message' => 'Veritabanı hatası: ' . mysqli_error($baglanti)]);
    exit;
}

$yorumlar = [];
while ($satir = mysqli_fetch_assoc($sonuc)) {
    $yorumlar[] = $satir;
}

echo json_encode($yorumlar);
exit;
?>