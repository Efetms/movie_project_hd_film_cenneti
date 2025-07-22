<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmler</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css'>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
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

   
<div class="film-list-container">
    <h1 class="film-list-title filmler-title">En Çok İzlenen Filmler</h1>
          <div class="film-list-item">
              <div class="movie-card coming-soon">
              <a href="assasin-creed.php"><img src="img/movie2.jpg" alt="Film 2"></a>
              <h3>Assasin's Creed </h3>
              <p>Aksiyon,Macera | 2016</p>
              <a href="#" class="btn">Detayları Gör</a>
          </div>
          <div class="movie-card coming-soon">
          <a href="thor.php"><img src="img/thor3.jpg" alt="Film 2"></a>
            <h3>Thor 4</h3>
            <p>Aksiyon,Macera | 2016</p>
            <a href="#" class="btn">Detayları Gör</a>
        </div>
        <div class="movie-card coming-soon">
          <img src="img/island.jpg" alt="Film 2">
          <h3>Shutter Island</h3>
          <p>Gerilim,Gizem | 2016</p>
          <a href="#" class="btn">Detayları Gör</a>
      </div>
      <div class="movie-card coming-soon">
        <img src="img/drstrange.jpg" alt="Film 2">
        <h3>Dr strange 2</h3>
        <p>Fantastik,Aksiyon | 2016</p>
        <a href="#" class="btn">Detayları Gör</a>
    </div>
    <div class="movie-card coming-soon">
      <img src="img/dune.jpg" alt="Film 2">
      <h3>Dune </h3>
      <p>Bilim Kurgu | 2016</p>
      <a href="#" class="btn">Detayları Gör</a>
  </div>
  <div class="movie-card coming-soon">
    <img src="img/Recepİvedik7.jpg" alt="Film 2">
    <h3>Recep ivedik 7 </h3>
    <p>Komedi,Dram | 2016</p>
    <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" >Detayları Gör</a>
  </div>  
        </div>
      </div>  
      <div class="film-list-container">
        <h1 class="film-list-title filmler-title">Gerilim Filmleri</h1>
              <div class="film-list-item">
                  <div class="movie-card coming-soon">
                  <img src="img/konuş benimle.jpg" alt="Film 2">
                  <h3>Konuş Benimle</h3>
                  <p>Korku,Gerilim | 2016</p>
                  <a href="#" class="btn">Detayları Gör</a>
              </div>
              <div class="movie-card coming-soon">
                <img src="img/the jester.png" alt="Film 2">
                <h3>The jester</h3>
                <p>Korku,Gerilim | 2016</p>
                <a href="#" class="btn">Detayları Gör</a>
            </div>
            <div class="movie-card coming-soon">
              <img src="img/the platform.jpg" alt="Film 2">
              <h3>The Platform</h3>
              <p>Korku,Gerilim | 2016</p>
              <a href="#" class="btn">Detayları Gör</a>
          </div>
          <div class="movie-card coming-soon">
            <img src="img/nefesini tutt.jpg" alt="Film 2">
            <h3>Nefesini Tut 2</h3>
            <p>Korku,Gerilim | 2016</p>
            <a href="#" class="btn">Detayları Gör</a>
        </div>
        <div class="movie-card coming-soon">
          <img src="img/şeytanın avukatıı.webp" alt="Film 2">
          <h3>Şeytanın Avukatı</h3>
          <p>Korku,Gerilim | 2016</p>
          <a href="#" class="btn">Detayları Gör</a>
      </div>
      <div class="movie-card coming-soon">
        <img src="img/zihin gegini.jpg" alt="Film 2">
        <h3>Zihin Gezgini</h3>
        <p>Korku,Gerilim | 2016</p>
        <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" >Detayları Gör</a>
      </div>  
            </div>
          </div>  
          <div class="film-list-container">
            <h1 class="film-list-title filmler-title">Yerli filmler</h1>
                  <div class="film-list-item">
                      <div class="movie-card coming-soon">
                      <img src="img/enişte.jpg" alt="Film 2">
                      <h3> Aykut Enişte</h3>
                      <p> Komedi,Dram | 2016</p>
                      <a href="#" class="btn">Detayları Gör</a>
                  </div>
                  <div class="movie-card coming-soon">
                    <img src="img/zübeyde.jpg" alt="Film 2">
                    <h3>Zübeyde</h3>
                    <p> Dram | 2016</p>
                    <a href="#" class="btn">Detayları Gör</a>
                </div>
                <div class="movie-card coming-soon">
                  <img src="img/ayla.jpg" alt="Film 2">
                  <h3>Ayla</h3>
                  <p> Savaş,Dram | 2016</p>
                  <a href="#" class="btn">Detayları Gör</a>
              </div>
              <div class="movie-card coming-soon">
                <img src="img/müstakbel damat.webp" alt="Film 2">
                <h3>Müstakbel Damat</h3>
                <p> Komedi | 2016</p>
                <a href="#" class="btn">Detayları Gör</a>
            </div>
            <div class="movie-card coming-soon">
              <img src="img/mutluyuz.jpg" alt="Film 2">
              <h3>Mutluyuz</h3>
              <p> Komedi | 2016</p>
              <a href="#" class="btn">Detayları Gör</a>
          </div>
          <div class="movie-card coming-soon">
            <img src="img/aile arasında.webp" alt="Film 2">
            <h3>Aile Arasında</h3>
            <p> Komedi,Aksiyon | 2016</p>
            <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" >Detayları Gör</a>
          </div>  
                </div>
              </div>  
              <div class="film-list-container">
    <h1 class="film-list-title filmler-title">Komedi Filmleri</h1>
          <div class="film-list-item">
              <div class="movie-card coming-soon">
              <img src="img/illegal hayatlar.png" alt="Film 2">
              <h3>İllegal Hayatlar</h3>
              <p> Komedi | 2016</p>
              <a href="#" class="btn">Detayları Gör</a>
          </div>
          <div class="movie-card coming-soon">
            <img src="img/kolpaçino bomba.jpg" alt="Film 2">
            <h3>Kolpaçino 2</h3>
            <p> Komedi | 2016</p>
            <a href="#" class="btn">Detayları Gör</a>
        </div>
        <div class="movie-card coming-soon">
          <img src="img/çakallarla.jpg" alt="Film 2">
          <h3>Çakallarla Dans 3</h3>
          <p> Komedi | 2016</p>
          <a href="#" class="btn">Detayları Gör</a>
      </div>
      <div class="movie-card coming-soon">
        <img src="img/Arog.jpg" alt="Film 2">
        <h3>Arog</h3>
        <p> Komedi | 2016</p>
        <a href="#" class="btn">Detayları Gör</a>
    </div>
    <div class="movie-card coming-soon">
      <img src="img/düğün dernek 2.jpg" alt="Film 2">
      <h3>Düğün Dernek 2</h3>
      <p> Komedi | 2016</p>
      <a href="#" class="btn">Detayları Gör</a>
  </div>
  <div class="movie-card coming-soon">
    <img src="img/kolpaçino 3.jpg" alt="Film 2">
    <h3>Kolpaçino 3</h3>
    <p>Komedi | 2016</p>
    <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" >Detayları Gör</a>
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



      </script>
</body>
</html>