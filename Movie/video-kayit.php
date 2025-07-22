<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["email"])) {
    die(json_encode(['success' => false, 'message' => 'Oturum açılmamış']));
}

$film_id = intval($_POST['film_id']);
$user_id = $_SESSION['kullanici_id'];

// Debug için log
error_log("Video izleme kaydı: Kullanıcı $user_id, Film $film_id");

$sorgu = $baglanti->prepare("INSERT INTO izlemeler (kullanici_id, film_id, izleme_tarihi) VALUES (?, ?, NOW())");
$sorgu->bind_param("ii", $user_id, $film_id);
$sorgu->execute();

echo json_encode(['success' => true]);
?>