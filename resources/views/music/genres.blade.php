<x-music-layout>
    <x-slot name="title">Thể loại âm nhạc</x-slot>
<main>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
        <div class="container">
            <h2 class="title-highlight">Thể Loại Âm Nhạc</h2>

            <div class="row g-4 mt-2">
                @forelse($genres as $genre)
                    @php
                        $genreId = $genre->danh_muc_id ?? $genre->id ?? 0;
                    @endphp
                    <div class="col-md-6 col-lg-3">
                        <a href="{{ route('music.genre', ['id' => $genreId]) }}" class="text-decoration-none">
                            <div class="genre-box">
                                <h5 class="genre-text">{{ $genre->ten_danh_muc ?? $genre->genre_name ?? 'Thể loại' }}</h5>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning">Chưa có thể loại nào.</div>
                    </div>
                @endforelse
            </div>
        </div>

       <style>
    /* Thiết kế thẻ box genre */
    .genre-box {
        background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
        border-radius: 12px;
        padding: 60px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 160px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        margin-bottom: 20px;
    }

    /* Hiệu ứng khi rê chuột vào */
    .genre-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
    }

    /* Chữ bên trong mặc định */
    .genre-text {
        color: #ff4081;
        font-weight: 800;
        font-size: 1.4rem;
        margin: 0;
        text-align: center;
        transition: color 0.3s ease;
    }


    /* Đổi màu chữ sang trắng khi hover */
    .genre-box:hover .genre-text {
        color: #ffffff !important;
    }
</style>
    </main>
</x-music-layout>
