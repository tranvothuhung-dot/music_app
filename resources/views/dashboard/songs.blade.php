@extends('layouts.user-music')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title m-0">Bài Hát</h2>
        <span class="badge bg-light text-dark border">{{ $songs->total() }} bài</span>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4 mb-4">
        @forelse($songs as $song)
            <div class="col">
                <div
                    class="card custom-card song-card h-100"
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
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/'.$song->song_image) }}" onerror="this.src='https://via.placeholder.com/300'" alt="{{ $song->song_name }}">
                        <div class="play-overlay">
                            <button type="button" class="btn-play-circle" data-action="play" data-song-id="{{ $song->song_id }}">
                                <i class="fas fa-play ms-1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="overflow-hidden flex-grow-1">
                                <h6 class="fw-bold mb-1 text-truncate">{{ $song->song_name }}</h6>
                                <small class="text-muted d-block text-truncate">{{ $song->artist_name }}</small>
                                <small class="text-muted d-block mt-2">{{ gmdate('i:s', (int) $song->duration) }}</small>
                            </div>
                            <div class="dropdown ms-2">
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
                                    <li><button class="dropdown-item py-2" type="button" data-action="share" data-song-id="{{ $song->song_id }}" data-song-name="{{ e($song->song_name) }}" data-song-artist="{{ e($song->artist_name) }}"><i class="fas fa-share me-2 text-secondary"></i> Chia sẻ</button></li>
                                    <li><button class="dropdown-item py-2" type="button" data-action="copy-link" data-song-id="{{ $song->song_id }}"><i class="fas fa-link me-2 text-secondary"></i> Sao chép liên kết</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-muted">Không có bài hát nào.</div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $songs->links() }}
    </div>
@endsection