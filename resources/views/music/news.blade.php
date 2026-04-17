<x-music-layout>
    <x-slot name="title">Tin tức</x-slot>

    <div class="container py-4">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        .title-highlight {
            font-family: 'Poppins', sans-serif;
            font-size: 38px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #2b2b2b;
            border-left: 6px solid #f82c75;
            padding-left: 16px;
            line-height: 1.2;
            margin: 0;
        }
    </style>

    <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="title-highlight">Tin Tức</h1>
                </div>
            </div>

        <div class="row g-3">
            @forelse($news as $item)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        @php
                            $newsImage = $item->image ?? (isset($item->new_image) ? $item->new_image : null);
                        @endphp
                        <img src="{{ asset($newsImage ? 'storage/image/' . $newsImage : 'images/n1.jpg') }}" class="card-img-top" alt="{{ $item->title ?? 'Tin tức' }}">
                        <div class="card-body">
                            <h5 class="card-title mb-2">{{ $item->title ?? 'Tin tức mới' }}</h5>
                            <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($item->description ?? $item->excerpt ?? 'Cập nhật tin tức âm nhạc mới nhất.', 110) }}</p>
                            <a href="#" class="text-decoration-none">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">Hiện chưa có tin tức âm nhạc.</div>
                </div>
            @endforelse
        </div>
    </div>
</x-music-layout>