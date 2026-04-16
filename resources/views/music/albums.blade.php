@extends('layouts.user-music')

@section('content')
    @if(!empty($selected_album))
        <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <a href="{{ route('dashboard.albums') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3" data-album-list-link>
                    <i class="fas fa-arrow-left me-1"></i> Trở về
                </a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-4 col-12">
                <div class="card custom-card h-100 p-3">
                    <div class="card-img-wrapper rounded-4 overflow-hidden">
                        <img src="{{ asset('images/'.$selected_album->cover_image) }}" onerror="this.src='https://via.placeholder.com/500'" alt="{{ $selected_album->album_name }}">
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="fw-bold mb-1">{{ $selected_album->album_name }}</h3>
                        <div class="text-primary fw-semibold">{{ $selected_album->artist_name }}</div>
                    </div>
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
                                <li><button class="dropdown-item py-2" type="button" data-action="artist" data-song-id="{{ $song->song_id }}" data-artist-id="{{ $song->artist_id }}"><i class="fas fa-user me-2 text-secondary"></i> Đi tới ca sĩ</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="share" data-song-id="{{ $song->song_id }}" data-song-name="{{ e($song->song_name) }}" data-song-artist="{{ e($song->artist_name) }}"><i class="fas fa-share me-2 text-secondary"></i> Chia sẻ</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="copy-link" data-song-id="{{ $song->song_id }}"><i class="fas fa-link me-2 text-secondary"></i> Sao chép liên kết</button></li>
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-light border text-muted">Album này chưa có bài hát.</div>
                @endforelse
            </div>
        </div>
    @endif

    @if(empty($selected_album))
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title m-0">Tất Cả Album</h2>
            <span class="badge bg-light text-dark border">{{ $albums->total() }} album</span>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-4">
            @forelse($albums as $album)
                <div class="col">
                    <a href="{{ route('dashboard.albums', ['album_id' => $album->album_id]) }}" class="text-decoration-none text-reset d-block" data-album-link>
                        <div class="card custom-card h-100 {{ (int)($selected_album_id ?? 0) === (int)$album->album_id ? 'active-song' : '' }}">
                            <div class="card-img-wrapper">
                                <img src="{{ asset('images/'.$album->cover_image) }}" onerror="this.src='https://via.placeholder.com/300'" alt="{{ $album->album_name }}">
                                <div class="play-overlay">
                                    <span class="btn btn-light rounded-pill fw-bold px-3 py-2">Xem Album</span>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-1 text-truncate">{{ $album->album_name }}</h6>
                                <small class="text-muted d-block text-truncate">{{ $album->artist_name }}</small>
                                @if(!empty($album->release_date))
                                    <small class="text-muted d-block mt-2">{{ date('d/m/Y', strtotime($album->release_date)) }}</small>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-muted">Không có album nào.</div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $albums->links() }}
        </div>
    @endif
@endsection
