<?php
session_start();
include("baglanti.php");

$film_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM filmler WHERE id = $film_id";
$result = mysqli_query($baglanti, $sql);

if(!$result || mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$film = mysqli_fetch_assoc($result);

// Resim URL'sini normalize et
function getImageUrl($path) {
    $baseUrl = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    
    if (empty($path)) return $baseUrl . '/film/img/default_poster.jpg';
    if (preg_match('/^https?:\/\//i', $path)) return $path;
    if (preg_match('/[a-zA-Z]:[\\\/].*\.(jpg|png|jpeg|gif)$/i', $path)) {
        return $baseUrl . '/film/img/' . basename($path);
    }
    return $baseUrl . '/' . ltrim($path, '/');
}

$imageUrl = getImageUrl($film['image']);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($film['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .film-container { display: flex; margin: 20px; }
        .film-poster { flex: 0 0 300px; margin-right: 20px; }
        .film-poster img { width: 100%; border-radius: 8px; }
        .film-info { flex: 1; }
        .film-title { font-size: 2rem; margin-bottom: 10px; }
        .film-meta { color: #666; margin-bottom: 20px; }
        .film-meta span { margin-right: 15px; }
        .film-actions { margin-bottom: 20px; }
        .btn-play { margin-right: 10px; }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>
    
    <div class="film-container">
        <div class="film-poster">
            <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($film['title']); ?>">
        </div>
        
        <div class="film-info">
            <h1 class="film-title"><?php echo htmlspecialchars($film['title']); ?></h1>
            
            <div class="film-meta">
                <span><?php echo htmlspecialchars($film['release_date']); ?></span>
                <span><?php echo htmlspecialchars($film['genre']); ?></span>
                <span><?php echo htmlspecialchars($film['hours']); ?> saat</span>
            </div>
            
            <div class="film-actions">
                <?php if(!empty($film['video_yolu'])): ?>
                    <a href="<?php echo htmlspecialchars($film['video_yolu']); ?>" class="btn btn-danger btn-play">
                        <i class="material-icons">play_arrow</i> Oynat
                    </a>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['email'])): ?>
                    <button class="btn btn-outline-secondary favorite-btn" data-movieid="<?php echo $film['id']; ?>">
                        <i class="material-icons">favorite_border</i> Favori
                    </button>
                <?php endif; ?>
            </div>
            
            <div class="film-description">
                <h3>Konu</h3>
                <p><?php echo nl2br(htmlspecialchars($film['description'])); ?></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.favorite-btn').click(function() {
            const movieId = $(this).data('movieid');
            const btn = $(this);
            
            $.post('favori-ekle.php', { movie_id: movieId }, function(response) {
                const icon = btn.find('.material-icons');
                if(response.includes('eklendi')) {
                    icon.text('favorite');
                    btn.removeClass('btn-outline-secondary').addClass('btn-danger');
                } else {
                    icon.text('favorite_border');
                    btn.removeClass('btn-danger').addClass('btn-outline-secondary');
                }
            });
        });
    });
    </script>
</body>
</html>