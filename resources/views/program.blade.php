<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Program - Wakaf Nurul Taqwa</title>
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

    @php
        $iconMap = [
            'pendidikan' => 'education',
            'lingkungan' => 'leaf',
            'ekonomi' => 'money',
            'ibadah' => 'moon',
            'kemanusiaan' => 'people',
        ];

        $firstCategoryId = optional($categories->first())->id;
    @endphp

    <main class="program-page">
        <section class="program-category-panel">
            @if ($categories->isNotEmpty())
                <div class="program-category-tabs" aria-label="Kategori program">
                    @foreach ($categories as $category)
                        @php
                            $normalizedCategory = strtolower($category->nama_kategori);
                            $iconName = collect($iconMap)->first(fn ($icon, $keyword) => str_contains($normalizedCategory, $keyword), 'people');
                            $isLingkunganCategory = str_contains($normalizedCategory, 'lingkungan');
                            $isKemanusiaanCategory = str_contains($normalizedCategory, 'kemanusiaan');
                        @endphp

                        <button
                            class="program-category-button @if ($loop->first) is-active @endif"
                            type="button"
                            data-category-id="{{ $category->id }}"
                            aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
                        >
                            <span class="program-category-icon" aria-hidden="true">
                                @if ($isLingkunganCategory)
                                    <img src="{{ asset('image/LOGOLINGKUNGAN.png') }}" alt="">
                                @elseif ($isKemanusiaanCategory)
                                    <img src="{{ asset('image/logokemanusiaan.png') }}" alt="" class="program-category-image-kemanusiaan">
                                @else
                                    @include('partials.program-icon', ['name' => $iconName])
                                @endif
                            </span>
                            <span>{{ $category->nama_kategori }}</span>
                        </button>
                    @endforeach
                </div>
            @else
                <p class="program-empty-text">Belum ada kategori di tabel kategori.</p>
            @endif
        </section>

        <section class="program-result-section">
            <h2>Program</h2>

            <div class="program-list-grid" id="program-list">
                @forelse ($programs as $program)
                    <article
                        class="program-card"
                        data-program-card
                        data-category-id="{{ $program->kategoriId() }}"
                        @if ($firstCategoryId && $program->kategoriId() !== (int) $firstCategoryId) hidden @endif
                    >
                        <img src="{{ $program->gambar ? asset('storage/' . $program->gambar) : asset('image/ZIS.png') }}" alt="{{ $program->judul }}">
                        <div class="program-card-body">
                            <h3>{{ $program->judul }}</h3>
                            @if ($program->deskripsi)
                                <p class="program-description">{{ $program->deskripsi }}</p>
                            @endif
                            <a href="{{ route('program.detail', $program) }}" class="program-card-button">Wakaf Sekarang</a>
                        </div>
                    </article>
                @empty
                    <p class="program-empty-text">Belum ada program.</p>
                @endforelse
            </div>

            <p class="program-empty-text" id="program-filter-empty" hidden>Belum ada program pada kategori ini.</p>
        </section>
    </main>

    <script>
        const categoryButtons = document.querySelectorAll('.program-category-button');
        const programCards = document.querySelectorAll('[data-program-card]');
        const emptyProgramText = document.getElementById('program-filter-empty');

        function filterPrograms(categoryId) {
            let visibleCount = 0;

            programCards.forEach((card) => {
                const isMatch = card.dataset.categoryId === categoryId;
                card.hidden = !isMatch;

                if (isMatch) {
                    visibleCount += 1;
                }
            });

            if (emptyProgramText) {
                emptyProgramText.hidden = visibleCount > 0 || programCards.length === 0;
            }
        }

        categoryButtons.forEach((button) => {
            button.addEventListener('click', () => {
                categoryButtons.forEach((item) => {
                    item.classList.remove('is-active');
                    item.setAttribute('aria-pressed', 'false');
                });

                button.classList.add('is-active');
                button.setAttribute('aria-pressed', 'true');
                filterPrograms(button.dataset.categoryId);
            });
        });

        if (categoryButtons.length > 0) {
            filterPrograms(categoryButtons[0].dataset.categoryId);
        }
    </script>
</body>
</html>
