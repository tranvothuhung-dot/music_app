@props(['title'])
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link rel="stylesheet" href="{{asset('library/bootstrap.min.css')}}">

    <script src="{{asset('library/jquery.slim.min.js')}}"></script>
    <script src="{{asset('library/popper.min.js')}}"></script>
    <script src="{{asset('library/bootstrap.bundle.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="{{asset('library/jquery-3.7.1.js')}}" ></script>
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
            font-size: 14px;
        }

        .container {
            max-width: 1200px;
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

        /* ----- CSS MỚI CHO NÚT ĐĂNG NHẬP / ĐĂNG KÝ ----- */
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
                        <li class="nav-item"><a class="nav-link" href="{{ url('/music') }}">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/music/bai-hat') }}">Bài hát</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/music/album') }}">Album</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/music/nghe-si') }}">Nghệ sĩ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/music/tin-tuc') }}">Tin tức</a></li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        <div class="search-container d-none d-lg-block">
                            <i class="fas fa-search search-icon"></i>
                            <input class="search-input" type="text" name="keyword" placeholder="Tìm kiếm bài hát...">
                        </div>
                        <div class="auth-buttons d-flex align-items-center">
                            @guest
                                <a href="{{ route('login') }}" class="btn-auth btn-login">Đăng nhập</a>
                                <a href="{{ route('register') }}" class="btn-auth btn-register">Đăng ký</a>
                            @else
                                <div class="dropdown">
                                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                                        <img src="{{ asset('images/default.png') }}" class="user-avatar me-2" alt="Avatar">
                                        <span class="fw-bold text-dark d-none d-lg-block text-truncate" style="max-width: 100px;">{{ Auth::user()->full_name ?? Auth::user()->username }}</span>
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
        <div class="banner-wrapper">
            <img src="{{asset('images/banner.png')}}" alt="Banner">
        </div>
    </header>
    <main>
        {{$slot}}
    </main>

</body>
</html>