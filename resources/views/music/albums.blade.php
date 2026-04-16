@extends('layouts.user-music')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title m-0">Album</h2>
        <span class="badge bg-light text-dark border">{{ $albums->total() }} album</span>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-4">
        @forelse($albums as $album)
            <div class="col">
                <div class="card custom-card h-100">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/'.$album->cover_image) }}" onerror="this.src='https://via.placeholder.com/300'" alt="{{ $album->album_name }}">
                    </div>
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-1 text-truncate">{{ $album->album_name }}</h6>
                        <small class="text-muted d-block text-truncate">{{ $album->artist_name }}</small>
                        @if(!empty($album->release_date))
                            <small class="text-muted d-block mt-2">{{ date('d/m/Y', strtotime($album->release_date)) }}</small>
                        @endif
                    </div>
                </div>
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
@endsection
