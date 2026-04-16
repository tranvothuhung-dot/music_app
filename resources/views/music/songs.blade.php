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
                        <h6 class="fw-bold mb-1 text-truncate">{{ $song->song_name }}</h6>
                        <small class="text-muted d-block text-truncate">{{ $song->artist_name }}</small>
                        <small class="text-muted d-block mt-2">{{ gmdate('i:s', (int) $song->duration) }}</small>
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
