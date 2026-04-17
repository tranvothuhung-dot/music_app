<x-music-layout>
    <x-slot name="title">Bài hát</x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        .title-highlight {
            font-family: 'Poppins', sans-serif;
            font-size: 38px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #2b2b2b;
            border-left: 6px solid #f82c75;
            padding-left: 16px;
            line-height: 1.2;
            margin: 0;
        }
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="title-highlight">Kho Bài Hát</h1>
            </div>
        </div>

        <div class="row g-3">
            @forelse($songs as $song)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0">
                        @php
                            $songImage = $song->image ?? $song->song_image ?? (isset($song->new_image) ? $song->new_image : null);
                        @endphp
                        <img src="{{ asset($songImage ? 'storage/image/' . $songImage : 'images/s1.png') }}" class="card-img-top" alt="{{ $song->song_name }}">
                        <div class="card-body">
                            <h5 class="card-title mb-1">{{ $song->song_name }}</h5>
                            <p class="card-text text-muted mb-3">{{ $song->artist_name ?? 'Nghệ sĩ chưa rõ' }}</p>
                            @auth
                                <button class="btn btn-sm btn-primary">Nghe ngay</button>
                            @else
                                <button class="btn btn-sm btn-outline-primary restricted-action" data-bs-toggle="modal" data-bs-target="#requireLoginModal">Đăng nhập để nghe</button>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">Chưa có bài hát nào trong hệ thống.</div>
                </div>
            @endforelse
        </div>
    </div>
</x-music-layout>