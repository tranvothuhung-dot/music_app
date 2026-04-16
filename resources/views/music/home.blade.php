@extends('layouts.user-music')

@section('content')

    <div class="rounded-4 overflow-hidden mb-5 shadow">
        <img src="{{ asset('images/banner.png') }}" class="w-100" style="max-height: 350px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/1200x350/ffb6c1/ffffff?text=MELODY+%26+JOY'">
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title m-0">Thịnh Hành</h2>
        <a href="#" class="btn btn-outline-secondary rounded-pill btn-sm px-3">Xem tất cả</a>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
        @foreach($trending as $song)
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
                    <img src="{{ asset('images/'.$song->song_image) }}" onerror="this.src='https://via.placeholder.com/300'">
                    <div class="play-overlay">
                        <button type="button" class="btn-play-circle js-play-song" data-action="play" data-song-id="{{ $song->song_id }}"><i class="fas fa-play ms-1"></i></button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="overflow-hidden flex-grow-1">
                            <h6 class="fw-bold mb-1 text-truncate">{{ $song->song_name }}</h6>
                            <small class="text-muted d-block text-truncate">{{ $song->artist_name }}</small>
                        </div>
                        <div class="dropdown ms-2">
                            <button class="btn btn-link text-secondary p-0 btn-song-menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 overflow-hidden">
                                <li><button class="dropdown-item py-2" type="button" data-action="play" data-song-id="{{ $song->song_id }}"><i class="fas fa-play me-2 text-primary"></i> Phát ngay</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="like" data-song-id="{{ $song->song_id }}"><i class="fas fa-heart me-2 text-danger"></i> Thêm vào yêu thích</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="queue" data-song-id="{{ $song->song_id }}"><i class="fas fa-list-ul me-2 text-secondary"></i> Thêm vào hàng đợi</button></li>
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

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title m-0">Mới Phát Hành</h2>
        <a href="#" class="btn btn-outline-secondary rounded-pill btn-sm px-3">Xem tất cả</a>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
        @foreach($newest_songs as $song)
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
                    <img src="{{ asset('images/'.$song->song_image) }}" onerror="this.src='https://via.placeholder.com/300'">
                    
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

    <div class="row mb-5">
        <div class="col-md-7 mb-4 mb-md-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title m-0">Album Nổi Bật</h2>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 g-3">
                @foreach($albums as $al)
                <div class="col">
                    <div class="d-flex align-items-center p-2 bg-white rounded-3 shadow-sm border border-light custom-card" style="cursor: pointer; height: auto;">
                        <img src="{{ asset('images/'.$al->cover_image) }}" width="60" height="60" class="rounded object-fit-cover" onerror="this.src='https://via.placeholder.com/60'">
                        <div class="ms-3 overflow-hidden">
                            <div class="fw-bold text-truncate" style="font-size: 0.95rem;">{{ $al->album_name }}</div>
                            <small class="text-primary text-truncate">{{ $al->artist_name }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title m-0">Nghệ Sĩ</h2>
            </div>
            <div class="d-flex flex-wrap gap-3">
                @foreach($artists_list as $art)
                <div class="text-center" style="width: 75px; cursor: pointer;">
                    <img src="{{ asset('images/'.$art->avatar_image) }}" class="rounded-circle border border-2 border-white shadow-sm" style="width: 70px; height: 70px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/70'">
                    <div class="small text-truncate mt-2 fw-semibold">{{ $art->artist_name }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <textarea id="data-songs-source" style="display:none;">
        {{ json_encode($js_data) }}
    </textarea>

@endsection