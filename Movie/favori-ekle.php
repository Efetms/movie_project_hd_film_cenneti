<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["email"])) {
    die("Lütfen giriş yapın!");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["movie_id"])) {
        $movie_id = intval($_POST["movie_id"]); // Gelen movie_id'yi integer olarak al
        $user_email = $_SESSION["email"];

        // Kullanıcı ID'sini çek
        $user_query = "SELECT id FROM kullanicilar WHERE email = '$user_email'";
        $user_result = mysqli_query($baglanti, $user_query);

        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user_data = mysqli_fetch_assoc($user_result);
            $user_id = $user_data["id"];

            // Daha önce eklenmiş mi kontrol et
            $check_query = "SELECT * FROM favori_filmler WHERE user_id = $user_id AND movie_id = $movie_id";
            $check_result = mysqli_query($baglanti, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                echo "Bu film zaten favorilere eklenmiş!";
            } else {
                // Favorilere ekleme işlemi
                $insert_query = "INSERT INTO favori_filmler (user_id, movie_id) VALUES ($user_id, $movie_id)";
                if (mysqli_query($baglanti, $insert_query)) {
                    echo "Film favorilere eklendi!";
                } else {
                    echo "Hata oluştu: " . mysqli_error($baglanti);
                }
            }
        } else {
            echo "Kullanıcı bulunamadı!";
        }
    } else {
        echo "Eksik veri gönderildi!";
    }
} else {
    echo "Geçersiz istek!";
}
?>
