<?php
session_start();
include("baglanti.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $film_id = intval($_GET['film_id']);

    $sorgu = "SELECT y.id AS yorum_id, y.film_id, y.yorum, y.yorum_tarihi, k.ad AS kullanici_adi, k.soyad AS kullanici_soyadi, y.kullanici_id 
              FROM yorumlar y
              INNER JOIN kullanicilar k ON y.kullanici_id = k.id
              WHERE y.film_id = $film_id
              ORDER BY y.yorum_tarihi DESC";

    $sonuc = mysqli_query($baglanti, $sorgu);
    $yorumlar = [];

    while ($satir = mysqli_fetch_assoc($sonuc)) {
        $yorumlar[] = $satir;
    }

    echo json_encode($yorumlar);
    exit;
}
?>