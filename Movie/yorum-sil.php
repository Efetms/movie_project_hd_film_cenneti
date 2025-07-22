<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION['kullanici_id'])) {
    echo json_encode(['success' => false, 'message' => 'Oturum açılmamış!']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Sadece POST isteklerini kabul et
    $yorum_id = intval($_POST['yorum_id']);
    $kullanici_id = $_SESSION['kullanici_id'];

    // Yorumun kullanıcıya ait olup olmadığını kontrol et
    $sorgu = "SELECT * FROM yorumlar WHERE id = $yorum_id AND kullanici_id = $kullanici_id";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if (mysqli_num_rows($sonuc) === 0) {
        echo json_encode(['success' => false, 'message' => 'Bu yorumu silme yetkiniz yok!']);
        exit;
    }

    // Yorumu sil
    $silSorgu = "DELETE FROM yorumlar WHERE id = $yorum_id";
    if (mysqli_query($baglanti, $silSorgu)) {
        echo json_encode(['success' => true, 'message' => 'Yorum başarıyla silindi.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Yorum silinirken bir hata oluştu: ' . mysqli_error($baglanti)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek metodu!']);
}
?>