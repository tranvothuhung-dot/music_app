<x-music-layout>
    <x-slot name="title">{{ $album->album_name }}</x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        .album-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
        }

        .album-info {
            display: flex;
            align-items: flex-end;
            gap: 2rem;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .album-cover {
            width: 180px;
            height: 180px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            object-fit: cover;
        }

        .album-details h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.02em;
        }

        .album-details p {
            font-size: 1.1rem;
            margin: 0;
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

    <div class="album-header">
        <div class="album-info">
            @php
                $albumImage = $album->image ?? $album->album_image ?? null;
            @endphp
            <img src="{{ asset($albumImage ? 'storage/image/' . $albumImage : 'images/al1.png') }}" alt="{{ $album->album_name }}" class="album-cover">
            <div class="album-details">
                <p style="font-size: 0.9rem; margin-bottom: 0.5rem;">Album</p>
                <h1>{{ $album->album_name }}</h1>
                <p>{{ $album->artist_name }}</p>
                <p style="font-size: 0.9rem; margin-top: 1rem;">{{ count($songs) }} bài hát</p>
            </div>
        </div>
    </div>

    <div class="songs-list">
        <h3 class="fw-bold mb-3">Danh sách bài hát</h3>
        
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
            <div class="alert alert-info">Album này chưa có bài hát nào.</div>
        @endif
    </div>

</x-music-layout>
