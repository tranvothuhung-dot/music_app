<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicApp - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-color: #ff4081; }
        .text-primary { color: var(--primary-color) !important; }
        .bg-primary { background-color: var(--primary-color) !important; }
        body { padding-bottom: 150px !important; }
        
        /* Layout & Card */
        .sidebar-sticky { position: sticky; top: 90px; height: calc(100vh - 110px); overflow-y: auto; border-right: 1px solid #eee; padding-right: 15px;}
        .section-title { font-weight: 700; border-left: 5px solid var(--primary-color); padding-left: 15px; margin-bottom: 25px; }
        .custom-card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); height: 100%; transition: all 0.3s; }
        .custom-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
        .card-img-wrapper { position: relative; overflow: hidden; border-radius: 15px 15px 0 0; aspect-ratio: 1/1; }
        .card-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .custom-card:hover .card-img-wrapper img { transform: scale(1.08); }
        
        /* Nút Play Overlay */
        .play-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; opacity: 0; transition: 0.3s; }
        .custom-card:hover .play-overlay { opacity: 1; }
        .btn-play-circle { width: 50px; height: 50px; border-radius: 50%; background: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; border: none; font-size: 1.2rem; }
        
        /* Sidebar items */
        .sidebar-shell {
            background: #f4f5f8;
            border: 1px solid #eceef3;
            border-radius: 22px;
            padding: 16px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.75);
        }

        .library-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .library-plus-btn {
            width: 30px;
            height: 30px;
            border: 0;
            border-radius: 50%;
            background: #4b5563;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: 0.2s ease;
        }

        .library-plus-btn:hover {
            background: #374151;
            transform: translateY(-1px);
        }

        .library-card {
            width: 100%;
            border: 0;
            text-decoration: none;
            border-radius: 14px;
            padding: 12px;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #ff3f86 0%, #ff6fa8 100%);
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 18px rgba(255, 64, 129, 0.22);
            transition: 0.2s ease;
        }

        .library-card[aria-expanded="true"] {
            outline: 2px solid #1f2937;
            outline-offset: 0;
        }

        .library-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 22px rgba(255, 64, 129, 0.28);
        }

        .library-card-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.24);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .library-card-text {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .library-card-title {
            font-size: 1.02rem;
            font-weight: 800;
            line-height: 1.05;
            text-align: left;
        }

        .library-card-sub {
            margin-top: 4px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.92);
            text-align: left;
        }

        .library-toggle {
            justify-content: space-between;
        }

        .library-toggle .library-card-right {
            margin-left: auto;
            color: rgba(255,255,255,0.95);
            font-size: 0.85rem;
            transition: transform 0.2s ease;
        }

        .library-toggle[aria-expanded="true"] .library-card-right {
            transform: rotate(180deg);
        }

        .library-collapse {
            margin: -2px 0 10px;
            padding-left: 2px;
            padding-right: 2px;
        }

        .queue-song {
            border: 0;
            border-radius: 10px;
            padding: 8px 10px;
            background: #f5f6f8;
            transition: 0.2s ease;
            width: 100%;
            text-align: left;
            margin-bottom: 7px;
            box-shadow: 0 1px 2px rgba(17, 24, 39, 0.07);
            color: #374151;
        }

        .queue-song-wrap {
            position: relative;
            margin-bottom: 7px;
        }

        .liked-song-wrap {
            position: relative;
            margin-bottom: 7px;
        }

        .liked-song-play {
            width: 100%;
            border: 0;
            border-radius: 10px;
            padding: 8px 44px 8px 10px;
            background: #f5f6f8;
            transition: 0.2s ease;
            text-align: left;
            box-shadow: 0 1px 2px rgba(17, 24, 39, 0.07);
            color: #374151;
        }

        .liked-song-wrap:hover .liked-song-play {
            transform: translateY(-1px);
            background: #eef1f6;
            box-shadow: 0 4px 10px rgba(17, 24, 39, 0.1);
        }

        .liked-song-menu-btn {
            position: absolute;
            top: 50%;
            right: 8px;
            transform: translateY(-50%);
            border: 0;
            width: 26px;
            height: 26px;
            border-radius: 8px;
            background: transparent;
            color: #6b7280;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s ease;
        }

        .liked-song-menu-btn:hover {
            background: rgba(17, 24, 39, 0.08);
            color: #374151;
        }

        .liked-song-dropdown {
            min-width: 185px;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.18);
            padding: 8px;
        }

        .liked-song-dropdown .dropdown-item {
            border-radius: 8px;
            font-weight: 600;
            color: #ef4444;
        }

        .liked-song-dropdown .dropdown-item:hover {
            background: #fff1f2;
            color: #dc2626;
        }

        .queue-song-play {
            width: 100%;
            border: 0;
            border-radius: 10px;
            padding: 8px 44px 8px 10px;
            background: #f5f6f8;
            transition: 0.2s ease;
            text-align: left;
            box-shadow: 0 1px 2px rgba(17, 24, 39, 0.07);
            color: #374151;
        }

        .queue-song-wrap:hover .queue-song-play {
            transform: translateY(-1px);
            background: #eef1f6;
            box-shadow: 0 4px 10px rgba(17, 24, 39, 0.1);
        }

        .queue-song-menu-btn {
            position: absolute;
            top: 50%;
            right: 8px;
            transform: translateY(-50%);
            border: 0;
            width: 26px;
            height: 26px;
            border-radius: 8px;
            background: transparent;
            color: #6b7280;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s ease;
        }

        .queue-song-menu-btn:hover {
            background: rgba(17, 24, 39, 0.08);
            color: #374151;
        }

        .queue-song-dropdown {
            min-width: 170px;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.18);
            padding: 8px;
        }

        .queue-song-dropdown .dropdown-item {
            border-radius: 8px;
            font-weight: 600;
            color: #ef4444;
        }

        .queue-song-dropdown .dropdown-item:hover {
            background: #fff1f2;
            color: #dc2626;
        }

        .queue-song:hover {
            transform: translateY(-1px);
            background: #eef1f6;
            box-shadow: 0 4px 10px rgba(17, 24, 39, 0.1);
        }

        .queue-song .fw-semibold {
            color: #111827;
        }

        .queue-song .sidebar-subtitle {
            color: #6b7280;
        }

        .history-status {
            font-size: 0.78rem;
            color: #9aa2af;
            line-height: 1.1;
            margin-top: 3px;
        }

        .queue-song.active-song {
            background: linear-gradient(135deg, #ff4081 0%, #ff80ab 100%);
            color: white;
            box-shadow: 0 10px 22px rgba(255, 64, 129, 0.22);
        }

        .queue-song-wrap.active-song .queue-song-play {
            background: linear-gradient(135deg, #ff4081 0%, #ff80ab 100%);
            color: white;
            box-shadow: 0 10px 22px rgba(255, 64, 129, 0.22);
        }

        .liked-song-wrap.active-song .liked-song-play {
            background: linear-gradient(135deg, #ff4081 0%, #ff80ab 100%);
            color: white;
            box-shadow: 0 10px 22px rgba(255, 64, 129, 0.22);
        }

        .queue-song-wrap.active-song .queue-song-menu-btn {
            color: rgba(255, 255, 255, 0.92);
            background: rgba(255, 255, 255, 0.18);
        }

        .liked-song-wrap.active-song .liked-song-menu-btn {
            color: rgba(255, 255, 255, 0.92);
            background: rgba(255, 255, 255, 0.18);
        }

        .queue-song-wrap.active-song .queue-song-menu-btn:hover {
            background: rgba(255, 255, 255, 0.26);
            color: #fff;
        }

        .liked-song-wrap.active-song .liked-song-menu-btn:hover {
            background: rgba(255, 255, 255, 0.26);
            color: #fff;
        }

        .queue-song.active-song .text-muted,
        .queue-song.active-song .small,
        .queue-song.active-song .sidebar-subtitle,
        .queue-song.active-song .history-status,
        .queue-song-wrap.active-song .small,
        .queue-song-wrap.active-song .sidebar-subtitle,
        .liked-song-wrap.active-song .small,
        .liked-song-wrap.active-song .sidebar-subtitle {
            color: rgba(255, 255, 255, 0.78) !important;
        }

        .queue-clear-btn {
            border: 0;
            background: transparent;
            color: #ef4444;
            font-weight: 600;
            padding: 2px 0;
            margin-top: 6px;
        }

        .queue-clear-btn:hover {
            color: #dc2626;
        }

        .section-divider {
            border-top: 1px solid #dfe3eb;
            margin: 14px 0;
        }

        .playlist-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #616975;
            margin-bottom: 10px;
        }

        .playlist-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px;
            border-radius: 14px;
            background: linear-gradient(135deg, #ff3f86 0%, #ff6fa8 100%);
            color: #fff;
            text-decoration: none;
            box-shadow: 0 8px 18px rgba(255, 64, 129, 0.22);
            margin-bottom: 10px;
        }

        .playlist-chip:hover {
            color: #fff;
            transform: translateY(-1px);
        }

        .playlist-chip-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.22);
            flex-shrink: 0;
        }

        .playlist-chip-name {
            font-weight: 800;
            flex-grow: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .playlist-chip-menu {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .playlist-chip-wrap {
            position: relative;
            margin-bottom: 10px;
        }

        .playlist-chip {
            margin-bottom: 0;
            width: 100%;
            border: 0;
            text-align: left;
        }

        .playlist-chip-menu-btn {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            border: 0;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: transparent;
            color: rgba(255, 255, 255, 0.92);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s ease;
        }

        .playlist-chip-menu-btn:hover {
            background: rgba(255, 255, 255, 0.22);
            color: #fff;
        }

        .playlist-dropdown {
            min-width: 170px;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.18);
            padding: 8px;
        }

        .playlist-dropdown .dropdown-item {
            border-radius: 8px;
            font-weight: 600;
            color: #ef4444;
        }

        .playlist-dropdown .dropdown-item:hover {
            background: #fff1f2;
            color: #dc2626;
        }

        .action-toast {
            position: fixed;
            right: 18px;
            bottom: 126px;
            z-index: 1200;
            border-radius: 12px;
            padding: 10px 14px;
            box-shadow: 0 14px 30px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateY(8px);
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.2s ease;
            font-size: 0.92rem;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 220px;
            max-width: 320px;
            border: 1px solid transparent;
            background: #111827;
            color: #fff;
        }

        .action-toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .action-toast.info {
            background: #1f2937;
            border-color: #374151;
        }

        .action-toast.success {
            background: #0f766e;
            border-color: #14b8a6;
        }

        .action-toast.error {
            background: #b42318;
            border-color: #f04438;
        }

        .action-toast-icon {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.2);
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .action-toast-text {
            line-height: 1.25;
        }
        
        /* Player dưới cùng */
        .player-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            min-height: 110px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-top: 1px solid #eee;
            z-index: 1050;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
        }

        .song-card {
            cursor: pointer;
        }

        .song-card.active-song {
            outline: 2px solid rgba(255, 64, 129, 0.35);
            box-shadow: 0 18px 30px rgba(255, 64, 129, 0.12);
        }

        .song-card .btn-song-menu {
            opacity: 0.7;
        }

        .song-card:hover .btn-song-menu {
            opacity: 1;
        }

        .song-card .dropdown-menu {
            min-width: 240px;
        }

        .player-cover {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .player-meta {
            min-width: 0;
        }

        .player-title {
            font-weight: 800;
            line-height: 1.15;
        }

        .player-artist {
            font-size: 0.85rem;
        }

        .player-control-btn {
            border: 0;
            background: transparent;
            color: #222;
            font-size: 1rem;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            transition: 0.2s ease;
        }

        .player-control-btn:hover {
            background: #f3f4f6;
        }

        .player-control-btn.primary {
            width: 52px;
            height: 52px;
            background: var(--primary-color);
            color: white;
            box-shadow: 0 10px 24px rgba(255, 64, 129, 0.25);
        }

        .player-control-btn.primary:hover {
            background: #e83274;
        }

        .player-progress,
        .player-volume {
            accent-color: var(--primary-color);
        }

        @media (max-width: 991.98px) {
            .player-bar {
                padding-top: 14px;
                padding-bottom: 14px;
            }

            .player-left,
            .player-right {
                width: 100% !important;
            }

            .player-center {
                width: 100%;
                order: 3;
            }

            .player-right {
                justify-content: space-between !important;
            }
        }

        /* Top bar + search */
        .top-nav-inner {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .top-nav-brand {
            margin-right: 6px;
            font-size: 2.15rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .top-nav-menu {
            display: flex;
            align-items: center;
            gap: 4px;
            flex-wrap: nowrap;
            margin-right: 8px;
        }

        .top-menu-link {
            text-decoration: none;
            color: #52525b;
            font-weight: 700;
            font-size: 1.02rem;
            padding: 10px 16px;
            border-radius: 999px;
            line-height: 1;
            transition: 0.2s ease;
            white-space: nowrap;
        }

        .top-menu-link:hover {
            color: #1f2937;
            background: #f3f4f6;
        }

        .top-menu-link.active {
            background: linear-gradient(135deg, #ff4081 0%, #ff5f9a 100%);
            color: #fff;
            box-shadow: 0 8px 20px rgba(255, 64, 129, 0.35);
        }

        .top-search-form {
            flex: 1 1 300px;
            min-width: 240px;
            max-width: 340px;
            margin: 0;
        }

        .top-search-form .input-group {
            background: #eceff3;
            border: 1px solid #eceff3;
            border-radius: 999px;
            overflow: hidden;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .top-search-form .input-group:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 64, 129, 0.15);
            background: #fff;
        }

        .top-search-form .input-group-text {
            background: transparent;
            border: 0;
            color: #64748b;
            padding-left: 14px;
        }

        .top-search-form .form-control {
            border: 0;
            background: transparent;
            box-shadow: none;
            height: 40px;
            font-size: 0.98rem;
        }

        .top-search-form .form-control:focus {
            box-shadow: none;
            background: transparent;
        }

        .top-nav-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .top-nav-user {
            font-weight: 700;
            color: #1f2937;
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-logout {
            border-radius: 999px;
            padding: 8px 18px;
            font-weight: 600;
        }

        @media (max-width: 991.98px) {
            .top-nav-brand {
                order: 1;
            }

            .top-nav-menu {
                order: 3;
                width: 100%;
                overflow-x: auto;
                padding-bottom: 2px;
            }

            .top-nav-actions {
                order: 2;
            }

            .top-search-form {
                order: 4;
                flex: 1 1 100%;
                min-width: 0;
                max-width: 100%;
            }

            .top-nav-user {
                max-width: 120px;
                font-size: 0.92rem;
            }
        }
    </style>
</head>
<body class="bg-light pb-5 mb-5">

    <nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm py-3 mb-4">
        <div class="container-fluid px-4 top-nav-inner">
            <a class="navbar-brand text-primary top-nav-brand" href="{{ route('dashboard') }}"><i class="fas fa-play-circle me-2"></i>MusicApp</a>
            <div class="top-nav-menu">
                <a href="{{ route('dashboard') }}" class="top-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Trang chủ</a>
                <a href="{{ route('dashboard.songs') }}" class="top-menu-link {{ request()->routeIs('dashboard.songs') ? 'active' : '' }}">Bài hát</a>
                <a href="{{ route('dashboard.albums') }}" class="top-menu-link {{ request()->routeIs('dashboard.albums') ? 'active' : '' }}">Album</a>
                <a href="{{ route('dashboard.artists') }}" class="top-menu-link {{ request()->routeIs('dashboard.artists') ? 'active' : '' }}">Nghệ sĩ</a>
                <a href="{{ route('music.index') }}" class="top-menu-link {{ request()->routeIs('music.index') ? 'active' : '' }}">Thể loại</a>
                <a href="{{ route('dashboard.news') }}" class="top-menu-link {{ request()->routeIs('dashboard.news') ? 'active' : '' }}">Tin tức</a>
            </div>
            <form method="POST" action="{{ route('music.search') }}" class="top-search-form">
                @csrf
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input
                        type="text"
                        name="keyword"
                        class="form-control"
                        placeholder="Tìm bài hát, ca sĩ..."
                        value="{{ old('keyword') }}"
                    >
                </div>
            </form>
            <div class="top-nav-actions">
                <span class="top-nav-user d-none d-xl-inline">{{ Auth::user()->full_name ?? Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm btn-logout">Đăng xuất</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-lg-3 d-none d-lg-block">
                <div class="sidebar-sticky">
                    <div class="sidebar-shell">
                        <div class="library-head">
                            <h5 class="m-0 fw-bold text-secondary"><i class="fas fa-book-open me-2"></i>My Library</h5>
                            <button type="button" class="library-plus-btn" title="Tạo playlist mới">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <button type="button" class="library-card" data-bs-toggle="collapse" data-bs-target="#likedSongsCollapse" aria-expanded="false" aria-controls="likedSongsCollapse">
                            <span class="library-card-icon"><i class="fas fa-heart"></i></span>
                            <span class="library-card-text">
                                <span class="library-card-title">Liked Songs</span>
                                <span id="liked-songs-count" class="library-card-sub">{{ $count_liked }} bài hát</span>
                            </span>
                        </button>
                        <div class="collapse library-collapse" id="likedSongsCollapse">
                            <div id="liked-songs-list">
                                @foreach($liked_songs as $likedSong)
                                    <div class="liked-song-wrap" data-liked-item data-song-id="{{ $likedSong->song_id }}">
                                        <button type="button" class="liked-song-play d-flex align-items-center gap-3" data-queue-song data-song-id="{{ $likedSong->song_id }}">
                                            <span class="fw-bold small" style="width: 28px;">&hearts;</span>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <div class="fw-semibold text-truncate">{{ $likedSong->song_name }}</div>
                                                <div class="sidebar-subtitle text-truncate">{{ $likedSong->artist_name }}</div>
                                            </div>
                                        </button>
                                        <button type="button" class="liked-song-menu-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-liked-menu>
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end liked-song-dropdown">
                                            <li>
                                                <button type="button" class="dropdown-item" data-liked-remove data-song-id="{{ $likedSong->song_id }}">
                                                    <i class="fas fa-heart-crack me-2"></i>Xóa khỏi yêu thích
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                            <div id="liked-songs-empty" class="small text-muted px-2 py-2 {{ $liked_songs->isNotEmpty() ? 'd-none' : '' }}">Chưa có bài hát yêu thích.</div>
                        </div>

                        <button type="button" class="library-card library-toggle" data-bs-toggle="collapse" data-bs-target="#queueSongsCollapse" aria-expanded="false" aria-controls="queueSongsCollapse">
                            <span class="d-flex align-items-center gap-2">
                                <span class="library-card-icon"><i class="fas fa-list-ol"></i></span>
                                <span class="library-card-title">Danh sách phát</span>
                            </span>
                            <span class="library-card-right"><i class="fas fa-chevron-down"></i></span>
                        </button>
                        <div class="collapse library-collapse" id="queueSongsCollapse">
                            <div id="queue-songs-list"></div>
                            <div id="queue-songs-empty" class="small text-muted px-2 py-2">Chưa có bài hát nào trong hàng đợi.</div>
                            <button id="queue-clear-all" type="button" class="queue-clear-btn d-none">Xóa hết</button>
                        </div>

                        <button type="button" class="library-card library-toggle" data-bs-toggle="collapse" data-bs-target="#historySongsCollapse" aria-expanded="false" aria-controls="historySongsCollapse">
                            <span class="d-flex align-items-center gap-2">
                                <span class="library-card-icon"><i class="fas fa-history"></i></span>
                                <span class="library-card-title">Lịch sử nghe</span>
                            </span>
                            <span class="library-card-right"><i class="fas fa-chevron-down"></i></span>
                        </button>
                        <div class="collapse library-collapse" id="historySongsCollapse">
                            <div id="history-songs-list">
                                @foreach($history_list as $historySong)
                                    <button type="button" class="queue-song d-flex align-items-center gap-3" data-queue-song data-song-id="{{ $historySong->song_id }}">
                                        <img src="{{ asset('images/'.$historySong->song_image) }}" width="34" height="34" class="rounded object-fit-cover" alt="{{ $historySong->song_name }}">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="fw-semibold text-truncate">{{ $historySong->song_name }}</div>
                                            <div class="sidebar-subtitle text-truncate">{{ $historySong->artist_name }}</div>
                                            <div class="history-status text-truncate"><i class="far fa-clock me-1"></i>Vừa xong</div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                            <div id="history-songs-empty" class="small text-muted px-2 py-2 {{ $history_list->isNotEmpty() ? 'd-none' : '' }}">Chưa có lịch sử.</div>
                        </div>

                        <hr class="section-divider">

                        <h6 class="playlist-title">Playlist của bạn</h6>
                        <div id="my-playlist-list">
                        @forelse($my_playlists as $playlist)
                            <div class="playlist-chip-wrap" data-playlist-item data-playlist-id="{{ $playlist->playlist_id }}">
                                <button type="button" class="playlist-chip">
                                    <span class="playlist-chip-icon"><i class="fas fa-music"></i></span>
                                    <span class="playlist-chip-name">{{ $playlist->playlist_name }}</span>
                                </button>
                                <button
                                    type="button"
                                    class="playlist-chip-menu-btn dropdown-toggle"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    data-playlist-menu
                                >
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end playlist-dropdown">
                                    <li>
                                        <button type="button" class="dropdown-item" data-playlist-remove data-playlist-id="{{ $playlist->playlist_id }}">
                                            <i class="fas fa-trash me-2"></i>Xóa Playlist
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        @empty
                            <div id="my-playlist-empty" class="small text-muted py-2 px-1">Chưa có playlist nào.</div>
                        @endforelse
                        </div>
                        @if($my_playlists->isNotEmpty())
                            <div id="my-playlist-empty" class="small text-muted py-2 px-1 d-none">Chưa có playlist nào.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-12">
                @yield('content')
            </div>
        </div>
    </div>

    <div class="player-bar d-flex align-items-center px-4 gap-3 flex-wrap">
        <div class="player-left d-flex align-items-center gap-3 w-25">
            <img id="player-cover" src="{{ asset('images/default_song.png') }}" class="player-cover" alt="Ảnh bài hát">
            <div class="player-meta overflow-hidden">
                <div id="player-song-title" class="player-title text-truncate">Chọn bài hát</div>
                <div id="player-song-artist" class="player-artist text-muted text-truncate">...</div>
            </div>
            <button id="btn-like-current" type="button" class="player-control-btn ms-auto" title="Yêu thích">
                <i class="far fa-heart"></i>
            </button>
        </div>

        <div class="player-center flex-grow-1 text-center">
            <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                <button id="btn-shuffle" type="button" class="player-control-btn" title="Trộn bài">
                    <i class="fas fa-random"></i>
                </button>
                <button id="btn-prev" type="button" class="player-control-btn" title="Bài trước">
                    <i class="fas fa-backward-step"></i>
                </button>
                <button id="btn-play-pause" type="button" class="player-control-btn primary" title="Phát/Tạm dừng">
                    <i class="fas fa-play"></i>
                </button>
                <button id="btn-next" type="button" class="player-control-btn" title="Bài kế tiếp">
                    <i class="fas fa-forward-step"></i>
                </button>
                <button id="btn-repeat" type="button" class="player-control-btn" title="Lặp lại">
                    <i class="fas fa-rotate-right"></i>
                </button>
            </div>
            <div class="d-flex align-items-center gap-2 px-lg-5 px-0">
                <span id="player-current-time" class="small text-muted">0:00</span>
                <input id="player-progress" type="range" class="form-range player-progress flex-grow-1 mb-0" min="0" max="100" value="0">
                <span id="player-duration" class="small text-muted">0:00</span>
            </div>
        </div>

        <div class="player-right w-25 d-flex justify-content-end align-items-center gap-3">
            <i class="fas fa-volume-up text-muted"></i>
            <input id="player-volume" type="range" class="form-range player-volume mb-0" min="0" max="100" value="80" style="width: 110px;">
        </div>
    </div>

    <div id="action-toast" class="action-toast" role="status" aria-live="polite"></div>

    <audio id="music-audio" preload="metadata"></audio>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const songs = [];
            const songCatalog = @json($js_data['queue'] ?? []);
            const likedSongIds = new Set(@json($liked_songs->pluck('song_id')->values()));
            const toggleFavoriteUrl = @json(route('dashboard.favorites.toggle'));
            const addHistoryUrl = @json(route('dashboard.history.add'));
            const deletePlaylistUrl = @json(route('dashboard.playlists.delete'));
            const albumsPageUrl = @json(route('dashboard.albums'));
            const artistsPageUrl = @json(route('dashboard.artists'));
            const csrfToken = @json(csrf_token());

            const audio = document.getElementById('music-audio');
            const cover = document.getElementById('player-cover');
            const title = document.getElementById('player-song-title');
            const artist = document.getElementById('player-song-artist');
            const playPauseButton = document.getElementById('btn-play-pause');
            const shuffleButton = document.getElementById('btn-shuffle');
            const prevButton = document.getElementById('btn-prev');
            const nextButton = document.getElementById('btn-next');
            const repeatButton = document.getElementById('btn-repeat');
            const likeButton = document.getElementById('btn-like-current');
            const progress = document.getElementById('player-progress');
            const currentTimeLabel = document.getElementById('player-current-time');
            const durationLabel = document.getElementById('player-duration');
            const volumeRange = document.getElementById('player-volume');
            const actionToast = document.getElementById('action-toast');
            const likedSongsCount = document.getElementById('liked-songs-count');
            const likedSongsList = document.getElementById('liked-songs-list');
            const queueSongsList = document.getElementById('queue-songs-list');
            const historySongsList = document.getElementById('history-songs-list');
            const likedSongsEmpty = document.getElementById('liked-songs-empty');
            const queueSongsEmpty = document.getElementById('queue-songs-empty');
            const historySongsEmpty = document.getElementById('history-songs-empty');
            const queueClearAllButton = document.getElementById('queue-clear-all');
            const playlistContainer = document.getElementById('my-playlist-list');
            const playlistEmpty = document.getElementById('my-playlist-empty');

            let currentIndex = 0;
            let shuffleEnabled = false;
            let repeatMode = 'all';
            let toastTimer = null;
            let lastHistorySongId = null;

            function showToast(message, type = 'info') {
                if (!actionToast) {
                    return;
                }

                const iconMap = {
                    success: 'fa-check',
                    error: 'fa-xmark',
                    info: 'fa-circle-info',
                };
                const iconClass = iconMap[type] || iconMap.info;

                actionToast.classList.remove('info', 'success', 'error');
                actionToast.classList.add(type);
                actionToast.innerHTML = `<span class="action-toast-icon"><i class="fas ${iconClass}"></i></span><span class="action-toast-text">${message}</span>`;
                actionToast.classList.add('show');

                if (toastTimer) {
                    window.clearTimeout(toastTimer);
                }

                toastTimer = window.setTimeout(function () {
                    actionToast.classList.remove('show');
                }, 1800);
            }

            function buildSongLink(songId) {
                const url = new URL(window.location.href);
                url.searchParams.set('song_id', songId);

                return url.toString();
            }

            function getCardDataFromElement(element) {
                const card = element?.closest('[data-song-card]');

                if (!card) {
                    return null;
                }

                return {
                    song_id: Number(card.dataset.songId || 0),
                    song_name: card.dataset.songName || '',
                    artist_name: card.dataset.songArtist || '',
                    song_image: (card.dataset.songImage || '').split('/').pop(),
                    song_url: card.dataset.songUrl || '',
                    duration: Number(card.dataset.songDuration || 0),
                    album_id: Number(card.dataset.songAlbumId || 0),
                    artist_id: Number(card.dataset.songArtistId || 0),
                };
            }

            function getSongById(songId, sourceElement = null) {
                const normalizedId = Number(songId);
                let song = songs.find(function (item) {
                    return Number(item.song_id) === normalizedId;
                });

                if (song) {
                    return song;
                }

                song = songCatalog.find(function (item) {
                    return Number(item.song_id) === normalizedId;
                });

                if (song) {
                    return song;
                }

                song = getCardDataFromElement(sourceElement);

                if (song && Number(song.song_id) === normalizedId) {
                    return song;
                }

                return null;
            }

            function getSongIndex(songId) {
                return songs.findIndex(function (item) {
                    return Number(item.song_id) === Number(songId);
                });
            }

            function ensureSongInQueue(song) {
                const existingIndex = getSongIndex(song.song_id);

                if (existingIndex > -1) {
                    return { index: existingIndex, added: false };
                }

                songs.push(song);

                return { index: songs.length - 1, added: true };
            }

            function createSidebarSongButton(song, type, index) {
                if (type === 'queue') {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'queue-song-wrap';
                    wrapper.dataset.queueItem = '';
                    wrapper.dataset.songId = String(song.song_id);

                    const playButton = document.createElement('button');
                    playButton.type = 'button';
                    playButton.className = 'queue-song-play d-flex align-items-center gap-3';
                    playButton.setAttribute('data-queue-song', '');
                    playButton.dataset.songId = String(song.song_id);

                    const left = document.createElement('span');
                    left.className = 'fw-bold small';
                    left.style.width = '28px';
                    left.textContent = String(index + 1).padStart(2, '0');

                    const content = document.createElement('div');
                    content.className = 'flex-grow-1 overflow-hidden';

                    const songName = document.createElement('div');
                    songName.className = 'fw-semibold text-truncate';
                    songName.textContent = song.song_name || 'Unknown';

                    const artistName = document.createElement('div');
                    artistName.className = 'sidebar-subtitle text-truncate';
                    artistName.textContent = song.artist_name || '';

                    const menuButton = document.createElement('button');
                    menuButton.type = 'button';
                    menuButton.className = 'queue-song-menu-btn dropdown-toggle';
                    menuButton.dataset.bsToggle = 'dropdown';
                    menuButton.dataset.songId = String(song.song_id);
                    menuButton.setAttribute('aria-expanded', 'false');
                    menuButton.setAttribute('data-queue-menu', '');
                    menuButton.innerHTML = '<i class="fas fa-ellipsis-v"></i>';

                    const menu = document.createElement('ul');
                    menu.className = 'dropdown-menu dropdown-menu-end queue-song-dropdown';
                    menu.innerHTML = `<li><button type="button" class="dropdown-item" data-queue-remove="" data-song-id="${song.song_id}"><i class="fas fa-trash me-2"></i>Xóa khỏi hàng đợi</button></li>`;

                    content.appendChild(songName);
                    content.appendChild(artistName);
                    playButton.appendChild(left);
                    playButton.appendChild(content);
                    wrapper.appendChild(playButton);
                    wrapper.appendChild(menuButton);
                    wrapper.appendChild(menu);

                    return wrapper;
                }

                if (type === 'liked') {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'liked-song-wrap';
                    wrapper.dataset.likedItem = '';
                    wrapper.dataset.songId = String(song.song_id);

                    const playButton = document.createElement('button');
                    playButton.type = 'button';
                    playButton.className = 'liked-song-play d-flex align-items-center gap-3';
                    playButton.setAttribute('data-queue-song', '');
                    playButton.dataset.songId = String(song.song_id);

                    const left = document.createElement('span');
                    left.className = 'fw-bold small';
                    left.style.width = '28px';
                    left.textContent = '\u2665';

                    const content = document.createElement('div');
                    content.className = 'flex-grow-1 overflow-hidden';

                    const songName = document.createElement('div');
                    songName.className = 'fw-semibold text-truncate';
                    songName.textContent = song.song_name || 'Unknown';

                    const artistName = document.createElement('div');
                    artistName.className = 'sidebar-subtitle text-truncate';
                    artistName.textContent = song.artist_name || '';

                    const menuButton = document.createElement('button');
                    menuButton.type = 'button';
                    menuButton.className = 'liked-song-menu-btn dropdown-toggle';
                    menuButton.dataset.bsToggle = 'dropdown';
                    menuButton.dataset.songId = String(song.song_id);
                    menuButton.setAttribute('aria-expanded', 'false');
                    menuButton.setAttribute('data-liked-menu', '');
                    menuButton.innerHTML = '<i class="fas fa-ellipsis-v"></i>';

                    const menu = document.createElement('ul');
                    menu.className = 'dropdown-menu dropdown-menu-end liked-song-dropdown';
                    menu.innerHTML = `<li><button type="button" class="dropdown-item" data-liked-remove="" data-song-id="${song.song_id}"><i class="fas fa-heart-crack me-2"></i>Xóa khỏi yêu thích</button></li>`;

                    content.appendChild(songName);
                    content.appendChild(artistName);
                    playButton.appendChild(left);
                    playButton.appendChild(content);
                    wrapper.appendChild(playButton);
                    wrapper.appendChild(menuButton);
                    wrapper.appendChild(menu);

                    return wrapper;
                }

                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'queue-song d-flex align-items-center gap-3';
                button.setAttribute('data-queue-song', '');
                button.dataset.songId = String(song.song_id);

                const left = document.createElement('span');
                left.className = 'fw-bold small';
                left.style.width = '28px';
                left.textContent = '\u2665';

                const content = document.createElement('div');
                content.className = 'flex-grow-1 overflow-hidden';

                const songName = document.createElement('div');
                songName.className = 'fw-semibold text-truncate';
                songName.textContent = song.song_name || 'Unknown';

                const artistName = document.createElement('div');
                artistName.className = 'sidebar-subtitle text-truncate';
                artistName.textContent = song.artist_name || '';

                content.appendChild(songName);
                content.appendChild(artistName);
                button.appendChild(left);
                button.appendChild(content);

                return button;
            }

            function refreshQueueOrderLabels() {
                if (!queueSongsList) {
                    return;
                }

                queueSongsList.querySelectorAll('[data-queue-item]').forEach(function (item, index) {
                    const left = item.querySelector('span.fw-bold.small');

                    if (left) {
                        left.textContent = String(index + 1);
                    }
                });
            }

            function refreshQueueClearAllVisibility() {
                if (!queueClearAllButton || !queueSongsList) {
                    return;
                }

                queueClearAllButton.classList.toggle('d-none', queueSongsList.children.length === 0);
            }

            function refreshSidebarEmptyStates() {
                if (likedSongsEmpty && likedSongsList) {
                    likedSongsEmpty.classList.toggle('d-none', likedSongsList.children.length > 0);
                }

                if (queueSongsEmpty && queueSongsList) {
                    queueSongsEmpty.classList.toggle('d-none', queueSongsList.children.length > 0);
                }

                refreshQueueClearAllVisibility();

                if (historySongsEmpty && historySongsList) {
                    historySongsEmpty.classList.toggle('d-none', historySongsList.children.length > 0);
                }
            }

            function createHistorySongButton(song) {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'queue-song d-flex align-items-center gap-3';
                button.setAttribute('data-queue-song', '');
                button.dataset.songId = String(song.song_id);

                const image = document.createElement('img');
                image.width = 34;
                image.height = 34;
                image.className = 'rounded object-fit-cover';
                image.alt = song.song_name || 'Song';
                image.src = `${@json(asset('images'))}/${song.song_image || 'default_song.png'}`;
                image.onerror = function () {
                    image.src = 'https://via.placeholder.com/34';
                };

                const content = document.createElement('div');
                content.className = 'flex-grow-1 overflow-hidden';

                const songName = document.createElement('div');
                songName.className = 'fw-semibold text-truncate';
                songName.textContent = song.song_name || 'Unknown';

                const artistName = document.createElement('div');
                artistName.className = 'sidebar-subtitle text-truncate';
                artistName.textContent = song.artist_name || '';

                const status = document.createElement('div');
                status.className = 'history-status text-truncate';
                status.innerHTML = '<i class="far fa-clock me-1"></i>Vừa xong';

                content.appendChild(songName);
                content.appendChild(artistName);
                content.appendChild(status);
                button.appendChild(image);
                button.appendChild(content);

                return button;
            }

            function addSongToHistoryList(song) {
                if (!historySongsList || !song) {
                    return;
                }

                const existing = historySongsList.querySelector(`[data-song-id="${song.song_id}"]`);

                if (existing) {
                    existing.remove();
                }

                const button = createHistorySongButton(song);
                historySongsList.insertBefore(button, historySongsList.firstChild);

                while (historySongsList.children.length > 10) {
                    historySongsList.removeChild(historySongsList.lastChild);
                }

                refreshSidebarEmptyStates();
            }

            function addSongToSidebarList(song, type) {
                const targetList = type === 'liked' ? likedSongsList : queueSongsList;

                if (!targetList || !song) {
                    return;
                }

                const exists = type === 'liked'
                    ? targetList.querySelector(`[data-liked-item][data-song-id="${song.song_id}"]`)
                    : targetList.querySelector(`[data-song-id="${song.song_id}"]`);

                if (exists) {
                    return;
                }

                const button = createSidebarSongButton(song, type, targetList.children.length);
                targetList.insertBefore(button, targetList.firstChild);

                if (type === 'queue') {
                    refreshQueueOrderLabels();
                }

                refreshSidebarEmptyStates();
            }

            function removeSongFromLikedList(songId) {
                if (!likedSongsList) {
                    return;
                }

                const item = likedSongsList.querySelector(`[data-liked-item][data-song-id="${songId}"]`);

                if (item) {
                    item.remove();
                }

                refreshSidebarEmptyStates();
            }

            function refreshLikeActionButtons(songId = null) {
                const selector = songId
                    ? `[data-action="like"][data-song-id="${Number(songId)}"]`
                    : '[data-action="like"]';

                document.querySelectorAll(selector).forEach(function (button) {
                    const liked = likedSongIds.has(Number(button.dataset.songId));

                    button.innerHTML = liked
                        ? '<i class="fas fa-heart-crack me-2 text-danger"></i> Xóa khỏi yêu thích'
                        : '<i class="fas fa-heart me-2 text-danger"></i> Thêm vào yêu thích';
                });
            }

            function removeSongFromQueue(songId) {
                const normalizedSongId = Number(songId);
                const queueIndex = songs.findIndex(function (item) {
                    return Number(item.song_id) === normalizedSongId;
                });

                if (queueIndex === -1) {
                    return;
                }

                songs.splice(queueIndex, 1);

                if (queueSongsList) {
                    const item = queueSongsList.querySelector(`[data-queue-item][data-song-id="${normalizedSongId}"]`);

                    if (item) {
                        item.remove();
                    }
                }

                if (songs.length === 0) {
                    audio.pause();
                    audio.removeAttribute('src');
                    title.textContent = 'Chọn bài hát';
                    artist.textContent = '...';
                    cover.src = @json(asset('images/default_song.png'));
                    playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
                    currentIndex = 0;
                    updateActiveStates(0);
                    refreshQueueOrderLabels();
                    refreshSidebarEmptyStates();
                    return;
                }

                if (queueIndex < currentIndex) {
                    currentIndex -= 1;
                } else if (queueIndex === currentIndex) {
                    const nextIndex = Math.min(queueIndex, songs.length - 1);
                    updatePlayer(songs[nextIndex], !audio.paused);
                }

                refreshQueueOrderLabels();
                refreshSidebarEmptyStates();
            }

            function clearQueueSongs() {
                songs.length = 0;

                if (queueSongsList) {
                    queueSongsList.innerHTML = '';
                }

                audio.pause();
                audio.removeAttribute('src');
                title.textContent = 'Chọn bài hát';
                artist.textContent = '...';
                cover.src = @json(asset('images/default_song.png'));
                playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
                currentTimeLabel.textContent = '0:00';
                durationLabel.textContent = '0:00';
                progress.value = 0;
                currentIndex = 0;

                updateActiveStates(0);
                refreshQueueOrderLabels();
                refreshSidebarEmptyStates();
            }

            function updateLikedCount(count) {
                if (!likedSongsCount || typeof count !== 'number') {
                    return;
                }

                likedSongsCount.textContent = `${count} bài hát`;
            }

            async function toggleFavoriteOnServer(songId) {
                const response = await fetch(toggleFavoriteUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ song_id: Number(songId) }),
                });

                if (!response.ok) {
                    throw new Error('Toggle favorite failed');
                }

                return response.json();
            }

            async function addHistoryOnServer(songId) {
                const response = await fetch(addHistoryUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ song_id: Number(songId) }),
                });

                if (!response.ok) {
                    throw new Error('Add history failed');
                }

                return response.json();
            }

            async function deletePlaylistOnServer(playlistId) {
                const response = await fetch(deletePlaylistUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ playlist_id: Number(playlistId) }),
                });

                if (!response.ok) {
                    throw new Error('Delete playlist failed');
                }

                return response.json();
            }

            function refreshPlaylistEmptyState() {
                if (!playlistContainer || !playlistEmpty) {
                    return;
                }

                playlistEmpty.classList.toggle('d-none', playlistContainer.children.length > 0);
            }

            function formatTime(seconds) {
                if (!Number.isFinite(seconds) || seconds < 0) {
                    return '0:00';
                }

                const totalSeconds = Math.floor(seconds);
                const minutes = Math.floor(totalSeconds / 60);
                const remainder = String(totalSeconds % 60).padStart(2, '0');

                return `${minutes}:${remainder}`;
            }

            function getSongSource(song) {
                if (!song || !song.song_url) {
                    return '';
                }

                if (song.song_url.startsWith('http://') || song.song_url.startsWith('https://')) {
                    return song.song_url;
                }

                return @json(asset('storage/audio')) + '/' + song.song_url;
            }

            function updateLikeButton(song) {
                const isLiked = song && likedSongIds.has(Number(song.song_id));
                likeButton.innerHTML = isLiked ? '<i class="fas fa-heart text-danger"></i>' : '<i class="far fa-heart"></i>';
                likeButton.dataset.liked = isLiked ? '1' : '0';
            }

            function updateControlStates() {
                shuffleButton.classList.toggle('text-primary', shuffleEnabled);

                repeatButton.innerHTML = '<i class="fas fa-rotate-right"></i>';
                repeatButton.classList.toggle('text-primary', repeatMode !== 'off');
                repeatButton.title = repeatMode === 'one' ? 'Lặp lại 1 bài' : (repeatMode === 'all' ? 'Lặp lại tất cả' : 'Tắt lặp lại');
            }

            function updateActiveStates(songId) {
                document.querySelectorAll('[data-song-card]').forEach(function (card) {
                    card.classList.toggle('active-song', Number(card.dataset.songId) === Number(songId));
                });

                document.querySelectorAll('[data-queue-song]').forEach(function (item) {
                    item.classList.toggle('active-song', Number(item.dataset.songId) === Number(songId));
                });

                document.querySelectorAll('[data-queue-item]').forEach(function (item) {
                    item.classList.toggle('active-song', Number(item.dataset.songId) === Number(songId));
                });

                document.querySelectorAll('[data-liked-item]').forEach(function (item) {
                    item.classList.toggle('active-song', Number(item.dataset.songId) === Number(songId));
                });
            }

            function updatePlayer(song, autoplay = false) {
                if (!song) {
                    return;
                }

                currentIndex = songs.findIndex(function (item) {
                    return Number(item.song_id) === Number(song.song_id);
                });

                title.textContent = song.song_name || 'Chọn bài hát';
                artist.textContent = song.artist_name || '';
                cover.src = @json(asset('images/default_song.png'));
                cover.src = @json(asset('images')) + '/' + (song.song_image || 'default_song.png');

                audio.src = getSongSource(song);
                audio.volume = volumeRange.value / 100;
                currentTimeLabel.textContent = '0:00';
                durationLabel.textContent = formatTime(Number(song.duration || 0));
                progress.value = 0;

                updateActiveStates(song.song_id);
                updateLikeButton(song);

                if (autoplay) {
                    audio.play().catch(function () {
                        playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
                    });
                } else {
                    playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
                }
            }

            function playSongById(songId, autoplay = true, sourceElement = null) {
                const song = getSongById(songId, sourceElement);

                if (!song) {
                    return;
                }

                const queueResult = ensureSongInQueue(song);

                if (queueResult.added) {
                    addSongToSidebarList(song, 'queue');
                }

                updatePlayer(songs[queueResult.index], autoplay);
            }

            function playNext() {
                if (!songs.length) {
                    return;
                }

                if (shuffleEnabled) {
                    currentIndex = Math.floor(Math.random() * songs.length);
                } else {
                    currentIndex = (currentIndex + 1) % songs.length;
                }

                updatePlayer(songs[currentIndex], true);
            }

            function playPrevious() {
                if (!songs.length) {
                    return;
                }

                if (audio.currentTime > 4) {
                    audio.currentTime = 0;
                    return;
                }

                if (shuffleEnabled) {
                    currentIndex = Math.floor(Math.random() * songs.length);
                } else {
                    currentIndex = (currentIndex - 1 + songs.length) % songs.length;
                }

                updatePlayer(songs[currentIndex], true);
            }

            function togglePlayPause() {
                if (!audio.src && songs.length) {
                    updatePlayer(songs[currentIndex], true);
                    return;
                }

                if (audio.paused) {
                    audio.play().catch(function () {
                        playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
                    });
                } else {
                    audio.pause();
                }
            }

            function cycleRepeatMode() {
                if (repeatMode === 'all') {
                    repeatMode = 'one';
                } else if (repeatMode === 'one') {
                    repeatMode = 'off';
                } else {
                    repeatMode = 'all';
                }

                updateControlStates();
            }

            document.querySelectorAll('[data-song-card]').forEach(function (card) {
                card.addEventListener('click', function (event) {
                    if (event.target.closest('button, a, .dropdown-menu, .dropdown-toggle')) {
                        return;
                    }

                    playSongById(this.dataset.songId, true, this);
                });
            });

            document.addEventListener('click', function (event) {
                const queueButton = event.target.closest('[data-queue-song]');

                if (queueButton) {
                    playSongById(queueButton.dataset.songId, true, queueButton);
                }
            });

            document.addEventListener('click', function (event) {
                const removeButton = event.target.closest('[data-queue-remove]');

                if (!removeButton) {
                    return;
                }

                event.preventDefault();
                event.stopPropagation();

                removeSongFromQueue(removeButton.dataset.songId);
                showToast('Da xoa khoi hang doi', 'success');
            });

            document.addEventListener('click', function (event) {
                const removeLikedButton = event.target.closest('[data-liked-remove]');

                if (!removeLikedButton) {
                    return;
                }

                event.preventDefault();
                event.stopPropagation();

                const songId = Number(removeLikedButton.dataset.songId || 0);

                if (!songId) {
                    return;
                }

                toggleFavoriteOnServer(songId)
                    .then(function (data) {
                        if (!data.liked) {
                            likedSongIds.delete(songId);
                            removeSongFromLikedList(songId);
                            updateLikedCount(Number(data.liked_count));
                            refreshLikeActionButtons(songId);

                            if (songs[currentIndex] && Number(songs[currentIndex].song_id) === songId) {
                                updateLikeButton(songs[currentIndex]);
                            }

                            showToast('Da bo khoi yeu thich', 'success');
                            return;
                        }

                        showToast('Khong the bo yeu thich', 'error');
                    })
                    .catch(function () {
                        showToast('Khong the cap nhat yeu thich', 'error');
                    });
            });

            document.addEventListener('click', function (event) {
                const removePlaylistButton = event.target.closest('[data-playlist-remove]');

                if (!removePlaylistButton) {
                    return;
                }

                event.preventDefault();
                event.stopPropagation();

                const playlistId = Number(removePlaylistButton.dataset.playlistId || 0);

                if (!playlistId) {
                    return;
                }

                deletePlaylistOnServer(playlistId)
                    .then(function () {
                        const item = removePlaylistButton.closest('[data-playlist-item]');

                        if (item) {
                            item.remove();
                        }

                        refreshPlaylistEmptyState();
                        showToast('Da xoa playlist', 'success');
                    })
                    .catch(function () {
                        showToast('Khong the xoa playlist', 'error');
                    });
            });

            document.addEventListener('click', function (event) {
                const actionButton = event.target.closest('[data-action]');

                if (!actionButton) {
                    return;
                }

                const action = actionButton.dataset.action;
                const songId = actionButton.dataset.songId;

                if (action === 'play') {
                    playSongById(songId, true, actionButton);
                }

                if (action === 'queue') {
                    const song = getSongById(songId, actionButton);

                    if (song) {
                        const queueResult = ensureSongInQueue(song);

                        if (queueResult.added) {
                            addSongToSidebarList(song, 'queue');
                            showToast('Da them vao hang doi', 'success');
                        } else {
                            showToast('Bai hat da co trong hang doi', 'info');
                        }

                        playSongById(song.song_id, false);
                    }
                }

                if (action === 'like') {
                    const song = getSongById(songId, actionButton);

                    toggleFavoriteOnServer(songId)
                        .then(function (data) {
                            if (data.liked) {
                                likedSongIds.add(Number(songId));
                                addSongToSidebarList(song, 'liked');
                            } else {
                                likedSongIds.delete(Number(songId));
                                removeSongFromLikedList(songId);
                            }

                            updateLikedCount(Number(data.liked_count));
                            refreshLikeActionButtons(songId);

                            if (songs[currentIndex] && Number(songs[currentIndex].song_id) === Number(songId)) {
                                updateLikeButton(songs[currentIndex]);
                            }

                            showToast(data.liked ? 'Da them vao yeu thich' : 'Da bo khoi yeu thich', 'success');
                        })
                        .catch(function () {
                            showToast('Khong the cap nhat yeu thich', 'error');
                        });
                }

                if (action === 'share') {
                    const shareText = `${actionButton.dataset.songName || ''} - ${actionButton.dataset.songArtist || ''}`.trim();
                    const songLink = buildSongLink(songId);

                    if (navigator.share) {
                        navigator.share({
                            title: actionButton.dataset.songName || 'MusicApp',
                            text: shareText,
                            url: songLink,
                        }).then(function () {
                            showToast('Da chia se bai hat', 'success');
                        }).catch(function () {
                            showToast('Khong the chia se bai hat', 'error');
                        });
                    } else {
                        navigator.clipboard?.writeText(songLink);
                        showToast('Da sao chep lien ket bai hat', 'success');
                    }
                }

                if (action === 'copy-link') {
                    navigator.clipboard?.writeText(buildSongLink(songId));
                    showToast('Da sao chep lien ket bai hat', 'success');
                }

                if (action === 'album') {
                    const albumId = Number(actionButton.dataset.albumId || actionButton.closest('[data-song-card]')?.dataset.songAlbumId || 0);

                    if (albumId > 0) {
                        window.location.href = `${albumsPageUrl}?album_id=${albumId}`;
                    } else {
                        window.location.href = albumsPageUrl;
                    }
                }

                if (action === 'artist') {
                    const artistId = Number(actionButton.dataset.artistId || actionButton.closest('[data-song-card]')?.dataset.songArtistId || 0);

                    if (artistId > 0) {
                        window.location.href = `${artistsPageUrl}?artist_id=${artistId}`;
                    } else {
                        window.location.href = artistsPageUrl;
                    }
                }
            });

            playPauseButton.addEventListener('click', togglePlayPause);
            shuffleButton.addEventListener('click', function () {
                shuffleEnabled = !shuffleEnabled;
                updateControlStates();
            });
            prevButton.addEventListener('click', playPrevious);
            nextButton.addEventListener('click', playNext);
            repeatButton.addEventListener('click', cycleRepeatMode);

            likeButton.addEventListener('click', function () {
                if (!songs[currentIndex]) {
                    return;
                }

                const songId = Number(songs[currentIndex].song_id);

                toggleFavoriteOnServer(songId)
                    .then(function (data) {
                        if (data.liked) {
                            likedSongIds.add(songId);
                        } else {
                            likedSongIds.delete(songId);
                        }

                        updateLikedCount(Number(data.liked_count));
                        if (data.liked) {
                            addSongToSidebarList(songs[currentIndex], 'liked');
                        } else {
                            removeSongFromLikedList(songId);
                        }
                        refreshLikeActionButtons(songId);
                        updateLikeButton(songs[currentIndex]);
                        showToast(data.liked ? 'Da them vao yeu thich' : 'Da bo khoi yeu thich', 'success');
                    })
                    .catch(function () {
                        showToast('Khong the cap nhat yeu thich', 'error');
                    });
            });

            audio.addEventListener('play', function () {
                playPauseButton.innerHTML = '<i class="fas fa-pause"></i>';

                if (!songs[currentIndex]) {
                    return;
                }

                const song = songs[currentIndex];
                const songId = Number(song.song_id);

                if (songId === lastHistorySongId) {
                    return;
                }

                lastHistorySongId = songId;
                addSongToHistoryList(song);
                addHistoryOnServer(songId).catch(function () {});
            });

            audio.addEventListener('pause', function () {
                playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
            });

            audio.addEventListener('timeupdate', function () {
                if (!audio.duration) {
                    return;
                }

                progress.value = (audio.currentTime / audio.duration) * 100;
                currentTimeLabel.textContent = formatTime(audio.currentTime);
            });

            audio.addEventListener('loadedmetadata', function () {
                durationLabel.textContent = formatTime(audio.duration);
            });

            audio.addEventListener('ended', function () {
                if (repeatMode === 'one') {
                    audio.currentTime = 0;
                    audio.play();
                    return;
                }

                if (repeatMode === 'all' || shuffleEnabled) {
                    playNext();
                    return;
                }

                playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
            });

            audio.addEventListener('error', function () {
                title.textContent = 'Không thể phát bài hát';
                artist.textContent = 'Kiểm tra lại file nhạc';
                playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
            });

            progress.addEventListener('input', function () {
                if (!audio.duration) {
                    return;
                }

                audio.currentTime = (progress.value / 100) * audio.duration;
            });

            volumeRange.addEventListener('input', function () {
                audio.volume = volumeRange.value / 100;
            });

            if (queueClearAllButton) {
                queueClearAllButton.addEventListener('click', function () {
                    if (!songs.length) {
                        return;
                    }

                    clearQueueSongs();
                    showToast('Da xoa toan bo hang doi', 'success');
                });
            }

            updateControlStates();
            refreshSidebarEmptyStates();
            refreshQueueOrderLabels();
            refreshPlaylistEmptyState();
            refreshLikeActionButtons();

            if (songs.length) {
                updatePlayer(songs[0], false);
            }
        });
    </script>
</body>
</html>