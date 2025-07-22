<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sıkça Sorulan Sorular</title>
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
        :root {
            --primary-color: #ffffff;
            --accent-color: #d32f2f;
            --secondary-color: #312e2e54;
            --tertiary-color: #2c2c2c;
            --text-color: #e0e0e0;
            --muted-text-color: #a8a8a8;
            --background-gradient: linear-gradient(135deg, var(--secondary-color), var(--tertiary-color));
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: rgb(31, 29, 29);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .faq-container {
            width: 90%;
            max-width: 800px;
            background-color: rgba(11, 13, 29, 0.116);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 70px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
            color: var(--primary-color);
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
        }

        .faq-item {
            margin-bottom: 20px;
            padding: 15px 20px;
            
            background: var(--secondary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .faq-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 600;
            font-size: 18px;
            color: var(--text-color);
        }

        
        .toggle-btn {
            background-color: var(--accent-color);
            color: var(--text-color);
            border-radius: 50%;
            width: 28px;
            height: 28px;
            text-align: center;
            line-height: 28px;
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .faq-answer {
            margin-top: 15px;
            font-size: 16px;
            color: var(--muted-text-color);
            line-height: 1.8;
            display: none;
            padding-left: 15px;
            border-left: 4px solid var(--accent-color);
        }

        .faq-item.active .faq-answer {
            display: block;
            animation: fadeIn 0.4s ease-in-out;
        }

        .faq-item.active .toggle-btn {
            transform: rotate(45deg);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 26px;
            }

            .faq-question {
                font-size: 16px;
            }

            .faq-answer {
                font-size: 14px;
            }
        }
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

  


    <section class="faq-container">
        <h1>Sıkça Sorulan Sorular</h1>
        <article class="faq-item">
            <div class="faq-question">
               HDFİLMCENNETİ Nedir?
                <span class="toggle-btn">+</span>
            </div>
            <div class="faq-answer">
                HDFİLMCENNETİ,  Pixar, Marvel, Star Wars ve National Geographic'in içeriklerine erişim sağlayan bir dijital yayın platformudur.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
                HDFİLMCENNETİ'NE nasıl üye olabilirim?
                <span class="toggle-btn">+</span>
            </div>
            <div class="faq-answer">
                HDFİLMCENNETİ'NE üye olmak için web sitesini ziyaret edip bir hesap oluşturmanız ve gerekli bilgileri girmeniz gerekmektedir.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
                HDFİLMCENNETİ hangi cihazlarda çalışır?
                <span class="toggle-btn">+</span>
            </div>
            <div class="faq-answer">
                HDFİLMCENNETİ, akıllı telefonlar, tabletler, bilgisayarlar, akıllı TV'ler ve dahil olmak üzere birçok cihazda çalışır.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
               HDFİLMCENNETİ Nedir?
                <span class="toggle-btn">+</span>
            </div>
            <div class="faq-answer">
                HDFİLMCENNETİ,  Pixar, Marvel, Star Wars ve National Geographic'in içeriklerine erişim sağlayan bir dijital yayın platformudur.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
                HDFİLMCENNETİ'NE nasıl üye olabilirim?
                <span class="toggle-btn">+</span>
            </div>
            <div class="faq-answer">
                HDFİLMCENNETİ'NE üye olmak için web sitesini ziyaret edip bir hesap oluşturmanız ve gerekli bilgileri girmeniz gerekmektedir.
            </div>
        </article>
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
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // FAQ fonksiyonu
    document.querySelectorAll('.faq-item').forEach(item => {
        item.querySelector('.faq-question').addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
            if (!isActive) item.classList.add('active');
        });
    });

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
