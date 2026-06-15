<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Wakaf Nurul Taqwa</title>
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

    <form class="form-login" method="POST" action="{{ route('login.process') }}">
        @csrf

        <div class="title-login">Welcome,<br><span>Login to Continue</span></div>
        <input class="input-login" name="user_id" placeholder="User ID" type="text" value="{{ old('user_id') }}">
        <input class="input-login" name="password" placeholder="Password" type="password">

        @error('user_id')
            <p class="login-error">{{ $message }}</p>
        @enderror

        <button class="button-confirm" type="submit">Login</button>
    </form>
</body>
</html>
