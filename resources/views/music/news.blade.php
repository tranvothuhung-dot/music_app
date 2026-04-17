<x-music-layout>
    <x-slot name="title">Tin tức</x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        .news-card {
            display: flex;
            flex-direction: row;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border: 1px solid rgba(229,231,235,0.95);
            box-shadow: 0 4px 10px rgba(0,0,0,0.04);
            height: 100%; 
        }
        
        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(15,23,42,0.08);
        }

        .news-card-img-wrap {
            width: 40%;
            flex-shrink: 0;
            overflow: hidden;
        }

        .news-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .news-card:hover img {
            transform: scale(1.05);
        }

        .news-card .card-body {
            width: 60%;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }
        .card-title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 24px; /* Chiều cao cố định 1 dòng */
            height: 48px; /* Tổng chiều cao 2 dòng (24px * 2) */
            margin-bottom: 8px;
        }

        /* 2. Mô tả: Sửa lỗi lòi dòng chữ thứ 3 */
        .card-text {
            display: -webkit-box;
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 21px; /* Chiều cao chữ nhỏ */
            height: 42px; /* Khóa chết chiều cao đúng 2 dòng (21px * 2) */
            margin-bottom: 16px;
            color: #6b7280;
        }

        /* Căn chỉnh Icon và Meta info */
        .meta-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
        }

        .meta-icon {
            color: #f82c75;
            width: 24px; 
            text-align: left;
            margin-top: 3px; 
        }

        /* 3. Địa điểm: Khóa cứng chiều cao 2 dòng */
        .meta-location {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 21px;
            height: 42px; /* Khóa chết 42px để nút bấm luôn thẳng hàng */
            margin-bottom: 16px;
        }

        .btn-pink {
            background-color: #f82c75;
            color: white;
            border-radius: 50px;
            padding: 8px 24px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            text-decoration: none;
            width: max-content;
            transition: background-color 0.2s ease;
            margin-top: auto; 
        }

        .btn-pink:hover {
            background-color: #e01b60;
            color: white;
        }
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="title-highlight">Tin Tức</h1>
            </div>
        </div>

        <div class="row g-4">
            @forelse($news as $item)
                @php
                    $newsImage = $item->image ?? (isset($item->new_image) ? $item->new_image : null);
                @endphp
                
                <div class="col-lg-6 col-md-12">
                    <div class="news-card">
                        
                        <div class="news-card-img-wrap">
                            <img src="{{ asset($newsImage ? 'storage/image/' . $newsImage : 'images/n1.jpg') }}" alt="{{ $item->title ?? 'Tin tức' }}">
                        </div>

                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $item->title ?? 'Tin tức mới' }}</h5>
                            
                            <p class="card-text small">
                                {{ $item->description ?? $item->excerpt ?? 'Cập nhật tin tức âm nhạc mới nhất.' }}
                            </p>

                            <div class="meta-info">
                                <span class="meta-icon"><i class="fa-regular fa-calendar-days"></i></span> 
                                <span>{{ isset($item->created_at) ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') : '07/01/2026' }}</span>
                            </div>

                            <div class="meta-info meta-location">
                                <span class="meta-icon"><i class="fa-solid fa-location-dot"></i></span> 
                                <span>{{ $item->location ?? 'Công viên Văn hóa Lớn, TP. Hồ Chí Minh' }}</span>
                            </div>

                            <a href="#" class="btn-pink">Xem chi tiết</a>
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