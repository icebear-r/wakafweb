<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $program->judul }} - Wakaf Nurul Taqwa</title>
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

    <main class="program-detail-page">
        <nav class="program-detail-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('program') }}">Program</a>
            <span aria-hidden="true"></span>
            <span>Detail Program</span>
        </nav>

        <section class="program-detail-hero">
            <div class="program-detail-media">
                <img
                    src="{{ $program->gambar ? asset('storage/' . $program->gambar) : asset('image/ZIS.png') }}"
                    alt="{{ $program->judul }}"
                    class="program-detail-image"
                >

                <article class="program-detail-article">
                    {!! nl2br(e($program->artikel_program ?: $program->artikel_program)) !!}
                </article>
            </div>

            <div class="program-detail-content">
                <h1>{{ $program->judul }}</h1>
                <p>{{ $program->deskripsi }}</p>
                <a href="https://donasi.amalbaik.org/#/programs" class="program-detail-button">Wakaf Sekarang</a>
            </div>
        </section>
    </main>
</body>
</html>
