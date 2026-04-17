<x-music-layout>
    <x-slot name="title">{{ $artist->artist_name }}</x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        .container-artist {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* --- CSS Cho Thẻ Thông Tin Bên Trái --- */
        .artist-sidebar-card {
            background: white;
            border-radius: 16px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(229, 231, 235, 0.8);
            position: sticky;
            top: 100px; /* Cố định khi cuộn chuột */
        }

        /* ÉP BUỘC ẢNH PHẢI TRÒN XOE */
        .artist-avatar-circle {
            width: 200px !important;
            height: 200px !important;
            border-radius: 50% !important; /* Bo tròn hoàn toàn */
            object-fit: cover !important;
            aspect-ratio: 1/1 !important; /* Chống méo ảnh */
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            margin: 0 auto 24px auto;
            display: block;
            border: 4px solid #fff;
        }

        .artist-title {
            font-size: 28px;
            font-weight: 800;
            color: #2b2b2b;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .artist-role {
            color: #0d6efd; /* Màu xanh dương giống mẫu */
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 12px;
        }

        .artist-count {
            color: #888;
            font-size: 13px;
            margin-bottom: 24px;
        }

        .btn-play-all {
            background-color: #f82c75;
            color: white;
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 700;
            font-size: 16px;
            border: none;
            width: 100%;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-play-all:hover {
            background-color: #e01b60;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(248, 44, 117, 0.3);
        }

        /* --- CSS Cho Danh Sách Bài Hát Bên Phải --- */
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: #2b2b2b;
            border-left: 5px solid #bd0f4d; /* Vạch đỏ/hồng nổi bật */
            padding-left: 14px;
            margin-bottom: 24px;
            line-height: 1.2;
        }

        .song-item {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            background: white;
            border-radius: 12px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(229, 231, 235, 0.5);
            transition: all 0.2s ease;
            cursor: pointer;
            color: inherit;
            text-decoration: none;
        }

        .song-item:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
            border-color: rgba(248, 44, 117, 0.3);
            color: inherit;
        }

        .song-num {
            font-weight: 700;
            color: #6b7280;
            width: 30px;
            font-size: 14px;
        }

        .song-cover-sm {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 16px;
        }

        .song-info {
            flex: 1;
        }

        .song-name {
            font-weight: 700;
            color: #111827;
            margin: 0 0 4px 0;
            font-size: 15px;
        }

        .song-artist {
            color: #6b7280;
            font-size: 13px;
            margin: 0;
        }

        .back-link {
            color: #6b7280;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            font-weight: 600;
        }

        .back-link:hover {
            color: #f82c75;
        }

        /* Ẩn trạng thái Active của Menu khi ở trang chi tiết (Đã fix lỗi chữ tàng hình) */
        .navbar-nav .nav-link.active {
            background-color: transparent !important;
            color: #444 !important; /* Ép chữ về màu đen xám */
            box-shadow: none !important;
        }
        .navbar-nav .nav-link.active:hover {
            color: #f82c75 !important; /* Hover thì ra màu hồng */
        }
    </style>

    <div class="container py-4 container-artist">
        
        <a href="javascript:history.back()" class="back-link">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>

        <div class="row g-5">
            
            <div class="col-lg-4 col-md-5">
                <div class="artist-sidebar-card">
                    @php
                        $artistIndex = ($artist->artist_id ?? $artist->id ?? 1) % 8;
                        $artistIndex = $artistIndex === 0 ? 8 : $artistIndex;
                        $artistDefault = 'a' . $artistIndex . '.png';
                        $artistSource = $artist->image ?? $artist->artist_image ?? (isset($artist->new_image) ? $artist->new_image : null);
                        $firstSongId = $songs->count() > 0 ? ($songs->first()->song_id ?? $songs->first()->id ?? null) : null;
                    @endphp
                    <img src="{{ asset($artistSource ? 'storage/image/' . $artistSource : 'images/' . $artistDefault) }}" class="artist-avatar-circle" alt="{{ $artist->artist_name }}">

                    <h1 class="artist-title">{{ $artist->artist_name }}</h1>
                    <div class="artist-role">Nghệ sĩ</div>
                    <div class="artist-count">{{ count($songs) }} bài hát</div>

                    @guest
                        <button class="btn-play-all" data-bs-toggle="modal" data-bs-target="#requireLoginModal">
                            <i class="fas fa-play"></i> Phát Nhạc Ngay
                        </button>
                    @else
                        @if($firstSongId)
                            <a href="{{ route('music.song', ['id' => $firstSongId]) }}" class="btn-play-all">
                                <i class="fas fa-play"></i> Phát Nhạc Ngay
                            </a>
                        @else
                            <button class="btn-play-all" disabled style="opacity: 0.6; cursor: not-allowed;">
                                <i class="fas fa-play"></i> Phát Nhạc Ngay
                            </button>
                        @endif
                    @endguest
                </div>
            </div>

            <div class="col-lg-8 col-md-7">
                <h3 class="section-title">Danh sách bài hát</h3>
                
                @if($songs->count() > 0)
                    @foreach($songs as $idx => $song)
                        @php
                            $songImage = $song->image ?? $song->song_image ?? null;
                            $songId = $song->song_id ?? $song->id ?? 0;
                        @endphp
                        
                        @guest
                            <div class="song-item" data-bs-toggle="modal" data-bs-target="#requireLoginModal">
                        @else
                            <a href="{{ route('music.song', ['id' => $songId]) }}" class="song-item">
                        @endguest
                        
                            <div class="song-num">{{ $idx + 1 }}</div>
                            <img src="{{ asset($songImage ? 'storage/image/' . $songImage : 'images/s1.png') }}" alt="{{ $song->song_name }}" class="song-cover-sm">
                            <div class="song-info">
                                <p class="song-name">{{ $song->song_name }}</p>
                                <p class="song-artist">{{ $song->artist_name ?? 'Nghệ sĩ chưa rõ' }}</p>
                            </div>
                            
                        @guest
                            </div>
                        @else
                            </a>
                        @endguest
                        
                    @endforeach
                @else
                    <div class="alert alert-info border-0 shadow-sm rounded-3">Nghệ sĩ này chưa có bài hát nào.</div>
                @endif
            </div>

        </div>
    </div>
</x-music-layout>