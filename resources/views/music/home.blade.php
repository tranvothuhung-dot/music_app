@extends('layouts.user-music')

@section('content')

    <style>
        .album-feature-card {
            display: block;
            text-decoration: none;
            border-radius: 16px;
            overflow: hidden;
            background: #f8fafc;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
        }

        .album-feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.14);
        }

        .album-feature-media {
            position: relative;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            background: #e5e7eb;
        }

        .album-feature-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .album-feature-card:hover .album-feature-media img {
            transform: scale(1.04);
        }

        .album-feature-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.18);
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .album-feature-card:hover .album-feature-overlay {
            opacity: 1;
        }

        .album-feature-btn {
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.94);
            color: #111827;
            padding: 10px 26px;
            font-weight: 800;
            font-size: 1.1rem;
            line-height: 1;
        }

        .album-feature-body {
            padding: 12px 10px 14px;
            text-align: center;
            background: #f3f4f6;
        }

        .album-feature-title {
            font-weight: 800;
            font-size: 0.95rem;
            line-height: 1.25;
            color: #1f2937;
            margin-bottom: 4px;
            min-height: 2.4em;
        }

        .album-feature-artist {
            color: #ff3f86;
            font-size: 0.82rem;
            font-weight: 700;
            min-height: 1.3em;
        }

        .artist-feature-item {
            text-align: center;
        }

        .artist-feature-avatar {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ffffff;
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.14);
            transition: 0.2s ease;
        }

        .artist-feature-link:hover .artist-feature-avatar {
            transform: translateY(-2px);
            border-color: #ff3f86;
            box-shadow: 0 0 0 4px rgba(255, 63, 134, 0.24), 0 12px 24px rgba(15, 23, 42, 0.18);
        }

        .artist-feature-link:focus-visible .artist-feature-avatar {
            border-color: #ff3f86;
            box-shadow: 0 0 0 4px rgba(255, 63, 134, 0.24), 0 12px 24px rgba(15, 23, 42, 0.18);
        }

        .artist-feature-name {
            margin-top: 12px;
            font-size: 0.95rem;
            font-weight: 800;
            color: #1f2937;
            line-height: 1.2;
        }

        .artist-feature-album-link {
            display: inline-block;
            margin-top: 6px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #ff3f86;
            text-decoration: none;
        }

        .artist-feature-album-link:hover {
            color: #e83274;
            text-decoration: underline;
        }

        .news-home-card {
            background: #f3f4f6;
            border-radius: 16px;
            border: 1px solid transparent;
            overflow: hidden;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .news-home-card:hover,
        .news-home-card:focus-within {
            border-color: #ff3f86;
            box-shadow: 0 12px 24px rgba(255, 63, 134, 0.16);
            transform: translateY(-1px);
        }

        .news-home-image {
            width: 100%;
            height: 100%;
            min-height: 140px;
            object-fit: cover;
            display: block;
        }

        .news-home-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 6px;
        }

        .news-home-excerpt {
            font-size: 1.08rem;
            color: #6b7280;
            margin-bottom: 8px;
            line-height: 1.45;
        }

        .news-home-meta {
            color: #6b7280;
            font-size: 1.02rem;
            margin-bottom: 2px;
        }

        .news-home-meta i {
            color: #ff3f86;
        }

        .news-home-btn {
            margin-top: 10px;
            border-radius: 999px;
            padding: 9px 24px;
            font-weight: 700;
            font-size: 1.02rem;
            background: #ff3f86;
            border-color: #ff3f86;
            color: #fff;
        }

        .news-home-btn:hover,
        .news-home-btn:focus {
            background: #e11d70;
            border-color: #e11d70;
            color: #fff;
        }

        @media (max-width: 991.98px) {
            .album-feature-overlay {
                opacity: 1;
                background: rgba(0, 0, 0, 0.1);
            }

            .album-feature-btn {
                font-size: 1.65rem;
                padding: 12px 28px;
            }

            .album-feature-title {
                font-size: 0.92rem;
            }

            .album-feature-artist {
                font-size: 0.8rem;
            }

            .artist-feature-avatar {
                width: 118px;
                height: 118px;
            }

            .artist-feature-name {
                font-size: 0.9rem;
            }

            .artist-feature-album-link {
                font-size: 0.8rem;
            }

            .news-home-title {
                font-size: 1.15rem;
            }

            .news-home-excerpt,
            .news-home-meta {
                font-size: 0.95rem;
            }

            .news-home-btn {
                font-size: 0.95rem;
                padding: 8px 20px;
            }
        }
    </style>

    <div class="rounded-4 overflow-hidden mb-5 shadow">
        <img src="{{ asset('images/banner.png') }}" class="w-100" style="max-height: 350px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/1200x350/ffb6c1/ffffff?text=MELODY+%26+JOY'">
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title m-0">Thịnh Hành</h2>
        <a href="{{ route('dashboard.leaderboard') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3" data-leaderboard-link>Xem tất cả</a>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
        @foreach($trending as $song)
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
                    <img src="{{ asset('images/'.$song->song_image) }}" onerror="this.src='https://via.placeholder.com/300'">
                    <div class="play-overlay">
                        <button type="button" class="btn-play-circle js-play-song" data-action="play" data-song-id="{{ $song->song_id }}"><i class="fas fa-play ms-1"></i></button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="overflow-hidden flex-grow-1">
                            <h6 class="fw-bold mb-1 text-truncate">{{ $song->song_name }}</h6>
                            <small class="text-muted d-block text-truncate">{{ $song->artist_name }}</small>
                        </div>
                        <div class="dropdown ms-2">
                            <button class="btn btn-link text-secondary p-0 btn-song-menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 overflow-hidden">
                                <li><button class="dropdown-item py-2" type="button" data-action="play" data-song-id="{{ $song->song_id }}"><i class="fas fa-play me-2 text-primary"></i> Phát ngay</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="like" data-song-id="{{ $song->song_id }}"><i class="fas fa-heart me-2 text-danger"></i> Thêm vào yêu thích</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="queue" data-song-id="{{ $song->song_id }}"><i class="fas fa-list-ul me-2 text-secondary"></i> Thêm vào hàng đợi</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="playlist" data-song-id="{{ $song->song_id }}"><i class="fas fa-plus-square me-2 text-secondary"></i> Thêm vào Playlist</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="album" data-song-id="{{ $song->song_id }}" data-album-id="{{ $song->album_id ?? '' }}"><i class="fas fa-record-vinyl me-2 text-secondary"></i> Đi tới album</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="artist" data-song-id="{{ $song->song_id }}" data-artist-id="{{ $song->artist_id }}"><i class="fas fa-user me-2 text-secondary"></i> Đi tới ca sĩ</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="share" data-song-id="{{ $song->song_id }}" data-song-name="{{ e($song->song_name) }}" data-song-artist="{{ e($song->artist_name) }}"><i class="fas fa-share me-2 text-secondary"></i> Chia sẻ</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="copy-link" data-song-id="{{ $song->song_id }}"><i class="fas fa-link me-2 text-secondary"></i> Sao chép liên kết</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title m-0">Mới Phát Hành</h2>
        <a href="{{ route('dashboard.new-releases') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3" data-new-releases-link>Xem tất cả</a>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
        @foreach($newest_songs as $song)
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
                    <img src="{{ asset('images/'.$song->song_image) }}" onerror="this.src='https://via.placeholder.com/300'">
                    
                    @if($song->genre_name)
                        <span class="badge bg-dark position-absolute top-0 end-0 m-2 opacity-75">{{ $song->genre_name }}</span>
                    @endif
                    
                    <div class="play-overlay">
                        <button type="button" class="btn-play-circle js-play-song" data-action="play" data-song-id="{{ $song->song_id }}"><i class="fas fa-play ms-1"></i></button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="overflow-hidden flex-grow-1">
                            <h6 class="fw-bold mb-1 text-truncate">{{ $song->song_name }}</h6>
                            <small class="text-muted d-block text-truncate">{{ $song->artist_name }}</small>
                            <div class="mt-2"><span class="badge bg-success bg-opacity-10 text-success"><i class="fas fa-clock me-1"></i> Mới</span></div>
                        </div>
                        <div class="dropdown ms-2">
                            <button class="btn btn-link text-secondary p-0 btn-song-menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 overflow-hidden">
                                <li><button class="dropdown-item py-2" type="button" data-action="play" data-song-id="{{ $song->song_id }}"><i class="fas fa-play me-2 text-primary"></i> Phát ngay</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="like" data-song-id="{{ $song->song_id }}"><i class="fas fa-heart me-2 text-danger"></i> Thêm vào yêu thích</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="queue" data-song-id="{{ $song->song_id }}"><i class="fas fa-list-ul me-2 text-secondary"></i> Thêm vào hàng đợi</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="playlist" data-song-id="{{ $song->song_id }}"><i class="fas fa-plus-square me-2 text-secondary"></i> Thêm vào Playlist</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="album" data-song-id="{{ $song->song_id }}" data-album-id="{{ $song->album_id ?? '' }}"><i class="fas fa-record-vinyl me-2 text-secondary"></i> Đi tới album</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="artist" data-song-id="{{ $song->song_id }}" data-artist-id="{{ $song->artist_id }}"><i class="fas fa-user me-2 text-secondary"></i> Đi tới ca sĩ</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="share" data-song-id="{{ $song->song_id }}" data-song-name="{{ e($song->song_name) }}" data-song-artist="{{ e($song->artist_name) }}"><i class="fas fa-share me-2 text-secondary"></i> Chia sẻ</button></li>
                                <li><button class="dropdown-item py-2" type="button" data-action="copy-link" data-song-id="{{ $song->song_id }}"><i class="fas fa-link me-2 text-secondary"></i> Sao chép liên kết</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title m-0">Album Nổi Bật</h2>
            <a href="{{ route('dashboard.albums') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3">Xem tất cả</a>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            @foreach($albums as $al)
            <div class="col">
                <a href="{{ route('dashboard.albums', ['album_id' => $al->album_id]) }}" class="album-feature-card" data-album-link>
                    <div class="album-feature-media">
                        <img src="{{ asset('images/'.$al->cover_image) }}" alt="{{ $al->album_name }}" onerror="this.src='https://via.placeholder.com/400'">
                        <div class="album-feature-overlay">
                            <span class="album-feature-btn">Xem Album</span>
                        </div>
                    </div>
                    <div class="album-feature-body">
                        <div class="album-feature-title">{{ $al->album_name }}</div>
                        <div class="album-feature-artist">{{ $al->artist_name }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title m-0">Nghệ Sĩ Nổi Bật</h2>
            <a href="{{ route('dashboard.artists') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3">Xem tất cả</a>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
            @foreach($artists_list as $art)
            <div class="col artist-feature-item">
                <a href="{{ route('dashboard.artists', ['artist_id' => $art->artist_id]) }}" class="artist-feature-link text-decoration-none d-inline-block" title="{{ $art->artist_name }}" data-artist-link>
                    <img src="{{ asset('images/'.$art->avatar_image) }}" class="artist-feature-avatar" alt="{{ $art->artist_name }}" onerror="this.src='https://via.placeholder.com/130'">
                    <div class="artist-feature-name text-truncate">{{ $art->artist_name }}</div>
                </a>
                <a href="{{ route('dashboard.albums', ['artist_id' => $art->artist_id]) }}" class="artist-feature-album-link" data-album-link>Xem album</a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title m-0">Tin Tức</h2>
            <a href="{{ route('dashboard.news') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3">Xem tất cả</a>
        </div>

        <div class="d-flex flex-column gap-4">
            @forelse($news_list ?? [] as $item)
                <article class="news-home-card">
                    <div class="row g-0 align-items-stretch">
                        <div class="col-12 col-md-3">
                            <img
                                src="{{ asset('images/'.($item->new_image ?? 'banner.png')) }}"
                                onerror="this.src='https://via.placeholder.com/540x300'"
                                alt="{{ $item->title ?? 'Tin tức' }}"
                                class="news-home-image"
                            >
                        </div>
                        <div class="col-12 col-md-9">
                            <div class="p-3 p-md-4 h-100 d-flex flex-column justify-content-center">
                                <h4 class="news-home-title">{{ $item->title ?? 'Tin tức mới' }}</h4>
                                <p class="news-home-excerpt mb-2">{{ \Illuminate\Support\Str::limit(strip_tags($item->description ?? ''), 120) }}</p>
                                <div class="news-home-meta"><i class="fas fa-calendar-alt me-2"></i>{{ !empty($item->event_date) ? date('d/m/Y', strtotime($item->event_date)) : (!empty($item->created_at) ? date('d/m/Y', strtotime($item->created_at)) : 'Đang cập nhật') }}</div>
                                <div class="news-home-meta"><i class="fas fa-map-marker-alt me-2"></i>{{ $item->location ?? 'Địa điểm đang cập nhật' }}</div>
                                <div>
                                    <a href="{{ route('dashboard.news.detail', ['newsId' => $item->news_id]) }}" class="btn news-home-btn" data-news-detail-link>Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="alert alert-light border text-muted mb-0">Chưa có tin tức.</div>
            @endforelse
        </div>
    </div>

    <textarea id="data-songs-source" style="display:none;">
        {{ json_encode($js_data) }}
    </textarea>

@endsection