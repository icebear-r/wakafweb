<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Card - Wakaf Nurul Taqwa</title>
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
            <h1>Kelola Card Slider</h1>
            <p>Upload gambar slider beranda, ubah gambar, hapus, dan geser card untuk mengatur posisinya.</p>

            @if (session('success'))
                <div class="admin-alert">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="admin-alert admin-alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="slider-upload-form" action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>
                    Judul gambar
                    <input type="text" name="title" placeholder="Contoh: Wakaf Qurban Pelosok Negeri" value="{{ old('title') }}">
                </label>

                <label>
                    Gambar slider (Ukuran 1200 x 570 px)
                    <input type="file" name="image" accept="image/*" required>
                </label>

                <button type="submit">Tambah Slider</button>
            </form>

            <form id="slider-order-form" action="{{ route('sliders.reorder') }}" method="POST">
                @csrf
                <div class="slider-admin-list" id="slider-admin-list">
                    @forelse ($sliders as $slider)
                        <article class="slider-admin-card" draggable="true" data-slider-id="{{ $slider->id }}">
                            <button class="drag-handle" type="button" aria-label="Geser posisi">☰</button>

                            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title ?: 'Slider beranda' }}">

                            <div class="slider-admin-content">
                                <strong>{{ $slider->title ?: 'Tanpa judul' }}</strong>
                                <span>Geser card ini untuk mengubah urutan tampil di beranda.</span>
                            </div>

                            <span class="slider-order-number">{{ $loop->iteration }}</span>

                            <input type="hidden" name="slider_ids[]" value="{{ $slider->id }}">
                        </article>
                    @empty
                        <p class="empty-slider-text">Belum ada gambar slider. Tambahkan gambar pertama dari form di atas.</p>
                    @endforelse
                </div>

                @if ($sliders->isNotEmpty())
                    <button class="save-order-button" type="submit">Simpan Urutan</button>
                @endif
            </form>

            @if ($sliders->isNotEmpty())
                <div class="slider-edit-list">
                    @foreach ($sliders as $slider)
                        <article class="slider-edit-card">
                            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title ?: 'Slider beranda' }}">

                            <form action="{{ route('sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <label>
                                    Judul gambar
                                    <input type="text" name="title" value="{{ old('title', $slider->title) }}">
                                </label>

                                <label>
                                    Ganti gambar
                                    <input type="file" name="image" accept="image/*">
                                </label>

                                <label class="slider-check">
                                    <input type="checkbox" name="is_active" value="1" @checked($slider->is_active)>
                                    Tampilkan di beranda
                                </label>

                                <button type="submit">Simpan Perubahan</button>
                            </form>

                            <form action="{{ route('sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('Hapus gambar slider ini?')">
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

    <script>
        const sliderList = document.getElementById('slider-admin-list');
        let draggedCard = null;

        function syncSliderInputs() {
            if (!sliderList) {
                return;
            }

            sliderList.querySelectorAll('.slider-admin-card').forEach((card, index) => {
                const orderNumber = card.querySelector('.slider-order-number');

                if (orderNumber) {
                    orderNumber.textContent = index + 1;
                }

                card.querySelector('input[name="slider_ids[]"]').value = card.dataset.sliderId;
            });
        }

        if (sliderList) {
            sliderList.addEventListener('dragstart', (event) => {
                draggedCard = event.target.closest('.slider-admin-card');

                if (draggedCard) {
                    draggedCard.classList.add('is-dragging');
                }
            });

            sliderList.addEventListener('dragend', () => {
                if (draggedCard) {
                    draggedCard.classList.remove('is-dragging');
                }

                draggedCard = null;
                syncSliderInputs();
            });

            sliderList.addEventListener('dragover', (event) => {
                event.preventDefault();

                const afterElement = [...sliderList.querySelectorAll('.slider-admin-card:not(.is-dragging)')]
                    .find((card) => event.clientY <= card.getBoundingClientRect().top + card.offsetHeight / 2);

                if (!draggedCard) {
                    return;
                }

                if (afterElement) {
                    sliderList.insertBefore(draggedCard, afterElement);
                } else {
                    sliderList.appendChild(draggedCard);
                }
            });
        }
    </script>
</body>
</html>
