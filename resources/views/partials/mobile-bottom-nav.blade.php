<nav class="mobile-bottom-nav" aria-label="Navigasi mobile">
    <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') || request()->is('/') ? 'is-active' : '' }}" aria-label="Beranda">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M3 11.5 12 4l9 7.5"></path>
            <path d="M5.5 10.5V20h13v-9.5"></path>
            <path d="M9.5 20v-6h5v6"></path>
        </svg>
    </a>

    <a href="{{ route('program') }}" class="{{ request()->routeIs('program') || request()->routeIs('program.detail') ? 'is-active' : '' }}" aria-label="Program">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M5 5.5h14"></path>
            <path d="M5 12h14"></path>
            <path d="M5 18.5h14"></path>
            <path d="M8 3.5v4"></path>
            <path d="M16 10v4"></path>
            <path d="M11 16.5v4"></path>
        </svg>
    </a>

    <a href="https://donasi.amalbaik.org/#/programs" class="mobile-bottom-nav-donate" aria-label="Wakaf Sekarang">
        <img src="{{ asset('image/Logonavbar.png') }}" alt="">
    </a>

    <a href="{{ route('artikel') }}" class="{{ request()->routeIs('artikel') || request()->routeIs('artikel.detail') ? 'is-active' : '' }}" aria-label="Artikel">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M6 4.5h9l3 3V19.5H6z"></path>
            <path d="M15 4.5v3h3"></path>
            <path d="M9 11h6"></path>
            <path d="M9 15h6"></path>
        </svg>
    </a>

    <a href="{{ route('tentangkami') }}" class="{{ request()->routeIs('tentangkami') ? 'is-active' : '' }}" aria-label="Tentang Kami">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path>
            <path d="M4.5 20c1.2-3.8 4-6 7.5-6s6.3 2.2 7.5 6"></path>
        </svg>
    </a>
</nav>
