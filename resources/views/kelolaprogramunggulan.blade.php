<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Program Unggulan - Wakaf Nurul Taqwa</title>
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
            <h1>Kelola Program Unggulan</h1>
            <p>Pilih program dari data Kelola Program untuk ditampilkan sebagai card Program Unggulan di halaman beranda.</p>

            @if (session('success'))
                <div class="admin-alert">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="admin-alert admin-alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="slider-upload-form" action="{{ route('featured-programs.store') }}" method="POST">
                @csrf
                <label>
                    Pilih program
                    <select name="program_id" required>
                        <option value="">Pilih program yang sudah dibuat</option>
                        @foreach ($programs as $programOption)
                            <option value="{{ $programOption->id }}" @selected((int) old('program_id') === (int) $programOption->id)>
                                {{ $programOption->judul }}
                            </option>
                        @endforeach
                    </select>
                    <span class="admin-field-note">Gambar dan judul mengikuti data dari halaman Kelola Program.</span>
                </label>

                <button type="submit" @disabled($programs->isEmpty())>Tambahkan ke Unggulan</button>
            </form>

            <form id="featured-program-order-form" action="{{ route('featured-programs.reorder') }}" method="POST">
                @csrf
                <div class="slider-admin-list" id="featured-program-list">
                    @forelse ($featuredPrograms as $featuredProgram)
                        @php($program = $featuredProgram->program)
                        <article class="slider-admin-card" draggable="true" data-program-id="{{ $featuredProgram->id }}">
                            <button class="drag-handle" type="button" aria-label="Geser posisi">&#9776;</button>

                            <img src="{{ $program?->gambar ? asset('storage/' . $program->gambar) : asset('image/ZIS.png') }}" alt="{{ $program?->judul ?? $featuredProgram->title }}">

                            <div class="slider-admin-content">
                                <strong>{{ $program?->judul ?? $featuredProgram->title }}</strong>
                                <span>
                                    {{ $program ? 'Menggunakan data dari Kelola Program.' : 'Program asal tidak ditemukan.' }}
                                    Geser card ini untuk mengubah urutan tampil di beranda.
                                </span>
                            </div>

                            <span class="slider-order-number">{{ $loop->iteration }}</span>

                            <input type="hidden" name="featured_program_ids[]" value="{{ $featuredProgram->id }}">
                        </article>
                    @empty
                        <p class="empty-slider-text">Belum ada program unggulan. Pilih program pertama dari form di atas.</p>
                    @endforelse
                </div>

                @if ($featuredPrograms->isNotEmpty())
                    <button class="save-order-button" type="submit">Simpan Urutan</button>
                @endif
            </form>

            @if ($featuredPrograms->isNotEmpty())
                <div class="slider-edit-list">
                    @foreach ($featuredPrograms as $featuredProgram)
                        @php($selectedProgram = $featuredProgram->program)
                        <article class="slider-edit-card">
                            <img src="{{ $selectedProgram?->gambar ? asset('storage/' . $selectedProgram->gambar) : asset('image/ZIS.png') }}" alt="{{ $selectedProgram?->judul ?? $featuredProgram->title }}">

                            <form action="{{ route('featured-programs.update', $featuredProgram) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <label>
                                    Pilih program
                                    <select name="program_id" required>
                                        @foreach ($programs as $programOption)
                                            <option value="{{ $programOption->id }}" @selected((int) old('program_id', $featuredProgram->program_id) === (int) $programOption->id)>
                                                {{ $programOption->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>

                                <label class="slider-check">
                                    <input type="checkbox" name="is_active" value="1" @checked($featuredProgram->is_active)>
                                    Tampilkan di beranda
                                </label>

                                <button type="submit">Simpan Perubahan</button>
                            </form>

                            <form action="{{ route('featured-programs.destroy', $featuredProgram) }}" method="POST" onsubmit="return confirm('Hapus program dari unggulan?')">
                                @csrf
                                @method('DELETE')
                                <button class="delete-slider-button" type="submit">Hapus dari Unggulan</button>
                            </form>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    <script>
        const featuredProgramList = document.getElementById('featured-program-list');
        let draggedProgram = null;

        function syncFeaturedProgramInputs() {
            if (!featuredProgramList) {
                return;
            }

            featuredProgramList.querySelectorAll('.slider-admin-card').forEach((card, index) => {
                const orderNumber = card.querySelector('.slider-order-number');

                if (orderNumber) {
                    orderNumber.textContent = index + 1;
                }

                card.querySelector('input[name="featured_program_ids[]"]').value = card.dataset.programId;
            });
        }

        if (featuredProgramList) {
            featuredProgramList.addEventListener('dragstart', (event) => {
                draggedProgram = event.target.closest('.slider-admin-card');

                if (draggedProgram) {
                    draggedProgram.classList.add('is-dragging');
                }
            });

            featuredProgramList.addEventListener('dragend', () => {
                if (draggedProgram) {
                    draggedProgram.classList.remove('is-dragging');
                }

                draggedProgram = null;
                syncFeaturedProgramInputs();
            });

            featuredProgramList.addEventListener('dragover', (event) => {
                event.preventDefault();

                const afterElement = [...featuredProgramList.querySelectorAll('.slider-admin-card:not(.is-dragging)')]
                    .find((card) => event.clientY <= card.getBoundingClientRect().top + card.offsetHeight / 2);

                if (!draggedProgram) {
                    return;
                }

                if (afterElement) {
                    featuredProgramList.insertBefore(draggedProgram, afterElement);
                } else {
                    featuredProgramList.appendChild(draggedProgram);
                }
            });
        }
    </script>
</body>
</html>
