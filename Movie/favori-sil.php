<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION['kullanici_id'])) {
    echo json_encode(['success' => false, 'message' => 'Oturum açılmamış!']);
    exit();
}

$userId = $_SESSION['kullanici_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['movie_id'])) {
        $movieId = intval($_POST['movie_id']);
        $deleteQuery = "DELETE FROM favori_filmler WHERE user_id = $userId AND movie_id = $movieId";
        if (mysqli_query($baglanti, $deleteQuery)) {
            echo json_encode(['success' => true, 'message' => 'Film favorilerden silindi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Film silinirken bir hata oluştu.']);
        }
    } elseif (isset($_POST['delete_all'])) {
        $deleteAllQuery = "DELETE FROM favori_filmler WHERE user_id = $userId";
        if (mysqli_query($baglanti, $deleteAllQuery)) {
            echo json_encode(['success' => true, 'message' => 'Tüm favori filmler silindi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Filmler silinirken bir hata oluştu.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek metodu.']);
}
?>