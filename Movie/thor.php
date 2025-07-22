<?php
session_start();
include("baglanti.php");

// Thor filminin ID'si 1 olduğunu varsayıyoruz
$film_id = 2;
 $userId = "SELECT * FROM filmler WHERE id = $film_id";
// Film bilgilerini çek
$filmSorgu = "SELECT * FROM filmler WHERE id = $film_id";
$filmSonuc = mysqli_query($baglanti, $filmSorgu);
$film = mysqli_fetch_assoc($filmSonuc);

if (!$film) {
    die("Film bulunamadı!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $film['title']; ?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
/* Özel Kapatma Butonu */
.btn-close-custom {
    width: 40px;
    height: 40px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
}

.btn-close-custom:hover {
    background: rgba(229, 9, 20, 0.8);
    transform: rotate(90deg) scale(1.1);
}

.btn-close-custom svg {
    transition: all 0.3s ease;
}

.btn-close-custom:hover svg {
    stroke: white;
    transform: scale(1.1);
}

/* Modal header düzenlemesi */
.modal-header {
    padding: 0;
    background: transparent;
}
    </style>
</head>
<body>
  <!-- Navbar -->
<div class="nav-bar" id="content">
    <div class="logo">
        <a href="#"> <img src="img/logo.png" alt=""></a>
    </div>


 <nav class="navbar search">
        <form id="searchForm" role="search" autocomplete="off">
            <div class="input-group">
                <input class="form-control search-input" id="searchInput" type="search" 
                       placeholder="Film, dizi veya oyuncu ara..." 
                       aria-label="Search"
                       autocomplete="off"
                       spellcheck="false">
                <button class="btn btn-outline-danger" type="submit">
                    <i class="bi bi-search"></i>
                    <span class="d-none d-sm-inline">Ara</span>
                </button>
            </div>
            <div id="searchResults" class="search-dropdown"></div>
        </form>
    </nav>

    <div class="links">
        <ul>
            <li><a href="index.php">Anasayfa</a></li>
            <li><a href="sss.php">S.S.S</a></li>
            <li><a href="filmler.php">Filmler</a></li>        
                 
        </ul>
    </div>

    <div class="login">
        <?php if (isset($_SESSION["email"])): ?>
            <!-- Kullanıcı giriş yapmışsa gösterilecek kısım -->
            <div class="welcome-container" id="toggleMenu">
                <div class="user-info">
                <a href="kullanici-profili.php" class="user-avatar">
    👤
    <div class="light"></div>
</a>
                </div>
            </div>
           
        <?php else: ?>
            <!-- Kullanıcı giriş yapmamışsa gösterilecek kısım -->
            <a href="giris.php"><button id="giris" class="btn btn-primary">Giriş Yap</button></a>
            <a href="kayit.php"><button id="kayit" class="btn btn-success">Kayıt Ol</button></a>
        <?php endif; ?>
    </div>
</div>

<div id="loading-container">
    <div class="spinner"></div>
    <p id="loading-text">Çıkış yapılıyor...</p>
</div>
   <!-- Film Detayları -->
   <div class="swiper-slide">
       <div class="oynatSection">
           <div class="oynSection-inner">
               <div class="oynInner-textSec">
                   <h1 id="oynat-h"><?php echo $film['title']; ?></h1>
                   <p><?php echo $film['description']; ?></p>
               </div>
              <div class="oynInner-btnSec">
    <button class="oynat-btn">
        <span class="material-icons">play_arrow</span> Oynat
    </button>
    <?php
    $result = mysqli_query($baglanti, "SELECT * FROM filmler WHERE id = $film_id");
    if ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="movie-cardd">';
        echo '<button class="oynat-liste-btn" data-movieid="' . $row["id"] . '">';
        echo '<span class="material-icons">add</span> Favori';
        echo '</button>';
        echo '</div>';
    }
    ?>
</div>
               <div class="oynInner-cast">
                   <div class="castPlayer">
                       <div class="castPlayerImg">
                           <img src="https://img04.imgsinemalar.com/images/afis_buyuk/c/chris-hemsworth-1651834934.jpg" alt="">
                       </div>
                       <div class="castName">
                           <p>Chris Hemsworth</p>
                       </div>
                   </div>
                   <div class="castPlayer">
                       <div class="castPlayerImg">
                           <img src="https://img05.imgsinemalar.com/images/afis_buyuk/t/tom-hiddleston-1652180113.jpg" alt="">
                       </div>
                       <div class="castName">
                           <p>Tom Hiddleston</p>
                       </div>
                   </div>
                   <div class="castPlayer">
                       <div class="castPlayerImg">
                           <img src="https://img02.imgsinemalar.com/images/afis_buyuk/n/natalie-portman-1651835043.jpg" alt="">
                       </div>
                       <div class="castName">
                           <p>Natalie Portman</p>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="karartSec"></div>
       <img src="https://m.media-amazon.com/images/I/91rZG2MlOHL.jpg" alt="">
   </div>
<div class="film-list-container" style="margin-left: 120px; margin-bottom: 30px;">
  <h1 class="film-list-title" >Yeni Çıkanlar</h1>
  <div class="film-list-item">
    
    
    <!-- Diğer filmler - yakında gelecek -->
    <div class="movie-card coming-soon">
      <img src="img/movie2.jpg" alt="Assasin's Creed">
      <h3>Assasin's Creed</h3>
      <p>Aksiyon,Macera | 2016</p>
    </div>
    
    <div class="movie-card coming-soon">
      <img src="img/island.jpg" alt="Shutter Island">
      <h3>Shutter Island</h3>
      <p>Gerilim,Gizem | 2016</p>
    </div>
    
    <div class="movie-card coming-soon">
      <img src="img/drstrange.jpg" alt="Dr strange 2">
      <h3>Dr strange 2</h3>
      <p>Fantastik,Aksiyon | 2016</p>
    </div>
    
    <div class="movie-card coming-soon">
      <img src="img/dune.jpg" alt="Dune">
      <h3>Dune</h3>
      <p>Bilim Kurgu | 2016</p>
    </div>
    
    <div class="movie-card coming-soon">
      <img src="img/Recepİvedik7.jpg" alt="Recep İvedik 7">
      <h3>Recep ivedik 7</h3>
      <p>Komedi,Dram | 2016</p>
    </div>
  </div>
</div>
  <!-- Sol ve Sağ Ok Butonları -->

</div>
  
  <!-- Yorum Ekle -->
  <div class="container-yorum">
       <div class="yorum-yap-bolumu">
           <h2>Yorum Yap</h2>
           <form id="yorum-form">
               <textarea id="yorum" name="yorum" rows="4" placeholder="Yorumunuzu yazın" required></textarea>
               <button id="yorum-btn" type="submit">Gönder</button>
           </form>
       </div>

       <!-- Yorumları Listeleme Alanı -->
       <div class="yorumlar-bolumu">
           <h2>Yorumlar</h2>
           <div id="yorumlar-listesi">
               <!-- Dinamik olarak yorumlar buraya eklenecek -->
           </div>
       </div>
   </div>

<!-- Video Oynatma Modalı -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0">
        <div class="modal-header border-0 position-absolute top-0 end-0 z-3 pe-4 pt-3">
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 6L18 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body p-0 position-relative">
                <div class="video-player-container">
                    <video id="filmPlayer" class="video-player">
                        <source src="<?php echo htmlspecialchars($film['video_yolu']); ?>" type="video/mp4">
                        Tarayıcınız video oynatmayı desteklemiyor.
                    </video>
                    
                    <div class="video-loading" style="display: none;"></div>
                    
                    <div class="video-controls">
                        <div class="control-bar">
                            <button class="play-pause-btn">
                                <i class="bi bi-play-fill"></i>
                            </button>
                            <div class="progress-container">
                                <div class="progress-bar"></div>
                            </div>
                            <div class="time-display">
                                <span class="current-time">00:00</span> / <span class="duration">00:00</span>
                            </div>
                        </div>
                        <div class="control-bar secondary-controls">
                            <div class="volume-control">
                                <button class="volume-btn">
                                    <i class="bi bi-volume-up"></i>
                                </button>
                                <input type="range" class="volume-slider" min="0" max="1" step="0.01" value="1">
                            </div>
                            <button class="settings-btn">
                                <i class="bi bi-gear"></i>
                            </button>
                            <button class="fullscreen-btn">
                                <i class="bi bi-fullscreen"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   <!-- Footer -->
   <div class="footer">
       <div class="footer-wrap">
           <div class="footer-top">
               <a href="#"> <img src="img/logo.png" alt=""></a>
           </div>
           <div class="footer-center">
               <div class="mobile-and-tv-apps">
                   <ul>
                       <li><a href="#"><img src="img/Download_on_the_App_Store_Badge.svg.webp" alt=""></a></li>
                       <li id="google-play"><a href="#"><img src="img/Google_Play_Store_badge_EN.svg.png" alt=""></a></li>
                   </ul>
               </div>
               <div class="linkler">
                   <ul>
                       <li class="item"><a href="#">SSS</a></li>
                       <li class="item"><a href="#">Yatırımcı İlişkileri</a></li>
                       <li class="item"><a href="#">Kullanım Koşulları</a></li>
                       <li class="item"><a href="#">Bize Ulaşın</a></li>
                       <li class="item"><a href="#">Yardım Merkezi</a></li>
                       <li class="item"><a href="#">Çerez Tercihleri</a></li>
                       <li class="item"><a href="#">Gizlilik</a></li>
                       <li class="item"><a href="#">Hız testi</a></li>
                       <li class="item"><a href="#">Yasal hükümler</a></li>
                       <li class="item"><a href="#">Medya Merkezi</a></li>
                       <li class="item"><a href="#">Hesap</a></li>
                       <li class="item"><a href="#">Kurumsal Bilgiler</a></li>
                   </ul>
               </div>
           </div>
           <div class="footer-bottom">
               <span class="copyright">©2024 HDFİLMCENNETİ.<span> Tüm hakları saklıdır.</span></span>
               <ul class="social-icons">
                   <li><a href="#"><i class="fi fi-brands-instagram"></i></a></li>
                   <li><a href="#"><i class="fi fi-brands-whatsapp"></i></a></li>
                   <li><a href="#"><i class="fi fi-brands-twitter-alt"></i></a></li>
                   <li><a href="#"><i class="fi fi-brands-facebook"></i></a></li>
                   <li><a href="#"><i class="fi fi-brands-tik-tok"></i></a></li> 
               </ul>
           </div>
       </div>
   </div>
   
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>



    // Arama fonksiyonları
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const searchForm = document.getElementById('searchForm');
        let searchTimeout;

        // Thor filmi yönlendirme (tek bir event listener yeterli)
        document.addEventListener('click', function(e) {
            const filmItem = e.target.closest('.search-result-item[data-film="thor"]');
            if (filmItem) {
                window.location.href = 'thor.php';
                return; // Diğer kontrollere gerek yok
            }
        });

        // Anında arama fonksiyonu
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if(query.length > 0) {
                searchResults.innerHTML = `
                <div class="dropdown-item py-3 text-center text-muted">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="ms-2">Aranıyor...</span>
                </div>`;
                searchResults.classList.add('show');
                
                searchTimeout = setTimeout(() => {
                    fetch('api/live_search.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'query=' + encodeURIComponent(query)
                    })
                    .then(response => {
                        if(!response.ok) throw new Error('Arama servisi çalışmıyor');
                        return response.text();
                    })
                    .then(html => {
                        searchResults.innerHTML = html;
                        handleImageErrors();
                    })
                    .catch(error => {
                        console.error('Arama hatası:', error);
                        searchResults.innerHTML = `
                        <div class="dropdown-item text-danger py-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Arama servisine ulaşılamıyor. Lütfen daha sonra tekrar deneyin.
                        </div>`;
                    });
                }, 300);
            } else {
                searchResults.classList.remove('show');
            }
        });

        // Resim hata yönetimi fonksiyonu
        function handleImageErrors() {
            document.querySelectorAll('.search-result-image img').forEach(img => {
                img.onerror = function() {
                    if (!this.src.includes('default_poster.jpg')) {
                        this.src = window.location.origin + '/film/img/default_poster.jpg';
                        this.onerror = null;
                        
                        if (!this.parentElement.querySelector('.coming-soon-badge')) {
                            const badge = document.createElement('div');
                            badge.className = 'coming-soon-badge';
                            badge.textContent = 'Çok yakında sizlerle!';
                            this.parentElement.appendChild(badge);
                        }
                    }
                };
            });
        }

        // Form gönderim işlemi
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const query = searchInput.value.trim();
            
            if(query.length > 0) {
                const activeResult = document.querySelector('.search-result-item.highlighted');
                if(activeResult && activeResult.getAttribute('data-film') === 'thor') {
                    window.location.href = 'thor.php';
                } else {
                    window.location.href = `arama-sonuc.php?q=${encodeURIComponent(query)}`;
                }
            }
        });

        // Klavye navigasyonu
        searchInput.addEventListener('keydown', function(e) {
            const results = document.querySelectorAll('.search-result-item');
            
            if(e.key === 'ArrowDown' && results.length > 0) {
                e.preventDefault();
                const current = document.querySelector('.search-result-item.highlighted');
                if(current) {
                    current.classList.remove('highlighted');
                    const next = current.nextElementSibling || results[0];
                    next.classList.add('highlighted');
                    next.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    results[0].classList.add('highlighted');
                }
            } else if(e.key === 'ArrowUp' && results.length > 0) {
                e.preventDefault();
                const current = document.querySelector('.search-result-item.highlighted');
                if(current) {
                    current.classList.remove('highlighted');
                    const prev = current.previousElementSibling || results[results.length-1];
                    prev.classList.add('highlighted');
                    prev.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    results[results.length-1].classList.add('highlighted');
                }
            } else if(e.key === 'Enter') {
                e.preventDefault();
                const activeResult = document.querySelector('.search-result-item.highlighted');
                if(activeResult) {
                    if(activeResult.getAttribute('data-film') === 'thor') {
                        window.location.href = 'thor.php';
                    } else {
                        searchForm.dispatchEvent(new Event('submit'));
                    }
                }
            } else if(e.key === 'Escape') {
                searchResults.classList.remove('show');
                this.blur();
            }
        });
    });













///////////////////////////////////////////////////////////////////




$(document).ready(function(){
    // Favori butonlarına tıklanabilirlik ekle
    $(document).on('click', '.oynat-liste-btn', function(){
        var movieId = $(this).data("movieid");
        $.ajax({
            url: "favori-ekle.php",
            type: "POST",
            data: { movie_id: movieId },
            success: function(response) {
                alert(response);
            },
            error: function(xhr, status, error) {
                console.log("Hata:", error);
            }
        });
    });
    
    // Film ID'sini PHP'den al
    var filmId = <?php echo $film_id; ?>;
    
    // ========== VİDEO PLAYER KONTROLLERİ ==========
    const video = document.getElementById('filmPlayer');
    const playPauseBtn = document.querySelector('.play-pause-btn');
    const progressBar = document.querySelector('.progress-bar');
    const progressContainer = document.querySelector('.progress-container');
    const timeDisplay = document.querySelector('.time-display');
    const currentTimeElement = timeDisplay.querySelector('.current-time');
    const durationElement = timeDisplay.querySelector('.duration');
    const volumeBtn = document.querySelector('.volume-btn');
    const volumeSlider = document.querySelector('.volume-slider');
    const fullscreenBtn = document.querySelector('.fullscreen-btn');
    const videoContainer = document.querySelector('.video-player-container');
    const loadingIndicator = document.querySelector('.video-loading');
    let isVideoModalOpen = false;

    // Zaman formatı (saniyeyi MM:SS'ye çevir)
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = Math.floor(seconds % 60);
        return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
    }

    // İlerleme çubuğunu ve zamanı güncelle
    function updateProgress() {
        const progress = (video.currentTime / video.duration) * 100;
        progressBar.style.width = `${progress}%`;
        currentTimeElement.textContent = formatTime(video.currentTime);
    }

    // Video meta verileri yüklendiğinde süreyi ayarla
    video.addEventListener('loadedmetadata', function() {
        durationElement.textContent = formatTime(video.duration);
        loadingIndicator.style.display = 'none';
    });

    // Video buffering yaparken loading göster
    video.addEventListener('waiting', function() {
        loadingIndicator.style.display = 'block';
    });

    video.addEventListener('playing', function() {
        loadingIndicator.style.display = 'none';
    });

    // Oynat/Duraklat butonu
    playPauseBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (video.paused) {
            video.play();
            playPauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
        } else {
            video.pause();
            playPauseBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
        }
    });

    // Video oynatıldığında/durduğunda butonu güncelle
    video.addEventListener('play', function() {
        playPauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
    });

    video.addEventListener('pause', function() {
        playPauseBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
    });

    // İlerleme çubuğuna tıklama
    progressContainer.addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const pos = (e.pageX - rect.left) / this.offsetWidth;
        video.currentTime = pos * video.duration;
    });

    // Zaman güncelleme
    video.addEventListener('timeupdate', updateProgress);

    // Ses kontrolü
    volumeBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (video.volume > 0) {
            video.volume = 0;
            volumeBtn.innerHTML = '<i class="bi bi-volume-mute"></i>';
            volumeSlider.value = 0;
        } else {
            video.volume = 1;
            volumeBtn.innerHTML = '<i class="bi bi-volume-up"></i>';
            volumeSlider.value = 1;
        }
    });

    volumeSlider.addEventListener('input', function() {
        video.volume = this.value;
        if (this.value > 0.5) {
            volumeBtn.innerHTML = '<i class="bi bi-volume-up"></i>';
        } else if (this.value > 0) {
            volumeBtn.innerHTML = '<i class="bi bi-volume-down"></i>';
        } else {
            volumeBtn.innerHTML = '<i class="bi bi-volume-mute"></i>';
        }
    });

    // Tam ekran modu
    fullscreenBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (!document.fullscreenElement) {
            videoContainer.requestFullscreen().catch(err => {
                console.error(`Error attempting to enable fullscreen: ${err.message}`);
            });
            fullscreenBtn.innerHTML = '<i class="bi bi-fullscreen-exit"></i>';
        } else {
            document.exitFullscreen();
            fullscreenBtn.innerHTML = '<i class="bi bi-fullscreen"></i>';
        }
    });

    // Klavye kısayolları (GÜNCELLENMİŞ)
    document.addEventListener('keydown', function(e) {
        // Modal açık mı kontrolü
        const modalOpen = $('#videoModal').hasClass('show');
        
        // Input/textarea'da mıyız kontrolü
        const isInputFocused = document.activeElement.tagName.toLowerCase() === 'input' || 
                             document.activeElement.tagName.toLowerCase() === 'textarea';
        
        // Sadece modal açıkken ve input alanında değilken kısayollar çalışsın
        if (modalOpen && !isInputFocused) {
            switch (e.key) {
                case ' ':
                case 'k':
                    e.preventDefault();
                    if (video.paused) {
                        video.play();
                        playPauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
                    } else {
                        video.pause();
                        playPauseBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
                    }
                    break;
                case 'm':
                    e.preventDefault();
                    if (video.volume > 0) {
                        video.volume = 0;
                        volumeBtn.innerHTML = '<i class="bi bi-volume-mute"></i>';
                        volumeSlider.value = 0;
                    } else {
                        video.volume = 1;
                        volumeBtn.innerHTML = '<i class="bi bi-volume-up"></i>';
                        volumeSlider.value = 1;
                    }
                    break;
                case 'f':
                    e.preventDefault();
                    if (!document.fullscreenElement) {
                        videoContainer.requestFullscreen();
                        fullscreenBtn.innerHTML = '<i class="bi bi-fullscreen-exit"></i>';
                    } else {
                        document.exitFullscreen();
                        fullscreenBtn.innerHTML = '<i class="bi bi-fullscreen"></i>';
                    }
                    break;
                case 'ArrowLeft':
                    e.preventDefault();
                    video.currentTime = Math.max(0, video.currentTime - 5);
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    video.currentTime = Math.min(video.duration, video.currentTime + 5);
                    break;
            }
        }
    });

    // Fare hareketinde kontrolleri göster
    let controlsTimeout;
    videoContainer.addEventListener('mousemove', function() {
        document.querySelector('.video-controls').style.opacity = '1';
        clearTimeout(controlsTimeout);
        controlsTimeout = setTimeout(() => {
            if (!video.paused) {
                document.querySelector('.video-controls').style.opacity = '0';
            }
        }, 3000);
    });

    // Modal açıldığında video yükle
    $('#videoModal').on('shown.bs.modal', function() {
        loadingIndicator.style.display = 'block';
        video.load();
        isVideoModalOpen = true;
    });

    // Modal kapandığında video durdur
    $('#videoModal').on('hidden.bs.modal', function() {
        video.pause();
        if (document.fullscreenElement) {
            document.exitFullscreen();
        }
        isVideoModalOpen = false;
    });

    // ========== YORUM SİSTEMİ ==========
    // Yorumları getir
    function yorumlariGetir() {
        $.ajax({
            url: 'yorumlar.php',
            type: 'GET',
            data: { film_id: filmId },
            dataType: 'json',
            success: function (yorumlar) {
                $('#yorumlar-listesi').empty();
                if (yorumlar.length > 0) {
                    $.each(yorumlar, function (index, yorum) {
                        var yorumHTML = `
                            <div class="yorum" id="yorum-${yorum.yorum_id}">
                                <strong>${yorum.kullanici_adi} ${yorum.kullanici_soyadi}</strong>
                                <p>${yorum.yorum}</p>
                                <small>${yorum.yorum_tarihi}</small>
                                ${yorum.kullanici_id == <?php echo $_SESSION['kullanici_id'] ?? 0; ?> ? 
                                    `<div class="yorum-actions">
                                        <button class="duzenle-btn" data-yorum-id="${yorum.yorum_id}"><i class="bi bi-pencil"></i> Düzenle</button>
                                        <button class="sil-btn" data-yorum-id="${yorum.yorum_id}"><i class="bi bi-trash"></i> Sil</button>
                                    </div>` : ''
                                }
                            </div>
                        `;
                        $('#yorumlar-listesi').append(yorumHTML);
                    });

                    hashKontrolEt();

                    // Sil butonları
                    $('.sil-btn').on('click', function () {
                        var yorumId = $(this).data('yorum-id');
                        yorumSil(yorumId);
                    });

                    // Düzenle butonları
                    $('.duzenle-btn').on('click', function () {
                        var yorumId = $(this).data('yorum-id');
                        yorumDuzenle(yorumId);
                    });
                } else {
                    $('#yorumlar-listesi').html('<p class="no-comments">Henüz yorum yapılmamış.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                $('#yorumlar-listesi').html('<p class="error-message">Yorumlar yüklenirken bir hata oluştu.</p>');
            }
        });
    }

    // Yorum sil
    function yorumSil(yorumId) {
        if (confirm('Bu yorumu silmek istediğinizden emin misiniz?')) {
            $.ajax({
                url: 'yorum-sil.php',
                type: 'POST',
                data: { yorum_id: yorumId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        yorumlariGetir();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    alert('Yorum silinirken bir hata oluştu.');
                }
            });
        }
    }

    // Yorum düzenle
    function yorumDuzenle(yorumId) {
        var yorumElement = $(`#yorum-${yorumId} p`);
        var yorumMetni = yorumElement.text().trim();

        yorumElement.html(`<textarea class="duzenleme-metin">${yorumMetni}</textarea>`);

        var textarea = yorumElement.find('.duzenleme-metin');
        textarea.focus();
        textarea[0].setSelectionRange(textarea.val().length, textarea.val().length);

        textarea.on('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                var yeniYorum = textarea.val().trim();
                if (yeniYorum === '') {
                    alert('Yorum boş olamaz!');
                    return;
                }

                $.ajax({
                    url: 'yorum-duzenle.php',
                    type: 'POST',
                    data: { yorum_id: yorumId, yeni_yorum: yeniYorum },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            yorumlariGetir();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Hatası:", status, error);
                        alert('Yorum düzenlenirken bir hata oluştu.');
                    }
                });
            }
        });
    }

    // URL hash kontrolü
    function hashKontrolEt() {
        var hash = window.location.hash;
        if (hash) {
            var yorumId = hash.replace('#yorum-', '');
            var yorumElement = $(`#yorum-${yorumId}`);
            if (yorumElement.length > 0) {
                yorumElement.addClass('vurgulanan');
                $('html, body').animate({
                    scrollTop: yorumElement.offset().top - 100
                }, 300);
            }
        }
    }

    // Yorum ekleme formu
    $('#yorum-form').submit(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var yorum = $('#yorum').val().trim();
        if (yorum === '') {
            alert('Yorum boş olamaz!');
            return false;
        }

        $.ajax({
            url: 'yorumlar-getir.php',
            type: 'POST',
            data: { film_id: filmId, yorum: yorum },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#yorum').val('');
                    yorumlariGetir();
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // Sayfa yüklendiğinde yorumları getir
    yorumlariGetir();

    // ========== OYNAT BUTONU ==========
    $(document).on('click', '.oynat-btn', function() {
        var videoUrl = $(this).data('video-url');
        var filmId = $(this).data('film-id');
        
        <?php if(!isset($_SESSION["email"])): ?>
            alert('Lütfen önce giriş yapın!');
            window.location.href = 'giris.php';
        <?php else: ?>
            $('#filmPlayer source').attr('src', videoUrl);
            var video = document.getElementById('filmPlayer');
            video.load();
            
            var videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
            videoModal.show();
            
            $.ajax({
                url: 'video-kayit.php',
                type: 'POST',
                data: { film_id: filmId, action: 'start' }
            });
            
            $('#videoModal').on('hidden.bs.modal', function () {
                video.pause();
            });
        <?php endif; ?>
    });
});
</script>
</body>
</html>