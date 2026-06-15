<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wakaf Nurul Taqwa</title>
    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="has-mobile-bottom-nav">
    <nav class="navbar">
        <div class="navkiri">
            <img src="{{ asset('image/logo wakaf.webp') }}" alt="logo wakaf nurul takwa" class="logo">
            <div class="searchbar"></div>
        </div>

        <input type="checkbox" id="nav-toggle" class="nav-toggle">
        <label for="nav-toggle" class="menu-toggle" aria-label="Buka menu navigasi">
            <span></span>
            <span></span>
            <span></span>
        </label>

        <ul class="menu">
            <li><a href="{{ route('beranda') }}">Beranda</a></li>
            <li><a href="{{ route('program') }}">Program</a></li>
            <li><a href="{{ route('artikel') }}">Artikel</a></li>
            <li><a href="{{ route('tentangkami') }}">Tentang Kami</a></li>
            <li class="donasi"><a href="https://donasi.amalbaik.org/#/programs">Wakaf Sekarang</a></li>

        </ul>

    </nav>
    @include('partials.mobile-bottom-nav')

    <!--CARD SLIDE-->
    <section class="hero-slider-section">
  <div class="swiper heroSwiper">
    <div class="swiper-wrapper">

      @forelse ($sliders as $slider)
        <div class="swiper-slide">
          <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title ?: 'Banner Wakaf' }}">
        </div>
      @empty
        <div class="swiper-slide">
          <img src="{{ asset('image/banner-wakaf.jpg') }}" alt="Banner Qurban">
        </div>
      @endforelse

    </div>

    <!-- Dot pagination -->
    <div class="swiper-pagination"></div>
  </div>
</section>

<section class="info-section">
  <div class="info-text">
    <p>
      Lembaga Wakaf Nurul Taqwa (LWNT) secara resmi terdaftar pada tanggal 30 Desember 2019. berada dibawah naungan Yayasan Nurul Taqwa yang mengelola masjid Nurul Taqwa di area Gambir, Jakarta Pusat menjadikan masjid sebagai pusat pemberdayaan dan menjadi kontributor kemajuan masyarakat banyak.
    </p>
    <p>
     LWNT terdaftar di KEMENKUMHAM dengan No.AHU0012935.AH.01.12. Th. 2018 dan telah terdaftar sebagai Nazhir di Badan Wakaf Indonesia dengan Surat Tanda Bukti Pendaftaran 3.3.00235.
    </p>
  </div>

  <div class="info-image">
    <img src="{{ asset('image/IMG_9791.JPG.jpg') }}" alt="Dokumentasi Wakaf">
  </div>
</section>

<section class="info-wakif">
  <div class="jumlahwakif image-info">
    <div class="wakif-stats">
      <div class="wakif-stat">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M13.5295 8.35186C12.9571 8.75995 12.2566 9 11.5 9C9.567 9 8 7.433 8 5.5C8 3.567 9.567 2 11.5 2C12.753 2 13.8522 2.65842 14.4705 3.64814M6 20.0872H8.61029C8.95063 20.0872 9.28888 20.1277 9.61881 20.2086L12.3769 20.8789C12.9753 21.0247 13.5988 21.0388 14.2035 20.9214L17.253 20.3281C18.0585 20.1712 18.7996 19.7854 19.3803 19.2205L21.5379 17.1217C22.154 16.5234 22.154 15.5524 21.5379 14.9531C20.9832 14.4134 20.1047 14.3527 19.4771 14.8103L16.9626 16.6449C16.6025 16.9081 16.1643 17.0498 15.7137 17.0498H13.2855L14.8311 17.0498C15.7022 17.0498 16.4079 16.3633 16.4079 15.5159V15.2091C16.4079 14.5055 15.9156 13.892 15.2141 13.7219L12.8286 13.1417C12.4404 13.0476 12.0428 13 11.6431 13C10.6783 13 8.93189 13.7988 8.93189 13.7988L6 15.0249M20 6.5C20 8.433 18.433 10 16.5 10C14.567 10 13 8.433 13 6.5C13 4.567 14.567 3 16.5 3C18.433 3 20 4.567 20 6.5ZM2 14.6L2 20.4C2 20.9601 2 21.2401 2.10899 21.454C2.20487 21.6422 2.35785 21.7951 2.54601 21.891C2.75992 22 3.03995 22 3.6 22H4.4C4.96005 22 5.24008 22 5.45399 21.891C5.64215 21.7951 5.79513 21.6422 5.89101 21.454C6 21.2401 6 20.9601 6 20.4V14.6C6 14.0399 6 13.7599 5.89101 13.546C5.79513 13.3578 5.64215 13.2049 5.45399 13.109C5.24008 13 4.96005 13 4.4 13L3.6 13C3.03995 13 2.75992 13 2.54601 13.109C2.35785 13.2049 2.20487 13.3578 2.10899 13.546C2 13.7599 2 14.0399 2 14.6Z" />
        </svg>
        <strong class="count-up" data-count="40435">0</strong>
        <span>Jumlah Wakif</span>
      </div>

      <div class="wakif-stat">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M14 11H8M10 15H8M16 7H8M20 6.8V17.2C20 18.8802 20 19.7202 19.673 20.362C19.3854 20.9265 18.9265 21.3854 18.362 21.673C17.7202 22 16.8802 22 15.2 22H8.8C7.11984 22 6.27976 22 5.63803 21.673C5.07354 21.3854 4.6146 20.9265 4.32698 20.362C4 19.7202 4 18.8802 4 17.2V6.8C4 5.11984 4 4.27976 4.32698 3.63803C4.6146 3.07354 5.07354 2.6146 5.63803 2.32698C6.27976 2 7.11984 2 8.8 2H15.2C16.8802 2 17.7202 2 18.362 2.32698C18.9265 2.6146 19.3854 3.07354 19.673 3.63803C20 4.27976 20 5.11984 20 6.8Z" />
        </svg>
        <strong class="count-up" data-count="10">0</strong>
        <span>Jumlah Program</span>
      </div>

      <div class="wakif-stat">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M22 21V19C22 17.1362 20.7252 15.5701 19 15.126M15.5 3.29076C16.9659 3.88415 18 5.32131 18 7C18 8.67869 16.9659 10.1159 15.5 10.7092M17 21C17 19.1362 17 18.2044 16.6955 17.4693C16.2895 16.4892 15.5108 15.7105 14.5307 15.3045C13.7956 15 12.8638 15 11 15H8C6.13623 15 5.20435 15 4.46927 15.3045C3.48915 15.7105 2.71046 16.4892 2.30448 17.4693C2 18.2044 2 19.1362 2 21M13.5 7C13.5 9.20914 11.7091 11 9.5 11C7.29086 11 5.5 9.20914 5.5 7C5.5 4.79086 7.29086 3 9.5 3C11.7091 3 13.5 4.79086 13.5 7Z" />
        </svg>
        <strong class="count-up" data-count="1534238">0</strong>
        <span>Jumlah Penerima Manfaat</span>
      </div>
    </div>
  </div>
</section>

<section class="quote-wakaf">
  <div class="quote-card">
    <span class="tandakutip-left">“</span>

    <p>
      wakaf adalah penyerahan harta dari seseorang (wakif)
      untuk dimanfaatkan selamanya atau dalam jangka waktu
      tertentu demi kepentingan ibadah dan kesejahteraan umum,
      tanpa mengurangi pokok harta tersebut.
    </p>

    <span class="tandakutip-right">“</span>
  </div>
</section>

<section class="macam-program">
  <div class="text-program">
    <p>Program Unggulan</p>
  </div>
  <div class="card-program">
    @forelse ($featuredPrograms as $program)
      <article class="program-card">
        <img src="{{ $program->gambar ? asset('storage/' . $program->gambar) : asset('image/ZIS.png') }}" alt="{{ $program->judul }}">
        <div class="program-card-body">
          <h3>{{ $program->judul }}</h3>
          <a href="{{ route('program.detail', $program) }}" class="program-card-button">Wakaf Sekarang</a>
        </div>
      </article>
    @empty
      @for ($i = 0; $i < 3; $i++)
        <article class="program-card">
          <img src="{{ asset('image/banner-wakaf.jpg') }}" alt="Wakaf Qurban Pelosok Negeri">
          <div class="program-card-body">
            <h3>Wakaf Qurban<br>Pelosok Negeri</h3>
            <a href="#" class="program-card-button">Wakaf Sekarang</a>
          </div>
        </article>
      @endfor
    @endforelse
  </div>
</section> 
<section class="moreprogram">
  <a href="{{ url('/program') }}">Lihat Program Lainnya</a>
</section>

<section class="artikel-section">
  <div class="text-program">
    <p>Artikel</p>
  </div>
  <div class="card-artikel">
    @forelse ($latestArticles as $article)
      <article class="artikel-card">
        <img src="{{ $article->image ? asset('storage/' . $article->image) : asset('image/banner-wakaf.jpg') }}" alt="{{ $article->title }}">
        <div class="artikel-card-body">
          <h3>{{ $article->title }}</h3>
          @if ($article->excerpt)
            <p>{{ $article->excerpt }}</p>
          @endif
          <a href="{{ route('artikel') }}" class="artikel-card-button">Baca Artikel</a>
        </div>
      </article>
    @empty
      @for ($i = 0; $i < 4; $i++)
        <article class="artikel-card">
          <img src="{{ asset('image/banner-wakaf.jpg') }}" alt="Artikel Wakaf">
          <div class="artikel-card-body">
            <h3>Manfaat Wakaf untuk Kesejahteraan Umat</h3>
            <p>Ringkasan singkat artikel akan tampil di bagian ini.</p>
            <a href="{{ route('artikel') }}" class="artikel-card-button">Baca Artikel</a>
          </div>
        </article>
      @endfor
    @endforelse
  </div>
</section>
<section class="moreartikel">
  <a href="{{ route('artikel') }}">Lihat Artikel Lainnya</a>
</section>

<footer class="site-footer">
  <div class="footer-content">
    <div class="footer-brand">
      <img src="{{ asset('image/logo2.svg') }}" alt="Logo Wakaf Nurul Taqwa" class="footer-logo">
      <p>
        Wakaf Nurul Taqwa merupakan lembaga yang mengelola harta penyerahan wakif demi kepentingan ibadah dan kesejahteraan umum tanpa mengurangi jumlah harta tersebut.
      </p>
    </div>

    <div class="footer-links">
      <div>
        <h2>Navigasi</h2>
        <nav class="footer-menu" aria-label="Navigasi footer">
          <a href="{{ route('beranda') }}">Home</a>
          <a href="{{ route('program') }}">Program</a>
          <a href="{{ route('artikel') }}">Artikel</a>
          <a href="{{ route('tentangkami') }}">About</a>
        </nav>
      </div>

      <div>
        <h2>Sosial Media</h2>
        <div class="footer-social" aria-label="Sosial media">
          <a href="https://www.instagram.com/wakaf.nt/" aria-label="Instagram">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <rect x="3" y="3" width="18" height="18" rx="5"></rect>
              <circle cx="12" cy="12" r="4"></circle>
              <circle cx="17.5" cy="6.5" r="1"></circle>
            </svg>
          </a>
          <a href="#" aria-label="Facebook">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M14 8h3V4h-3c-3 0-5 2-5 5v3H6v4h3v5h4v-5h3l1-4h-4V9c0-.6.4-1 1-1Z"></path>
            </svg>
          </a>
          <a href="#" aria-label="WhatsApp">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M4 20l1.2-4A8 8 0 1 1 8 18.8L4 20Z"></path>
              <path d="M9 8.8c.3 3 2.2 5 5.2 6 .6.2 1.4-.8 1.6-1.3.1-.3 0-.5-.3-.7l-1.3-.7c-.3-.2-.6-.1-.8.1l-.5.6c-1.1-.5-2-1.3-2.6-2.5l.6-.5c.3-.2.3-.5.2-.8l-.6-1.4c-.1-.3-.4-.4-.7-.3-.5.1-1 .5-.8 1.5Z"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-bottom">@Copyright WakafNurulTakwa 2026</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  const heroSlideCount = {{ $sliders->isEmpty() ? 1 : $sliders->count() }};
  const heroSwiper = new Swiper('.heroSwiper', {
  slidesPerView: 1,
  centeredSlides: false,
  initialSlide: 0,
  spaceBetween: 0,
  loop: heroSlideCount > 1,
  loopedSlides: heroSlideCount,
  loopAdditionalSlides: heroSlideCount,
  slidesPerGroup: 1,
  loopPreventsSliding: false,
  watchSlidesProgress: true,
  observer: true,
  observeParents: true,
  speed: 600,
  allowTouchMove: true,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  breakpoints: {
    577: {
      slidesPerView: 'auto',
      centeredSlides: true,
      spaceBetween: 28,
    },
  },
});

const countElements = document.querySelectorAll('.count-up');

function animateCount(element) {
  const target = Number(element.dataset.count);
  const duration = 1600;
  const startTime = performance.now();

  function update(currentTime) {
    const elapsed = currentTime - startTime;
    const progress = Math.min(elapsed / duration, 1);
    const easedProgress = 1 - Math.pow(1 - progress, 3);
    const currentValue = Math.floor(target * easedProgress);

    element.textContent = currentValue.toLocaleString('en-US');

    if (progress < 1) {
      requestAnimationFrame(update);
    } else {
      element.textContent = target.toLocaleString('en-US');
    }
  }

  requestAnimationFrame(update);
}

const countObserver = new IntersectionObserver((entries, observer) => {
  entries.forEach((entry) => {
    if (!entry.isIntersecting) {
      return;
    }

    animateCount(entry.target);
    observer.unobserve(entry.target);
  });
}, {
  threshold: 0.45,
});

countElements.forEach((element) => countObserver.observe(element));

</script>

</body>
</html>
