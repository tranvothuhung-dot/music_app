<x-music-layout>
    <x-slot name="title">{{ $song->song_name }}</x-slot>
 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        .song-detail-page {
        background: #f5f7fb;
        font-family: 'Poppins', sans-serif;
        padding: 2.5rem 16px;
        background: #f5f7fb;
        font-family: 'Poppins', sans-serif;  
        justify-content: center;
        padding: 2rem 16px; /* tăng padding cho đẹp */
    }
        .song-detail-card {
        width: 100%;
        max-width: 680px;
        background: #ffffff;
        border-radius: 32px;
        box-shadow: 0 30px 80px rgba(15, 23, 42, 0.08);
        overflow: hidden;
        max-height: calc(100vh - 120px); /* ✅ giới hạn chiều cao */
    }
        .song-detail-cover {
            padding: 2rem;
            display: flex;
            justify-content: center;
            background: #f6f7fb;
        }
        .song-detail-cover img {
            width: 228px;
            height: 228px;
            object-fit: cover;
            border-radius: 24px;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.12);
            transition: transform 0.3s ease;
        }
        .song-detail-cover img:hover {
            transform: scale(1.03);
        }
        .song-detail-body {
            padding: 1.6rem 2rem 2rem;
        }
        .song-detail-title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #111827;
            margin-bottom: 0.4rem;
        }
        .song-detail-artist {
            display: inline-block;
            color: #2563eb;
            font-size: 1.05rem;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 1.8rem;
        }
        .song-detail-artist:hover {
            text-decoration: underline;
        }
        .song-detail-panel {
            margin: 0 auto;
            max-width: 95%;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            padding: 1.5rem 1.5rem;
            text-align: center;
            box-shadow: inset 0 0 0 1px rgba(229, 231, 235, 0.8);
        }
        .song-detail-badge {
            width: 64px;
            height: 64px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: rgba(255, 64, 129, 0.12);
            color: #ff4081;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .song-detail-panel h5 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #111827;
            margin-bottom: 0.6rem;
        }
        .song-detail-panel p {
            font-family: 'Poppins', sans-serif;
            font-size: 0.98rem;
            line-height: 1.75;
            color: #6b7280;
            margin-bottom: 1.4rem;
        }
        .song-detail-button {
            width: 100%;
            max-width: 280px;
            margin: 0 auto;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            background: #ff4081;
            color: #ffffff;
            border: none;
            border-radius: 999px;
            padding: 0.95rem 1.35rem;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 16px 34px rgba(255, 64, 129, 0.18);
            transition: transform 0.2s ease, background 0.2s ease;
            cursor: pointer;
        }
        .song-detail-button:hover {
            background: #e83274;
            transform: translateY(-2px);
        }
        .song-detail-back {
            color: #6b7280;
            transition: color 0.2s ease;
            font-weight: 600;
            text-decoration: none;
        }
        .song-detail-back:hover {
            color: #111827;
        }
    </style>

    <div class="song-detail-page">
        <div class="container d-flex flex-column align-items-center">
            
            <div class="song-detail-card">
                <div class="song-detail-cover">
                    @php
                        $songImage = $song->image ?? $song->song_image ?? (isset($song->new_image) ? $song->new_image : null);
                    @endphp
                    <img src="{{ asset($songImage ? 'images/' . $songImage : 'images/s1.png') }}" alt="{{ $song->song_name }}">
                </div>
                
                <div class="song-detail-body text-center">
                    <h1 class="song-detail-title">{{ $song->song_name }}</h1>
                    <a href="#" class="song-detail-artist">{{ $song->artist_name ?? 'Nghệ sĩ chưa rõ' }}</a>

                    @auth
                        <audio controls autoplay class="w-100 mt-3 mb-3 rounded-3" style="max-width: 100%;">
                            <source src="{{ asset('songs_1/' . ($song->song_url ?? '')) }}" type="audio/mpeg">
                            Trình duyệt của bạn không hỗ trợ audio.
                        </audio>
                    @else
                        <div class="song-detail-panel">
                            <div class="song-detail-badge mx-auto">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h5>Đăng nhập để nghe</h5>
                            <p>Bạn cần tài khoản để thưởng thức bài hát này.</p>
                            <button type="button" class="btn btn-pink song-detail-button" data-bs-toggle="modal" data-bs-target="#requireLoginModal">
                                Đăng nhập ngay
                            </button>
                        </div>
                    @endauth
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="javascript:history.back()" class="song-detail-back d-inline-flex align-items-center gap-2">
                <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

        </div>
    </div>
</x-music-layout>
