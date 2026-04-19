<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'MusicApp' }}</title>
    <link rel="stylesheet" href="{{ asset('library/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="{{ asset('library/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('library/popper.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap.bundle.min.js') }}"></script>
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            white-space: nowrap;
        }

        .navbar-nav .nav-link {
            color: #444 !important;
            font-size: 0.98rem;
            font-weight: 600;
            padding: 10px 14px !important;
            border-radius: 999px;
            margin: 0 4px;
            transition: all 0.25s ease;
            white-space: nowrap;
        }

        .navbar-nav .nav-item {
            flex: 0 0 auto;
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
            white-space: nowrap;
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
            font-family: 'Poppins', sans-serif;
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
            z-index: 1000;
            pointer-events: auto;
            cursor: pointer;
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
            font-size: 1.2rem;
            font-weight: 700;
            color: #ff4081;
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        .guest-login-modal .modal-title i {
            font-size: 1.3rem;
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
            font-size: 1.15rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
            letter-spacing: -0.01em;
            line-height: 1.45;
        }

        .guest-login-modal .modal-body p {
            font-size: 1rem;
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 0;
            line-height: 1.75;
        }

        .guest-login-modal .modal-footer {
            border-top: none;
            padding: 0 2rem 2rem;
            background: #ffffff;
            justify-content: center;
            gap: 1.25rem;
        }

        .guest-login-modal .btn {
            font-family: 'Poppins', sans-serif;
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
            color: var(--primary-color);
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

        .section-title,
        .card-title,
        .artist-title,
        .album-title,
        .genre-title,
        .news-card .card-title {
            color: var(--primary-color);
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

        footer {
            background-color: #ffffff;
            color: #555;
            font-size: 0.9rem;
            margin-top: 40px;
        }
        .footer-heading {
            color: #222;
            font-weight: 700;
            margin-bottom: 18px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .footer-link {
            color: #666;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            transition: 0.3s;
        }
        .footer-link:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }
        .social-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f1f3f4;
            color: #555;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            transition: 0.3s;
            text-decoration: none;
        }
        .social-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }
        .footer-subscribe-btn {
            background: #f82c75;
            color: #fff;
            border: none;
            min-width: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .footer-subscribe-btn:hover {
            background: #e01d67;
            color: #fff;
        }
        .footer-subscribe-btn i {
            color: #fff;
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
                    <div class="search-container d-none d-lg-flex position-relative" id="searchBoxGlobal">
                        <form action="{{ route('music.search') }}" method="GET" id="searchForm" class="w-100">
                            <i class="fas fa-search search-icon"></i>
                            <input class="search-input" type="text" name="q" id="searchInput" placeholder="Tìm kiếm bài hát, nghệ sĩ..." autocomplete="off" value="{{ request('q') }}">
                        </form>
                        
                        <div id="searchDropdown" class="shadow-lg rounded-4" style="display: none; position: absolute; top: 110%; left: 0; width: 350px; background: #fff; z-index: 1050; padding: 15px; max-height: 400px; overflow-y: auto;">
                        </div>
                    </div>
                        <div class="auth-buttons d-flex align-items-center">
                            @guest
                                <a href="{{ route('login') }}" class="btn-auth btn-login">Đăng nhập</a>
                                <a href="{{ route('register') }}" class="btn-auth btn-register">Đăng ký</a>
                            @else
                                @php
                                    $avatarSrc = Auth::user()->avatar_image_url ?? asset('images/user_7_1767909311.jpg');
                                @endphp
                                <div class="dropdown">
                                    <a href="#" class="user-dropdown-toggle d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                        <img src="{{ $avatarSrc }}" onerror="this.src='{{ asset('images/user_7_1767909311.jpg') }}'" class="user-avatar me-2" alt="Avatar">
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


    @include('components.login-required-modal')
    <div class="modal fade guest-login-modal" id="playConfirmModal" tabindex="-1" aria-labelledby="playConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <div class="modal-title" id="playConfirmLabel">
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

    

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="pt-5 pb-3 border-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ url('/music') }}" class="d-flex align-items-center text-decoration-none mb-3">
                        <span class="fs-4 fw-bold text-dark">MusicApp</span>
                    </a>
                    <p class="text-muted small pe-4">
                        Thế giới âm nhạc trong tầm tay. Nghe nhạc chất lượng cao, cập nhật xu hướng mới nhất mỗi ngày.
                    </p>
                    <div class="mt-3">
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 mb-4">
                    <h6 class="footer-heading">Khám phá</h6>
                    <a href="{{ route('music.index') }}" class="footer-link">Trang chủ</a>
                    <a href="{{ route('music.songs') }}" class="footer-link">Bài hát mới</a>
                    <a href="{{ route('music.albums') }}" class="footer-link">Album Hot</a>
                    <a href="{{ route('music.artists') }}" class="footer-link">Nghệ sĩ</a>
                </div>

                <div class="col-lg-2 col-md-3 mb-4">
                    <h6 class="footer-heading">Hỗ trợ</h6>
                    <a href="#" class="footer-link">Điều khoản</a>
                    <a href="#" class="footer-link">Bảo mật</a>
                    <a href="#" class="footer-link">Liên hệ</a>
                    <a href="#" class="footer-link">Góp ý</a>
                </div>

                <div class="col-lg-4 col-md-12 mb-4">
                    <h6 class="footer-heading">Đăng ký nhận tin</h6>
                    <form class="input-group">
                        <input type="email" class="form-control bg-light" placeholder="Email của bạn...">
                        <button class="btn footer-subscribe-btn" type="button"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>

            <hr class="my-4 text-muted opacity-25">

            <div class="text-center text-muted small">
                &copy; {{ date('Y') }} <strong>MusicApp</strong>. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        window.isAuthenticated = @json(auth()->check());
        window.isLogged = !!window.isAuthenticated;

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.restricted-action').forEach(function (button) {
                button.addEventListener('click', function (event) {
                    if (!window.isAuthenticated) {
                        event.preventDefault();
                        var modal = new bootstrap.Modal(document.getElementById('requireLoginModal'));
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

            // Close login modal on X button click
            document.addEventListener('click', function (event) {
                if (event.target.classList.contains('btn-close') && event.target.closest('#requireLoginModal')) {
                    const modalEl = document.getElementById('requireLoginModal');
                    if (modalEl && window.bootstrap && window.bootstrap.Modal) {
                        const modal = window.bootstrap.Modal.getInstance(modalEl);
                        if (modal) {
                            modal.hide();
                        }
                    }
                }
            });

        });
	
// LOGIC TÌM KIẾM AJAX (GIỮ NGUYÊN HOẠT ĐỘNG TỐT CỦA MÀY)
        let searchTimeout;
        const dropdown = $('#searchDropdown');

        $('#searchInput').on('input', function() {
            clearTimeout(searchTimeout);
            let q = $(this).val().trim();
            if(q === '') { dropdown.fadeOut(); return; }
            
            searchTimeout = setTimeout(() => {
                $.get("{{ route('search.ajax') }}", {q: q}, function(res) {
                    if(res.type === 'search') {
                        let html = '';
                        
                        // Render Nghệ sĩ
                        if(res.artists && res.artists.length > 0) {
                            html += `<div style="font-size: 13px; font-weight: bold; color: #888; margin-bottom: 10px; text-transform: uppercase;">Nghệ sĩ</div>`;
                            res.artists.forEach(a => {
                                let imgSrc = a.avatar_image ? `/images/${a.avatar_image}` : '/images/default.png';
                                html += `
                                <a href="/music/nghe-si/${a.artist_id}" class="d-flex align-items-center mb-2 text-decoration-none text-dark p-2 rounded" style="transition: 0.2s; background: #f8f9fa;">
                                    <img src="${imgSrc}" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 12px; object-fit: cover;">
                                    <div class="fw-bold">${a.artist_name}</div>
                                </a>`;
                            });
                        }

                        // Render Bài hát
                        if(res.songs && res.songs.length > 0) {
                            html += `<div style="font-size: 13px; font-weight: bold; color: #888; margin-top: 15px; margin-bottom: 10px; text-transform: uppercase;">Bài hát</div>`;
                            res.songs.forEach(s => {
                                let imgSrc = s.song_image ? `/images/${s.song_image}` : '/images/default.png';
                                html += `
                                <div class="d-flex align-items-center mb-2 p-2 rounded live-song-item" style="cursor:pointer; transition: 0.2s; background: #f8f9fa;" data-id="${s.song_id}">
                                    <img src="${imgSrc}" style="width: 40px; height: 40px; border-radius: 6px; margin-right: 12px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold" style="font-size: 14px;">${s.song_name}</div>
                                        <div class="text-muted" style="font-size: 12px;">${s.artist_name}</div>
                                    </div>
                                </div>`;
                            });
                        }

                        if(html === '') html = '<div class="text-center text-muted py-3">Không tìm thấy kết quả</div>';
                        dropdown.html(html).fadeIn();
                    }
                });
            }, 300);
        });

        // Ẩn dropdown khi click ra ngoài
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#searchBoxGlobal').length) dropdown.fadeOut();
        });


        // Chốt chặn cho `.live-song-item` trong dropdown search (dùng data-id)
        $(document).on('click', '.live-song-item', function(e) {
        console.log("CLICKED");
        console.log("isLogged:", window.isLogged);
        e.preventDefault();
        e.stopPropagation();

        dropdown.fadeOut();

        if(!window.isLogged) {
            console.log("SHOW MODAL");
            showRequireLoginModal();
        } else {
            window.location.href = '/music/bai-hat/' + $(this).data('id');
        }
    });

    $(document).on('click', 'a[href^="/music/bai-hat/"]', function(e) {
    if (!window.isLogged) {
        e.preventDefault();
        showRequireLoginModal();
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

        function playSongNow() {
    if (currentPlaySongId) {
        window.location.href = '/music/bai-hat/' + currentPlaySongId;
    }
}

function showRequireLoginModal() {
    let modalEl = document.getElementById('requireLoginModal');

    if (!modalEl) {
        console.error("KHÔNG TÌM THẤY MODAL!");
        return;
    }

    let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}

        
    </script>
</body>
</html>