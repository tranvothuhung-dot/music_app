@props(['title' => config('app.name', 'MusicApp') . ' - Admin'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWix+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkR4j8NWT9fpmjHtk8K+q4M7gJxR8VJ6Yx8g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --admin-bg: #eceef3;
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --text: #2e3440;
            --muted: #7f8796;
            --primary: #ff4d8b;
            --primary-soft: #ffd4e5;
            --border: #e5e8ef;
            --shadow: 0 10px 25px rgba(20, 26, 40, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Nunito', sans-serif;
            font-weight: 600;
            color: var(--text);
            background: linear-gradient(145deg, #f2f4f8, #e7ebf2);
            min-height: 100vh;
        }

        .admin-shell {
            display: grid;
            grid-template-columns: 250px minmax(0, 1fr);
            min-height: 100vh;
        }

        .admin-sidebar {
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            padding: 22px 16px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 6px 8px 24px;
            color: var(--primary);
            font-weight: 800;
            font-size: 34px;
            letter-spacing: 0.2px;
            text-decoration: none;
        }

        .brand i {
            font-size: 22px;
        }

        .menu-title {
            margin: 0 12px 12px;
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            margin: 0 4px;
            border-radius: 999px;
            text-decoration: none;
            color: var(--text);
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .menu-item:hover {
            background: #f6f8fb;
            transform: translateX(2px);
        }

        .menu-item.active {
            color: #fff;
            background: linear-gradient(135deg, #ff5b96, #ff3f83);
            box-shadow: 0 8px 20px rgba(255, 77, 139, 0.35);
        }

        .menu-item i {
            width: 18px;
            text-align: center;
        }

        .admin-main {
            padding: 22px;
        }

        .topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 16px;
            position: relative;
        }

        .user-dropdown {
            position: relative;
        }

        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--border);
            box-shadow: 0 5px 14px rgba(33, 38, 54, 0.06);
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .user-chip:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 20px rgba(255, 77, 139, 0.15);
        }

        .user-chip img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }

        .dropdown-chevron {
            display: inline-block;
            margin-left: 2px;
            color: var(--primary);
            font-size: 12px;
            font-weight: bold;
            transition: transform 0.2s ease;
        }

        .user-chip.active .dropdown-chevron {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(22, 28, 45, 0.12);
            min-width: 200px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.15s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-family: inherit;
        }

        .dropdown-item:first-child {
            border-radius: 12px 12px 0 0;
        }

        .dropdown-item:last-child {
            border-radius: 0 0 12px 12px;
        }

        .dropdown-item:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
        }

        .banner-card {
            overflow: hidden;
            border-radius: 22px;
            background: var(--card-bg);
            box-shadow: var(--shadow);
            border: 1px solid #e8ebf3;
        }

        .banner-card img {
            width: 100%;
            height: 340px;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 1024px) {
            .admin-shell {
                grid-template-columns: 86px minmax(0, 1fr);
            }

            .brand span,
            .menu-title,
            .menu-item span {
                display: none;
            }

            .menu-item {
                justify-content: center;
                border-radius: 16px;
                padding: 12px;
            }
        }

        @media (max-width: 768px) {
            .admin-shell {
                grid-template-columns: 1fr;
            }

            .admin-sidebar {
                position: static;
                height: auto;
                border-right: 0;
                border-bottom: 1px solid var(--border);
                padding-bottom: 12px;
            }

            .brand span,
            .menu-title,
            .menu-item span {
                display: inline;
            }

            .menu-list {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .menu-item {
                border-radius: 12px;
                justify-content: flex-start;
            }

            .admin-main {
                padding: 16px;
            }

            .banner-card img {
                height: 220px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
@php
    $menuItems = [
        [
            'label' => 'Dashboard',
            'icon' => 'fa-solid fa-chart-pie',
            'url' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'label' => 'Người Dùng',
            'icon' => 'fa-solid fa-users',
            'url' => route('admin.users.index'),
            'active' => request()->routeIs('admin.users.*'),
        ],
        [
            'label' => 'Nghệ Sĩ',
            'icon' => 'fa-solid fa-microphone-lines',
            'url' => route('admin.artists.index'),
            'active' => request()->routeIs('admin.artists.*'),
        ],
        [
            'label' => 'Albums',
            'icon' => 'fa-solid fa-compact-disc',
            'url' => route('admin.albums.index'),
            'active' => request()->routeIs('admin.albums.*'),
        ],
        [
            'label' => 'Thể Loại',
            'icon' => 'fa-solid fa-tags',
            'url' => route('admin.genres.index'),
            'active' => request()->routeIs('admin.genres.*'),
        ],
        [
            'label' => 'Bài Hát',
            'icon' => 'fa-solid fa-music',
            'url' => route('admin.songs.index'),
            'active' => request()->routeIs('admin.songs.*'),
        ],
        [
            'label' => 'Tin Tức',
            'icon' => 'fa-solid fa-newspaper',
            'url' => route('admin.news.index'),
            'active' => request()->routeIs('admin.news.*'),
        ],
    ];
@endphp

<div class="admin-shell">
    <aside class="admin-sidebar">
        <a class="brand" href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}">
            <i class="fas fa-circle-play"></i>
            <span>MusicApp</span>
        </a>

        <p class="menu-title">Menu quản lý</p>

        <nav class="menu-list" aria-label="Admin menu">
            @foreach($menuItems as $item)
                <a href="{{ $item['url'] }}" class="menu-item {{ $item['active'] ? 'active' : '' }}">
                    <i class="{{ $item['icon'] }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </aside>

    <section class="admin-main">
        <header class="topbar">
            <div class="user-dropdown">
                <button class="user-chip" id="userChipBtn" type="button">
                    <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                    <img src="{{ asset('images/admin.png') }}" alt="Admin avatar">
                    <span class="dropdown-chevron">▼</span>
                </button>
                <div class="dropdown-menu" id="dropdownMenu">
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-arrow-right-from-bracket" style="color: #ff4d8b;"></i>
                            <span>Đăng xuất</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="banner-card">
            <img src="{{ asset('images/banner.png') }}" alt="Admin banner">
        </div>

        {{ $slot ?? '' }}
    </section>
</div>

<script>
    const userChipBtn = document.getElementById('userChipBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');

    userChipBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        userChipBtn.classList.toggle('active');
        dropdownMenu.classList.toggle('show');
    });

    document.addEventListener('click', function(event) {
        const userDropdown = document.querySelector('.user-dropdown');
        if (!userDropdown.contains(event.target)) {
            userChipBtn.classList.remove('active');
            dropdownMenu.classList.remove('show');
        }
    });
</script>

@stack('scripts')
</body>
</html>
