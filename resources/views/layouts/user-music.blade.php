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
        body { padding-bottom: 20px !important; }
        body.has-player-bar { padding-bottom: 150px !important; }
        
        /* Layout & Card */
        .sidebar-sticky {
            position: sticky;
            top: 90px;
            height: calc(100vh - 90px - 130px);
            overflow-y: auto;
            overscroll-behavior: contain;
            border-right: 1px solid #eee;
            padding-right: 15px;
            padding-bottom: 12px;
        }
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

        .queue-song .dropdown {
            position: relative;
            z-index: 2;
        }

        .queue-song .dropdown-menu {
            z-index: 3500;
        }

        .queue-song .btn-song-menu::after {
            display: none !important;
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
            top: 12px;
            right: 10px;
            transform: none;
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

        .playlist-chip-menu-btn::after,
        .playlist-song-menu-btn::after {
            display: none !important;
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

        .playlist-song-list {
            margin-top: 8px;
            padding-left: 6px;
            padding-right: 6px;
        }

        .playlist-chip-wrap.is-collapsed .playlist-song-list {
            display: none;
        }

        .playlist-song-wrap {
            position: relative;
            margin-bottom: 6px;
        }

        .playlist-song-item {
            width: 100%;
            border: 0;
            background: #eef1f5;
            color: #4b5563;
            border-radius: 10px;
            text-align: left;
            padding: 7px 38px 7px 10px;
            font-size: 0.9rem;
            line-height: 1.2;
        }

        .playlist-song-item.active-song {
            background: linear-gradient(135deg, #ff4081 0%, #ff80ab 100%);
            color: #fff;
            box-shadow: 0 10px 22px rgba(255, 64, 129, 0.22);
        }

        .playlist-song-item.active-song .playlist-song-name,
        .playlist-song-item.active-song .playlist-song-artist {
            color: rgba(255, 255, 255, 0.9);
        }

        .playlist-song-wrap.active-song .playlist-song-menu-btn {
            color: rgba(255, 255, 255, 0.92);
            background: rgba(255, 255, 255, 0.18);
        }

        .playlist-song-wrap.active-song .playlist-song-menu-btn:hover {
            background: rgba(255, 255, 255, 0.26);
            color: #fff;
        }

        .playlist-song-menu-btn {
            position: absolute;
            top: 50%;
            right: 7px;
            transform: translateY(-50%);
            border: 0;
            width: 24px;
            height: 24px;
            border-radius: 7px;
            background: transparent;
            color: #9aa2af;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .playlist-song-menu-btn:hover {
            background: rgba(17, 24, 39, 0.08);
            color: #4b5563;
        }

        .playlist-song-dropdown {
            min-width: 170px;
            border: 0;
            border-radius: 10px;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.18);
            padding: 6px;
        }

        .playlist-song-dropdown .dropdown-item {
            border-radius: 8px;
            font-weight: 600;
            color: #ef4444;
        }

        .playlist-song-dropdown .dropdown-item:hover {
            background: #fff1f2;
            color: #dc2626;
        }

        .playlist-song-item .playlist-song-name {
            color: #111827;
            font-weight: 700;
        }

        .playlist-song-item .playlist-song-artist {
            color: #6b7280;
            font-size: 0.83rem;
            margin-top: 2px;
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
            transition: transform 0.25s ease, opacity 0.25s ease;
        }

        .player-bar.is-hidden {
            transform: translateY(115%);
            opacity: 0;
            pointer-events: none;
        }

        .song-card {
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        .song-card:hover,
        .song-card:focus-within {
            z-index: 40;
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
            z-index: 3000;
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
            color: #111827;
            font-size: 1rem;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            transition: 0.2s ease;
        }

        .player-control-btn.is-active {
            color: var(--primary-color);
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

        .player-volume {
            accent-color: var(--primary-color);
        }

        .player-volume::-webkit-slider-runnable-track {
            background: linear-gradient(
                90deg,
                #ff3f86 0%,
                #ff3f86 var(--volume-progress, 80%),
                #d1d5db var(--volume-progress, 80%),
                #d1d5db 100%
            );
            height: 6px;
            border-radius: 999px;
        }

        .player-volume::-webkit-slider-thumb {
            background: #ff3f86;
            border: 0;
            width: 14px;
            height: 14px;
            margin-top: -4px;
            border-radius: 50%;
        }

        .player-volume::-moz-range-track {
            background: #d1d5db;
            height: 6px;
            border: 0;
            border-radius: 999px;
        }

        .player-volume::-moz-range-progress {
            background: #ff3f86;
            height: 6px;
            border-radius: 999px;
        }

        .player-volume::-moz-range-thumb {
            background: #ff3f86;
            border: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
        }

        .player-seekbar {
            position: relative;
            height: 8px;
            border-radius: 999px;
            background: #e5e7eb;
            cursor: pointer;
            flex-grow: 1;
            touch-action: none;
            user-select: none;
        }

        .player-seek-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%;
            border-radius: 999px;
            background: linear-gradient(90deg, #ff3f86 0%, #ff6fa8 100%);
        }

        .player-seek-handle {
            position: absolute;
            top: 50%;
            right: -6px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #ff3f86;
            transform: translateY(-50%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
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

        .user-avatar-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 999px;
        }

        .user-menu-toggle {
            border: 0;
            border-radius: 8px;
            background: #fff;
            color: #111827;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px;
            line-height: 1;
            font-weight: 700;
            max-width: 200px;
        }

        .user-menu-toggle::after {
            color: #ff3f86;
            margin-left: 2px;
        }

        .user-menu-toggle:hover,
        .user-menu-toggle:focus,
        .user-menu-toggle:active {
            border-color: transparent !important;
            background: #fff !important;
            color: #111827 !important;
        }

        .user-menu-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ff3f86;
            flex-shrink: 0;
            cursor: pointer;
        }

        .user-menu-name {
            max-width: 132px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #ff3f86;
            font-size: 0.98rem;
        }

        .user-menu-dropdown {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.2);
            min-width: 170px;
            padding: 8px;
        }

        .user-menu-item {
            border: 0;
            background: transparent;
            width: 100%;
            text-align: left;
            border-radius: 8px;
            padding: 9px 10px;
            color: #374151;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .user-menu-item:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .user-menu-item.logout {
            color: #ef4444;
            font-weight: 800;
        }

        .user-menu-item.logout:hover {
            background: #fff1f2;
            color: #dc2626;
        }

        .user-menu-form {
            margin: 0;
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

            .user-menu-name {
                max-width: 100px;
                font-size: 0.9rem;
            }
        }

        .site-footer {
            margin-top: 24px;
            padding: 36px 0 34px;
            border-top: 1px solid #dfe3eb;
            color: #374151;
        }

        .footer-brand {
            font-size: 1.8rem;
            font-weight: 800;
            color: #ff3f86;
            margin-bottom: 10px;
        }

        .footer-text {
            font-size: 0.95rem;
            color: #4b5563;
            line-height: 1.6;
            max-width: 340px;
            margin-bottom: 16px;
        }

        .footer-socials {
            display: flex;
            gap: 10px;
        }

        .footer-social {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #eef1f5;
            color: #ff3f86;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .footer-social:hover {
            background: #ff5f9a;
            color: #fff;
        }

        .footer-heading {
            font-size: 0.95rem;
            font-weight: 800;
            color: #ff3f86;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .footer-links {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 8px;
        }

        .footer-links a {
            font-size: 0.95rem;
            color: #4b5563;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-links button {
            border: 0;
            background: transparent;
            padding: 0;
            font-size: 0.95rem;
            color: #4b5563;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: #ff3f86;
        }

        .footer-links button:hover {
            color: #ff3f86;
        }

        .footer-subscribe {
            display: flex;
            border: 1px solid #cfd6df;
            border-radius: 8px;
            overflow: hidden;
            max-width: 360px;
            background: #fff;
        }

        .footer-subscribe input {
            border: 0;
            padding: 10px 12px;
            width: 100%;
            outline: none;
            font-size: 0.95rem;
        }

        .footer-subscribe button {
            border: 0;
            width: 44px;
            background: #ff3f86;
            color: #fff;
        }

        .footer-bottom {
            font-size: 0.92rem;
            margin-top: 28px;
            padding-top: 16px;
            border-top: 1px solid #dfe3eb;
            color: #4b5563;
            text-align: center;
        }

        .playlist-modal .modal-content {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.28);
        }

        .playlist-modal .modal-header {
            border-bottom: 0;
            padding: 16px 18px 8px;
        }

        .playlist-modal .modal-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #1f2937;
        }

        .playlist-modal .btn-close {
            box-shadow: none;
        }

        .playlist-modal .modal-body {
            padding: 4px 18px 18px;
        }

        .playlist-modal-label {
            font-weight: 700;
            color: #4b5563;
            margin-bottom: 8px;
        }

        .playlist-modal .form-select,
        .playlist-modal .form-control {
            border-radius: 999px;
            border: 1px solid #d1d5db;
            height: 40px;
            box-shadow: none;
        }

        .playlist-modal .form-select:focus,
        .playlist-modal .form-control:focus {
            border-color: #ff3f86;
            box-shadow: 0 0 0 3px rgba(255, 63, 134, 0.16);
        }

        .playlist-modal-save {
            margin-top: 14px;
            width: 100%;
            border: 0;
            border-radius: 999px;
            height: 42px;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, #ff3f86 0%, #ff5f9a 100%);
        }

        @media (max-width: 991.98px) {
            .site-footer {
                padding-bottom: 26px;
            }

            .footer-col {
                margin-bottom: 20px;
            }
        }
        /* --- Bổ sung CSS cho Search Dropdown --- */
            .dropdown-title { font-size: 11px; font-weight: 800; color: #888; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;}
            .history-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 15px;}
            .history-tag { background: #f1f3f4; padding: 6px 12px; border-radius: 20px; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px; color: #444; transition: 0.2s;}
            .history-tag:hover { background: #e2e6ea; }
            .history-tag .del-btn { color: #aaa; font-size: 11px; padding: 2px;}
            .history-tag .del-btn:hover { color: #ff4081; }
            #clearHistoryBtn { float: right; font-size: 11px; color: #ff4081; cursor: pointer; text-transform: none; font-weight: 600;}
            .live-item { display: flex; align-items: center; padding: 8px; border-radius: 8px; cursor: pointer; transition: background 0.2s; text-decoration: none; color: inherit;}
            .live-item:hover { background: #f8f9fa; }
            .live-item img { width: 40px; height: 40px; border-radius: 6px; margin-right: 12px; object-fit: cover; }
            .live-item .info { flex-grow: 1; overflow: hidden; }
            .live-item .title { font-weight: 600; color: #111; font-size: 14px; margin: 0; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;}
            .live-item .subtitle { font-size: 12px; color: #777; margin: 0; margin-top: 2px;}
    </style>
</head>
<body class="bg-light">
    @php
        $count_liked = $count_liked ?? 0;
        $liked_songs = $liked_songs ?? collect();
        $history_list = $history_list ?? collect();
        $my_playlists = $my_playlists ?? collect();
        $playlist_songs_map = $playlist_songs_map ?? collect();
        $js_data = $js_data ?? ['queue' => []];
    @endphp

    <nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm py-3 mb-4">
        <div class="container-fluid px-4 top-nav-inner">
            <a class="navbar-brand text-primary top-nav-brand" href="{{ route('dashboard') }}"><i class="fas fa-play-circle me-2"></i>MusicApp</a>
            <div class="top-nav-menu">
                <a href="{{ route('dashboard') }}" class="top-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Trang chủ</a>
                <a href="{{ route('dashboard.songs') }}" class="top-menu-link {{ request()->routeIs('dashboard.songs') ? 'active' : '' }}">Bài hát</a>
                <a href="{{ route('dashboard.albums') }}" class="top-menu-link {{ request()->routeIs('dashboard.albums') ? 'active' : '' }}">Album</a>
                <a href="{{ route('dashboard.artists') }}" class="top-menu-link {{ request()->routeIs('dashboard.artists') ? 'active' : '' }}">Nghệ sĩ</a>
                <a href="{{ route('dashboard.genres') }}" class="top-menu-link {{ request()->routeIs('dashboard.genres') ? 'active' : '' }}">Thể loại</a>
                <a href="{{ route('dashboard.news') }}" class="top-menu-link {{ request()->routeIs('dashboard.news') ? 'active' : '' }}">Tin tức</a>
            </div>
            <div class="top-search-form position-relative">
                <form method="GET" action="{{ route('music.search') }}" id="searchForm">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input 
                            type="text" 
                            name="q" 
                            id="searchInput" 
                            class="form-control" 
                            placeholder="Tìm bài hát, ca sĩ, album..." 
                            value="{{ request()->query('q') }}" 
                            autocomplete="off"
                        >
                    </div>
                </form>
                <div id="searchDropdown" style="display: none; position: absolute; top: 110%; left: 0; width: 100%; background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); z-index: 1050; padding: 15px; max-height: 400px; overflow-y: auto;">
                    </div>
            </div>
            <div class="top-nav-actions">
                <div class="dropdown d-flex align-items-center gap-2">
                    @php
                        $displayName = Auth::user()->full_name ?? Auth::user()->name;
                        $avatarImage = Auth::user()->avatar_image ?? '';
                        $avatarSrc = $avatarImage
                            ? (str_starts_with($avatarImage, 'http://') || str_starts_with($avatarImage, 'https://') ? $avatarImage : asset('images/'.$avatarImage))
                            : 'https://ui-avatars.com/api/?background=ffffff&color=111827&name='.urlencode($displayName);
                    @endphp
                    <a href="{{ route('profile.edit') }}" class="user-avatar-link" data-profile-link>
                        <img src="{{ $avatarSrc }}" alt="{{ $displayName }}" class="user-menu-avatar" onerror="this.src='https://ui-avatars.com/api/?background=ffffff&color=111827&name={{ urlencode($displayName) }}'">
                    </a>
                    <button class="btn dropdown-toggle user-menu-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="user-menu-name">{{ $displayName }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end user-menu-dropdown">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="user-menu-item">
                                <i class="fas fa-user-circle text-secondary"></i>Hồ sơ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.favorites') }}" class="user-menu-item" data-favorites-link>
                                <i class="fas fa-heart text-danger"></i>Yêu thích
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="user-menu-form">
                                @csrf
                                <button type="submit" class="user-menu-item logout">
                                    <i class="fas fa-right-from-bracket"></i>Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
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
                            <button type="button" class="library-plus-btn" title="Dùng menu bài hát để thêm vào playlist">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <button type="button" class="library-card library-toggle" data-bs-toggle="collapse" data-bs-target="#likedSongsCollapse" aria-expanded="false" aria-controls="likedSongsCollapse">
                            <span class="d-flex align-items-center gap-2">
                                <span class="library-card-icon"><i class="fas fa-heart"></i></span>
                                <span class="library-card-text">
                                    <span class="library-card-title">Liked Songs</span>
                                    <span id="liked-songs-count" class="library-card-sub">{{ $count_liked }} bài hát</span>
                                </span>
                            </span>
                            <span class="library-card-right"><i class="fas fa-chevron-down"></i></span>
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
                                            <div class="history-status text-truncate"><i class="far fa-clock me-1"></i>{{ \Illuminate\Support\Carbon::parse($historySong->listened_at)->format('H:i d/m/Y') }}</div>
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
                            @php
                                $playlistSongs = ($playlist_songs_map ?? collect())->get($playlist->playlist_id, collect());
                            @endphp
                            <div class="playlist-chip-wrap" data-playlist-item data-playlist-id="{{ $playlist->playlist_id }}">
                                <button type="button" class="playlist-chip">
                                    <span class="playlist-chip-icon"><i class="fas fa-music"></i></span>
                                    <span class="playlist-chip-name">{{ $playlist->playlist_name }}</span>
                                </button>
                                <button
                                    type="button"
                                    class="playlist-chip-menu-btn"
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
                                <div class="playlist-song-list" data-playlist-songs>
                                    @foreach($playlistSongs as $playlistSong)
                                        <div class="playlist-song-wrap" data-playlist-song-item data-song-id="{{ $playlistSong->song_id }}" data-playlist-id="{{ $playlist->playlist_id }}">
                                            <button type="button" class="playlist-song-item" data-queue-song data-song-id="{{ $playlistSong->song_id }}">
                                                <div class="playlist-song-name text-truncate">{{ $playlistSong->song_name }}</div>
                                                <div class="playlist-song-artist text-truncate">{{ $playlistSong->artist_name }}</div>
                                            </button>
                                            <button type="button" class="playlist-song-menu-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end playlist-song-dropdown">
                                                <li>
                                                    <button
                                                        type="button"
                                                        class="dropdown-item"
                                                        data-playlist-song-remove
                                                        data-playlist-id="{{ $playlist->playlist_id }}"
                                                        data-song-id="{{ $playlistSong->song_id }}"
                                                    >
                                                        <i class="fas fa-trash me-2"></i>Xóa khỏi playlist
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
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

        <footer class="site-footer">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 footer-col">
                    <div class="footer-brand">MusicApp</div>
                    <p class="footer-text">Thế giới âm nhạc trong tầm tay. Nghe nhạc chất lượng cao, cập nhật xu hướng mới nhất mỗi ngày.</p>
                    <div class="footer-socials">
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="footer-social" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="footer-social" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="footer-social" aria-label="Youtube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 footer-col">
                    <h6 class="footer-heading">Khám Phá</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('dashboard') }}" data-footer-link>Trang chủ</a></li>
                        <li><a href="{{ route('dashboard.songs') }}" data-footer-link>Bài hát mới</a></li>
                        <li><a href="{{ route('dashboard.albums') }}" data-footer-link>Album Hot</a></li>
                        <li><a href="{{ route('dashboard.artists') }}" data-footer-link>Nghệ sĩ</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 footer-col">
                    <h6 class="footer-heading">Hỗ Trợ</h6>
                    <ul class="footer-links">
                        <li><button type="button" data-footer-help="Điều khoản">Điều khoản</button></li>
                        <li><button type="button" data-footer-help="Bảo mật">Bảo mật</button></li>
                        <li><button type="button" data-footer-help="Liên hệ">Liên hệ</button></li>
                        <li><button type="button" data-footer-help="Góp ý">Góp ý</button></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 footer-col">
                    <h6 class="footer-heading">Đăng Ký Nhận Tin</h6>
                    <form class="footer-subscribe" id="footer-subscribe-form" action="{{ route('newsletter.subscribe') }}" method="post">
                        @csrf
                        <input type="email" name="email" id="footer-subscribe-email" placeholder="Email của bạn..." aria-label="Email đăng ký" required>
                        <button type="submit" aria-label="Gửi đăng ký"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">&copy; {{ date('Y') }} <strong>MusicApp</strong>. All rights reserved.</div>
        </footer>
    </div>

    <div class="player-bar is-hidden d-flex align-items-center px-4 gap-3 flex-wrap" id="player-bar">
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
                <div id="player-seekbar" class="player-seekbar" role="slider" aria-label="Tiến trình phát" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div id="player-seek-fill" class="player-seek-fill">
                        <span class="player-seek-handle"></span>
                    </div>
                </div>
                <span id="player-duration" class="small text-muted">0:00</span>
            </div>
        </div>

        <div class="player-right w-25 d-flex justify-content-end align-items-center gap-3">
            <i class="fas fa-volume-up text-muted"></i>
            <input id="player-volume" type="range" class="form-range player-volume mb-0" min="0" max="100" value="80" style="width: 110px;">
        </div>
    </div>

    <div id="action-toast" class="action-toast" role="status" aria-live="polite"></div>

    <div class="modal fade" id="loginRequireModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            <div class="modal-body text-center p-5">
                <i class="fas fa-lock" style="font-size: 40px; color: #ff4081; margin-bottom: 20px;"></i>
                <h4 class="fw-bold mb-3">Đăng nhập để nghe/sử dụng</h4>
                <p class="text-muted mb-4">Bạn cần tài khoản để thưởng thức trọn vẹn và sử dụng tính năng này.</p>
                <a href="/login" class="btn btn-primary px-5 py-2" style="background-color: #ff4081; border: none; border-radius: 25px; font-weight: bold;">Đăng nhập ngay</a>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="addPlaylistModal" tabindex="-1" aria-labelledby="addPlaylistLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #e5e7eb;">
                    <h5 class="modal-title" id="addPlaylistLabel">Thêm vào Playlist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="playlist-select" class="form-label">Chọn Playlist:</label>
                    <select id="playlist-select" class="form-select" style="border-radius: 8px;">
                        <option value="">-- Chọn playlist --</option>
                    </select>
                    <input type="text" id="playlist-new-name" class="form-control mt-3 d-none" placeholder="Nhập tên playlist mới..." style="border-radius: 8px;">
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e5e7eb;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Hủy</button>
                    <button type="button" id="playlist-save-btn" class="btn btn-primary" style="background-color: #ff4081; border: none; border-radius: 8px; font-weight: bold;">Thêm vào Playlist</button>
                </div>
            </div>
        </div>
    </div>

    <audio id="music-audio" preload="metadata"></audio>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const songs = [];
            const songCatalog = @json($js_data['queue'] ?? []);
            const likedSongIds = new Set(@json($liked_songs->pluck('song_id')->values()));
            const toggleFavoriteUrl = @json(route('dashboard.favorites.toggle'));
            const addHistoryUrl = @json(route('dashboard.history.add'));
            const addSongToPlaylistUrl = @json(route('dashboard.playlists.addSong'));
            const removeSongFromPlaylistUrl = @json(route('dashboard.playlists.removeSong'));
            const deletePlaylistUrl = @json(route('dashboard.playlists.delete'));
            const albumsPageUrl = @json(route('dashboard.albums'));
            const artistsPageUrl = @json(route('dashboard.artists'));
            const csrfToken = @json(csrf_token());
            const playbackStateKey = 'musicapp.playbackState';
            const playbackStateWindowKey = '__musicapp_playback_state__';
            const queueStateKey = 'musicapp.queueState';

            const audio = document.getElementById('music-audio');
            const playerBar = document.getElementById('player-bar');
            const cover = document.getElementById('player-cover');
            const title = document.getElementById('player-song-title');
            const artist = document.getElementById('player-song-artist');
            const playPauseButton = document.getElementById('btn-play-pause');
            const shuffleButton = document.getElementById('btn-shuffle');
            const prevButton = document.getElementById('btn-prev');
            const nextButton = document.getElementById('btn-next');
            const repeatButton = document.getElementById('btn-repeat');
            const likeButton = document.getElementById('btn-like-current');
            const seekBar = document.getElementById('player-seekbar');
            const seekFill = document.getElementById('player-seek-fill');
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
            const addPlaylistModalEl = document.getElementById('addPlaylistModal');
            const playlistSelect = document.getElementById('playlist-select');
            const playlistNewNameInput = document.getElementById('playlist-new-name');
            const playlistSaveButton = document.getElementById('playlist-save-btn');

            const addPlaylistModal = addPlaylistModalEl ? new bootstrap.Modal(addPlaylistModalEl) : null;

            let currentIndex = 0;
            let shuffleEnabled = false;
            let repeatMode = 'off';
            let toastTimer = null;
            let lastHistorySongId = null;
            let lastHistoryRecordedAt = 0;
            let pendingPlaylistSong = null;
            let isSeeking = false;
            let isRestoringPlayback = false;
            let lastSavedSecond = -1;

            function revealPlayerBar() {
                if (!playerBar) {
                    return;
                }

                playerBar.classList.remove('is-hidden');
                document.body.classList.add('has-player-bar');
            }

            function hidePlayerBar() {
                if (!playerBar) {
                    return;
                }

                playerBar.classList.add('is-hidden');
                document.body.classList.remove('has-player-bar');
            }

            function resetPlayerState() {
                audio.pause();
                audio.removeAttribute('src');
                title.textContent = 'Chọn bài hát';
                artist.textContent = '...';
                cover.src = @json(asset('images/default_song.png'));
                playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
                currentTimeLabel.textContent = '0:00';
                durationLabel.textContent = '0:00';
                setSeekVisual(0);
                currentIndex = 0;
                updateActiveStates(0);
            }

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
            window.showToast = showToast;

            function updateVolumeVisual(value) {
                if (!volumeRange) {
                    return;
                }

                const min = Number(volumeRange.min || 0);
                const max = Number(volumeRange.max || 100);
                const current = Number(value);

                if (!Number.isFinite(current) || max <= min) {
                    return;
                }

                const clamped = Math.min(max, Math.max(min, current));
                const percent = ((clamped - min) / (max - min)) * 100;
                volumeRange.style.setProperty('--volume-progress', `${percent}%`);
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

            function normalizeSongForStorage(song) {
                if (!song) {
                    return null;
                }

                const songId = Number(song.song_id || 0);

                if (!songId) {
                    return null;
                }

                return {
                    song_id: songId,
                    song_name: String(song.song_name || ''),
                    artist_name: String(song.artist_name || ''),
                    song_image: String(song.song_image || ''),
                    song_url: String(song.song_url || ''),
                    duration: Number(song.duration || 0),
                    album_id: Number(song.album_id || 0),
                    artist_id: Number(song.artist_id || 0),
                };
            }

            function saveQueueState() {
                const normalizedQueue = songs
                    .map(normalizeSongForStorage)
                    .filter(function (song) {
                        return !!song;
                    });

                try {
                    sessionStorage.setItem(queueStateKey, JSON.stringify(normalizedQueue));
                } catch (error) {}
            }

            function clearQueueState() {
                try {
                    sessionStorage.removeItem(queueStateKey);
                } catch (error) {}
            }

            function restoreQueueState() {
                let rawState = '';

                try {
                    rawState = sessionStorage.getItem(queueStateKey) || '';
                } catch (error) {}

                if (!rawState) {
                    return;
                }

                let parsedState = null;

                try {
                    parsedState = JSON.parse(rawState);
                } catch (error) {
                    parsedState = null;
                }

                if (!Array.isArray(parsedState) || parsedState.length === 0) {
                    return;
                }

                songs.length = 0;
                parsedState.forEach(function (song) {
                    const normalizedSong = normalizeSongForStorage(song);

                    if (normalizedSong) {
                        songs.push(normalizedSong);
                    }
                });

                if (queueSongsList) {
                    queueSongsList.innerHTML = '';

                    songs.forEach(function (song) {
                        const button = createSidebarSongButton(song, 'queue', queueSongsList.children.length);
                        queueSongsList.insertBefore(button, queueSongsList.firstChild);
                    });
                }

                refreshQueueOrderLabels();
                refreshSidebarEmptyStates();
            }

            function ensureSongInQueue(song) {
                const existingIndex = getSongIndex(song.song_id);

                if (existingIndex > -1) {
                    return { index: existingIndex, added: false };
                }

                songs.push(song);
                saveQueueState();

                return { index: songs.length - 1, added: true };
            }

            function ensurePlaybackQueue() {
                if (songs.length > 0) {
                    return true;
                }

                if (!Array.isArray(songCatalog) || songCatalog.length === 0) {
                    showToast('Chua co bai hat de phat', 'info');
                    return false;
                }

                songCatalog.forEach(function (song) {
                    songs.push(song);
                });

                saveQueueState();

                if (currentIndex < 0 || currentIndex >= songs.length) {
                    currentIndex = 0;
                }

                return songs.length > 0;
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
                status.innerHTML = `<i class="far fa-clock me-1"></i>${formatHistoryDateTime(song.listened_at)}`;

                content.appendChild(songName);
                content.appendChild(artistName);
                content.appendChild(status);
                button.appendChild(image);
                button.appendChild(content);

                return button;
            }

            function formatHistoryDateTime(value) {
                const date = value ? new Date(value) : new Date();

                if (Number.isNaN(date.getTime())) {
                    return '';
                }

                const pad = function (num) {
                    return String(num).padStart(2, '0');
                };

                const hours = pad(date.getHours());
                const minutes = pad(date.getMinutes());
                const day = pad(date.getDate());
                const month = pad(date.getMonth() + 1);
                const year = date.getFullYear();

                return `${hours}:${minutes} ${day}/${month}/${year}`;
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

            function pushHistoryRealtime(song, force = false) {
                if (!song) {
                    return;
                }

                const songId = Number(song.song_id);

                if (!songId) {
                    return;
                }

                const now = Date.now();
                const isDuplicateInShortTime = songId === lastHistorySongId && (now - lastHistoryRecordedAt) < 30000;

                if (!force && isDuplicateInShortTime) {
                    return;
                }

                const historySong = {
                    ...song,
                    listened_at: new Date().toISOString(),
                };

                lastHistorySongId = songId;
                lastHistoryRecordedAt = now;
                addSongToHistoryList(historySong);
                addHistoryOnServer(songId).catch(function () {});
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

            function refreshFavoritesPageState() {
                const favoritesList = document.getElementById('favorites-page-songs-list');
                const favoritesEmpty = document.getElementById('favorites-page-empty');

                if (!favoritesList) {
                    return;
                }

                favoritesList.querySelectorAll('[data-favorite-page-item]').forEach(function (item, index) {
                    const indexLabel = item.querySelector('[data-favorite-page-index]');

                    if (indexLabel) {
                        indexLabel.textContent = String(index + 1);
                    }
                });

                if (favoritesEmpty) {
                    favoritesEmpty.classList.toggle('d-none', favoritesList.children.length > 0);
                }
            }

            function addSongToFavoritesPageList(song) {
                const favoritesList = document.getElementById('favorites-page-songs-list');

                if (!favoritesList || !song || !song.song_id) {
                    return;
                }

                const existing = favoritesList.querySelector(`[data-favorite-page-item][data-song-id="${song.song_id}"]`);

                if (existing) {
                    existing.remove();
                }

                const item = document.createElement('div');
                item.className = 'queue-song d-flex align-items-center gap-3 mb-2';
                item.setAttribute('data-favorite-page-item', '');
                item.setAttribute('data-song-card', '');
                item.dataset.songId = String(song.song_id);
                item.dataset.songName = String(song.song_name || '');
                item.dataset.songArtist = String(song.artist_name || '');
                item.dataset.songImage = `${@json(asset('images'))}/${song.song_image || 'default_song.png'}`;
                item.dataset.songUrl = String(song.song_url || '');
                item.dataset.songDuration = String(Number(song.duration || 0));
                item.dataset.songAlbumId = String(Number(song.album_id || 0));
                item.dataset.songArtistId = String(Number(song.artist_id || 0));

                item.innerHTML = `
                    <span class="fw-bold text-muted" style="width: 26px;" data-favorite-page-index>1</span>
                    <img src="${@json(asset('images'))}/${song.song_image || 'default_song.png'}" width="44" height="44" class="rounded object-fit-cover" alt="${song.song_name || 'Song'}" onerror="this.src='https://via.placeholder.com/44'">
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-bold text-truncate">${song.song_name || 'Unknown'}</div>
                        <div class="text-muted text-truncate">${song.artist_name || ''}</div>
                    </div>
                    <button class="btn btn-link text-secondary p-0 btn-song-menu" type="button" data-action="like" data-song-id="${song.song_id}" data-like-icon-only title="Xóa khỏi yêu thích">
                        <i class="fas fa-heart-crack text-danger"></i>
                    </button>
                `;

                favoritesList.insertBefore(item, favoritesList.firstChild);
                refreshFavoritesPageState();
            }

            function removeSongFromFavoritesPageList(songId) {
                const favoritesList = document.getElementById('favorites-page-songs-list');

                if (!favoritesList) {
                    return;
                }

                const item = favoritesList.querySelector(`[data-favorite-page-item][data-song-id="${Number(songId)}"]`);

                if (item) {
                    item.remove();
                }

                refreshFavoritesPageState();
            }

            function refreshLikeActionButtons(songId = null) {
                const selector = songId
                    ? `[data-action="like"][data-song-id="${Number(songId)}"]`
                    : '[data-action="like"]';

                document.querySelectorAll(selector).forEach(function (button) {
                    const liked = likedSongIds.has(Number(button.dataset.songId));

                    if (button.hasAttribute('data-like-icon-only')) {
                        button.innerHTML = liked
                            ? '<i class="fas fa-heart-crack text-danger"></i>'
                            : '<i class="fas fa-heart text-danger"></i>';
                        button.setAttribute('title', liked ? 'Xóa khỏi yêu thích' : 'Thêm vào yêu thích');
                        return;
                    }

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
                    resetPlayerState();
                    hidePlayerBar();
                    clearPersistedPlaybackState();
                    clearQueueState();
                    refreshQueueOrderLabels();
                    refreshSidebarEmptyStates();
                    return;
                }

                resetPlayerState();
                hidePlayerBar();
                clearPersistedPlaybackState();
                saveQueueState();
                refreshQueueOrderLabels();
                refreshSidebarEmptyStates();
            }

            function clearQueueSongs() {
                songs.length = 0;

                if (queueSongsList) {
                    queueSongsList.innerHTML = '';
                }

                resetPlayerState();
                hidePlayerBar();
                clearPersistedPlaybackState();
                clearQueueState();
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

            async function addSongToPlaylistOnServer(songId, playlistName = '', playlistId = 0) {
                const response = await fetch(addSongToPlaylistUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        song_id: Number(songId),
                        playlist_name: playlistName,
                        playlist_id: Number(playlistId || 0),
                    }),
                });

                if (!response.ok) {
                    throw new Error('Add song to playlist failed');
                }

                return response.json();
            }

            async function removeSongFromPlaylistOnServer(playlistId, songId) {
                const response = await fetch(removeSongFromPlaylistUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        playlist_id: Number(playlistId),
                        song_id: Number(songId),
                    }),
                });

                if (!response.ok) {
                    throw new Error('Remove song from playlist failed');
                }

                return response.json();
            }

            function createPlaylistItem(playlist) {
                const wrapper = document.createElement('div');
                wrapper.className = 'playlist-chip-wrap';
                wrapper.dataset.playlistItem = '';
                wrapper.dataset.playlistId = String(playlist.playlist_id);

                const chip = document.createElement('button');
                chip.type = 'button';
                chip.className = 'playlist-chip';
                chip.innerHTML = '<span class="playlist-chip-icon"><i class="fas fa-music"></i></span><span class="playlist-chip-name"></span>';
                const chipName = chip.querySelector('.playlist-chip-name');
                if (chipName) {
                    chipName.textContent = playlist.playlist_name || 'Playlist mới';
                }

                const menuButton = document.createElement('button');
                menuButton.type = 'button';
                menuButton.className = 'playlist-chip-menu-btn';
                menuButton.dataset.bsToggle = 'dropdown';
                menuButton.setAttribute('aria-expanded', 'false');
                menuButton.setAttribute('data-playlist-menu', '');
                menuButton.innerHTML = '<i class="fas fa-ellipsis-v"></i>';

                const menu = document.createElement('ul');
                menu.className = 'dropdown-menu dropdown-menu-end playlist-dropdown';
                menu.innerHTML = `<li><button type="button" class="dropdown-item" data-playlist-remove="" data-playlist-id="${playlist.playlist_id}"><i class="fas fa-trash me-2"></i>Xóa Playlist</button></li>`;

                const songs = document.createElement('div');
                songs.className = 'playlist-song-list';
                songs.setAttribute('data-playlist-songs', '');

                wrapper.appendChild(chip);
                wrapper.appendChild(menuButton);
                wrapper.appendChild(menu);
                wrapper.appendChild(songs);

                return wrapper;
            }

            function addSongToPlaylistDisplay(playlistId, song) {
                if (!playlistContainer || !song) {
                    return;
                }

                const playlistItem = playlistContainer.querySelector(`[data-playlist-item][data-playlist-id="${playlistId}"]`);

                if (!playlistItem) {
                    return;
                }

                let songsContainer = playlistItem.querySelector('[data-playlist-songs]');

                if (!songsContainer) {
                    songsContainer = document.createElement('div');
                    songsContainer.className = 'playlist-song-list';
                    songsContainer.setAttribute('data-playlist-songs', '');
                    playlistItem.appendChild(songsContainer);
                }

                const exists = songsContainer.querySelector(`[data-song-id="${song.song_id}"]`);

                if (exists) {
                    exists.remove();
                }

                const songWrap = document.createElement('div');
                songWrap.className = 'playlist-song-wrap';
                songWrap.dataset.playlistSongItem = '';
                songWrap.dataset.songId = String(song.song_id);
                songWrap.dataset.playlistId = String(playlistId);
                songWrap.innerHTML = `<button type="button" class="playlist-song-item" data-queue-song="" data-song-id="${song.song_id}"><div class="playlist-song-name text-truncate">${song.song_name || 'Unknown'}</div><div class="playlist-song-artist text-truncate">${song.artist_name || ''}</div></button><button type="button" class="playlist-song-menu-btn" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button><ul class="dropdown-menu dropdown-menu-end playlist-song-dropdown"><li><button type="button" class="dropdown-item" data-playlist-song-remove="" data-playlist-id="${playlistId}" data-song-id="${song.song_id}"><i class="fas fa-trash me-2"></i>Xóa khỏi playlist</button></li></ul>`;

                songsContainer.insertBefore(songWrap, songsContainer.firstChild);

                while (songsContainer.children.length > 8) {
                    songsContainer.removeChild(songsContainer.lastChild);
                }
            }

            function refreshPlaylistEmptyState() {
                if (!playlistContainer || !playlistEmpty) {
                    return;
                }

                playlistEmpty.classList.toggle('d-none', playlistContainer.children.length > 0);
            }

            function loadPlaylistOptions() {
                if (!playlistSelect) {
                    return;
                }

                playlistSelect.innerHTML = '<option value="">-- Chọn playlist --</option>';

                const playlistItems = playlistContainer
                    ? Array.from(playlistContainer.querySelectorAll('[data-playlist-item]'))
                    : [];

                playlistItems.forEach(function (item) {
                    const playlistId = item.dataset.playlistId || '';
                    const nameNode = item.querySelector('.playlist-chip-name');
                    const playlistName = nameNode ? nameNode.textContent.trim() : '';

                    if (!playlistId || !playlistName) {
                        return;
                    }

                    const option = document.createElement('option');
                    option.value = playlistId;
                    option.textContent = playlistName;
                    playlistSelect.appendChild(option);
                });

                const newOption = document.createElement('option');
                newOption.value = '__new__';
                newOption.textContent = '+ Tạo playlist mới';
                playlistSelect.appendChild(newOption);
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

            function setSeekVisual(percent) {
                const clamped = Math.min(100, Math.max(0, Number(percent) || 0));

                if (seekFill) {
                    seekFill.style.width = `${clamped}%`;
                }

                if (seekBar) {
                    seekBar.setAttribute('aria-valuenow', String(Math.round(clamped)));
                }
            }

            function seekAudioToPercent(percent) {
                if (!audio.duration) {
                    return;
                }

                const normalizedPercent = Math.min(100, Math.max(0, Number(percent) || 0));
                const nextTime = (normalizedPercent / 100) * audio.duration;

                if (Number.isFinite(nextTime)) {
                    audio.currentTime = nextTime;
                    setSeekVisual(normalizedPercent);
                }
            }

            function seekAudioToClientX(clientX) {
                if (!audio.duration || !seekBar) {
                    return;
                }

                const rect = seekBar.getBoundingClientRect();
                const percent = Math.min(1, Math.max(0, (clientX - rect.left) / rect.width));
                seekAudioToPercent(percent * 100);
                currentTimeLabel.textContent = formatTime(audio.currentTime);
            }

            function getSongSource(song) {
                if (!song || !song.song_url) {
                    return '';
                }

                const rawUrl = String(song.song_url || '').trim();

                if (rawUrl.startsWith('http://') || rawUrl.startsWith('https://')) {
                    return rawUrl;
                }

                if (rawUrl.startsWith('/storage/')) {
                    return rawUrl;
                }

                if (rawUrl.startsWith('storage/')) {
                    return '/' + rawUrl;
                }

                if (rawUrl.startsWith('song/')) {
                    return '/storage/' + rawUrl;
                }

                if (rawUrl.startsWith('/song/')) {
                    return '/storage' + rawUrl;
                }

                return '/storage/song/' + rawUrl;
            }

            function updateLikeButton(song) {
                const isLiked = song && likedSongIds.has(Number(song.song_id));
                likeButton.innerHTML = isLiked ? '<i class="fas fa-heart text-danger"></i>' : '<i class="far fa-heart"></i>';
                likeButton.dataset.liked = isLiked ? '1' : '0';
            }

            function updateControlStates() {
                shuffleButton.classList.toggle('is-active', shuffleEnabled);

                repeatButton.innerHTML = '<i class="fas fa-rotate-right"></i>';
                repeatButton.classList.toggle('is-active', repeatMode !== 'off');
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

                document.querySelectorAll('[data-playlist-song-item]').forEach(function (item) {
                    item.classList.toggle('active-song', Number(item.dataset.songId) === Number(songId));
                });
            }

            function updatePlayer(song, autoplay = false) {
                if (!song) {
                    return;
                }

                revealPlayerBar();

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
                setSeekVisual(0);

                updateActiveStates(song.song_id);
                updateLikeButton(song);

                if (autoplay) {
                    pushHistoryRealtime(song);
                    audio.play().catch(function () {
                        playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
                    });
                } else {
                    playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
                }
            }

            function savePlaybackState() {
                if (!audio || !songs.length || currentIndex < 0 || !songs[currentIndex]) {
                    return;
                }

                if (isRestoringPlayback) {
                    return;
                }

                const currentSong = songs[currentIndex];
                const state = {
                    song_id: Number(currentSong.song_id || 0),
                    song_data: currentSong,
                    current_time: Number(audio.currentTime || 0),
                    volume: Number(audio.volume || 0),
                    paused: Boolean(audio.paused),
                    shuffle_enabled: Boolean(shuffleEnabled),
                    repeat_mode: repeatMode,
                };

                try {
                    sessionStorage.setItem(playbackStateKey, JSON.stringify(state));
                } catch (error) {}

                try {
                    window.name = `${playbackStateWindowKey}${JSON.stringify(state)}`;
                } catch (error) {}
            }

            function clearPersistedPlaybackState() {
                try {
                    sessionStorage.removeItem(playbackStateKey);
                } catch (error) {}

                try {
                    const winName = String(window.name || '');

                    if (winName.startsWith(playbackStateWindowKey)) {
                        window.name = '';
                    }
                } catch (error) {}
            }

            function isReloadNavigation() {
                try {
                    const entries = window.performance && window.performance.getEntriesByType
                        ? window.performance.getEntriesByType('navigation')
                        : [];

                    if (entries && entries[0] && entries[0].type) {
                        return entries[0].type === 'reload';
                    }

                    if (window.performance && window.performance.navigation) {
                        return window.performance.navigation.type === 1;
                    }
                } catch (error) {}

                return false;
            }

            function getPersistedPlaybackStateRaw() {
                let rawState = '';

                try {
                    rawState = sessionStorage.getItem(playbackStateKey) || '';
                } catch (error) {}

                if (rawState) {
                    return rawState;
                }

                try {
                    const winName = String(window.name || '');

                    if (winName.startsWith(playbackStateWindowKey)) {
                        return winName.slice(playbackStateWindowKey.length);
                    }
                } catch (error) {}

                return '';
            }

            function restorePlaybackState() {
                const reloadedPage = isReloadNavigation();

                const rawState = getPersistedPlaybackStateRaw();

                if (!rawState) {
                    return false;
                }

                let state = null;

                try {
                    state = JSON.parse(rawState);
                } catch (error) {
                    return false;
                }

                if (!state) {
                    return false;
                }

                const songId = Number(state.song_id || 0);

                if (!songId) {
                    return false;
                }

                shuffleEnabled = Boolean(state.shuffle_enabled);
                if (['off', 'one', 'all'].includes(state.repeat_mode)) {
                    repeatMode = state.repeat_mode;
                }
                updateControlStates();

                const restoredSong = getSongById(songId) || state.song_data;

                if (!restoredSong) {
                    return false;
                }

                const queueResult = ensureSongInQueue(restoredSong);

                if (queueResult.added) {
                    addSongToSidebarList(restoredSong, 'queue');
                }

                isRestoringPlayback = true;
                updatePlayer(songs[queueResult.index], false);

                const restoreVolume = Number(state.volume);
                if (Number.isFinite(restoreVolume) && restoreVolume >= 0 && restoreVolume <= 1) {
                    audio.volume = restoreVolume;
                    if (volumeRange) {
                        volumeRange.value = String(Math.round(restoreVolume * 100));
                        updateVolumeVisual(volumeRange.value);
                    }
                }

                const resumeAt = Number(state.current_time || 0);
                const shouldPlay = !reloadedPage && state.paused === false;

                const applyResumeState = function () {
                    const finishRestore = function () {
                        isRestoringPlayback = false;
                        savePlaybackState();
                    };

                    if (Number.isFinite(resumeAt) && resumeAt > 0) {
                        const safeTime = audio.duration
                            ? Math.min(resumeAt, Math.max(0, audio.duration - 0.25))
                            : resumeAt;
                        audio.currentTime = safeTime;
                        currentTimeLabel.textContent = formatTime(safeTime);

                        if (audio.duration) {
                            setSeekVisual((safeTime / audio.duration) * 100);
                        }
                    }

                    if (shouldPlay) {
                        audio.play().then(function () {
                            if (Number.isFinite(resumeAt) && resumeAt > 0) {
                                const safeTimeAfterPlay = audio.duration
                                    ? Math.min(resumeAt, Math.max(0, audio.duration - 0.25))
                                    : resumeAt;
                                audio.currentTime = safeTimeAfterPlay;
                                if (audio.duration) {
                                    setSeekVisual((safeTimeAfterPlay / audio.duration) * 100);
                                }
                            }

                            finishRestore();
                        }).catch(function () {
                            finishRestore();
                        });
                        return;
                    }

                    finishRestore();
                };

                if (audio.readyState >= 1) {
                    applyResumeState();
                } else {
                    audio.addEventListener('loadedmetadata', applyResumeState, { once: true });
                    audio.addEventListener('canplay', applyResumeState, { once: true });
                }

                return true;
            }

            function savePlaybackStateOnNavigationIntent(event) {
                const target = event.target;

                if (!(target instanceof Element)) {
                    return;
                }

                const link = target.closest('a[href]');

                if (link) {
                    const href = (link.getAttribute('href') || '').trim();

                    if (!href || href.startsWith('#') || href.toLowerCase().startsWith('javascript:')) {
                        return;
                    }

                    savePlaybackState();
                    return;
                }

                const form = target.closest('form');

                if (form) {
                    savePlaybackState();
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
            window.playSongById = playSongById;

            function playNext() {
                if (!ensurePlaybackQueue()) {
                    return;
                }

                const navigationList = Array.isArray(songCatalog) && songCatalog.length > 0 ? songCatalog : songs;
                const currentSongId = Number(songs[currentIndex]?.song_id || 0);
                const currentNavIndex = navigationList.findIndex(function (item) {
                    return Number(item.song_id) === currentSongId;
                });

                if (!navigationList.length) {
                    return;
                }

                let targetIndex = currentNavIndex > -1 ? currentNavIndex : 0;

                if (shuffleEnabled) {
                    targetIndex = Math.floor(Math.random() * navigationList.length);

                    if (navigationList.length > 1) {
                        while (targetIndex === currentNavIndex) {
                            targetIndex = Math.floor(Math.random() * navigationList.length);
                        }
                    }
                } else {
                    targetIndex = (targetIndex + 1) % navigationList.length;
                }

                const nextSong = navigationList[targetIndex];
                const queueResult = ensureSongInQueue(nextSong);

                if (queueResult.added) {
                    addSongToSidebarList(nextSong, 'queue');
                }

                updatePlayer(songs[queueResult.index], true);
            }

            function playPrevious() {
                if (!ensurePlaybackQueue()) {
                    return;
                }

                if (audio.currentTime > 4) {
                    audio.currentTime = 0;
                    return;
                }

                const navigationList = Array.isArray(songCatalog) && songCatalog.length > 0 ? songCatalog : songs;
                const currentSongId = Number(songs[currentIndex]?.song_id || 0);
                const currentNavIndex = navigationList.findIndex(function (item) {
                    return Number(item.song_id) === currentSongId;
                });

                if (!navigationList.length) {
                    return;
                }

                let targetIndex = currentNavIndex > -1 ? currentNavIndex : 0;

                if (shuffleEnabled) {
                    targetIndex = Math.floor(Math.random() * navigationList.length);

                    if (navigationList.length > 1) {
                        while (targetIndex === currentNavIndex) {
                            targetIndex = Math.floor(Math.random() * navigationList.length);
                        }
                    }
                } else {
                    targetIndex = (targetIndex - 1 + navigationList.length) % navigationList.length;
                }

                const prevSong = navigationList[targetIndex];
                const queueResult = ensureSongInQueue(prevSong);

                if (queueResult.added) {
                    addSongToSidebarList(prevSong, 'queue');
                }

                updatePlayer(songs[queueResult.index], true);
            }

            function togglePlayPause() {
                if (!audio.src) {
                    if (!ensurePlaybackQueue()) {
                        return;
                    }

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
                savePlaybackState();
            }

            function bindSongCardClicks(scope = document) {
                scope.querySelectorAll('[data-song-card]').forEach(function (card) {
                    if (card.dataset.playBound === '1') {
                        return;
                    }

                    card.dataset.playBound = '1';
                    card.addEventListener('click', function (event) {
                        if (event.target.closest('button, a, .dropdown-menu, .dropdown-toggle')) {
                            return;
                        }

                        playSongById(this.dataset.songId, true, this);
                    });
                });
            }

            function syncTopMenuActive(targetUrl) {
                let targetPath = '';

                try {
                    targetPath = new URL(targetUrl, window.location.origin).pathname;
                } catch (error) {
                    return;
                }

                document.querySelectorAll('.top-menu-link').forEach(function (link) {
                    let linkPath = '';

                    try {
                        linkPath = new URL(link.href, window.location.origin).pathname;
                    } catch (error) {
                        return;
                    }

                    link.classList.toggle('active', linkPath === targetPath);
                });
            }

            async function loadTopMenuContent(url, pushToHistory = true) {
                savePlaybackState();

                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) {
                    throw new Error('Cannot load top menu content');
                }

                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const incomingMain = doc.querySelector('.col-lg-9.col-12');
                const currentMain = document.querySelector('.col-lg-9.col-12');

                if (!incomingMain || !currentMain) {
                    throw new Error('Main content block missing');
                }

                currentMain.innerHTML = incomingMain.innerHTML;
                bindSongCardClicks(currentMain);
                syncTopMenuActive(url);

                if (pushToHistory) {
                    window.history.pushState({ topMenuPartial: true, url: url }, '', url);
                }
            }

            bindSongCardClicks();

            document.addEventListener('click', function (event) {
                const topMenuLink = event.target.closest('.top-menu-link');

                if (!topMenuLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(topMenuLink.href)
                    .catch(function () {
                        window.location.href = topMenuLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const newsDetailLink = event.target.closest('[data-news-detail-link]');

                if (!newsDetailLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(newsDetailLink.href)
                    .catch(function () {
                        window.location.href = newsDetailLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const albumLink = event.target.closest('[data-album-link]');

                if (!albumLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(albumLink.href)
                    .catch(function () {
                        window.location.href = albumLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const artistLink = event.target.closest('[data-artist-link]');

                if (!artistLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(artistLink.href)
                    .catch(function () {
                        window.location.href = artistLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const genreLink = event.target.closest('[data-genre-link]');

                if (!genreLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(genreLink.href)
                    .catch(function () {
                        window.location.href = genreLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const favoritesLink = event.target.closest('[data-favorites-link]');

                if (!favoritesLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(favoritesLink.href)
                    .catch(function () {
                        window.location.href = favoritesLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const footerLink = event.target.closest('[data-footer-link]');

                if (!footerLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(footerLink.href)
                    .catch(function () {
                        window.location.href = footerLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const footerHelp = event.target.closest('[data-footer-help]');

                if (!footerHelp) {
                    return;
                }

                event.preventDefault();
                const topic = footerHelp.getAttribute('data-footer-help') || 'Mục này';
                showToast(`${topic} dang cap nhat`, 'info');
            });

            document.addEventListener('click', function (event) {
                const profileLink = event.target.closest('[data-profile-link]');

                if (!profileLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(profileLink.href)
                    .catch(function () {
                        window.location.href = profileLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const leaderboardLink = event.target.closest('[data-leaderboard-link]');

                if (!leaderboardLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(leaderboardLink.href)
                    .catch(function () {
                        window.location.href = leaderboardLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const homeLink = event.target.closest('[data-home-link]');

                if (!homeLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(homeLink.href)
                    .catch(function () {
                        window.location.href = homeLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const newReleasesLink = event.target.closest('[data-new-releases-link]');

                if (!newReleasesLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(newReleasesLink.href)
                    .catch(function () {
                        window.location.href = newReleasesLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const albumListLink = event.target.closest('[data-album-list-link]');

                if (!albumListLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(albumListLink.href)
                    .catch(function () {
                        window.location.href = albumListLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const artistListLink = event.target.closest('[data-artist-list-link]');

                if (!artistListLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(artistListLink.href)
                    .catch(function () {
                        window.location.href = artistListLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const genreListLink = event.target.closest('[data-genre-list-link]');

                if (!genreListLink) {
                    return;
                }

                event.preventDefault();

                loadTopMenuContent(genreListLink.href)
                    .catch(function () {
                        window.location.href = genreListLink.href;
                    });
            });

            document.addEventListener('click', function (event) {
                const shareArticleButton = event.target.closest('[data-share-article]');

                if (!shareArticleButton) {
                    return;
                }

                event.preventDefault();

                const shareTitle = shareArticleButton.dataset.shareTitle || 'Tin tuc';
                const shareUrl = window.location.href;

                if (navigator.share) {
                    navigator.share({
                        title: shareTitle,
                        text: 'Xem bai viet nay',
                        url: shareUrl,
                    }).then(function () {
                        showToast('Da chia se bai viet', 'success');
                    }).catch(function () {
                        showToast('Khong the chia se bai viet', 'error');
                    });
                    return;
                }

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(shareUrl)
                        .then(function () {
                            showToast('Da sao chep lien ket bai viet', 'success');
                        })
                        .catch(function () {
                            showToast('Khong the sao chep lien ket', 'error');
                        });
                    return;
                }

                showToast('Trinh duyet khong ho tro chia se', 'info');
            });

            window.addEventListener('popstate', function () {
                loadTopMenuContent(window.location.href, false).catch(function () {});
            });

            document.addEventListener('click', function (event) {
                const playlistChip = event.target.closest('.playlist-chip');

                if (!playlistChip) {
                    return;
                }

                const playlistItem = playlistChip.closest('[data-playlist-item]');

                if (!playlistItem) {
                    return;
                }

                event.preventDefault();
                playlistItem.classList.toggle('is-collapsed');
            });

            document.addEventListener('click', function (event) {
                const queueButton = event.target.closest('[data-queue-song]');

                if (queueButton) {
                    playSongById(queueButton.dataset.songId, true, queueButton);
                }
            });

            document.addEventListener('click', function (event) {
                const playAllButton = event.target.closest('[data-play-all-songs]');

                if (!playAllButton) {
                    return;
                }

                event.preventDefault();

                let songIdsFromButton = [];

                try {
                    songIdsFromButton = JSON.parse(playAllButton.dataset.songIds || '[]');
                } catch (error) {
                    songIdsFromButton = [];
                }

                const listContainer = playAllButton.closest('.row, .col-lg-4, .col-lg-8, .card, .container, .container-fluid') || document;
                const songIdsFromVisibleList = Array.from(listContainer.querySelectorAll('[data-song-card][data-song-id]'))
                    .map(function (item) {
                        return Number(item.dataset.songId || 0);
                    })
                    .filter(function (songId) {
                        return Number.isFinite(songId) && songId > 0;
                    });

                const orderedSongIds = (songIdsFromVisibleList.length ? songIdsFromVisibleList : songIdsFromButton)
                    .map(function (songId) {
                        return Number(songId || 0);
                    })
                    .filter(function (songId) {
                        return Number.isFinite(songId) && songId > 0;
                    });

                const uniqueSongIds = Array.from(new Set(orderedSongIds));

                if (uniqueSongIds.length === 0) {
                    showToast('Khong co bai hat de phat', 'info');
                    return;
                }

                uniqueSongIds.forEach(function (songId) {
                    const song = getSongById(songId, playAllButton);

                    if (!song) {
                        return;
                    }

                    const queueResult = ensureSongInQueue(song);

                    if (queueResult.added) {
                        addSongToSidebarList(song, 'queue');
                    }
                });

                const firstSongId = uniqueSongIds[0] || null;

                if (firstSongId !== null) {
                    playSongById(firstSongId, true, playAllButton);
                    showToast('Dang phat toan bo danh sach', 'success');
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
                            removeSongFromFavoritesPageList(songId);
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
                const removePlaylistSongButton = event.target.closest('[data-playlist-song-remove]');

                if (!removePlaylistSongButton) {
                    return;
                }

                event.preventDefault();
                event.stopPropagation();

                const playlistId = Number(removePlaylistSongButton.dataset.playlistId || 0);
                const songId = Number(removePlaylistSongButton.dataset.songId || 0);

                if (!playlistId || !songId) {
                    return;
                }

                removeSongFromPlaylistOnServer(playlistId, songId)
                    .then(function (data) {
                        if (!data.deleted) {
                            showToast('Khong the xoa khoi playlist', 'error');
                            return;
                        }

                        const songItem = removePlaylistSongButton.closest('[data-playlist-song-item]');

                        if (songItem) {
                            songItem.remove();
                        }

                        showToast('Da xoa khoi playlist', 'success');
                    })
                    .catch(function () {
                        showToast('Khong the xoa khoi playlist', 'error');
                    });
            });

            document.addEventListener('click', function (event) {
                const openLikedButton = event.target.closest('[data-open-liked]');

                if (!openLikedButton) {
                    return;
                }

                event.preventDefault();

                const likedCollapseEl = document.getElementById('likedSongsCollapse');

                if (!likedCollapseEl) {
                    return;
                }

                const collapseInstance = bootstrap.Collapse.getOrCreateInstance(likedCollapseEl, {
                    toggle: false,
                });

                collapseInstance.show();
                likedCollapseEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
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

                if (action === 'playlist') {
                    const song = getSongById(songId, actionButton);

                    if (!song) {
                        return;
                    }

                    if (!addPlaylistModal || !playlistSelect || !playlistSaveButton) {
                        return;
                    }

                    pendingPlaylistSong = song;
                    loadPlaylistOptions();
                    playlistSelect.value = '';
                    if (playlistNewNameInput) {
                        playlistNewNameInput.value = '';
                        playlistNewNameInput.classList.add('d-none');
                    }
                    addPlaylistModal.show();
                }

                if (action === 'like') {
                    const song = getSongById(songId, actionButton);

                    toggleFavoriteOnServer(songId)
                        .then(function (data) {
                            if (data.liked) {
                                likedSongIds.add(Number(songId));
                                addSongToSidebarList(song, 'liked');
                                addSongToFavoritesPageList(song);
                            } else {
                                likedSongIds.delete(Number(songId));
                                removeSongFromLikedList(songId);
                                removeSongFromFavoritesPageList(songId);
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
                    const targetUrl = albumId > 0 ? `${albumsPageUrl}?album_id=${albumId}` : albumsPageUrl;

                    loadTopMenuContent(targetUrl)
                        .catch(function () {
                            savePlaybackState();
                            window.location.href = targetUrl;
                        });
                }

                if (action === 'artist') {
                    const artistId = Number(actionButton.dataset.artistId || actionButton.closest('[data-song-card]')?.dataset.songArtistId || 0);
                    const targetUrl = artistId > 0 ? `${artistsPageUrl}?artist_id=${artistId}` : artistsPageUrl;

                    loadTopMenuContent(targetUrl)
                        .catch(function () {
                            savePlaybackState();
                            window.location.href = targetUrl;
                        });
                }
            });

            playPauseButton.addEventListener('click', togglePlayPause);
            shuffleButton.addEventListener('click', function () {
                shuffleEnabled = !shuffleEnabled;
                updateControlStates();
                savePlaybackState();
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
                            addSongToFavoritesPageList(songs[currentIndex]);
                        } else {
                            removeSongFromLikedList(songId);
                            removeSongFromFavoritesPageList(songId);
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
                savePlaybackState();
            });

            audio.addEventListener('pause', function () {
                playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
                savePlaybackState();
            });

            audio.addEventListener('timeupdate', function () {
                if (!audio.duration || isSeeking) {
                    return;
                }

                setSeekVisual((audio.currentTime / audio.duration) * 100);
                currentTimeLabel.textContent = formatTime(audio.currentTime);

                const wholeSecond = Math.floor(audio.currentTime);
                if (wholeSecond !== lastSavedSecond) {
                    lastSavedSecond = wholeSecond;
                    savePlaybackState();
                }
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

            if (seekBar) {
                const endSeeking = function (event) {
                    if (!isSeeking) {
                        return;
                    }

                    if (event && typeof event.clientX === 'number') {
                        seekAudioToClientX(event.clientX);
                    }

                    isSeeking = false;

                    if (event && seekBar.releasePointerCapture && event.pointerId !== undefined) {
                        try {
                            seekBar.releasePointerCapture(event.pointerId);
                        } catch (error) {}
                    }
                };

                seekBar.addEventListener('pointerdown', function (event) {
                    event.preventDefault();
                    isSeeking = true;

                    if (seekBar.setPointerCapture) {
                        try {
                            seekBar.setPointerCapture(event.pointerId);
                        } catch (error) {}
                    }

                    seekAudioToClientX(event.clientX);
                });

                seekBar.addEventListener('pointermove', function (event) {
                    if (!isSeeking) {
                        return;
                    }

                    event.preventDefault();
                    seekAudioToClientX(event.clientX);
                });

                seekBar.addEventListener('pointerup', function (event) {
                    event.preventDefault();
                    endSeeking(event);
                });

                seekBar.addEventListener('pointercancel', endSeeking);

                window.addEventListener('pointerup', endSeeking);
                window.addEventListener('pointercancel', endSeeking);

                seekBar.addEventListener('click', function (event) {
                    seekAudioToClientX(event.clientX);
                });
            }


            volumeRange.addEventListener('input', function () {
                audio.volume = volumeRange.value / 100;
                updateVolumeVisual(volumeRange.value);
                savePlaybackState();
            });

            document.addEventListener('click', savePlaybackStateOnNavigationIntent, true);
            document.addEventListener('submit', function () {
                savePlaybackState();
            }, true);

            window.addEventListener('pagehide', function () {
                savePlaybackState();
            });

            document.addEventListener('visibilitychange', function () {
                if (document.visibilityState === 'hidden') {
                    savePlaybackState();
                }
            });

            window.addEventListener('beforeunload', function () {
                savePlaybackState();
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

            if (playlistSelect && playlistNewNameInput) {
                playlistSelect.addEventListener('change', function () {
                    const isNew = playlistSelect.value === '__new__';
                    playlistNewNameInput.classList.toggle('d-none', !isNew);

                    if (isNew) {
                        playlistNewNameInput.focus();
                    }
                });
            }

            if (playlistSaveButton && playlistSelect) {
                playlistSaveButton.addEventListener('click', function () {
                    if (!pendingPlaylistSong) {
                        return;
                    }

                    const selectedValue = playlistSelect.value;
                    const isNew = selectedValue === '__new__';
                    const playlistId = !isNew && selectedValue ? Number(selectedValue) : 0;
                    const playlistName = isNew && playlistNewNameInput ? playlistNewNameInput.value.trim() : '';

                    if (!playlistId && !playlistName) {
                        showToast('Vui long chon playlist hoac nhap ten moi', 'error');
                        return;
                    }

                    addSongToPlaylistOnServer(pendingPlaylistSong.song_id, playlistName, playlistId)
                        .then(function (data) {
                            if (!data || !data.playlist) {
                                showToast('Khong the them vao playlist', 'error');
                                return;
                            }

                            if (data.created_playlist && playlistContainer) {
                                const exists = playlistContainer.querySelector(`[data-playlist-item][data-playlist-id="${data.playlist.playlist_id}"]`);

                                if (!exists) {
                                    const playlistItem = createPlaylistItem(data.playlist);
                                    playlistContainer.insertBefore(playlistItem, playlistContainer.firstChild);
                                    refreshPlaylistEmptyState();
                                }
                            }

                            addSongToPlaylistDisplay(data.playlist.playlist_id, pendingPlaylistSong);

                            showToast(
                                data.added
                                    ? `Da them vao playlist: ${data.playlist.playlist_name}`
                                    : `Bai hat da co trong playlist: ${data.playlist.playlist_name}`,
                                data.added ? 'success' : 'info'
                            );

                            if (addPlaylistModal) {
                                addPlaylistModal.hide();
                            }
                        })
                        .catch(function () {
                            showToast('Khong the them vao playlist', 'error');
                        });
                });
            }

            if (addPlaylistModalEl) {
                addPlaylistModalEl.addEventListener('hidden.bs.modal', function () {
                    pendingPlaylistSong = null;
                    if (playlistSelect) {
                        playlistSelect.value = '';
                    }
                    if (playlistNewNameInput) {
                        playlistNewNameInput.value = '';
                        playlistNewNameInput.classList.add('d-none');
                    }
                });
            }

            const footerSubscribeForm = document.getElementById('footer-subscribe-form');
            const footerSubscribeEmail = document.getElementById('footer-subscribe-email');

            if (footerSubscribeForm && footerSubscribeEmail) {
                footerSubscribeForm.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const email = String(footerSubscribeEmail.value || '').trim();
                    const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                    const tokenInput = footerSubscribeForm.querySelector('input[name="_token"]');
                    const csrfToken = tokenInput ? tokenInput.value : '';

                    if (!isValidEmail) {
                        showToast('Vui lòng nhập email hợp lệ', 'error');
                        return;
                    }

                    fetch(footerSubscribeForm.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ email: email }),
                    })
                        .then(function (response) {
                            return response.json().then(function (data) {
                                if (!response.ok) {
                                    throw new Error(data.message || 'Đăng ký thất bại. Vui lòng thử lại.');
                                }
                                return data;
                            });
                        })
                        .then(function (data) {
                            footerSubscribeEmail.value = '';
                            showToast(data.message || 'Đăng ký nhận tin thành công', 'success');
                        })
                        .catch(function (error) {
                            showToast(error.message || 'Đăng ký thất bại. Vui lòng thử lại.', 'error');
                        });
                });
            }

            updateControlStates();
            updateVolumeVisual(volumeRange.value);
            restoreQueueState();
            refreshSidebarEmptyStates();
            refreshQueueOrderLabels();
            refreshPlaylistEmptyState();
            refreshLikeActionButtons();
            const restoredPlayback = restorePlaybackState();

            if (!restoredPlayback && !audio.src && songs.length) {
                updatePlayer(songs[0], false);
            }

            // --- BẮT ĐẦU: LOGIC TÌM KIẾM AJAX DÀNH CHO DASHBOARD (VANILLA JS) ---
            let searchTimeout;
            const searchInput = document.getElementById('searchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            const searchForm = document.getElementById('searchForm');
            const isUserLoggedIn = {{ Auth::check() ? 'true' : 'false' }}; 

            const HistoryManager = {
                getKey: () => isUserLoggedIn ? 'music_search_history_auth' : 'music_search_history_guest',
                get: function() { return JSON.parse(localStorage.getItem(this.getKey())) || []; },
                add: function(keyword) {
                    if(!keyword) return;
                    let h = this.get();
                    h = h.filter(k => k !== keyword);
                    h.unshift(keyword);
                    if(h.length > 5) h.pop();
                    localStorage.setItem(this.getKey(), JSON.stringify(h));
                },
                remove: function(keyword) {
                    let h = this.get().filter(k => k !== keyword);
                    localStorage.setItem(this.getKey(), JSON.stringify(h));
                },
                clear: function() { localStorage.removeItem(this.getKey()); }
            };

            const DropdownUI = {
                show: function() { 
                    searchDropdown.style.display = 'block'; 
                    searchDropdown.style.opacity = '0';
                    setTimeout(() => { searchDropdown.style.opacity = '1'; searchDropdown.style.transition = 'opacity 0.2s'; }, 10);
                },
                hide: function() { 
                    searchDropdown.style.opacity = '0';
                    setTimeout(() => { searchDropdown.style.display = 'none'; }, 200);
                },
                renderDefault: function(trendingData) {
                    let history = HistoryManager.get();
                    let html = '';
                    
                    if (isUserLoggedIn && history.length > 0) {
                        html += `<div class="dropdown-title">Lịch sử tìm kiếm <span id="clearHistoryBtn">Xóa tất cả</span></div>
                                <div class="history-tags">`;
                        history.forEach(k => {
                            html += `<div class="history-tag" data-key="${k}">
                                        <i class="fas fa-history"></i> <span class="h-text">${k}</span> <i class="fas fa-times del-btn"></i>
                                    </div>`;
                        });
                        html += `</div>`;
                    }

                    if (trendingData && trendingData.length > 0) {
                        html += `<div class="dropdown-title">Gợi ý thịnh hành</div>`;
                        trendingData.forEach(song => {
                            let imgSrc = song.song_image ? `/images/${song.song_image}` : 'https://via.placeholder.com/40';
                            let views = song.view_count >= 1000000 ? (song.view_count/1000000).toFixed(1) + 'M' : 
                                        (song.view_count >= 1000 ? (song.view_count/1000).toFixed(1) + 'K' : song.view_count);
                            
                            html += `
                            <div class="live-item suggestion-item" data-id="${song.song_id}">
                                <img src="${imgSrc}">
                                <div class="info">
                                    <p class="title">${song.song_name}</p>
                                    <p class="subtitle">${song.artist_name} • <i class="fas fa-headphones" style="font-size:10px;"></i> ${views}</p>
                                </div>
                            </div>`;
                        });
                    }
                    searchDropdown.innerHTML = html;
                },
                renderLiveSearch: function(data) {
                    let html = '';
                    if(data.artists && data.artists.length > 0) {
                        html += `<div class="dropdown-title">Nghệ sĩ</div>`;
                        data.artists.forEach(a => {
                            let imgSrc = a.avatar_image ? `/images/${a.avatar_image}` : 'https://via.placeholder.com/40';
                            html += `
                            <a href="{{ route('music.search') }}?q=${encodeURIComponent(a.artist_name)}" class="live-item text-decoration-none">
                                <img src="${imgSrc}" style="border-radius: 50%;">
                                <div class="info"><p class="title">${a.artist_name}</p></div>
                            </a>`;
                        });
                    }
                    if(data.albums && data.albums.length > 0) {
                        html += `<div class="dropdown-title mt-3">Album</div>`;
                        data.albums.forEach(al => {
                            let imgSrc = al.cover_image ? `/images/${al.cover_image}` : 'https://via.placeholder.com/40';
                            html += `
                            <a href="{{ route('music.search') }}?q=${encodeURIComponent(al.album_name)}" class="live-item text-decoration-none">
                                <img src="${imgSrc}" style="border-radius: 6px;">
                                <div class="info"><p class="title">${al.album_name}</p></div>
                            </a>`;
                        });
                    }
                    if(data.songs && data.songs.length > 0) {
                        html += `<div class="dropdown-title mt-3">Bài hát</div>`;
                        data.songs.forEach(s => {
                            let imgSrc = s.song_image ? `/images/${s.song_image}` : 'https://via.placeholder.com/40';
                            html += `
                            <div class="live-item suggestion-item" data-id="${s.song_id}">
                                <img src="${imgSrc}">
                                <div class="info">
                                    <p class="title">${s.song_name}</p>
                                    <p class="subtitle">${s.artist_name}</p>
                                </div>
                            </div>`;
                        });
                    }
                    if(html === '') html = '<div class="text-center text-muted py-3 small">Không tìm thấy kết quả</div>';
                    searchDropdown.innerHTML = html;
                }
            };

            if(searchInput) {
                searchInput.addEventListener('focus', function() {
                    let q = this.value.trim();
                    if(q === '') fetchDefault();
                    else fetchLive(q);
                    DropdownUI.show();
                });

                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    let q = this.value.trim();
                    if(q === '') { fetchDefault(); return; }
                    searchTimeout = setTimeout(() => fetchLive(q), 300);
                });
            }

            function fetchDefault() {
                fetch("{{ route('search.ajax') }}", { headers: { 'Accept': 'application/json' }})
                    .then(res => res.json())
                    .then(res => {
                        if(res.type === 'trending') DropdownUI.renderDefault(res.data);
                    }).catch(e => console.error(e));
            }

            function fetchLive(q) {
                fetch(`{{ route('search.ajax') }}?q=${encodeURIComponent(q)}`, { headers: { 'Accept': 'application/json' }})
                    .then(res => res.json())
                    .then(res => {
                        if(res.type === 'search') DropdownUI.renderLiveSearch(res);
                    }).catch(e => console.error(e));
            }

            if(searchForm) {
                searchForm.addEventListener('submit', function() {
                    let q = searchInput.value.trim();
                    if(q) HistoryManager.add(q);
                });
            }

            // Gắn event delegation chung cho toàn document
            document.addEventListener('click', function(e) {
                // Click vào chữ lịch sử
                const hText = e.target.closest('.history-tag .h-text');
                if (hText) {
                    let q = hText.closest('.history-tag').getAttribute('data-key');
                    searchInput.value = q;
                    searchForm.submit();
                    return;
                }

                // Click xóa 1 item lịch sử
                const delBtn = e.target.closest('.del-btn');
                if (delBtn) {
                    e.stopPropagation();
                    HistoryManager.remove(delBtn.closest('.history-tag').getAttribute('data-key'));
                    fetchDefault();
                    return;
                }

                // Click xóa tất cả lịch sử
                if (e.target.id === 'clearHistoryBtn') {
                    HistoryManager.clear();
                    fetchDefault();
                    return;
                }

                // Click bài hát gợi ý
                const suggestion = e.target.closest('.suggestion-item');
                if (suggestion) {
                    DropdownUI.hide();
                    if(!isUserLoggedIn) {
                        const modalEl = document.getElementById('loginRequireModal');
                        if(modalEl) bootstrap.Modal.getOrCreateInstance(modalEl).show();
                        return;
                    }
                    
                    let songId = suggestion.getAttribute('data-id');
                    if(songId && typeof window.playSongById === 'function') {
                        window.playSongById(songId, true); 
                        searchInput.value = ''; 
                    }
                    return;
                }

                // Click ra ngoài thanh tìm kiếm -> Ẩn dropdown
                if (!e.target.closest('.top-search-form')) {
                    DropdownUI.hide();
                }
            });
        });
    </script>
</body>
</html>