<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Artikel - Wakaf Nurul Taqwa</title>
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

    <main class="artikel-page">
        <header class="artikel-page-header">
            <h1>Artikel</h1>

            <div class="artikel-controls">
                <label class="artikel-search" aria-label="Cari artikel">
                    <input type="search" placeholder="Search..." data-article-search>
                </label>

                <button class="artikel-sort" type="button" aria-label="Urutkan dari terbaru" title="Terbaru ke terlama" data-article-sort>
                    <svg viewBox="0 0 44 44" aria-hidden="true">
                        <path d="M7 10h23M7 20h16M7 30h10"></path>
                        <path d="M32 14v20"></path>
                        <path d="m24 27 8 8 8-8"></path>
                    </svg>
                </button>
            </div>
        </header>

        <section class="artikel-list" id="artikel-list" aria-live="polite">
            @forelse ($articles as $article)
                <article
                    class="artikel-list-card"
                    data-article-card
                    data-title="{{ strtolower($article->title) }}"
                    data-excerpt="{{ strtolower($article->excerpt ?? '') }}"
                    data-date="{{ $article->updated_at?->timestamp ?? 0 }}"
                >
                    <img src="{{ $article->image ? asset('storage/' . $article->image) : asset('image/IMG_9791.JPG.jpg') }}" alt="{{ $article->title }}">

                    <div class="artikel-card-content">
                        <h2>{{ $article->title }}</h2>
                        <p>
                            {{ $article->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($article->content ?? 'Ringkasan artikel wakaf akan tampil di bagian ini.'), 190) }}
                        </p>
                        <a href="{{ route('artikel.detail', $article) }}" class="artikel-card-link">Lihat Selengkapnya</a>
                    </div>
                </article>
            @empty
                <article
                    class="artikel-list-card"
                    data-article-card
                    data-title="wakaf qurban pelosok negeri"
                    data-excerpt="lorem ipsum dolor sit amet"
                    data-date="0"
                >
                    <img src="{{ asset('image/IMG_9791.JPG.jpg') }}" alt="Wakaf Qurban Pelosok Negeri">

                    <div class="artikel-card-content">
                        <h2>Wakaf Qurban Pelosok Negeri</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                        <button type="button" class="artikel-card-link">Lihat Selengkapnya</button>
                    </div>
                </article>
            @endforelse
        </section>

        <p class="artikel-empty" id="artikel-empty" hidden>Artikel yang dicari belum ditemukan.</p>
    </main>

    <script>
        const articleSearch = document.querySelector('[data-article-search]');
        const articleList = document.getElementById('artikel-list');
        const articleSort = document.querySelector('[data-article-sort]');
        const articleEmpty = document.getElementById('artikel-empty');
        let sortDirection = 'desc';

        function filterArticles() {
            const keyword = articleSearch ? articleSearch.value.trim().toLowerCase() : '';
            const articleCards = document.querySelectorAll('[data-article-card]');
            let visibleCount = 0;

            articleCards.forEach((card) => {
                const text = `${card.dataset.title || ''} ${card.dataset.excerpt || ''}`;
                const isMatch = text.includes(keyword);

                card.hidden = !isMatch;
                if (isMatch) {
                    visibleCount += 1;
                }
            });

            if (articleEmpty) {
                articleEmpty.hidden = visibleCount > 0;
            }
        }

        if (articleSearch) {
            articleSearch.addEventListener('input', filterArticles);
        }

        if (articleSort && articleList) {
            articleSort.addEventListener('click', () => {
                sortDirection = sortDirection === 'desc' ? 'asc' : 'desc';

                const sortedCards = Array.from(document.querySelectorAll('[data-article-card]')).sort((firstCard, secondCard) => {
                    const firstDate = Number(firstCard.dataset.date || 0);
                    const secondDate = Number(secondCard.dataset.date || 0);

                    return sortDirection === 'desc'
                        ? secondDate - firstDate
                        : firstDate - secondDate;
                });

                sortedCards.forEach((card) => articleList.appendChild(card));
                articleSort.classList.toggle('is-oldest', sortDirection === 'asc');
                articleSort.setAttribute('aria-label', sortDirection === 'desc' ? 'Urutkan dari terbaru' : 'Urutkan dari terlama');
                articleSort.setAttribute('title', sortDirection === 'desc' ? 'Terbaru ke terlama' : 'Terlama ke terbaru');
                filterArticles();
            });
        }
    </script>
</body>
</html>
