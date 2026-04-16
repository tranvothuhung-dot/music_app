@extends('layouts.user-music')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title m-0">Tin Tức</h2>
        <span class="badge bg-light text-dark border">{{ is_countable($news) ? count($news) : 0 }} bài viết</span>
    </div>

    <div class="row g-4">
        @forelse($news as $item)
            <div class="col-12">
                <div class="bg-white border rounded-4 shadow-sm p-3 p-md-4">
                    <div class="d-flex flex-column flex-md-row gap-3">
                        <img
                            src="{{ asset('images/'.($item->new_image ?? 'banner.png')) }}"
                            onerror="this.src='https://via.placeholder.com/260x140'"
                            alt="{{ $item->title ?? 'News' }}"
                            class="rounded-3"
                            style="width: 260px; max-width: 100%; height: 140px; object-fit: cover;"
                        >
                        <div>
                            <h5 class="fw-bold mb-2">{{ $item->title ?? 'Tin tức' }}</h5>
                            <div class="text-muted small mb-2">
                                {{ !empty($item->event_date) ? date('d/m/Y', strtotime($item->event_date)) : (!empty($item->created_at) ? date('d/m/Y H:i', strtotime($item->created_at)) : '') }}
                            </div>
                            <p class="mb-0 text-secondary">{{ \Illuminate\Support\Str::limit(strip_tags($item->description ?? ''), 220) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-muted">Chưa có tin tức.</div>
            </div>
        @endforelse
    </div>
@endsection
