@extends('layouts.user-music')

@section('content')
    <style>
        .genre-card {
            min-height: 124px;
            background: #f3f4f6;
            transition: background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .genre-card .genre-card-name {
            color: #f83f86;
            transition: color 0.2s ease;
        }

        .genre-card-link:hover .genre-card,
        .genre-card-link:focus-visible .genre-card {
            background: linear-gradient(135deg, #f6a6b0 0%, #e8b2cf 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(248, 63, 134, 0.2);
        }

        .genre-card-link:hover .genre-card-name,
        .genre-card-link:focus-visible .genre-card-name {
            color: #fff;
        }
    </style>

    @if(!empty($selected_genre))
        <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <a href="{{ route('dashboard.genres') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3" data-genre-list-link>
                    <i class="fas fa-arrow-left me-1"></i> Trở về
                </a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-4 col-12">
                <div class="card custom-card h-100 p-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle mx-auto" style="width: 200px; height: 200px; background: #f3f4f6; box-shadow: inset 0 0 0 1px rgba(17,24,39,0.04);">
                        <i class="fas fa-music" style="font-size: 4.2rem; color: #f06292;"></i>
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="fw-bold mb-1">{{ $selected_genre->genre_name }}</h3>
                        <div class="text-primary fw-semibold">Tuyển tập</div>
                    </div>
                    @if($genre_songs->isNotEmpty())
                        <button
                            type="button"
                            class="btn btn-primary rounded-pill fw-bold mt-4"
                            style="background: #f83f86; border: 0;"
                            data-play-all-songs
                            data-song-ids='@json($genre_songs->pluck("song_id")->values())'
                        >
                            <i class="fas fa-play me-2"></i>Phát Tất Cả
                        </button>
                    @endif
                </div>
            </div>

            <div class="col-lg-8 col-12">
                <h2 class="section-title mb-3">Danh sách bài hát</h2>
                @forelse($genre_songs as $index => $song)
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
                        <span class="fw-bold text-muted" style="width: 26px;">{{ $index + 1 }}</span>
                        <img src="{{ asset('images/'.$song->song_image) }}" width="44" height="44" class="rounded object-fit-cover" alt="{{ $song->song_name }}" onerror="this.src='https://via.placeholder.com/44'">
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-bold text-truncate">{{ $song->song_name }}</div>
                            <div class="text-muted text-truncate">{{ $song->artist_name }}</div>
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
                                <li><button class="dropdown-item py-2" type="button" data-action="artist" data-song-id="{{ $song->song_id }}" data-artist-id="{{ $song->artist_id }}"><i class="fas fa-user me-2 text-secondary"></i> Đi tới ca sĩ</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="album" data-song-id="{{ $song->song_id }}" data-album-id="{{ $song->album_id ?? '' }}"><i class="fas fa-record-vinyl me-2 text-secondary"></i> Đi tới album</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="share" data-song-id="{{ $song->song_id }}" data-song-name="{{ e($song->song_name) }}" data-song-artist="{{ e($song->artist_name) }}"><i class="fas fa-share me-2 text-secondary"></i> Chia sẻ</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="copy-link" data-song-id="{{ $song->song_id }}"><i class="fas fa-link me-2 text-secondary"></i> Sao chép liên kết</button></li>
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-light border text-muted">Thể loại này chưa có bài hát.</div>
                @endforelse
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title m-0">Thể Loại</h2>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4 mb-4">
            @forelse($genres as $genre)
                <div class="col">
                    <a href="{{ route('dashboard.genres', ['genre_id' => $genre->genre_id]) }}" class="genre-card-link text-decoration-none text-reset d-block" data-genre-link>
                        <div class="genre-card card custom-card h-100 border-0">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <h3 class="genre-card-name m-0 fw-bold">{{ $genre->genre_name }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-muted">Không có thể loại nào.</div>
                </div>
            @endforelse
        </div>
    @endif
@endsection
