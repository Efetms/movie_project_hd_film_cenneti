<?php
  session_start();
  include("baglanti.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HDFİLMCENNETİ</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Swiper.js CSS -->
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
<!-- Swiper.js JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style> 
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    
   </style>

</head>
<body>
<?php
session_start();
?>

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
            <li><a href="#">Anasayfa</a></li>
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


    <div class="movie-Area">
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="oynatSection">
                  <div class="oynSection-inner">
                    <div class="oynInner-textSec">
                      <h1 id="oynat-h">The Godfather</h1>
                      <p>
                      The Godfather, Corleone ailesinin mafya dünyasındaki güç mücadelesini konu alır. Ailenin reisi Vito Corleone’nin (Marlon Brando) başındaki tehlikeler sonrası, oğlu Michael (Al Pacino) başlangıçta uzak durmayı planlasa da, ailesini korumak için suç dünyasına adım atar. Film, sadakat, güç ve ihanet temalarını işler..</p>
                    </div>
                    <!-- The Godfather filmi için favori butonu kısmı -->
<div class="oynInner-btnSec">
    <button class="oynat-btn">
        <span class="material-icons">play_arrow</span> Oynat
    </button>
    <?php
    $result = mysqli_query($baglanti, "SELECT * FROM filmler WHERE id = 3");
    if ($row = mysqli_fetch_assoc($result)) {
        $favoriDurumu = "";
        if (isset($_SESSION["email"])) {
            $kullanici_id = $_SESSION["kullanici_id"];
            $favoriKontrol = mysqli_query($baglanti, "SELECT * FROM favoriler WHERE kullanici_id = $kullanici_id AND film_id = 3");
            if (mysqli_num_rows($favoriKontrol) > 0) {
                $favoriDurumu = "favorite";
            } else {
                $favoriDurumu = "favorite_border";
            }
        } else {
            $favoriDurumu = "favorite_border";
        }
        
        echo '<div class="movie-cardd">';
        echo '<button class="oynat-liste-btn" data-movieid="' . $row["id"] . '">';
        echo '<span class="material-icons">' . $favoriDurumu . '</span> Favori';
        echo '</button>';
        echo '</div>';
    }
    ?>
</div>
                    <div class="oynInner-cast">
                      <div class="castPlayer">
                        <div class="castPlayerImg">
                          <img src="img/ben.jpg" alt="">
                        </div>
                       <div class="castName">
                        <p>Efe İtmiş</p>
                       </div>
                      </div>
                      <div class="castPlayer">
                        <div class="castPlayerImg">
                          <img src="img/emirhan.jpg" alt="">
                        </div>
                       <div class="castName">
                        <p>Emirhan Yılmaz</p>
                       </div>
                      </div>
                      <div class="castPlayer">
                        <div class="castPlayerImg">
                          <img src="img/ibo.jpg" alt="">
                        </div>
                       <div class="castName">
                        <p>İbrahim Bilgin</p>
                       </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="karartSec"></div>
              <img src="https://www.mrporter.com/content/images/cms/ycm/resource/blob/10480180/917475d76bf62c1e443a2ff6a1096833/16-9-jpg-data.jpg" alt="">
            </div>
            <div class="swiper-slide">
              <div class="oynatSection">
                <div class="oynSection-inner">
                  <div class="oynInner-textSec">
                    <h1 id="oynat-h">Fight Club</h1>
                    <p>Fight Club, sıkıcı ve monoton bir yaşam süren bir adamın (Edward Norton) içsel boşluğunu ve kimlik arayışını konu alır. Tanıştığı Tyler Durden (Brad Pitt) ile birlikte yeraltı dövüş kulüpleri kurarak, toplumsal normlara karşı isyan ederler. Film, tüketime, toplumsal baskılara ve erkeklik kavramına dair eleştirilerle doludur..</p>
                  </div>
                 <!-- Fight Club filmi için favori butonu kısmı -->
<div class="oynInner-btnSec">
    <button class="oynat-btn">
        <span class="material-icons">play_arrow</span> Oynat
    </button>
    <?php
    $result = mysqli_query($baglanti, "SELECT * FROM filmler WHERE id = 4");
    if ($row = mysqli_fetch_assoc($result)) {
        $favoriDurumu = "";
        if (isset($_SESSION["email"])) {
            $kullanici_id = $_SESSION["kullanici_id"];
            $favoriKontrol = mysqli_query($baglanti, "SELECT * FROM favoriler WHERE kullanici_id = $kullanici_id AND film_id = 4");
            if (mysqli_num_rows($favoriKontrol) > 0) {
                $favoriDurumu = "favorite";
            } else {
                $favoriDurumu = "favorite_border";
            }
        } else {
            $favoriDurumu = "favorite_border";
        }
        
        echo '<div class="movie-cardd">';
        echo '<button class="oynat-liste-btn" data-movieid="' . $row["id"] . '">';
        echo '<span class="material-icons">' . $favoriDurumu . '</span> Favori';
        echo '</button>';
        echo '</div>';
    }
    ?>
</div>
                  <div class="oynInner-cast">
                    <div class="castPlayer">
                      <div class="castPlayerImg">
                        <img src="img/ben.jpg" alt="">
                      </div>
                     <div class="castName">
                      <p>Efe itmiş</p>
                     </div>
                    </div>
                    <div class="castPlayer">
                      <div class="castPlayerImg">
                        <img src="img/mert.png" alt="">
                      </div>
                     <div class="castName">
                      <p>Mert Hamurci</p>
                     </div>
                    </div>
                    <div class="castPlayer">
                      <div class="castPlayerImg">
                        <img src="img/furkan.png" alt="">
                      </div>
                     <div class="castName">
                      <p>Furkan Dursun</p>
                     </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="karartSec"></div>
            <img src="https://shelfd.com/images/69354630-cd34-11e8-8ac4-3132abee88e1.jpg?w=1280&h=720&fit=crop&s=5b0912957fa4373a67c0ef52000c3f82" alt="">
          </div>
            </div>
      
        <!-- Navigation Buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
      
    </div>

    
<div class="film-list-container">
  <h1 class="film-list-title">Yeni Çıkanlar</h1>
  <div class="film-list-item">
    <!-- Thor kartı - aktif film -->
    <div class="movie-card highlight">
      <a href="thor.php"><img src="img/thor3.jpg" alt="Thor 4"></a>
      <h3>Thor 4</h3>
      <p>Aksiyon,Macera | 2016</p>
      <a href="thor.php" class="btn">Detayları Gör</a>
    </div>
    
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

<!-- Button trigger modal -->


<!-- Modal -->
<!-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> -->

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




document.addEventListener('DOMContentLoaded', function() {
    // Arama sonuçlarındaki tıklamaları dinle
    document.addEventListener('click', function(e) {
        const filmItem = e.target.closest('.search-result-item');
        
        // Eğer tıklanan öğe bir film öğesiyse ve Thor filmiyse
        if (filmItem && filmItem.getAttribute('data-film') === 'thor') {
            window.location.href = 'thor.php';
        }
        
        // Diğer filmlerde herhangi bir işlem yapma
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Arama fonksiyonları
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const searchForm = document.getElementById('searchForm');
    let searchTimeout;

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
            searchResults.style.display = 'block';
            
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
                    
     document.querySelectorAll('img').forEach(img => {
    img.onerror = function() {
        // Sadece bir kere default resme yönlendir
        if (!this.src.includes('default_poster.jpg')) {
            this.src = window.location.origin + '/film/img/default_poster.jpg';
            this.onerror = null; // Sonsuz döngüyü engelle
            
            // Eğer yakında badge yoksa ekleyelim
            if (!this.parentElement.querySelector('.coming-soon-badge')) {
                const badge = document.createElement('div');
                badge.className = 'coming-soon-badge';
                badge.textContent = 'Çok yakında sizlerle!';
                this.parentElement.appendChild(badge);
            }
        }
    };
});
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
            searchResults.style.display = 'none';
        }
    });

    // Form gönderim işlemi
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const query = searchInput.value.trim();
        
        if(query.length > 0) {
            const activeResult = document.querySelector('.search-result-item.highlighted');
            if(activeResult) {
                window.location.href = activeResult.getAttribute('href');
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
            } else {
                results[results.length-1].classList.add('highlighted');
            }
        } else if(e.key === 'Enter' && document.querySelector('.search-result-item.highlighted')) {
            e.preventDefault();
            const activeResult = document.querySelector('.search-result-item.highlighted');
            window.location.href = activeResult.getAttribute('href');
        } else if(e.key === 'Escape') {
            searchResults.style.display = 'none';
            this.blur();
        }
    });

    // Swiper slider
    var swiper = new Swiper('.mySwiper', {
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        slidesPerView: 1,
        spaceBetween: 0,
    });

    // Favori butonları
    document.querySelectorAll('.oynat-liste-btn, .favorite-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const movieId = this.dataset.movieid;
            
            fetch('favori-ekle.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'movie_id=' + movieId
            })
            .then(response => response.text())
            .then(response => {
                if(response.includes('eklendi')) {
                    this.innerHTML = '<span class="material-icons">favorite</span> Favori';
                    this.classList.add('active');
                } else {
                    this.innerHTML = '<span class="material-icons">favorite_border</span> Favori';
                    this.classList.remove('active');
                }
            });
        });
    });

    // Kullanıcı menüsü
    const toggleMenu = document.getElementById('toggleMenu');
    if(toggleMenu) {
        toggleMenu.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('dropdown-active');
        });

        document.addEventListener('click', function() {
            toggleMenu.classList.remove('dropdown-active');
        });
    }

    // Çıkış işlemi
    const logoutLink = document.getElementById('logoutLink');
    const loadingContainer = document.getElementById('loading-container');
    
    if(logoutLink && loadingContainer) {
        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('body > *:not(.nav-bar):not(#loading-container)').forEach(el => {
                el.style.display = 'none';
            });
            loadingContainer.style.display = 'flex';
            setTimeout(function() {
                window.location.href = 'cikis.php';
            }, 680);
        });
    }

    // Resim yükleme hataları için global handler
    document.addEventListener('error', function(e) {
        if(e.target.tagName === 'IMG') {
            const img = e.target;
            if(!img.src.includes('default_poster.jpg')) {
                img.src = window.location.origin + '/film/img/default_poster.jpg';
            }
        }
    }, true);
});


// Favori butonlarına tıklanabilirlik ekle (jQuery kullanarak)
$(document).on('click', '.oynat-liste-btn', function(){
    var movieId = $(this).data("movieid");
    var button = $(this);
    
    <?php if(!isset($_SESSION["email"])): ?>
        alert('Lütfen önce giriş yapın!');
        window.location.href = 'giris.php';
    <?php else: ?>
        $.ajax({
            url: "favori-ekle.php",
            type: "POST",
            data: { movie_id: movieId },
            success: function(response) {
                if(response.includes('eklendi')) {
                    button.html('<span class="material-icons">favorite</span> Favori');
                    alert("Favorilere eklendi!");
                } else if(response.includes('zaten')) {
                    alert("Bu film zaten favorilerinizde!");
                } else if(response.includes('kaldırıldı')) {
                    button.html('<span class="material-icons">favorite_border</span> Favori');
                    alert("Favorilerden kaldırıldı!");
                } else {
                    alert(response);
                }
            },
            error: function(xhr, status, error) {
                console.log("Hata:", error);
                alert("İşlem sırasında bir hata oluştu!");
            }
        });
    <?php endif; ?>
});


</script>


 
        
</body>
</html> 