@extends('layouts.user-music')

@section('content')
    <style>
        .artist-circle-link .artist-avatar {
            border: 3px solid #ffffff;
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.16);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .artist-circle-link:hover .artist-avatar,
        .artist-circle-link:focus-visible .artist-avatar {
            border-color: #ff3f86;
            box-shadow: 0 0 0 4px rgba(255, 63, 134, 0.24), 0 12px 24px rgba(15, 23, 42, 0.18);
            transform: translateY(-2px);
        }
    </style>

    @if(!empty($selected_artist))
        <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <a href="{{ route('dashboard.artists') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3" data-artist-list-link>
                    <i class="fas fa-arrow-left me-1"></i> Trở về
                </a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-4 col-12">
                <div class="card custom-card h-100 p-3">
                    <div class="card-img-wrapper rounded-4 overflow-hidden">
                        <img src="{{ asset('images/'.$selected_artist->avatar_image) }}" onerror="this.src='https://via.placeholder.com/500'" alt="{{ $selected_artist->artist_name }}">
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="fw-bold mb-1">{{ $selected_artist->artist_name }}</h3>
                        <div class="text-primary fw-semibold">Nghệ sĩ</div>
                    </div>
                    @if($artist_songs->isNotEmpty())
                        <button
                            type="button"
                            class="btn btn-primary rounded-pill fw-bold mt-4"
                            style="background: #f83f86; border: 0;"
                            data-play-all-songs
                            data-song-ids='@json($artist_songs->pluck("song_id")->values())'
                        >
                            <i class="fas fa-play me-2"></i>Phát Tất Cả
                        </button>
                    @endif
                </div>
            </div>

            <div class="col-lg-8 col-12">
                <h2 class="section-title mb-3">Danh sách bài hát</h2>
                @forelse($artist_songs as $index => $song)
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
                                <li><button class="dropdown-item py-2" type="button" data-action="album" data-song-id="{{ $song->song_id }}" data-album-id="{{ $song->album_id ?? '' }}"><i class="fas fa-record-vinyl me-2 text-secondary"></i> Đi tới album</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="share" data-song-id="{{ $song->song_id }}" data-song-name="{{ e($song->song_name) }}" data-song-artist="{{ e($song->artist_name) }}"><i class="fas fa-share me-2 text-secondary"></i> Chia sẻ</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="copy-link" data-song-id="{{ $song->song_id }}"><i class="fas fa-link me-2 text-secondary"></i> Sao chép liên kết</button></li>
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-light border text-muted">Nghệ sĩ này chưa có bài hát.</div>
                @endforelse
            </div>
        </div>
    @endif

    @if(empty($selected_artist))
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title m-0">Nghệ Sĩ</h2>
            <span class="badge bg-light text-dark border">{{ $artists->total() }} nghệ sĩ</span>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-5 g-4 mb-4">
            @forelse($artists as $artist)
                <div class="col text-center">
                    <a href="{{ route('dashboard.artists', ['artist_id' => $artist->artist_id]) }}" class="artist-circle-link text-decoration-none text-reset d-inline-block" title="{{ $artist->artist_name }}" data-artist-link>
                        <img
                            src="{{ asset('images/'.$artist->avatar_image) }}"
                            onerror="this.src='https://via.placeholder.com/120'"
                            class="artist-avatar rounded-circle {{ (int)($selected_artist_id ?? 0) === (int)$artist->artist_id ? 'border-primary' : '' }}"
                            style="width: 132px; height: 132px; object-fit: cover;"
                            alt="{{ $artist->artist_name }}"
                        >
                        <div class="fw-bold mt-3 text-truncate">{{ $artist->artist_name }}</div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-muted">Không có nghệ sĩ nào.</div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $artists->links() }}
        </div>
    @endif
@endsection
