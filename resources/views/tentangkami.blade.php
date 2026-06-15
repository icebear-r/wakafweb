<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tentang Kami - Wakaf Nurul Taqwa</title>
    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">
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

    <main class="tentang-page">
        <section class="tentang-card" aria-label="Tentang Wakaf Nurul Taqwa">
            <div class="tentang-copy">
                <span class="tentang-quote tentang-quote-start" aria-hidden="true">“</span>
                <p>
                    Wakaf Nurul Taqwa merupakan lembaga yang mengelola harta penyerahan wakif demi kepentingan ibadah dan kesejahteraan umum tanpa mengurangi jumlah harta tersebut.
                </p>
                <span class="tentang-quote tentang-quote-end" aria-hidden="true">“</span>
            </div>

            <img src="{{ asset('image/logo wakaf.png') }}" alt="Wakaf Nurul Taqwa" class="tentang-logo">
        </section>

        <section class="tentang-profile">
            <h1>Tentang Kami</h1>
            <p>
                Lembaga Wakaf Nurul Taqwa (LWNT) secara resmi terdaftar pada tanggal 30 Desember 2019. berada dibawah naungan Yayasan Nurul Taqwa yang mengelola masjid Nurul Taqwa di area Gambir, Jakarta Pusat menjadikan masjid sebagai pusat pemberdayaan dan menjadi kontributor kemajuan masyarakat banyak.LWNT terdaftar di KEMENKUMHAM dengan No.AHU0012935.AH.01.12. Th. 2018 dan telah terdaftar sebagai Nazhir di Badan Wakaf Indonesia dengan Surat Tanda Bukti Pendaftaran 3.3.00235.Berbekal semangat menghadirkan kemaslahatan berkelanjutan, Lembaga Wakaf Nurul Taqwa (LWNT) berkomitmen mengelola dan mengembangkan aset wakaf secara produktif di bidang pendidikan, ekonomi, sosial, dan keagamaan. Melalui tata kelola yang amanah dan transparan, LWNT berupaya menjadikan wakaf sebagai sarana pemberdayaan umat dan kontribusi nyata bagi kemajuan masyarakat.
            </p>
        </section>

        <section class="tentang-vision-mission">
            <h2>Visi dan Misi</h2>

            <div class="tentang-vm-grid">
                <article class="tentang-vm-card tentang-vm-card-visi">
                    <h3>VISI</h3>
                    <p>
                        Menjadi lembaga wakaf yang amanah, profesional dan terpercaya dalam mengoptimalkan wakaf produktif untuk kemandirian dan kesejahteraan umat secara berkelanjutan.
                    </p>
                </article>

                <article class="tentang-vm-card tentang-vm-card-misi">
                    <h3>MISI</h3>
                    <p>
                        Menjalankan penghimpunan, pengelolaan dan pengembangan harta benda wakaf secara profesional, transparan dan akuntable sesuai prinsip syariah dan ketentuan peraturan perundang-undangan.
                    </p>
                    <p>
                        Mengoptimalkan pendayagunaan wakaf produktif dan meningkatkan nilai manfaat serta keberlanjutan harta benda wakaf melalui pengelolaan yang efektif, efisien dan berorientasi pada kemaslahatan umum melalui pemberdayaan dengan pendekatan social enterprise.
                    </p>
                    <p>
                        Kolaborasi positif dengan stakeholder wakaf Indonesia dan meningkatkan pemahaman masyarakat kepada wakaf melalui sosialisasi, edukasi dan penguatan literasi wakaf.
                    </p>
                </article>
            </div>
        </section>

        <section class="tentang-structure">
            <h2>Struktur Kami</h2>

            <div class="tentang-structure-grid">
                <article class="tentang-structure-item">
                    <div class="tentang-structure-photo">
                        <img src="{{ asset('image/ceo.svg') }}" alt="Chief Executive Officer">
                    </div>
                    <h1>Wakhid Effendi</h1>
                    <h3>Chief Executive Officer</h3>
                </article>

                <article class="tentang-structure-item">
                    <div class="tentang-structure-photo">
                        <img src="{{ asset('image/ceo2.svg') }}" alt="Chief Executive Officer" class="tentang-structure-photo-ceo2">
                    </div>
                    <h1>Agus Triyono</h1>
                    <h3>Chief Finance  Officer</h3>
                </article>

                <article class="tentang-structure-item">
                    <div class="tentang-structure-photo">
                        <img src="{{ asset('image/cco.svg') }}" alt="Chief Executive Officer" class="tentang-structure-photo-cco">
                    </div>
                    <h1>Arya Fajar</h1>
                    <h3>Chief Operating Officer</h3>
                </article>

                <article class="tentang-structure-item">
                    <div class="tentang-structure-photo">
                        <img src="{{ asset('image/head.svg') }}" alt="Chief Executive Officer" class="tentang-structure-photo-head">
                    </div>
                    <h1>Nanang Ardiansyah</h1>
                    <h3>Head of Wakaf Division</h3>
                </article>
            </div>
        </section>
    </main>
</body>
</html>
