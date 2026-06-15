<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Wakaf Nurul Taqwa</title>
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
            <li class="donasi"><a href="#">Admin</a></li>
        </ul>
    </nav>

    <main class="admin-page">
        <section class="admin-panel">
            <h1>Dashboard Admin</h1>
            <p>Kelola konten website Wakaf Nurul Taqwa dari halaman ini.</p>

            @if (session('success'))
                <div class="admin-alert">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="admin-alert admin-alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="admin-actions">
                <a href="{{ route('kelolacard') }}" class="admin-card">Kelola Card</a>
                <a href="{{ route('kelolaprogram') }}" class="admin-card">Kelola Program</a>
                <a href="{{ route('kelolaartikel') }}" class="admin-card">Kelola Artikel</a>
                <a href="{{ route('kelolaprogramunggulan') }}" class="admin-card">Kelola Program Unggulan</a>
            </div>

            @if (auth()->user()?->role === 'superadmin')
                <section class="admin-user-management">
                    <h2>Kelola User</h2>
                    <p>Tambahkan user baru dan atur role akses dashboard.</p>

                    <form class="slider-upload-form admin-user-form" action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <label>
                            User ID
                            <input type="text" name="user_id" value="{{ old('user_id') }}" placeholder="Masukan User yang ingin dibuat" required>
                        </label>

                        <label>
                            Password
                            <input type="password" name="password" required>
                        </label>

                        <label>
                            Konfirmasi password
                            <input type="password" name="password_confirmation" required>
                        </label>

                        <label>
                            Role
                            <select name="role" required>
                                <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                                <option value="superadmin" @selected(old('role') === 'superadmin')>Superadmin</option>
                            </select>
                        </label>

                        <button type="submit">Tambah User</button>
                    </form>

                    <div class="admin-user-list">
                        @forelse ($managedUsers as $managedUser)
                            <article class="admin-user-card">
                                <div>
                                    <strong>{{ $managedUser->user_id }}</strong>
                                    <span>Dibuat: {{ optional($managedUser->created_at)->format('d M Y') ?? '-' }}</span>
                                </div>

                                <form action="{{ route('admin.users.update-role', $managedUser) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <label>
                                        Role
                                        <select name="role" required>
                                            <option value="admin" @selected($managedUser->role === 'admin')>Admin</option>
                                            <option value="superadmin" @selected($managedUser->role === 'superadmin')>Superadmin</option>
                                        </select>
                                    </label>

                                    <button type="submit">Simpan Role</button>
                                </form>
                            </article>
                        @empty
                            <p class="empty-slider-text">Belum ada user.</p>
                        @endforelse
                    </div>
                </section>
            @endif
        </section>
    </main>

</body>
</html>
