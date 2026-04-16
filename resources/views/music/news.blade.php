@extends('layouts.user-music')

@section('content')
    <style>
        .news-item-card {
            border: 1px solid #e5e7eb;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .news-item-card:hover,
        .news-item-card:focus-within {
            border-color: #ff3f86 !important;
            box-shadow: 0 12px 24px rgba(255, 63, 134, 0.18) !important;
            transform: translateY(-1px);
        }

        .news-detail-btn {
            background: #ff3f86;
            border-color: #ff3f86;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .news-detail-btn:hover,
        .news-detail-btn:focus {
            background: #e11d70 !important;
            border-color: #e11d70 !important;
        }

        .news-detail-title {
            font-size: clamp(1.8rem, 2.8vw, 3rem);
            line-height: 1.12;
        }

        .news-detail-meta-title {
            font-size: clamp(1.25rem, 1.8vw, 2rem);
        }

        .news-detail-meta-location {
            font-size: clamp(1.05rem, 1.5vw, 1.45rem);
        }

        .news-detail-image {
            max-height: 420px;
            object-fit: cover;
            width: min(100%, 860px);
            margin: 0 auto;
            display: block;
            image-rendering: auto;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.16);
        }

        .news-detail-content {
            font-size: clamp(1rem, 1.2vw, 1.25rem);
            line-height: 1.7;
            color: #111827;
        }

        .news-tag-chip {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            background: #f8fafc;
            color: #64748b;
            font-size: 0.95rem;
            margin-right: 8px;
            margin-bottom: 8px;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.08);
        }

        .news-back-btn {
            min-width: 126px;
            border: 1px solid #111827;
            color: #111827;
            font-weight: 700;
            border-radius: 999px;
            background: #fff;
        }

        .news-share-btn {
            min-width: 200px;
            background: #ff3f86;
            border-color: #ff3f86;
            color: #fff;
            font-weight: 700;
            border-radius: 999px;
        }

        .news-share-btn:hover,
        .news-share-btn:focus {
            background: #e11d70;
            border-color: #e11d70;
            color: #fff;
        }
    </style>

    @if(!empty($selected_news))
        @php
            $baseDescription = trim((string) ($selected_news->description ?? ''));
            $autoDescription = $baseDescription;

            if (mb_strlen($autoDescription) < 260) {
                $autoDescription .= "\n\nSự kiện được thiết kế với không gian sân khấu ngoài trời hiện đại, hệ thống ánh sáng - âm thanh tiêu chuẩn quốc tế và khu trải nghiệm tương tác cho khán giả. Bên cạnh các tiết mục biểu diễn chính, người tham dự còn có thể tham gia hoạt động giao lưu nghệ sĩ, khu ẩm thực đa dạng và photobooth theo chủ đề âm nhạc.";
                $autoDescription .= "\n\nĐây là dịp để bạn gặp gỡ cộng đồng yêu nhạc, cập nhật xu hướng mới và tận hưởng bầu không khí lễ hội trọn vẹn từ chiều đến đêm. Chương trình phù hợp cho cả nhóm bạn, gia đình và những người yêu thích trải nghiệm nghệ thuật trực tiếp.";
            }

            $lineupDayOne = [
                'DJ Luna (EDM)',
                'Ban nhạc Sunset Vibes (Pop-Rock)',
                'Ca sĩ Minh Hằng (Pop)',
            ];

            $lineupDayTwo = [
                'DJ Orion (Electronic)',
                'Ban nhạc Urban Pulse (Indie-Rock)',
                'Ca sĩ Khoa Nam (Ballad)',
            ];

            if ((int) ($selected_news->news_id ?? 0) === 2) {
                $lineupDayOne = [
                    'Luna Wave (Progressive House)',
                    'Skyline Duo (Melodic Techno)',
                    'Rin K. (Future Bass)',
                ];

                $lineupDayTwo = [
                    'Orion Pulse (Hard Dance)',
                    'Neon District (Electro Pop)',
                    'Echo Frame (Synthwave)',
                ];
            }

            $detailImageSrc = !empty($selected_news->image_url)
                ? $selected_news->image_url
                : asset('images/'.($selected_news->new_image ?? 'banner.png'));
        @endphp

        <div class="mb-3 d-flex align-items-center gap-2">
            <span class="badge rounded-pill" style="background: #ffe3ee; color: #ff3f86;">News</span>
            <span class="fw-bold text-uppercase text-secondary">
                {{ !empty($selected_news->created_at) ? date('F j, Y', strtotime($selected_news->created_at)) : '' }}
            </span>
        </div>

        <h1 class="fw-bold mb-3 news-detail-title">{{ $selected_news->title }}</h1>

        <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-3">
            <div class="d-flex align-items-start gap-2">
                <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold" style="width: 40px; height: 40px; background: #1f2937;">B</span>
                <div>
                    <div class="fw-bold news-detail-meta-title">Ban Tổ Chức Summer Music Festival</div>
                    <div class="text-muted news-detail-meta-location"><i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $selected_news->location ?? 'Đang cập nhật địa điểm' }}</div>
                </div>
            </div>
            <a href="{{ route('dashboard.news') }}" class="btn btn-light rounded-pill border px-3" title="Quay lại danh sách tin">
                <i class="fas fa-link"></i>
            </a>
        </div>

        <div class="mb-4">
            <img
                src="{{ $detailImageSrc }}"
                onerror="this.src='https://via.placeholder.com/1200x560'"
                alt="{{ $selected_news->title ?? 'News detail' }}"
                class="w-100 rounded-4 news-detail-image"
                loading="eager"
                decoding="async"
            >
        </div>

        <div class="news-detail-content">
            <p class="mb-2">Thời gian: {{ !empty($selected_news->event_date) ? date('d/m/Y', strtotime($selected_news->event_date)) : 'Đang cập nhật' }}</p>
            <p class="mb-2">Địa điểm: {{ $selected_news->location ?? 'Đang cập nhật' }}</p>
            <p class="mb-4">Giờ mở cửa: 14:00 - 23:00 mỗi ngày</p>

            <p class="mb-2 fw-bold">Mô tả sự kiện:</p>
            <p class="mb-4">{!! nl2br(e($autoDescription !== '' ? $autoDescription : 'Đang cập nhật nội dung sự kiện.')) !!}</p>

            <p class="mb-2 fw-bold">Điểm nổi bật:</p>
            <p class="mb-4">
                - Sân khấu đa lớp, hiệu ứng hình ảnh theo từng set nhạc.<br>
                - Khu check-in chủ đề lễ hội và mini game tương tác với quà tặng.<br>
                - Khu ẩm thực và khu nghỉ chân bố trí xuyên suốt khuôn viên.
            </p>

            <p class="mb-2 fw-bold">Thông tin vé:</p>
            <p class="mb-4">
                - Vé tiêu chuẩn: 499.000đ<br>
                - Vé VIP: 1.290.000đ (khu vực gần sân khấu, quà tặng độc quyền)<br>
                - Ưu đãi nhóm 4 người: giảm 10% tổng hóa đơn
            </p>

            <p class="mb-2 fw-bold">Line-up nghệ sĩ:</p>
            <p class="mb-0">
                Ngày 1:<br>
                @foreach($lineupDayOne as $artist)
                    - {{ $artist }}<br>
                @endforeach
                <br>
                Ngày 2:<br>
                @foreach($lineupDayTwo as $artist)
                    - {{ $artist }}<br>
                @endforeach
            </p>

            <p class="mb-2 mt-4 fw-bold">Lưu ý khi tham gia:</p>
            <p class="mb-4">
                - Mang theo nước uống và mũ/kem chống nắng<br>
                - Không mang theo đồ uống có cồn ngoài khu vực quy định<br>
                - Tuân thủ hướng dẫn an ninh và y tế
            </p>

            <p class="mb-1 fw-bold">Liên hệ & Mạng xã hội:</p>
            <p class="mb-0">- Fanpage: facebook.com/SummerMusicFestival2026</p>
            <p class="mb-0">- Instagram: @SummerMusicFest2026</p>
            <p class="mb-3">- Hotline: 0909 123 456</p>

            <p class="mb-2 fw-bold text-uppercase">Tags chủ đề:</p>
            <div class="mb-4">
                <span class="news-tag-chip">#music</span>
                <span class="news-tag-chip">#festival</span>
                <span class="news-tag-chip">#summer</span>
                <span class="news-tag-chip">#2026</span>
                <span class="news-tag-chip">#event</span>
            </div>

            <hr class="my-5">

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pb-2">
                <a href="{{ route('dashboard.news') }}" class="btn news-back-btn px-4 py-2" data-news-detail-link>
                    <i class="fas fa-arrow-left me-2"></i>Trở về
                </a>
                <button
                    type="button"
                    class="btn news-share-btn px-4 py-2"
                    data-share-article
                    data-share-title="{{ e($selected_news->title ?? 'Tin tuc') }}"
                >
                    Chia sẻ bài viết <i class="fas fa-share-alt ms-2"></i>
                </button>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title m-0">Tin Tức</h2>
            <span class="badge bg-light text-dark border">{{ is_countable($news) ? count($news) : 0 }} bài viết</span>
        </div>

        <div class="row g-4">
            @forelse($news as $item)
                <div class="col-12">
                    <div class="bg-white rounded-4 shadow-sm p-3 p-md-4 news-item-card">
                        <div class="d-flex flex-column flex-md-row gap-3">
                            <img
                                src="{{ asset('images/'.($item->new_image ?? 'banner.png')) }}"
                                onerror="this.src='https://via.placeholder.com/260x140'"
                                alt="{{ $item->title ?? 'News' }}"
                                class="rounded-3"
                                style="width: 260px; max-width: 100%; height: 140px; object-fit: cover;"
                            >
                            <div class="w-100">
                                <h5 class="fw-bold mb-2">{{ $item->title ?? 'Tin tức' }}</h5>
                                <div class="text-muted small mb-2">
                                    {{ !empty($item->event_date) ? date('d/m/Y', strtotime($item->event_date)) : (!empty($item->created_at) ? date('d/m/Y H:i', strtotime($item->created_at)) : '') }}
                                </div>
                                <p class="mb-3 text-secondary">{{ \Illuminate\Support\Str::limit(strip_tags($item->description ?? ''), 220) }}</p>
                                <a href="{{ route('dashboard.news.detail', ['newsId' => $item->news_id]) }}" class="btn btn-primary rounded-pill px-4 news-detail-btn" data-news-detail-link>Xem chi tiết</a>
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
    @endif
@endsection
