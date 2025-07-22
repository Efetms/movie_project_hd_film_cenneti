<?php
header('Content-Type: text/html; charset=utf-8');
require_once('../baglanti.php');

// TÜM resimler için default poster yolu
$default_poster = 'img/default_poster.jpg'; // Bu yolun doğru olduğundan emin olun

try {
    $query = isset($_POST['query']) ? trim($_POST['query']) : '';
    
    if(empty($query)) {
        $sql = "SELECT id, title FROM filmler ORDER BY RAND() LIMIT 8";
        $stmt = $baglanti->prepare($sql);
    } else {
        $sql = "SELECT id, title FROM filmler WHERE title LIKE ? LIMIT 10";
        $stmt = $baglanti->prepare($sql);
        $searchQuery = "%" . $query . "%";
        $stmt->bind_param("s", $searchQuery);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $html = '';
    
 while($film = $result->fetch_assoc()) {
    $isThor = stripos($film['title'], 'Thor') !== false;
     $imageUrl = $isThor ? '/film/img/thor3.jpg' : '/film/img/default_poster.jpg';    
    $html .= '
    <div class="search-result-item" data-film="'.($isThor ? 'thor' : '').'">
        <div class="search-result-image" style="background-image: url('.$imageUrl.')">
            '.($isThor ? '' : '<div class="coming-soon-badge">Çok yakında sizlerle!</div>').'
        </div>
        <div class="search-result-info">
            <div class="search-result-title">'.$film['title'].'</div>
        </div>
    </div>';
}
    
    echo $html ?: '<div class="no-results">Sonuç bulunamadı</div>';

} catch(Exception $e) {
    echo '<div class="error-message">Arama geçici olarak hizmet veremiyor</div>';
}
?>