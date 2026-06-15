<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Program - Wakaf Nurul Taqwa</title>
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
            <h1>Kelola Program</h1>
            <p>Tambah, ubah, dan hapus program yang tampil di halaman Program. Setiap program wajib memilih kategori dari tabel kategori.</p>

            @if (session('success'))
                <div class="admin-alert">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="admin-alert admin-alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="slider-upload-form" action="{{ route('programs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>
                    Judul program
                    <input type="text" name="judul" placeholder="Contoh: Wakaf Pendidikan" value="{{ old('judul') }}" required>
                </label>

                <label>
                    Kategori program
                    <select name="kategori_id" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((int) old('kategori_id') === (int) $category->id)>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label>
                    Deskripsi
                    <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" required>
                    <span class="admin-field-note">Kolom deskripsi wajib diisi untuk ditampilkan pada card program.</span>
                </label>

                <label>
                    Artikel program
                    <textarea name="artikel_program" rows="6" placeholder="Tulis artikel lengkap untuk halaman detail program." required>{{ old('artikel_program') }}</textarea>
                    <span class="admin-field-note">Artikel ini akan tampil sebagai konten lengkap pada halaman detail program.</span>
                </label>

                <label>
                    Gambar program (1200 x 570 px)
                    <input type="file" name="gambar" accept="image/*" required>
                    <span class="admin-field-note">Gambar ini akan tampil di card program pada halaman Program.</span>
                </label>

                <button type="submit" @disabled($categories->isEmpty())>Tambah Program</button>
            </form>

            <div class="slider-admin-list">
                @forelse ($programs as $program)
                    <article class="slider-admin-card program-admin-card">
                        <span class="slider-order-number">{{ $loop->iteration }}</span>

                        <img src="{{ $program->gambar ? asset('storage/' . $program->gambar) : asset('image/ZIS.png') }}" alt="{{ $program->judul }}">

                        <div class="slider-admin-content">
                            <strong>{{ $program->judul }}</strong>
                            <span>
                                Kategori:
                                {{ optional($categories->firstWhere('id', $program->kategoriId()))->nama_kategori ?? 'Tidak ditemukan' }}
                            </span>
                        </div>

                        <span class="program-admin-description">{{ $program->deskripsi }}</span>
                    </article>
                @empty
                    <p class="empty-slider-text">Belum ada program. Tambahkan program pertama dari form di atas.</p>
                @endforelse
            </div>

            @if ($programs->isNotEmpty())
                <div class="slider-edit-list">
                    @foreach ($programs as $program)
                        <article class="slider-edit-card">
                            <img src="{{ $program->gambar ? asset('storage/' . $program->gambar) : asset('image/ZIS.png') }}" alt="{{ $program->judul }}">

                            <form action="{{ route('programs.update', $program) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <label>
                                    Judul program
                                    <input type="text" name="judul" value="{{ old('judul', $program->judul) }}" required>
                                </label>

                                <label>
                                    Kategori program
                                    <select name="kategori_id" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected((int) old('kategori_id', $program->kategoriId()) === (int) $category->id)>
                                                {{ $category->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>

                                <label>
                                    Deskripsi
                                    <input type="text" name="deskripsi" value="{{ old('deskripsi', $program->deskripsi) }}" required>
                                </label>

                                <label>
                                    Artikel program
                                    <textarea name="artikel_program" rows="6" required>{{ old('artikel_program', $program->artikel_program) }}</textarea>
                                </label>

                                <label>
                                    Ganti gambar
                                    <input type="file" name="gambar" accept="image/*">
                                </label>

                                <button type="submit">Simpan Perubahan</button>
                            </form>

                            <form action="{{ route('programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Hapus program ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="delete-slider-button" type="submit">Hapus</button>
                            </form>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</body>
</html>
