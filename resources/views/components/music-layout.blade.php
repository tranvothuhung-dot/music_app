<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'MusicApp' }}</title>
    <link rel="stylesheet" href="{{ asset('library/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <script src="{{ asset('library/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('library/popper.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap.bundle.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="{{ asset('library/jquery-3.7.1.js') }}"></script>
    <style>
        :root {
            --primary-color: #ff4081;
            --bg-body: #f8f9fa;
        }
        body {
            background-color: var(--bg-body);
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            padding-top: 50px;
            font-size: 14px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .header-wrapper {
            width: 100%;
            margin: 0 auto;
        }

        .banner-wrapper {
            max-width: 1000px;
            margin: 24px auto 0;
            padding: 0 15px;
        }

        .banner-wrapper img {
            width: 100%;
            height: auto;
            display: block;
        }

        main {
            padding-top: 20px;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 10px rgba(0,0,0,0.05);
            padding: 14px 0;
            min-height: 72px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.75rem;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--primary-color) !important;
            margin-right: 22px;
            letter-spacing: -0.02em;
        }

        .navbar-nav .nav-link {
            color: #444 !important;
            font-size: 0.98rem;
            font-weight: 600;
            padding: 10px 16px !important;
            border-radius: 999px;
            margin: 0 6px;
            transition: all 0.25s ease;
        }

        .navbar-nav .nav-link:hover {
            background-color: #fff0f5;
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link.active {
            background-color: var(--primary-color);
            color: white !important;
            box-shadow: 0 4px 12px rgba(255,64,129,0.25);
        }

        .search-container {
            position: relative;
            width: 260px;
            margin-right: 24px;
            transition: 0.3s;
        }

        .search-input {
            background: #f1f3f4;
            border: 2px solid transparent;
            border-radius: 50px;
            padding: 10px 20px 10px 45px;
            width: 100%;
            max-width: 260px;
            outline: none;
            transition: 0.3s;
            font-size: 0.95rem;
            color: #333;
        }

        .search-input:focus {
            background: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(255,64,129,0.15);
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1rem;
            z-index: 2;
            pointer-events: none;
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-auth {
            padding: 8px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
            text-decoration: none;
            display: inline-block;
        }

        .btn-login {
            background-color: transparent;
            color: var(--primary-color);
        }

        .btn-login:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-register {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(255, 64, 129, 0.2);
        }

        .btn-register:hover {
            background-color: #e83274;
            border-color: #e83274;
            color: white;
            box-shadow: 0 6px 15px rgba(255, 64, 129, 0.3);
        }

        .text-pink {
            color: #ff4081 !important;
        }

        .bg-pink {
            background-color: #ff4081 !important;
            color: #fff !important;
        }

        .btn-pink {
            background-color: #ff4081;
            color: #ffffff;
            border: none;
            box-shadow: 0 10px 24px rgba(255, 64, 129, 0.24);
        }

        .btn-pink:hover {
            background-color: #e83274;
            color: #ffffff;
        }

        .btn-outline-pink {
            background-color: transparent;
            color: #ff4081;
            border: 1px solid #ff4081;
        }

        .btn-outline-pink:hover {
            background-color: rgba(255, 64, 129, 0.08);
            color: #ff4081;
        }

        .modal-icon {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fb;
            color: #9ca3af;
        }

        .modal-title.text-pink {
            font-size: 1.05rem;
        }

        .modal-body h5 {
            font-size: 1.18rem;
            font-weight: 700;
        }

        .modal-body p {
            color: #6b7280;
            margin-bottom: 0;
        }

        .guest-login-modal .modal-content {
            border-radius: 32px;
            overflow: hidden;
            background: #ffffff;
            border: none;
            padding: 0;
        }

        .guest-login-modal .modal-header {
            border-bottom: none;
            padding: 2.5rem 2rem 1.5rem;
            background: #ffffff;
            position: relative;
        }

        .guest-login-modal .modal-header .btn-close {
            position: absolute;
            right: 1.5rem;
            top: 1.5rem;
            width: 1.8rem;
            height: 1.8rem;
            opacity: 1;
            background: transparent;
            border: none;
            padding: 0;
            font-size: 1.5rem;
            color: #d1d5db;
        }

        .guest-login-modal .modal-header .btn-close:hover {
            opacity: 1;
            color: #6b7280;
            background: transparent;
        }

        .guest-login-modal .modal-header .btn-close::after {
            content: '\00d7';
            display: block;
        }

        .guest-login-modal .modal-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ff4081;
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        .guest-login-modal .modal-title i {
            font-size: 1.5rem;
        }

        .guest-login-modal .modal-body {
            padding: 2rem 2rem 2.5rem;
            background: #ffffff;
            text-align: center;
        }

        .guest-login-modal .modal-body .modal-icon {
            width: 110px;
            height: 110px;
            margin: 0 auto 1.75rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #d1d5db;
            font-size: 3.5rem;
        }

        .guest-login-modal .modal-body h5 {
            font-size: 1.3rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 0.75rem;
            letter-spacing: -0.01em;
            line-height: 1.3;
        }

        .guest-login-modal .modal-body p {
            font-size: 0.95rem;
            color: #6b7280;
            margin-bottom: 0;
            line-height: 1.5;
        }

        .guest-login-modal .modal-footer {
            border-top: none;
            padding: 0 2rem 2rem;
            background: #ffffff;
            justify-content: center;
            gap: 1.25rem;
        }

        .guest-login-modal .btn {
            font-size: 1rem;
            font-weight: 700;
            padding: 0.9rem 2.5rem;
            border-radius: 999px;
            min-width: 160px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .guest-login-modal .btn-pink {
            background-color: #ff4081;
            color: #ffffff;
            border: none;
            box-shadow: 0 10px 28px rgba(255, 64, 129, 0.25);
        }

        .guest-login-modal .btn-pink:hover {
            background-color: #e83274;
            box-shadow: 0 14px 35px rgba(255, 64, 129, 0.35);
            transform: translateY(-2px);
        }

        .guest-login-modal .btn-outline-pink {
            background-color: transparent;
            color: #ff4081;
            border: 2px solid #ff4081;
        }

        .guest-login-modal .btn-outline-pink:hover {
            background-color: rgba(255, 64, 129, 0.08);
            color: #ff4081;
            border-color: #ff4081;
        }

        .title-highlight {
            font-family: 'Poppins', sans-serif;
            font-size: 2.4rem;
            font-weight: 700;
            letter-spacing: -0.04em;
            color: #2b2b2b;
            border-left: 6px solid var(--primary-color);
            padding-left: 16px;
            line-height: 1.15;
            margin: 0;
            margin-bottom: 0.9rem;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .section-heading a {
            color: #6c757d;
            font-size: 0.92rem;
            font-weight: 600;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            transition: color 0.25s ease, transform 0.25s ease;
        }

        .section-heading a:hover {
            color: var(--primary-color);
            transform: translateX(2px);
        }

        .card {
            border: none;
            border-radius: 1rem;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.08);
        }

        .music-card {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
        }

        .music-card .card-img-top {
            border-top-left-radius: 1.25rem;
            border-top-right-radius: 1.25rem;
            transition: transform 0.35s ease;
        }

        .music-card:hover .card-img-top {
            transform: scale(1.03);
        }

        .music-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.02);
            opacity: 0;
            transition: opacity 0.25s ease;
            pointer-events: none;
        }

        .music-card:hover::after {
            opacity: 1;
        }

        .music-card .card-body {
            padding: 1.25rem;
        }

        .card-title {
            font-weight: 700;
            color: #2b2b2b;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .card-text {
            color: #6c757d;
        }

        .card-img-top {
            object-fit: cover;
            min-height: 220px;
        }

        .artist-avatar-box {
            width: 140px;
            height: 140px;
            margin: 0 auto 1.1rem;
            border-radius: 50%;
            background: #fff;
            padding: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.08);
            border: 2px solid rgba(255, 64, 129, 0.16);
        }

        .artist-card {
            padding: 1.5rem 1rem 1.3rem;
        }

        .artist-card .card-body {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .artist-avatar-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        /* ----------------------------------------------- */

        .user-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px var(--primary-color);
            transition: 0.3s;
        }

        .user-avatar:hover {
            transform: scale(1.05);
        }

        .dropdown-menu {
            right: 0;
            left: auto;
            min-width: 180px;
            max-width: 280px;
            width: auto;
            word-wrap: break-word;
            white-space: normal;
        }

        .dropdown-menu .dropdown-item {
            white-space: normal;
        }

        .dropdown-menu-end {
            right: 0 !important;
            left: auto !important;
        }

        /* --- HIỆU ỨNG HOVER BÀI HÁT & ALBUM --- */
        .card-img-wrapper {
            position: relative;
            overflow: hidden;
            border-top-left-radius: 1.25rem;
            border-top-right-radius: 1.25rem;
        }
        .card-img-wrapper img {
            width: 100%;
            transition: transform 0.4s ease;
        }
        .music-card:hover .card-img-wrapper img {
            transform: scale(1.08);
        }
        .play-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none; /* Để không block click khi chưa hover */
        }
        .music-card:hover .play-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        /* Nút Play Bài Hát */
        .btn-play-circle {
            width: 55px;
            height: 55px;
            background-color: #ff4081; 
            color: white;
            border-radius: 50%; 
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            border: none;
            box-shadow: 0 4px 15px rgba(255, 64, 129, 0.5);
            transform: translateY(15px);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .btn-play-circle i {
            margin-left: 4px; 
        }
        .music-card:hover .btn-play-circle {
            transform: translateY(0);
        }
        .btn-play-circle:hover {
            background-color: #e83274;
            transform: scale(1.1) !important;
        }

        /* Nút Xem Album */
        .btn-xem-album {
            background-color: rgba(220, 220, 220, 0.9);
            color: #000;
            font-weight: 800;
            padding: 10px 24px;
            border-radius: 30px;
            text-decoration: none;
            transform: translateY(15px);
            transition: all 0.3s ease;
        }
        .music-card:hover .btn-xem-album {
            transform: translateY(0);
        }
        .btn-xem-album:hover {
            background-color: #fff;
            color: #000;
            transform: scale(1.05) !important;
        }

        /* --- HIỆU ỨNG HOVER NGHỆ SĨ --- */
        .artist-item {
            display: block;
            text-decoration: none;
            transition: transform 0.3s ease;
        }
        .artist-item:hover {
            transform: translateY(-5px);
        }
        .artist-avatar-box {
            width: 160px;
            height: 160px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid transparent; /* Viền trong suốt mặc định */
            padding: 0; 
            background: transparent;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: all 0.4s ease;
        }
        .artist-item:hover .artist-avatar-box {
            border-color: #ff4081; /* Đổi thành viền hồng khi hover */
            box-shadow: 0 0 25px rgba(255, 64, 129, 0.5); /* Phát sáng màu hồng */
        }

        /* --- GIAO DIỆN TIN TỨC (DẠNG NGANG) --- */
        .news-card-horizontal {
            display: flex;
            flex-direction: row;
            border-radius: 1.25rem;
            overflow: hidden;
            background: #fff;
        }
        .news-img-wrapper {
            width: 40%;
            position: relative;
        }
        .news-img-wrapper img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .news-content {
            width: 60%;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .btn-news-detail {
            background-color: #d81b60;
            color: white;
            font-weight: 600;
            padding: 8px 24px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            align-self: flex-start;
            margin-top: 10px;
            transition: 0.3s;
        }
        .btn-news-detail:hover {
            background-color: #ad144b;
            color: white;
        }

        /* --- GENRE BADGE --- */
        .genre-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            backdrop-filter: blur(5px);
            z-index: 10;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-xl sticky-top">
            <div class="container-fluid px-4">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/music') }}">
                    <i class="fas fa-play-circle me-2"></i>MusicApp
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#musicNavbar">
                    <span class="fas fa-bars text-dark fs-3"></span>
                </button>

                <div class="collapse navbar-collapse" id="musicNavbar">
                    <ul class="navbar-nav mx-auto mb-2 mb-xl-0 d-flex align-items-center" style="gap: 14px;">
                        <li class="nav-item"><a class="nav-link {{ request()->is('/') || request()->is('music') ? 'active' : '' }}" href="{{ url('/music') }}">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('music/bai-hat*') ? 'active' : '' }}" href="{{ url('/music/bai-hat') }}">Bài hát</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('music/album*') ? 'active' : '' }}" href="{{ url('/music/album') }}">Album</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('music/nghe-si*') ? 'active' : '' }}" href="{{ url('/music/nghe-si') }}">Nghệ sĩ</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('music/the-loai*') || request()->is('music/genres*') ? 'active' : '' }}" href="{{ url('/music/the-loai') }}">Thể loại</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('music/tin-tuc*') ? 'active' : '' }}" href="{{ url('/music/tin-tuc') }}">Tin tức</a></li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        <form class="search-container d-none d-lg-flex" action="{{ route('music.search') }}" method="POST">
                            @csrf
                            <i class="fas fa-search search-icon"></i>
                            <input class="search-input" type="text" name="keyword" placeholder="Tìm kiếm bài hát..." value="{{ old('keyword') }}">
                        </form>
                        <div class="auth-buttons d-flex align-items-center">
                            @guest
                                <a href="{{ route('login') }}" class="btn-auth btn-login">Đăng nhập</a>
                                <a href="{{ route('register') }}" class="btn-auth btn-register">Đăng ký</a>
                            @else
                                @php
                                    $avatarImage = Auth::user()->avatar_image ?? Auth::user()->avatar_url ?? 'user_7_1767909311.jpg';
                                @endphp
                                <div class="dropdown">
                                    <a href="#" class="user-dropdown-toggle d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                        <img src="{{ asset('images/' . $avatarImage) }}" onerror="this.src='{{ asset('images/user_7_1767909311.jpg') }}'" class="user-avatar me-2" alt="Avatar">
                                        <span class="fw-bold text-dark d-none d-lg-block text-truncate" style="max-width: 100px;">{{ Auth::user()->name }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-4 overflow-hidden">
                                        <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="fas fa-user-circle me-2 text-secondary"></i>Quản lý</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item py-2 text-danger fw-bold"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @if(request()->is('/') || request()->is('music'))
            <div class="banner-wrapper">
                <img src="{{ asset('images/banner.png') }}" alt="Banner">
            </div>
        @endif
    </header>

    <div class="modal fade guest-login-modal" id="guestLoginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <div class="modal-title" id="guestLoginModalLabel">
                        <i class="fas fa-lock"></i>Yêu cầu quyền truy cập
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-icon">
                        <i class="fas fa-headphones"></i>
                    </div>
                    <h5>Bạn cần đăng nhập để nghe bài hát này.</h5>
                    <p>Vui lòng đăng nhập hoặc tạo tài khoản mới.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('login') }}" class="btn btn-pink">Đăng Nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-pink">Đăng Ký</a>
                </div>
            </div>
        </div>
    </div>

    <x-login-required-modal />

    <!-- Play Confirmation Modal -->
    <div class="modal fade" id="playConfirmModal" tabindex="-1" aria-labelledby="playConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content rounded-4 border-0 shadow-lg p-3" style="background: #ffffff;">
                <div class="modal-header border-bottom-0 pb-0 pt-2">
                    <h5 class="modal-title fw-bold text-danger d-flex align-items-center" id="playConfirmLabel">
                        <i class="fas fa-lock me-2"></i>Cần đăng nhập
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-headphones fa-4x text-secondary opacity-50"></i>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark fs-5">Bạn cần đăng nhập để nghe bài hát</h5>
                    <p class="text-muted small">Đăng nhập ngay để bắt đầu thưởng thức âm nhạc.</p>
                </div>
                <div class="modal-footer border-top-0 justify-content-center pb-2 pt-0 gap-3">
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#requireLoginModal" style="min-width: 140px;">Đăng Nhập Ngay</button>
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4 fw-bold" data-bs-dismiss="modal" style="min-width: 140px;">Hủy</button>
                </div>
            </div>
        </div>
    </div>

    <main>
        {{ $slot }}
    </main>

    <script>
        window.isAuthenticated = @json(auth()->check());
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.restricted-action').forEach(function (button) {
                button.addEventListener('click', function (event) {
                    if (!window.isAuthenticated) {
                        event.preventDefault();
                        var modal = new bootstrap.Modal(document.getElementById('guestLoginModal'));
                        modal.show();
                    }
                });
            });

            document.querySelectorAll('.user-dropdown-toggle').forEach(function (toggle) {
                toggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    var parent = this.closest('.dropdown');
                    var menu = parent.querySelector('.dropdown-menu');
                    if (menu) {
                        menu.classList.toggle('show');
                        this.setAttribute('aria-expanded', menu.classList.contains('show'));
                    }
                });
            });

            document.addEventListener('click', function (event) {
                if (!event.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu.show').forEach(function (menu) {
                        menu.classList.remove('show');
                    });
                    document.querySelectorAll('.user-dropdown-toggle[aria-expanded="true"]').forEach(function (toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    });
                }
            });

            var modalCloseButton = document.querySelector('#guestLoginModal .btn-close');
            if (modalCloseButton) {
                modalCloseButton.addEventListener('click', function () {
                    var modalEl = document.getElementById('guestLoginModal');
                    if (modalEl && window.bootstrap && bootstrap.Modal) {
                        var instance = bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl);
                        instance.hide();
                    }
                });
            }
        });

        // Global variable để lưu song ID
        var currentPlaySongId = null;

        // Hàm đặt song hiện tại
        function setCurrentSong(songId, songName) {
            currentPlaySongId = songId;
            var modal = new bootstrap.Modal(document.getElementById('playConfirmModal'));
            modal.show();
        }

        // Hàm để play song
        function playSongNow() {
            if (currentPlaySongId) {
                window.location.href = '/music/bai-hat/' + currentPlaySongId;
            }
        }
    </script>
</body>
</html>
