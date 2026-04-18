@extends('layouts.user-music')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3" data-home-link>
                <i class="fas fa-arrow-left me-1"></i> Trở về
            </a>
            <h2 class="section-title m-0">Mới Phát Hành Theo Thể Loại</h2>
        </div>
        <span class="badge bg-light text-dark border">{{ $newest_songs->total() }} bài</span>
    </div>

    @forelse($newest_songs_by_genre as $genreName => $genreSongs)
        <section class="mb-5">
            <h3 class="h4 fw-bold text-primary mb-3">{{ $genreName }}</h3>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                @foreach($genreSongs as $song)
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

                                @if($song->genre_name)
                                    <span class="badge bg-dark position-absolute top-0 end-0 m-2 opacity-75">{{ $song->genre_name }}</span>
                                @endif

                                <div class="play-overlay">
                                    <button type="button" class="btn-play-circle js-play-song" data-action="play" data-song-id="{{ $song->song_id }}"><i class="fas fa-play ms-1"></i></button>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="overflow-hidden flex-grow-1">
                                        <h6 class="fw-bold mb-1 text-truncate">{{ $song->song_name }}</h6>
                                        <small class="text-muted d-block text-truncate">{{ $song->artist_name }}</small>
                                        <div class="mt-2"><span class="badge bg-success bg-opacity-10 text-success"><i class="fas fa-clock me-1"></i> Mới</span></div>
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
                @endforeach
            </div>
        </section>
    @empty
        <div class="alert alert-light border text-muted">Chưa có bài hát mới.</div>
    @endforelse

    <div class="d-flex justify-content-center">
        {{ $newest_songs->links() }}
    </div>
@endsection
