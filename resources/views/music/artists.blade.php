<x-music-layout>
    <x-slot name="title">Nghệ sĩ</x-slot>

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
                    <h1 class="title-highlight">Nghệ Sĩ</h1>
                </div>
            </div>
        <div class="row g-3">
            @forelse($artists as $artist)
                <div class="col-md-3 mb-4">
                    <div class="card artist-card h-100 text-center shadow-sm border-0">
                        @php
                                $artistIndex = $loop->iteration <= 8 ? $loop->iteration : ($loop->iteration % 8 ?: 8);
                                $artistDefault = 'a' . $artistIndex . '.png';
                                $artistSource = $artist->image ?? (isset($artist->artist_image) ? $artist->artist_image : null);
                            @endphp
                        <div class="artist-avatar-box">
                            <img src="{{ asset($artistSource ? 'storage/image/' . $artistSource : 'images/' . $artistDefault) }}" alt="{{ $artist->artist_name }}">
                        </div>
                        <div class="card-body pt-0">
                            <h5 class="card-title mb-1">{{ $artist->artist_name }}</h5>
                            <p class="card-text text-muted">Nghệ sĩ</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">Chưa có nghệ sĩ nào trong hệ thống.</div>
                </div>
            @endforelse
        </div>
    </div>
</x-music-layout>