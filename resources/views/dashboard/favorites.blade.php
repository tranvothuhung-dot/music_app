@extends('layouts.user-music')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3" data-home-link>
                <i class="fas fa-arrow-left me-1"></i> Trở về
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4" data-favorites-page>
        <div class="col-lg-4 col-12">
            <div class="card custom-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-center rounded-4 mx-auto" style="width: 100%; max-width: 270px; height: 270px; background: #f3f4f6; box-shadow: inset 0 0 0 1px rgba(17,24,39,0.04);">
                    <i class="fas fa-music" style="font-size: 7rem; color: #f06292;"></i>
                </div>
                <div class="text-center pt-3">
                    <h3 class="fw-bold mb-1">Liked Songs</h3>
                </div>
                @if($favorite_songs->isNotEmpty())
                    <button
                        type="button"
                        class="btn btn-primary rounded-pill fw-bold mt-4"
                        style="background: #f83f86; border: 0;"
                        data-play-all-songs
                        data-song-ids='@json($favorite_songs->pluck("song_id")->values())'
                    >
                        <i class="fas fa-play me-2"></i>Phát Tất Cả
                    </button>
                @endif
            </div>
        </div>

        <div class="col-lg-8 col-12">
            <h2 class="section-title mb-3">Danh sách bài hát</h2>
            <div id="favorites-page-songs-list">
                @foreach($favorite_songs as $index => $song)
                    <div
                        class="queue-song d-flex align-items-center gap-3 mb-2"
                        data-favorite-page-item
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
                        <span class="fw-bold text-muted" style="width: 26px;" data-favorite-page-index>{{ $index + 1 }}</span>
                        <img src="{{ asset('images/'.$song->song_image) }}" width="44" height="44" class="rounded object-fit-cover" alt="{{ $song->song_name }}" onerror="this.src='https://via.placeholder.com/44'">
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-bold text-truncate">{{ $song->song_name }}</div>
                            <div class="text-muted text-truncate">{{ $song->artist_name }}</div>
                        </div>
                        <button class="btn btn-link text-secondary p-0 btn-song-menu" type="button" data-action="like" data-song-id="{{ $song->song_id }}" data-like-icon-only title="Xóa khỏi yêu thích">
                            <i class="fas fa-heart-crack text-danger"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            <div id="favorites-page-empty" class="alert alert-light border text-muted {{ $favorite_songs->isNotEmpty() ? 'd-none' : '' }}">Bạn chưa có bài hát yêu thích.</div>
        </div>
    </div>
@endsection
