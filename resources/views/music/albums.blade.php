<x-music-layout>
    <x-slot name="title">Album</x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        .title-highlight {
            font-family: 'Poppins', sans-serif;
            font-size: 38px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--primary-color);
            border-left: 6px solid #f82c75;
            padding-left: 16px;
            line-height: 1.2;
            margin: 0px;
        }
        /* Hiệu ứng hover nhẹ cho card để biết là có thể click */
        .album-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            margin-bottom: 24px;
        }
        .album-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        }
        .album-row {
            row-gap: 1.5rem;
        }
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="title-highlight">Album</h1>
            </div>
        </div>

        <div class="row album-row g-3">
            @forelse($albums as $album)
                @php
                    $albumIndex = $loop->iteration <= 8 ? $loop->iteration : ($loop->iteration % 8 ?: 8);
                    $albumDefault = 'al' . $albumIndex . '.png';
                    $albumSource = $album->image ?? $album->album_image ?? (isset($album->new_image) ? $album->new_image : null);
                    
                    // Lấy ID của album để tạo đường dẫn (Link)
                    $albumId = $album->album_id ?? $album->id ?? 0;
                @endphp
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 album-card">
                        
                        <a href="{{ route('music.album', $albumId) }}">
                            <img src="{{ asset($albumSource ? 'images/' . $albumSource : 'images/' . $albumDefault) }}" class="card-img-top" alt="{{ $album->album_name }}">
                        </a>
                        
                        <div class="card-body">
                            <h5 class="card-title mb-1">
                                <a href="{{ route('music.album', $albumId) }}" class="text-dark text-decoration-none">{{ $album->album_name }}</a>
                            </h5>
                            <p class="card-text text-muted mb-3">{{ $album->artist_name ?? 'Nghệ sĩ chưa rõ' }}</p>
                            
                            <a href="{{ route('music.album', $albumId) }}" class="btn btn-sm btn-outline-pink">Xem album</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">Chưa có album nào trong hệ thống.</div>
                </div>
            @endforelse
        </div>
    </div>
</x-music-layout>

