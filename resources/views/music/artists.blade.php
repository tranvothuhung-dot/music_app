@extends('layouts.user-music')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title m-0">Nghệ Sĩ</h2>
        <span class="badge bg-light text-dark border">{{ $artists->total() }} nghệ sĩ</span>
    </div>

    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-5 g-4 mb-4">
        @forelse($artists as $artist)
            <div class="col text-center">
                <div class="p-3 bg-white border rounded-4 shadow-sm h-100">
                    <img
                        src="{{ asset('images/'.$artist->avatar_image) }}"
                        onerror="this.src='https://via.placeholder.com/120'"
                        class="rounded-circle border border-2 border-white shadow"
                        style="width: 110px; height: 110px; object-fit: cover;"
                        alt="{{ $artist->artist_name }}"
                    >
                    <div class="fw-bold mt-3 text-truncate">{{ $artist->artist_name }}</div>
                    @if(!empty($artist->country))
                        <div class="small text-muted mt-1">{{ $artist->country }}</div>
                    @endif
                </div>
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
@endsection
