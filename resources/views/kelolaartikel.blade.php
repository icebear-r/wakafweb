<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Artikel - Wakaf Nurul Taqwa</title>
    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
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
            <li class="donasi"><a href="{{ route('admin') }}">Admin</a></li>
        </ul>
    </nav>

    <main class="admin-page">
        <section class="admin-panel">
            <h1>Kelola Artikel</h1>
            <p>Tambah, ubah, hapus, dan atur artikel yang tampil di card artikel beranda.</p>

            @if (session('success'))
                <div class="admin-alert">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="admin-alert admin-alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="slider-upload-form" action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>
                    Judul artikel
                    <input type="text" name="title" placeholder="Contoh: Manfaat Wakaf untuk Kesejahteraan Umat" value="{{ old('title') }}" required>
                </label>

                <label>
                    Ringkasan artikel
                    <textarea name="excerpt" rows="4" placeholder="Tulis ringkasan singkat artikel">{{ old('excerpt') }}</textarea>
                    <span class="admin-field-note">Maksimal 18 kata agar ringkasan tampil penuh di card beranda.</span>
                </label>

                <label>
                    Isi artikel
                    <textarea name="content" rows="10" placeholder="Tulis isi lengkap artikel">{{ old('content') }}</textarea>
                </label>

                <label>
                    Gambar artikel (1280 x 720 px)
                    <input type="file" name="image" accept="image/*">
                </label>

                <button type="submit">Tambah Artikel</button>
            </form>

            @if ($articles->isNotEmpty())
                <div class="slider-edit-list">
                    @foreach ($articles as $article)
                        <article class="slider-edit-card">
                            <img src="{{ $article->image ? asset('storage/' . $article->image) : asset('image/banner-wakaf.jpg') }}" alt="{{ $article->title }}">

                            <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <label>
                                    Judul artikel
                                    <input type="text" name="title" value="{{ old('title', $article->title) }}" required>
                                </label>

                                <label>
                                    Ringkasan artikel
                                    <textarea name="excerpt" rows="4">{{ old('excerpt', $article->excerpt) }}</textarea>
                                    <span class="admin-field-note">Maksimal 18 kata agar ringkasan tampil penuh di card beranda.</span>
                                </label>

                                <label>
                                    Isi artikel
                                    <textarea name="content" rows="10">{{ old('content', $article->content) }}</textarea>
                                </label>

                                <label>
                                    Ganti gambar
                                    <input type="file" name="image" accept="image/*">
                                </label>

                                <label class="slider-check">
                                    <input type="checkbox" name="is_active" value="1" @checked($article->is_active)>
                                    Tampilkan di beranda
                                </label>

                                <button type="submit">Simpan Perubahan</button>
                            </form>

                            <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="delete-slider-button" type="submit">Hapus</button>
                            </form>
                        </article>
                    @endforeach
                </div>
            @else
                <p class="empty-slider-text">Belum ada artikel. Tambahkan artikel pertama dari form di atas.</p>
            @endif
        </section>
    </main>
</body>
</html>
