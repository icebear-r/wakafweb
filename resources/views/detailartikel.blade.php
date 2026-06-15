<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $article->title }} - Wakaf Nurul Taqwa</title>
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

    <main class="artikel-detail-page">
        <nav class="artikel-detail-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('artikel') }}">Artikel</a>
            <span aria-hidden="true"></span>
            <span>Detail Artikel</span>
        </nav>

        <article class="artikel-detail-content">
            <h1>{{ $article->title }}</h1>

            <img
                src="{{ $article->image ? asset('storage/' . $article->image) : asset('image/IMG_9791.JPG.jpg') }}"
                alt="{{ $article->title }}"
                class="artikel-detail-image"
            >

            <div class="artikel-detail-text">
                {!! nl2br(e($article->content ?: $article->excerpt ?: 'Isi artikel belum tersedia.')) !!}
            </div>
        </article>
    </main>
</body>
</html>
