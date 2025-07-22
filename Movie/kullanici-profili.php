<?php
session_start();
include("baglanti.php"); // Veritabanı bağlantısını dahil et

$message = ""; // Mesajı saklamak için değişken
$messageType = ""; // Mesaj türünü saklamak için değişken (success veya error)

// Şifre değiştirme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Kullanıcı ID'sini oturumdan al
    if (!isset($_SESSION['kullanici_id'])) {
        $message = "Oturum açılmamış!";
        $messageType = "error";
    } else {
        $userId = $_SESSION['kullanici_id'];

        // Kullanıcının mevcut şifresini veritabanından al
        $sql = "SELECT parola FROM kullanicilar WHERE id = ?";
        $stmt = mysqli_prepare($baglanti, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hashedPassword);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Mevcut şifreyi doğrula
        if (password_verify($oldPassword, $hashedPassword)) {
            if ($newPassword === $confirmPassword) {
                // Yeni şifreyi hashle
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Yeni şifreyi veritabanında güncelle
                $updateSql = "UPDATE kullanicilar SET parola = ? WHERE id = ?";
                $updateStmt = mysqli_prepare($baglanti, $updateSql);
                mysqli_stmt_bind_param($updateStmt, "si", $newHashedPassword, $userId);

                if (mysqli_stmt_execute($updateStmt)) {
                    $_SESSION['message'] = "Şifre başarıyla değiştirildi!";
                    $_SESSION['messageType'] = "success";
                    header("Location: " . $_SERVER['PHP_SELF']); // Sayfayı yeniden yükle
                    exit();
                } else {
                    $message = "Şifre güncellenirken bir hata oluştu.";
                    $messageType = "error";
                }
                mysqli_stmt_close($updateStmt);
            } else {
                $message = "Yeni şifreler eşleşmiyor!";
                $messageType = "error";
            }
        } else {
            $message = "Eski şifre yanlış!";
            $messageType = "error";
        }
    }
}

// Ad, Soyad ve Email değiştirme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $newAd = $_POST['newAd'];
    $newSoyad = $_POST['newSoyad'];
    $newEmail = $_POST['newEmail'];

    // Kullanıcı ID'sini oturumdan al
    if (!isset($_SESSION['kullanici_id'])) {
        $message = "Oturum açılmamış!";
        $messageType = "error";
    } else {
        $userId = $_SESSION['kullanici_id'];

        // Veritabanında güncelleme yap
        $updateSql = "UPDATE kullanicilar SET ad = ?, soyad = ?, email = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($baglanti, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "sssi", $newAd, $newSoyad, $newEmail, $userId);

        if (mysqli_stmt_execute($updateStmt)) {
            // Oturum verilerini güncelle
            $_SESSION['ad'] = $newAd;
            $_SESSION['soyad'] = $newSoyad;
            $_SESSION['email'] = $newEmail;

            $_SESSION['message'] = "Profil bilgileri başarıyla güncellendi!";
            $_SESSION['messageType'] = "success";
            header("Location: " . $_SERVER['PHP_SELF']); // Sayfayı yeniden yükle
            exit();
        } else {
            $message = "Profil bilgileri güncellenirken bir hata oluştu.";
            $messageType = "error";
        }
        mysqli_stmt_close($updateStmt);
    }
}

// Favori filmleri çekme işlemi
$favoriFilmler = [];
if (isset($_SESSION['kullanici_id'])) {
    $userId = $_SESSION['kullanici_id'];
    $favoriSorgu = "
        SELECT f.id, f.title, f.description, f.release_date, f.genre, f.image, f.hours 
        FROM filmler f
        INNER JOIN favori_filmler ff ON f.id = ff.movie_id
        WHERE ff.user_id = $userId
    ";
    $favoriSonuc = mysqli_query($baglanti, $favoriSorgu);

    if ($favoriSonuc && mysqli_num_rows($favoriSonuc) > 0) {
        while ($film = mysqli_fetch_assoc($favoriSonuc)) {
            $favoriFilmler[] = $film;
        }
    }
}

// Oturum mesajlarını al
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageType = $_SESSION['messageType'];
    unset($_SESSION['message']); // Mesajı gösterdikten sonra temizle
    unset($_SESSION['messageType']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Profili</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Genel stil */
        body {
            background-color: #0f0f0f;
            color: white;
            font-family: 'Poppins', sans-serif;
            display: flex;
            padding: 20px;
            margin: 0;
        }

        /* Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

/* Sidebar */
.sidebar {
    width: 250px;
    background: linear-gradient(145deg, #1e1e1e, #2a2a2a);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 95vh;
}

/* Kullanıcı Bilgileri Container */
.welcome-container {
    background: linear-gradient(145deg, #6a11cb, #2575fc);
    padding: 20px;
    border-radius: 15px;
    color: white;
    margin-bottom: 20px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
    overflow: hidden;
}

.welcome-container::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent 70%);
    animation: rotate 10s linear infinite;
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.welcome-container:hover {
    transform: translateY(-5px);
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.4);
}

/* Kullanıcı Bilgileri */
.user-info {
    text-align: left;
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.user-info p {
    margin: 0;
    font-size: 16px;
    line-height: 1.6;
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-info p i {
    font-size: 20px;
    color: #fff;
}

.user-info .user-name {
    font-size: 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-info .user-email {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.9);
}

/* Sidebar Menü */
.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar li {
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    cursor: pointer;
    text-align: center;
    font-weight: 500;
    transition: all 0.3s ease;
    background: #333;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar li:hover {
    background: linear-gradient(145deg, #6a11cb, #2575fc);
    transform: scale(1.01);
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
}

.sidebar .active {
    background: linear-gradient(145deg, #6a11cb, #2575fc);
}

/* Menü İkonları */
.sidebar li i {
    margin-right: 10px;
    font-size: 18px;
}

/* Logout Container */
.logout-container {
    margin-top: auto;
    text-align: center;
    padding-top: 20px;
}

.logout-container a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
}

.logout-container a:hover {
    color: #2575fc;
}

/* Container */
.container {
    flex: 1;
    background: linear-gradient(145deg, #1e1e1e, #2a2a2a);
    margin-left: 20px;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
    overflow: auto;
    position: relative;
    z-index: 1;
    min-height: 100vh;
}

/* Container Scroll Bar Stili */
.container::-webkit-scrollbar {
    width: 10px; /* Scroll bar genişliği */
}

.container::-webkit-scrollbar-track {
    background: #1e1e1e; /* Scroll bar arka plan rengi */
    border-radius: 10px; /* Scroll bar track köşe yuvarlaklığı */
}

.container::-webkit-scrollbar-thumb {
    background: #444; /* Scroll bar thumb rengi (daha soft gri) */
    border-radius: 10px; /* Scroll bar thumb köşe yuvarlaklığı */
    border: 2px solid #1e1e1e; /* Scroll bar thumb kenarlık rengi */
}

.container::-webkit-scrollbar-thumb:hover {
    background: #555; /* Scroll bar thumb hover rengi (biraz daha açık gri) */
}

/* Firefox için Scroll Bar Stili */
.container {
    scrollbar-width: thin; /* Scroll bar genişliği */
    scrollbar-color: #444 #1e1e1e; /* Scroll bar thumb ve track rengi */
}

/* Profil Sayfası Stili */
.profile-content {
    display: none;
}

.profile-content.active {
    display: block;
}

.profile-content h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #fff;
}

.profile-content .user-info {
    background: linear-gradient(145deg, #1e1e1e, #2a2a2a);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 20px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
}

.profile-content form {
    background: linear-gradient(145deg, #1e1e1e, #2a2a2a);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
    margin-bottom: 20px;
    max-width: 100%;
    width: 100%;
    box-sizing: border-box;
    position: relative;
    z-index: 2;
}

.profile-content .input-container {
    margin-bottom: 20px;
}

.profile-content .input-container label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #ccc;
}

.profile-content .input-container input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: none;
    background: #333;
    color: white;
    font-size: 14px;
    transition: background 0.3s;
    box-sizing: border-box;
}

.profile-content .input-container input:focus {
    background: #444;
    outline: none;
}

.profile-content .save-btn {
    width: auto;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    background: #2ecc71;
    color: white;
    font-weight: bold;
    transition: background 0.3s, transform 0.2s;
    box-sizing: border-box;
}

.profile-content .save-btn:hover {
    background: #27ae60;
    transform: translateY(-2px);
}

/* Favori Filmler Sayfası Stili */
.favorites-content {
    display: none;
}

.favorites-content.active {
    display: block;
}

.favorites-content h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #fff;
}

.favorites-content table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.favorites-content th, .favorites-content td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #444;
}

.favorites-content th {
    background: #333;
}

.favorites-content td img {
    width: 60px;
    border-radius: 8px;
}

.favorites-content .delete-btn, .favorites-content .download-btn {
    padding: 8px 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s, transform 0.2s;
}

.favorites-content .delete-btn {
    background: #e74c3c;
    color: white;
}

.favorites-content .delete-btn:hover {
    background: #c0392b;
    transform: translateY(-2px);
}

.favorites-content .download-btn {
    background: #2ecc71;
    color: white;
}

.favorites-content .download-btn:hover {
    background: #27ae60;
    transform: translateY(-2px);
}

/* Mesaj stilleri */
.message {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    font-weight: bold;
}
.message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Responsive Tasarım */
@media (max-width: 768px) {
    .profile-content form {
        padding: 15px;
    }

    .profile-content .input-container input {
        padding: 10px;
    }

    .profile-content .save-btn {
        padding: 10px 15px;
    }
}
/* Yorumlarım Sayfası Stili */
.my-comments-content {
    padding: 20px;
    background: linear-gradient(145deg, #1e1e1e, #2a2a2a);
    border-radius: 15px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
    margin-bottom: 20px;
    display: none;
}
.my-comments-content.active{
       display: block;
}
.my-comments-content h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #fff;
    border-bottom: 2px solid red;
    padding-bottom: 10px;
}

#my-comments-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-height: 700px; /* Maksimum yükseklik */
    overflow-y: auto; /* Dikey kaydırma çubuğu */
    padding-right: 10px; /* Kaydırma çubuğu için boşluk */
}

/* Yorum Kartları */
.yorum {
    background: #333;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s, box-shadow 0.3s;
}

.yorum:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
    cursor: pointer;
}

.yorum strong {
    color: red;
    font-size: 18px;
    display: block;
    margin-bottom: 10px;
}

.yorum p {
    color: #fff;
    font-size: 14px;
    line-height: 1.6;
    margin: 0;
}

.yorum small {
    color: #888;
    font-size: 12px;
    display: block;
    margin-top: 10px;
}

/* Kaydırma çubuğu stilini özelleştirme */
#my-comments-list::-webkit-scrollbar {
    width: 8px; /* Kaydırma çubuğu genişliği */
}

#my-comments-list::-webkit-scrollbar-track {
    background: #1e1e1e; /* Kaydırma çubuğu arka plan rengi */
    border-radius: 10px;
}

#my-comments-list::-webkit-scrollbar-thumb {
    background: #6a11cb; /* Kaydırma çubuğu rengi */
    border-radius: 10px;
}

#my-comments-list::-webkit-scrollbar-thumb:hover {
    background: #2575fc; /* Kaydırma çubuğu hover rengi */
}
/* Yorum yoksa veya hata mesajı */
.no-comments, .error-message {
    text-align: center;
    color: #888;
    font-size: 16px;
    padding: 20px;
    background: #2a2a2a;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}
.yorum.vurgulanan {
    background: rgba(255, 255, 255, 0.1); /* Soluk bir arkaplan */
    border-left: 5px solid #6a11cb; /* Sol kenar çizgisi */
    transition: background 0.3s, border-left 0.3s;
}
</style>
</head>
<body>
<div class="sidebar">
    <!-- Kullanıcı Bilgileri -->
    <div class="welcome-container" id="toggleMenu">
        <div class="user-info">
            <div class="user-name">
                <i class="bi bi-person-circle"></i>
                <span><?php echo $_SESSION['ad'] . ' ' . $_SESSION['soyad']; ?></span>
            </div>
            <p><i class="bi bi-envelope"></i><?php echo $_SESSION['email']; ?></p>
        </div>
    </div>
    <ul>
        <!-- Anasayfa Bağlantısı -->
        <li onclick="goToHomePage()"><i class="bi bi-house"></i><span>Anasayfa</span></li>
        <li class="active" onclick="showProfile()"><i class="bi bi-person"></i><span>Profil</span></li>
        <li onclick="showFavorites()"><i class="bi bi-heart"></i><span>Favori Filmler</span></li>
        <li onclick="showMyComments()"><i class="bi bi-chat-left-text"></i><span>Yorumlarım</span></li>
    </ul>
    <div class="logout-container">
        <a href="cikis.php" id="logoutLink"><li><i class="bi bi-box-arrow-right"></i><span>Oturumu Kapat</span></li></a>
    </div>
</div>

<div class="container">
    <!-- Profil Sayfası -->
    <div class="profile-content active" id="profileContent">
        <h2>Profil Bilgileri</h2>
        <div class="user-info">
            <p><strong>Ad:</strong> <?php echo $_SESSION['ad']; ?></p>
            <p><strong>Soyad:</strong> <?php echo $_SESSION['soyad']; ?></p>
            <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        </div>

        <!-- Ad, Soyad ve Email Güncelleme Formu -->
        <h2>Profil Bilgilerini Güncelle</h2>

        <!-- Geri Bildirim Mesajı -->
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-container">
                <label for="newAd">Yeni Ad</label>
                <input type="text" id="newAd" name="newAd" placeholder="Yeni adınızı girin" value="<?php echo $_SESSION['ad']; ?>" required>
            </div>
            <div class="input-container">
                <label for="newSoyad">Yeni Soyad</label>
                <input type="text" id="newSoyad" name="newSoyad" placeholder="Yeni soyadınızı girin" value="<?php echo $_SESSION['soyad']; ?>" required>
            </div>
            <div class="input-container">
                <label for="newEmail">Yeni Email</label>
                <input type="email" id="newEmail" name="newEmail" placeholder="Yeni emailinizi girin" value="<?php echo $_SESSION['email']; ?>" required>
            </div>
            <button type="submit" name="update_profile" class="save-btn">Bilgileri Güncelle</button>
        </form>

        <!-- Şifre Değiştirme Formu -->
        <h2>Şifre Değiştir</h2>
        <form method="POST" action="">
            <div class="input-container">
                <label for="oldPassword">Eski Şifre</label>
                <input type="password" id="oldPassword" name="oldPassword" placeholder="Eski şifrenizi girin" required>
            </div>
            <div class="input-container">
                <label for="newPassword">Yeni Şifre</label>
                <input type="password" id="newPassword" name="newPassword" placeholder="Yeni şifrenizi girin" required>
            </div>
            <div class="input-container">
                <label for="confirmPassword">Yeni Şifre Tekrar</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Yeni şifrenizi tekrar girin" required>
            </div>
            <button type="submit" name="change_password" class="save-btn">Şifreyi Değiştir</button>
        </form>
    </div>

    <!-- Favori Filmler Sayfası -->
    <div class="favorites-content" id="favoritesContent">
        <h2>Favori Filmler</h2>
        <button class="delete-btn" onclick="confirmDeleteAll()">🗑 Tümünü Sil</button>
        <table>
            <thead>
                <tr>
                    <th>Resim</th>
                    <th>İsim</th>
                    <th>Kategori</th>
                    <th>Dil</th>
                    <th>Yıl</th>
                    <th> Ort. Süre</th>
                    <th>Eylemler</th>
                </tr>
            </thead>
            <tbody id="movie-list">
                <?php if (!empty($favoriFilmler)): ?>
                    <?php foreach ($favoriFilmler as $film): ?>
                        <tr id="film-<?php echo $film['id']; ?>">
                            <td><img src="<?php echo $film['image']; ?>" alt="<?php echo $film['title']; ?>" style="width: 60px; border-radius: 8px;"></td>
                            <td><?php echo $film['title']; ?></td>
                            <td><?php echo $film['genre']; ?></td>
                            <td><?php echo $film['language']; ?></td>
                            <td><?php echo $film['release_date']; ?></td>
                            <td><?php echo $film['hours']; ?>s</td>
                            <td>
                                <button class="download-btn" onclick="downloadMovie(<?php echo $film['id']; ?>)">⬇ İndir</button>
                                <button class="delete-btn" onclick="deleteMovie(<?php echo $film['id']; ?>)">🗑 Sil</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="no-movies">Favori film bulunamadı.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Yorumlarım Sayfası -->
    <div class="my-comments-content" id="myCommentsContent">
        <h2>Yorumlarım</h2>
        <div id="my-comments-list">
            <!-- Yorumlar buraya dinamik olarak eklenecek -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Anasayfa'ya git
    function goToHomePage() {
        window.location.href = "index.php";
    }

    // Profil ve Favori Filmler sayfalarını göster/gizle
    function showProfile() {
        document.getElementById('profileContent').classList.add('active');
        document.getElementById('favoritesContent').classList.remove('active');
        document.getElementById('myCommentsContent').classList.remove('active');
        setActiveTab(1); // Profil sekmesini aktif yap
    }

    function showFavorites() {
        document.getElementById('favoritesContent').classList.add('active');
        document.getElementById('profileContent').classList.remove('active');
        document.getElementById('myCommentsContent').classList.remove('active');
        setActiveTab(2); // Favori Filmler sekmesini aktif yap
    }

    function showMyComments() {
        document.getElementById('myCommentsContent').classList.add('active');
        document.getElementById('profileContent').classList.remove('active');
        document.getElementById('favoritesContent').classList.remove('active');
        setActiveTab(3); // Yorumlarım sekmesini aktif yap
        kullaniciYorumlariniGetir(); // Yorumları getir
    }

    // Aktif sekme stilini ayarla
    function setActiveTab(index) {
        const tabs = document.querySelectorAll('.sidebar li');
        tabs.forEach((tab, i) => {
            if (i === index) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });
    }

    // Sayfa yüklendiğinde Profil sayfasını göster
    window.onload = function () {
        showProfile();
    };

    // Kullanıcının yorumlarını getir
    function kullaniciYorumlariniGetir() {
        $.ajax({
            url: 'kullanici-yorumlari.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#my-comments-list').empty();
                if (response.length > 0) {
                    $.each(response, function (index, yorum) {
                        var yorumHTML = `
                            <div class="yorum" data-film-id="${yorum.film_id}" data-yorum-id="${yorum.yorum_id}">
                                <strong>${yorum.kullanici_adi} ${yorum.kullanici_soyadi}</strong>
                                <p>${yorum.yorum}</p>
                                <small>${yorum.yorum_tarihi}</small>
                            </div>
                        `;
                        $('#my-comments-list').append(yorumHTML);
                    });

                    // Yorumlara tıklanabilirlik ekle
                    $('.yorum').on('click', function () {
                        var filmId = $(this).data('film-id');
                        var yorumId = $(this).data('yorum-id');
                        window.location.href = `thor.php?id=${filmId}#yorum-${yorumId}`;
                    });
                } else {
                    $('#my-comments-list').html('<p class="no-comments">Henüz yorum yapmadınız.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                $('#my-comments-list').html('<p class="error-message">Yorumlar yüklenirken bir hata oluştu.</p>');
            }
        });
    }

    // Favori film silme işlemi
    function deleteMovie(movieId) {
        if (confirm('Bu filmi favorilerden silmek istediğinizden emin misiniz?')) {
            $.ajax({
                url: 'favori-sil.php',
                type: 'POST',
                data: { movie_id: movieId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        $('#film-' + movieId).remove(); // Film satırını tablodan kaldır
                        if ($('#movie-list tr').length === 1) { // Eğer hiç film kalmadıysa
                            $('#movie-list').html('<tr><td colspan="7" class="no-movies">Favori film bulunamadı.</td></tr>');
                        }
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    alert('Film silinirken bir hata oluştu.');
                }
            });
        }
    }

    // Tüm favori filmleri silme işlemi
    function confirmDeleteAll() {
        if (confirm('Tüm favori filmlerinizi silmek istediğinizden emin misiniz?')) {
            $.ajax({
                url: 'favori-sil.php',
                type: 'POST',
                data: { delete_all: true },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        $('#movie-list').html('<tr><td colspan="7" class="no-movies">Favori film bulunamadı.</td></tr>');
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    alert('Filmler silinirken bir hata oluştu.');
                }
            });
        }
    }
</script>
</body>
</html>