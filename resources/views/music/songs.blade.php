<x-music-layout>
    <x-slot name="title">Bài hát</x-slot>

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
            margin: 0;
        }

        /* Đảm bảo lớp overlay đen và icon play không cản trở cú click chuột */
        .play-overlay {
            pointer-events: none !important; 
        }
        .music-card:hover .play-overlay {
            pointer-events: none !important;
        }
        
        /* Hiệu ứng đổi màu tên bài hát khi hover */
        .card-title {
            color: #2b2b2b;
            transition: color 0.2s ease;
        }
        .music-card:hover .card-title {
            color: #f82c75;
        }
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="title-highlight">Kho Bài Hát</h1>
            </div>
        </div>

        <div class="row g-4"> @forelse($songs as $song)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    @php
                        $songImage = $song->image ?? $song->song_image ?? (isset($song->new_image) ? $song->new_image : null);
                        $songId = $song->song_id ?? $song->id ?? 0;
                    @endphp

                    <div class="card h-100 shadow-sm border-0 music-card">
                        
                        @guest
                            <a href="javascript:void(0)" class="text-decoration-none restricted-action" data-bs-toggle="modal" data-bs-target="#requireLoginModal" onclick="if (!window.isAuthenticated) { bootstrap.Modal.getOrCreateInstance(document.getElementById('requireLoginModal')).show(); return false; }">
                        @else
                            <a href="{{ route('music.song', ['id' => $songId]) }}" class="text-decoration-none">
                        @endguest

                            <div class="card-img-wrapper">
                                <img src="{{ asset($songImage ? 'storage/image/' . $songImage : 'images/s1.png') }}" class="card-img-top" alt="{{ $song->song_name }}">
                                <div class="play-overlay">
                                    <div class="btn-play-circle">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-body text-center">
                                <h5 class="card-title mb-1 text-truncate">{{ $song->song_name }}</h5>
                                <p class="card-text text-muted mb-0 text-truncate">{{ $song->artist_name ?? 'Nghệ sĩ chưa rõ' }}</p>
                            </div>

                        </a> </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info border-0 shadow-sm rounded-3">Chưa có bài hát nào trong hệ thống.</div>
                </div>
            @endforelse
        </div>
    </div>
</x-music-layout>