<x-music-layout>
    <x-slot name="title">{{ $genre->ten_danh_muc ?? $genre->genre_name ?? 'Thể loại' }}</x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        .genre-header {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
            text-align: center;
        }

        .genre-info {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .genre-icon {
            width: 120px;
            height: 120px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 3rem;
        }

        .genre-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .genre-header p {
            font-size: 1rem;
            margin: 0.5rem 0 0;
            opacity: 0.95;
        }

        .songs-list {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .song-item {
            display: flex;
            align-items: center;
            padding: 1.2rem;
            background: white;
            border-radius: 12px;
            margin-bottom: 0.8rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .song-item:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .song-num {
            font-weight: 700;
            color: #6b7280;
            width: 40px;
            text-align: center;
            margin-right: 1rem;
        }

        .song-cover-sm {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
        }

        .song-info {
            flex: 1;
        }

        .song-name {
            font-weight: 700;
            color: #111827;
            margin: 0;
            font-size: 0.95rem;
        }

        .song-artist {
            color: #6b7280;
            font-size: 0.85rem;
            margin: 0;
        }

        .play-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ff4081;
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            margin-left: auto;
        }

        .play-btn:hover {
            background: #e83274;
            transform: scale(1.1);
        }

        .back-link {
            color: #6b7280;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            padding: 0 15px;
        }

        .back-link:hover {
            color: #111827;
        }
    </style>

    <a href="javascript:history.back()" class="back-link">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>

    <div class="genre-header">
        <div class="genre-info">
            <div class="genre-icon">
                <i class="fas fa-music"></i>
            </div>
            <h1>{{ $genre->ten_danh_muc ?? $genre->genre_name ?? 'Thể loại' }}</h1>
            <p>{{ count($songs) }} bài hát</p>
        </div>
    </div>

    <div class="songs-list">
        <h3 class="fw-bold mb-3">Bài hát</h3>
        
        @if($songs->count() > 0)
            @foreach($songs as $idx => $song)
                @php
                    $songImage = $song->image ?? $song->song_image ?? null;
                    $songId = $song->song_id ?? $song->id ?? 0;
                @endphp
                <div class="song-item">
                    <div class="song-num">{{ $idx + 1 }}</div>
                    <img src="{{ asset($songImage ? 'storage/image/' . $songImage : 'images/s1.png') }}" alt="{{ $song->song_name }}" class="song-cover-sm">
                    <div class="song-info">
                        <p class="song-name">{{ $song->song_name }}</p>
                        <p class="song-artist">{{ $song->artist_name ?? 'Nghệ sĩ chưa rõ' }}</p>
                    </div>
                    @guest
                        <button class="play-btn" data-bs-toggle="modal" data-bs-target="#requireLoginModal" title="Play">
                            <i class="fas fa-play"></i>
                        </button>
                    @else
                        <a href="{{ route('music.song', ['id' => $songId]) }}" class="play-btn" title="Play">
                            <i class="fas fa-play"></i>
                        </a>
                    @endguest
                </div>
            @endforeach
        @else
            <div class="alert alert-info">Thể loại này chưa có bài hát nào.</div>
        @endif
    </div>

</x-music-layout>
