<x-music-layout>
    <x-slot name="title">Nghệ sĩ</x-slot>

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

        /* Thêm hiệu ứng hover cho thẻ nghệ sĩ giống trang Album */
        .artist-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
            padding: 0;
        }
        
        .artist-card:hover {
            transform: translateY(-4px);
        }

        /* Bo tròn ảnh nghệ sĩ ngoài danh sách */
        .artist-avatar-box {
            width: 180px;
            height: 180px;
            margin: 0 auto 18px;
            overflow: hidden;
            border-radius: 50%;
            background: transparent;
        }
        
        .artist-avatar-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%; /* Hình tròn đặc trưng của nghệ sĩ */
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .artist-card:hover .artist-avatar-box img {
            transform: scale(1.05);
        }

        .artist-card .card-body {
            background: transparent;
            padding: 0 0 1rem;
        }
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="title-highlight">Nghệ Sĩ</h1>
            </div>
        </div>
        
        <div class="row g-3">
            @forelse($artists as $artist)
                <div class="col-md-3 mb-4">
                    <div class="card artist-card h-100 text-center shadow-sm border-0">
                        @php
                            $artistIndex = $loop->iteration <= 8 ? $loop->iteration : ($loop->iteration % 8 ?: 8);
                            $artistDefault = 'a' . $artistIndex . '.png';
                            $artistSource = $artist->image ?? (isset($artist->artist_image) ? $artist->artist_image : null);
                            
                            // Lấy ID của nghệ sĩ để tạo đường dẫn (Link)
                            $artistId = $artist->artist_id ?? $artist->id ?? 0;
                        @endphp
                        
                        <div class="artist-avatar-box">
                            <a href="{{ route('music.artist', $artistId) }}">
                                <img src="{{ asset($artistSource ? 'storage/image/' . $artistSource : 'images/' . $artistDefault) }}" alt="{{ $artist->artist_name }}">
                            </a>
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title mb-1">
                                <a href="{{ route('music.artist', $artistId) }}" class="text-dark text-decoration-none">{{ $artist->artist_name }}</a>
                            </h5>
                            
                            
                    
                        </div>
                        
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">Chưa có nghệ sĩ nào trong hệ thống.</div>
                </div>
            @endforelse
        </div>
    </div>
</x-music-layout>
