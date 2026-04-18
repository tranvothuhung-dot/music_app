@extends('layouts.user-music')

@section('content')
    <style>
        .leaderboard-list-card {
            height: auto !important;
        }

        .leaderboard-list-card:hover {
            transform: none !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05) !important;
        }

        .leaderboard-page-title {
            font-size: clamp(2.2rem, 3.2vw, 3rem);
        }

        .leaderboard-song-name {
            font-size: 1.12rem;
            line-height: 1.2;
        }

        .leaderboard-song-artist {
            font-size: 0.98rem;
            line-height: 1.2;
        }

        @media (max-width: 991.98px) {
            .leaderboard-song-name {
                font-size: 1.2rem;
            }

            .leaderboard-song-artist {
                font-size: 1rem;
            }
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3" data-home-link>
                <i class="fas fa-arrow-left me-1"></i> Trở về
            </a>
            <h2 class="section-title leaderboard-page-title m-0">Bảng Xếp Hạng Thịnh Hành</h2>
        </div>
        <span class="badge bg-danger rounded-pill px-3">Top 100</span>
    </div>

    <div class="card custom-card leaderboard-list-card border-0 p-2 p-md-3">
        <div class="d-flex px-3 py-2 text-muted fw-bold border-bottom">
            <div style="width: 52px;">#</div>
            <div class="flex-grow-1">Bài hát</div>
            <div class="text-end" style="width: 140px;">Lượt nghe</div>
        </div>

        @forelse($leaderboard_songs as $index => $song)
            <div
                class="queue-song d-flex align-items-center gap-3 mb-2"
                data-song-card
                data-song-id="{{ $song->song_id }}"
                data-song-name="{{ e($song->song_name) }}"
                data-song-artist="{{ e($song->artist_name) }}"
                data-song-image="{{ asset('images/'.$song->song_image) }}"
                data-song-url="{{ $song->song_url }}"
                data-song-duration="{{ $song->duration }}"
                data-song-album-id="{{ $song->album_id ?? '' }}"
                data-song-artist-id="{{ $song->artist_id }}"
            >
                <div class="fw-bold" style="width: 52px; color: {{ $index === 0 ? '#facc15' : ($index === 1 ? '#9ca3af' : ($index === 2 ? '#c2410c' : '#6b7280')) }}; font-size: 2rem; line-height: 1;">
                    {{ $index + 1 }}
                </div>
                <img src="{{ asset('images/'.$song->song_image) }}" width="56" height="56" class="rounded object-fit-cover" alt="{{ $song->song_name }}" onerror="this.src='https://via.placeholder.com/56'">
                <div class="flex-grow-1 overflow-hidden">
                    <div class="fw-bold text-truncate leaderboard-song-name">{{ $song->song_name }}</div>
                    <div class="text-muted text-truncate leaderboard-song-artist">{{ $song->artist_name }}</div>
                </div>
                <div class="text-end" style="width: 140px;">
                    <span class="badge rounded-pill bg-light text-secondary border px-3 py-2">
                        <i class="fas fa-headphones me-1"></i>{{ number_format((int) $song->view_count / 1000000, 0) }}M
                    </span>
                </div>
                <div class="dropdown ms-1">
                    <button class="btn btn-link text-secondary p-0 btn-song-menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 overflow-hidden">
                        <li><button class="dropdown-item py-2" type="button" data-action="play" data-song-id="{{ $song->song_id }}"><i class="fas fa-play me-2 text-primary"></i> Phát ngay</button></li>
                        <li><button class="dropdown-item py-2" type="button" data-action="like" data-song-id="{{ $song->song_id }}"><i class="fas fa-heart me-2 text-danger"></i> Thêm vào yêu thích</button></li>
                        <li><button class="dropdown-item py-2" type="button" data-action="queue" data-song-id="{{ $song->song_id }}"><i class="fas fa-list-ul me-2 text-secondary"></i> Thêm vào hàng đợi</button></li>
                        <li><button class="dropdown-item py-2" type="button" data-action="playlist" data-song-id="{{ $song->song_id }}"><i class="fas fa-plus-square me-2 text-secondary"></i> Thêm vào Playlist</button></li>
                        <li><button class="dropdown-item py-2" type="button" data-action="album" data-song-id="{{ $song->song_id }}" data-album-id="{{ $song->album_id ?? '' }}"><i class="fas fa-record-vinyl me-2 text-secondary"></i> Đi tới album</button></li>
                        <li><button class="dropdown-item py-2" type="button" data-action="artist" data-song-id="{{ $song->song_id }}" data-artist-id="{{ $song->artist_id }}"><i class="fas fa-user me-2 text-secondary"></i> Đi tới ca sĩ</button></li>
                    </ul>
                </div>
            </div>
        @empty
            <div class="alert alert-light border text-muted m-3">Chưa có dữ liệu bảng xếp hạng.</div>
        @endforelse
    </div>
@endsection
