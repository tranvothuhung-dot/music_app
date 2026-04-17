<x-admin-layout title="Bài Hát - Admin">
    @php
        $keyword = $keyword ?? trim((string) request('q', ''));
        $songs = collect($songs ?? []);
        $pagination = $pagination ?? null;
        $perPage = $perPage ?? 5;
        $artistsOptions = collect($artistsOptions ?? []);
        $albumsOptions = collect($albumsOptions ?? []);
        $genresOptions = collect($genresOptions ?? []);
    @endphp

    @push('styles')
        <style>
            .songs-page {
                margin-top: 26px;
            }

            .songs-title {
                margin: 0 0 16px;
                color: #252b36;
                font-size: 20px;
                font-weight: 700;
                line-height: 1.1;
            }

            .songs-toolbar {
                display: flex;
                gap: 16px;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 18px;
            }

            .songs-search {
                flex: 1;
                display: flex;
                max-width: 1060px;
            }

            .songs-input {
                flex: 1;
                height: 44px;
                border: 0;
                border-radius: 10px 0 0 10px;
                background: #ffffff;
                padding: 0 14px;
                color: #667084;
                font-size: 13px;
                outline: none;
                box-shadow: 0 3px 10px rgba(15, 23, 42, 0.06);
            }

            .songs-input::placeholder {
                color: #9aa3b2;
            }

            .songs-search-btn {
                height: 44px;
                min-width: 100px;
                border: 0;
                border-radius: 0 10px 10px 0;
                background: #2f3946;
                color: #fff;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                padding: 0 10px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
                white-space: nowrap;
            }

            .songs-add-btn {
                height: 44px;
                border: 0;
                border-radius: 10px;
                background: linear-gradient(135deg, #ff5897, #ff3f85);
                color: #fff;
                font-size: 13px;
                font-weight: 600;
                padding: 0 18px;
                cursor: pointer;
                box-shadow: 0 8px 18px rgba(255, 70, 139, 0.24);
                min-width: 158px;
                white-space: nowrap;
            }

            .songs-table-wrap {
                overflow: hidden;
                border: 1px solid #e5e8ef;
                border-radius: 12px;
            }

            .songs-pagination-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 16px;
                background: #f7f9fc;
                border: 1px solid #e5e8ef;
                border-top: 0;
                border-radius: 0 0 12px 12px;
                margin-bottom: 12px;
                margin-top: 12px;
                gap: 16px;
                flex-wrap: wrap;
            }

            .songs-pagination-info {
                font-size: 13px;
                color: #667084;
            }

            .songs-pagination-controls {
                display: flex;
                gap: 6px;
                align-items: center;
                flex-wrap: wrap;
            }

            .songs-pagination-controls a,
            .songs-pagination-controls span {
                padding: 6px 10px;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                font-size: 13px;
                text-decoration: none;
                color: #ff5897;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 32px;
                height: 32px;
            }

            .songs-pagination-controls a:hover {
                background: #fff5f8;
                border-color: #ff5897;
            }

            .songs-pagination-controls span.active {
                background: #ff5897;
                color: #fff;
                border-color: #ff5897;
                font-weight: 600;
            }

            .songs-pagination-controls span.disabled {
                color: #999;
                border-color: #dee2e6;
                cursor: not-allowed;
            }

            .songs-per-page-row {
                display: flex;
                gap: 12px;
                align-items: center;
                padding: 12px 0;
            }

            .songs-per-page-label {
                font-size: 13px;
                color: #667084;
            }

            .songs-per-page-select {
                padding: 6px 10px;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                font-size: 13px;
                color: #495057;
                background: #fff;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .songs-per-page-select:hover {
                border-color: #ff5897;
            }

            .songs-per-page-select:focus {
                outline: none;
                border-color: #ff5897;
                box-shadow: 0 0 0 0.2rem rgba(255, 88, 151, 0.1);
            }

            .songs-now-playing {
                display: none;
                align-items: center;
                gap: 14px;
                background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
                border: 1px solid #e6ebf2;
                border-radius: 12px;
                padding: 12px 14px;
                margin-bottom: 16px;
                box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
            }

            .songs-now-playing.show {
                display: flex;
            }

            .songs-now-cover {
                width: 54px;
                height: 54px;
                border-radius: 10px;
                object-fit: cover;
                border: 1px solid #d6dde8;
                background: #fff;
                flex-shrink: 0;
            }

            .songs-now-main {
                flex: 1;
                min-width: 0;
            }

            .songs-now-title {
                margin: 0 0 3px;
                font-size: 15px;
                font-weight: 700;
                color: #1f2937;
                line-height: 1.25;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .songs-now-artist {
                margin: 0 0 8px;
                font-size: 13px;
                font-weight: 600;
                color: #475569;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .songs-now-audio {
                width: 100%;
                height: 34px;
            }

            .songs-table {
                width: 100%;
                min-width: 100%;
                table-layout: fixed;
                border-collapse: collapse;
                font-size: 13px;
            }

            .songs-table thead th {
                text-align: center;
                font-weight: 700;
                background: #f7f9fc;
                padding: 10px;
                border-bottom: 1px solid #edf1f7;
                vertical-align: top;
                font-size: 13px;
                line-height: 1.3;
            }

            .songs-table tbody td {
                text-align: center;
                border-bottom: 1px solid #edf1f7;
                padding: 10px;
                font-size: 13px;
                color: #212938;
                vertical-align: top;
            }

            .songs-table tbody tr:last-child td {
                border-bottom: 0;
            }

            .song-cell {
                display: inline-flex;
                align-items: center;
                gap: 14px;
                justify-content: center;
                flex-wrap: nowrap;
                white-space: nowrap;
            }

            .songs-col-title {
                text-align: center !important;
                padding-left: 10px !important;
            }

            .songs-col-title-cell {
                text-align: left !important;
                padding-left: 1cm !important;
            }

            .songs-col-title-cell .song-cell {
                justify-content: flex-start;
            }

            .song-cover {
                width: 46px;
                height: 46px;
                border-radius: 10px;
                object-fit: cover;
                border: 1px solid #d8deea;
                background: #f2f4f8;
                flex-shrink: 0;
            }

            .song-cover-wrap {
                position: relative;
                width: 46px;
                height: 46px;
                border-radius: 10px;
                overflow: hidden;
                cursor: pointer;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .song-cover-wrap:hover {
                transform: translateY(-2px) scale(1.04);
                box-shadow: 0 8px 16px rgba(15, 23, 42, 0.18);
            }

            .song-cover-wrap.playing {
                box-shadow: 0 0 0 2px #1580f5;
            }

            .song-cover-play {
                position: absolute;
                inset: 0;
                border: 0;
                background: rgba(9, 14, 24, 0.45);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.2s ease;
                cursor: pointer;
                padding: 0;
            }

            .song-cover-play i {
                font-size: 16px;
                pointer-events: none;
            }

            .song-cover-wrap:hover .song-cover-play,
            .song-cover-wrap.playing .song-cover-play {
                opacity: 1;
            }

            .song-title {
                display: inline-block;
                max-width: 260px;
                font-size: 13px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .song-meta {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
                min-width: 0;
            }

            .action-buttons {
                display: inline-flex;
                align-items: center;
                gap: 0;
                border: 1px solid #d7dde5;
                border-radius: 4px;
                overflow: hidden;
                background: #fff;
            }

            .action-btn {
                width: 30px;
                height: 28px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-size: 13px;
                background: #fff;
                border: 0;
                transition: background-color 0.2s ease;
                cursor: pointer;
            }

            .action-btn svg {
                width: 14px;
                height: 14px;
                display: block;
            }

            .action-btn.edit {
                color: #0d6efd;
                border-right: 1px solid #d7dde5;
            }

            .action-btn.delete {
                color: #dc3545;
            }

            .action-btn.edit:hover {
                background: #f3f7ff;
                color: #0b5ed7;
            }

            .action-btn.delete:hover {
                background: #fff4f6;
                color: #bb2d3b;
            }

            .empty-state {
                padding: 28px 22px;
                text-align: center;
                color: #7b8593;
                font-size: 13px;
                font-weight: 500;
            }

            .song-modal-overlay {
                position: fixed;
                inset: 0;
                background: rgba(18, 24, 38, 0.55);
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 2000;
                padding: 16px;
            }

            .song-modal-overlay.show {
                display: flex;
            }

            .song-modal {
                width: 100%;
                max-width: 760px;
                background: #fff;
                border-radius: 6px;
                overflow: hidden;
                box-shadow: 0 22px 50px rgba(15, 23, 42, 0.35);
            }

            .song-modal-head {
                height: 52px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 14px;
                background: #1580f5;
                color: #fff;
            }

            .song-modal-title {
                margin: 0;
                font-size: 20px;
                font-weight: 700;
            }

            .song-modal-close {
                border: 0;
                background: transparent;
                color: #7bc0ff;
                font-size: 20px;
                line-height: 1;
                cursor: pointer;
                font-weight: 700;
            }

            .song-modal-body {
                padding: 14px 16px 12px;
                max-height: calc(100vh - 160px);
                overflow-y: auto;
            }

            .song-form-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0 14px;
            }

            .song-form-group {
                display: flex;
                flex-direction: column;
            }

            .song-form-group.full {
                grid-column: 1 / -1;
            }

            .song-form-label {
                display: block;
                font-size: 14px;
                font-weight: 600;
                color: #3f4753;
                margin-bottom: 6px;
            }

            .song-form-control {
                width: 100%;
                height: 40px;
                border: 1px solid #ced4da;
                border-radius: 4px;
                padding: 6px 10px;
                font-family: inherit;
                font-size: 14px;
                color: #495057;
                outline: none;
                margin-bottom: 12px;
            }

            .song-form-control:focus {
                border-color: #86b7fe;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
            }

            .song-file-label {
                color: #20a74e;
            }

            .song-file-input {
                height: auto;
                border: 0;
                border-radius: 0;
                padding: 4px;
                font-size: 14px;
                color: #2f3946;
                margin-bottom: 12px;
            }

            .song-modal-footer {
                display: flex;
                justify-content: flex-end;
                gap: 8px;
            }

            .song-modal-btn {
                border: 0;
                border-radius: 4px;
                padding: 8px 14px;
                color: #fff;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer;
                font-family: inherit;
            }

            .song-modal-btn.cancel {
                background: #6c757d;
            }

            .song-modal-btn.submit {
                background: #0d6efd;
            }

            .edit-modal-card {
                max-width: 760px;
            }

            .edit-modal-card .song-modal-head {
                height: 54px;
                background: #fff;
                color: #3b3f45;
                border-bottom: 1px solid #e5e7eb;
            }

            .edit-modal-card .song-modal-close {
                color: #7b8088;
            }

            .edit-modal-card .song-modal-btn.submit {
                background: #0d6efd;
            }

            @media (max-width: 1280px) {
                .songs-title {
                    font-size: 20px;
                }

                .songs-input,
                .songs-search-btn,
                .songs-add-btn {
                    font-size: 13px;
                    height: 40px;
                }

                .songs-search-btn,
                .songs-add-btn {
                    min-width: auto;
                }

                .songs-table thead th,
                .songs-table tbody td {
                    font-size: 13px;
                }
            }

            @media (max-width: 768px) {
                .songs-toolbar {
                    flex-direction: column;
                    align-items: stretch;
                }

                .songs-search {
                    max-width: 100%;
                }

                .songs-add-btn {
                    width: 100%;
                }

                .song-modal {
                    max-width: 100%;
                }

                .song-form-grid {
                    grid-template-columns: 1fr;
                }

                .song-form-group.full {
                    grid-column: auto;
                }

                .songs-now-playing {
                    flex-wrap: wrap;
                    padding: 10px;
                }

                .songs-now-cover {
                    width: 48px;
                    height: 48px;
                }
            }
        </style>
    @endpush

    <section class="songs-page">
        <h1 class="songs-title">Kho Bài Hát</h1>

        @if (session('success'))
            <div style="margin-bottom: 12px; padding: 10px 12px; border-radius: 10px; border: 1px solid #badbcc; background: #d1e7dd; color: #0f5132; font-size: 13px; font-weight: 700;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="margin-bottom: 12px; padding: 10px 12px; border-radius: 10px; border: 1px solid #f5c2c7; background: #f8d7da; color: #842029; font-size: 13px; font-weight: 700;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="songs-toolbar">
            <form class="songs-search" method="GET" action="{{ route('admin.songs.index') }}">
                <input
                    class="songs-input"
                    type="text"
                    name="q"
                    value="{{ $keyword }}"
                    placeholder="Tìm kiếm bài hát, ca sĩ..."
                >
                <button class="songs-search-btn" type="submit">
                    <span>🔍</span>
                    <span>Tìm kiếm</span>
                </button>
            </form>

            <button type="button" class="songs-add-btn" id="openSongModal">+ Thêm Bài Hát</button>
        </div>

        <div class="songs-per-page-row">
            <form method="GET" action="{{ route('admin.songs.index') }}" style="display: flex; gap: 8px; align-items: center;">
                <input type="hidden" name="q" value="{{ $keyword }}">
                <label class="songs-per-page-label" for="songsPerPageSelect">Bản ghi mỗi trang:</label>
                <select class="songs-per-page-select" id="songsPerPageSelect" name="per_page" onchange="this.form.submit()">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                </select>
            </form>
        </div>

        <div class="songs-now-playing" id="songsNowPlaying" aria-live="polite">
            <img id="songsNowCover" class="songs-now-cover" src="{{ asset('images/song-placeholder.svg') }}" alt="Now playing cover">
            <div class="songs-now-main">
                <p id="songsNowTitle" class="songs-now-title">Chưa chọn bài hát</p>
                <p id="songsNowArtist" class="songs-now-artist">-</p>
                <audio id="songsNowAudio" class="songs-now-audio" controls preload="metadata"></audio>
            </div>
        </div>

        <div class="songs-table-wrap">
            <table class="songs-table">
                <thead>
                    <tr>
                        <th class="songs-col-title">BÀI HÁT</th>
                        <th>CA SĨ</th>
                        <th>DURATION</th>
                        <th>VIEWS</th>
                        <th>NGÀY ĐĂNG</th>
                        <th>HÀNH ĐỘNG</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($songs as $song)
                        <tr>
                            <td class="songs-col-title-cell">
                                <div class="song-cell">
                                    <div class="song-cover-wrap js-song-cover"
                                        data-audio-src="{{ $song['audio_src'] ?? '' }}"
                                        data-song-id="{{ $song['id'] }}"
                                        data-title="{{ $song['title'] }}"
                                        data-artist="{{ $song['artist'] }}"
                                        data-cover="{{ asset($song['cover']) }}"
                                        title="Phát nhạc">
                                        <img class="song-cover" src="{{ asset($song['cover']) }}" alt="{{ $song['title'] }}">
                                        <button type="button" class="song-cover-play" aria-label="Phát bài hát">
                                            <i class="fa-solid fa-play"></i>
                                        </button>
                                    </div>
                                    <div class="song-meta">
                                        <span class="song-title">{{ $song['title'] }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $song['artist'] }}</td>
                            <td>{{ is_numeric($song['duration']) ? $song['duration'] . 's' : $song['duration'] }}</td>
                            <td>{{ $song['views'] }}</td>
                            <td>{{ $song['posted_at'] }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a class="action-btn edit js-open-edit-song" href="#" title="Sửa"
                                        data-id="{{ $song['id'] ?? 0 }}"
                                        data-title="{{ $song['title'] }}"
                                        data-artist-id="{{ $song['artist_id'] ?? 0 }}"
                                        data-album-id="{{ $song['album_id'] ?? 0 }}"
                                        data-genre-id="{{ $song['genre_id'] ?? 0 }}"
                                        data-duration="{{ $song['duration'] }}"
                                        data-song-url="{{ $song['song_url'] ?? '' }}">
                                        <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.songs.destroy', $song['id']) }}" onsubmit="return confirm('Bạn có chắc muốn xóa bài hát này?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-btn delete" type="submit" title="Xóa">
                                            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2" />
                                                <path d="M19 6l-1 14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1L5 6" />
                                                <line x1="10" y1="11" x2="10" y2="17" />
                                                <line x1="14" y1="11" x2="14" y2="17" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">Không tìm thấy bài hát nào phù hợp.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pagination && $pagination->hasPages())
            <div class="songs-pagination-top">
                <div class="songs-pagination-info">
                    Hiển thị {{ $pagination->firstItem() }} đến {{ $pagination->lastItem() }} trong {{ $pagination->total() }} bản ghi
                </div>
                <div class="songs-pagination-controls">
                    @if($pagination->onFirstPage())
                        <span class="disabled">← Trước</span>
                    @else
                        <a href="{{ $pagination->previousPageUrl() }}" title="Trang trước">← Trước</a>
                    @endif

                    @foreach($pagination->getUrlRange(1, $pagination->lastPage()) as $page => $url)
                        @if($page == $pagination->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($pagination->hasMorePages())
                        <a href="{{ $pagination->nextPageUrl() }}" title="Trang sau">Sau →</a>
                    @else
                        <span class="disabled">Sau →</span>
                    @endif
                </div>
            </div>
        @endif
    </section>

    <div class="song-modal-overlay" id="songModalOverlay" aria-hidden="true">
        <div class="song-modal" role="dialog" aria-modal="true" aria-labelledby="songModalTitle">
            <div class="song-modal-head">
                <h2 class="song-modal-title" id="songModalTitle">Thêm Bài Hát</h2>
                <button type="button" class="song-modal-close" id="closeSongModal" aria-label="Đóng">&times;</button>
            </div>

            <form class="song-modal-body" action="{{ route('admin.songs.store') }}" method="POST" enctype="multipart/form-data" id="addSongForm">
                @csrf
                <div class="song-form-grid">
                    <div class="song-form-group">
                        <label class="song-form-label" for="songName">Tên Bài Hát</label>
                        <input class="song-form-control" id="songName" name="song_name" type="text" value="{{ old('song_name') }}">
                    </div>

                    <div class="song-form-group">
                        <label class="song-form-label" for="songArtist">Ca Sĩ</label>
                        <select class="song-form-control" id="songArtist" name="artist_id" required>
                            <option value="">-- Chọn ca sĩ --</option>
                            @foreach($artistsOptions as $artistOption)
                                <option value="{{ $artistOption->artist_id }}" {{ (string) old('artist_id') === (string) $artistOption->artist_id ? 'selected' : '' }}>
                                    {{ $artistOption->artist_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="song-form-group">
                        <label class="song-form-label" for="songGenre">Thể Loại</label>
                        <select class="song-form-control" id="songGenre" name="genre_id" required>
                            <option value="">-- Chọn thể loại --</option>
                            @foreach($genresOptions as $genreOption)
                                <option value="{{ $genreOption->genre_id }}" {{ (string) old('genre_id') === (string) $genreOption->genre_id ? 'selected' : '' }}>
                                    {{ $genreOption->genre_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="song-form-group">
                        <label class="song-form-label" for="songDuration">Duration</label>
                        <input class="song-form-control" id="songDuration" name="duration" type="number" min="1" value="{{ old('duration') }}" placeholder="Ví dụ: 250">
                    </div>

                    <div class="song-form-group">
                        <label class="song-form-label" for="songAlbum">Album</label>
                        <select class="song-form-control" id="songAlbum" name="album_id" required>
                            <option value="">-- Chọn album --</option>
                            @foreach($albumsOptions as $albumOption)
                                <option value="{{ $albumOption->album_id }}" {{ (string) old('album_id') === (string) $albumOption->album_id ? 'selected' : '' }}>
                                    {{ $albumOption->album_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="song-form-group full">
                        <label class="song-form-label" for="songImage">Ảnh bài hát</label>
                        <input class="song-form-control song-file-input" id="songImage" name="song_image" type="file" accept="image/*">
                    </div>

                    <div class="song-form-group full">
                        <label class="song-form-label" for="songUrl">Link bài hát (song_url)</label>
                        <input class="song-form-control" id="songUrl" name="song_url" type="text" value="{{ old('song_url') }}" placeholder="https://... hoặc để trống nếu upload file nhạc">
                    </div>

                    <div class="song-form-group full">
                        <label class="song-form-label song-file-label" for="songFile">File Nhạc (.mp3)</label>
                        <input class="song-form-control song-file-input" id="songFile" name="song_file" type="file" accept="audio/mpeg,.mp3">
                    </div>
                </div>

                <div class="song-modal-footer">
                    <button type="button" class="song-modal-btn cancel" id="cancelSongModal">Hủy</button>
                    <button type="submit" class="song-modal-btn submit">Thêm</button>
                </div>
            </form>
        </div>
    </div>

    <div class="song-modal-overlay" id="editSongModalOverlay" aria-hidden="true">
        <div class="song-modal edit-modal-card" role="dialog" aria-modal="true" aria-labelledby="editSongModalTitle">
            <div class="song-modal-head">
                <h2 class="song-modal-title" id="editSongModalTitle">Sửa Bài Hát</h2>
                <button type="button" class="song-modal-close" id="closeEditSongModal" aria-label="Đóng">&times;</button>
            </div>

            <form class="song-modal-body" action="{{ route('admin.songs.update', ['song' => 0]) }}" method="POST" enctype="multipart/form-data" id="editSongForm" data-action-template="{{ route('admin.songs.update', ['song' => '__ID__']) }}">
                @csrf
                @method('PATCH')
                <div class="song-form-grid">
                    <div class="song-form-group">
                        <label class="song-form-label" for="editSongName">Tên Bài Hát</label>
                        <input class="song-form-control" id="editSongName" name="song_name" type="text">
                    </div>

                    <div class="song-form-group">
                        <label class="song-form-label" for="editSongArtist">Ca Sĩ</label>
                        <select class="song-form-control" id="editSongArtist" name="artist_id" required>
                            <option value="">-- Chọn ca sĩ --</option>
                            @foreach($artistsOptions as $artistOption)
                                <option value="{{ $artistOption->artist_id }}">{{ $artistOption->artist_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="song-form-group">
                        <label class="song-form-label" for="editSongGenre">Thể Loại</label>
                        <select class="song-form-control" id="editSongGenre" name="genre_id" required>
                            <option value="">-- Chọn thể loại --</option>
                            @foreach($genresOptions as $genreOption)
                                <option value="{{ $genreOption->genre_id }}">{{ $genreOption->genre_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="song-form-group">
                        <label class="song-form-label" for="editSongDuration">Duration</label>
                        <input class="song-form-control" id="editSongDuration" name="duration" type="number" min="1" placeholder="Ví dụ: 250">
                    </div>

                    <div class="song-form-group">
                        <label class="song-form-label" for="editSongAlbum">Album</label>
                        <select class="song-form-control" id="editSongAlbum" name="album_id" required>
                            <option value="">-- Chọn album --</option>
                            @foreach($albumsOptions as $albumOption)
                                <option value="{{ $albumOption->album_id }}">{{ $albumOption->album_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="song-form-group full">
                        <label class="song-form-label" for="editSongImage">Ảnh bài hát</label>
                        <input class="song-form-control song-file-input" id="editSongImage" name="song_image" type="file" accept="image/*">
                    </div>

                    <div class="song-form-group full">
                        <label class="song-form-label" for="editSongUrl">Link bài hát (song_url)</label>
                        <input class="song-form-control" id="editSongUrl" name="song_url" type="text" placeholder="https://... hoặc để trống nếu upload file nhạc">
                    </div>

                    <div class="song-form-group full">
                        <label class="song-form-label song-file-label" for="editSongFile">File Nhạc (.mp3)</label>
                        <input class="song-form-control song-file-input" id="editSongFile" name="song_file" type="file" accept="audio/mpeg,.mp3">
                    </div>
                </div>

                <div class="song-modal-footer">
                    <button type="button" class="song-modal-btn cancel" id="cancelEditSongModal">Hủy</button>
                    <button type="submit" class="song-modal-btn submit">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            (function () {
                const openButton = document.getElementById('openSongModal');
                const overlay = document.getElementById('songModalOverlay');
                const closeButton = document.getElementById('closeSongModal');
                const cancelButton = document.getElementById('cancelSongModal');
                const addForm = document.getElementById('addSongForm');

                if (!openButton || !overlay || !closeButton || !cancelButton) {
                    return;
                }

                const openModal = () => {
                    if (addForm) {
                        addForm.reset();
                    }
                    overlay.classList.add('show');
                    overlay.setAttribute('aria-hidden', 'false');
                };

                const closeModal = () => {
                    if (addForm) {
                        addForm.reset();
                    }
                    overlay.classList.remove('show');
                    overlay.setAttribute('aria-hidden', 'true');
                };

                openButton.addEventListener('click', openModal);
                closeButton.addEventListener('click', closeModal);
                cancelButton.addEventListener('click', closeModal);

                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) {
                        closeModal();
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' && overlay.classList.contains('show')) {
                        closeModal();
                    }
                });
            })();

            // Edit song modal
            (function () {
                const editButtons = document.querySelectorAll('.js-open-edit-song');
                const editOverlay = document.getElementById('editSongModalOverlay');
                const closeEditButton = document.getElementById('closeEditSongModal');
                const cancelEditButton = document.getElementById('cancelEditSongModal');
                const editForm = document.getElementById('editSongForm');
                const actionTemplate = editForm ? editForm.dataset.actionTemplate : '';

                if (!editOverlay || !closeEditButton || !cancelEditButton) {
                    return;
                }

                const openEditModal = (songData) => {
                    if (editForm) {
                        editForm.reset();
                    }
                    document.getElementById('editSongName').value = songData.title || '';
                    document.getElementById('editSongArtist').value = songData.artistId || '';
                    document.getElementById('editSongAlbum').value = songData.albumId || '';
                    document.getElementById('editSongGenre').value = songData.genreId || '';
                    document.getElementById('editSongDuration').value = songData.duration || '';
                    document.getElementById('editSongUrl').value = songData.songUrl || '';
                    editOverlay.classList.add('show');
                    editOverlay.setAttribute('aria-hidden', 'false');
                    editForm.dataset.songId = songData.id;

                    if (actionTemplate && songData.id) {
                        editForm.action = actionTemplate.replace('__ID__', songData.id);
                    }
                };

                const closeEditModal = () => {
                    if (editForm) {
                        editForm.reset();
                        editForm.dataset.songId = '';
                    }
                    editOverlay.classList.remove('show');
                    editOverlay.setAttribute('aria-hidden', 'true');
                };

                editButtons.forEach(button => {
                    button.addEventListener('click', function (e) {
                        e.preventDefault();
                        openEditModal({
                            id: this.dataset.id,
                            title: this.dataset.title,
                            artistId: this.dataset.artistId,
                            albumId: this.dataset.albumId,
                            genreId: this.dataset.genreId,
                            duration: this.dataset.duration,
                            songUrl: this.dataset.songUrl,
                        });
                    });
                });

                closeEditButton.addEventListener('click', closeEditModal);
                cancelEditButton.addEventListener('click', closeEditModal);

                editOverlay.addEventListener('click', function (event) {
                    if (event.target === editOverlay) {
                        closeEditModal();
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' && editOverlay.classList.contains('show')) {
                        closeEditModal();
                    }
                });
            })();

            // Song preview play on avatar hover/click
            (function () {
                const covers = document.querySelectorAll('.js-song-cover');
                const nowPlaying = document.getElementById('songsNowPlaying');
                const nowAudio = document.getElementById('songsNowAudio');
                const nowTitle = document.getElementById('songsNowTitle');
                const nowArtist = document.getElementById('songsNowArtist');
                const nowCover = document.getElementById('songsNowCover');

                if (!covers.length || !nowAudio) {
                    return;
                }

                let activeCover = null;

                const setIcon = (cover, iconClass) => {
                    if (!cover) {
                        return;
                    }
                    const icon = cover.querySelector('.song-cover-play i');
                    if (!icon) {
                        return;
                    }
                    icon.className = iconClass;
                };

                const clearActive = () => {
                    if (activeCover) {
                        activeCover.classList.remove('playing');
                        setIcon(activeCover, 'fa-solid fa-play');
                        activeCover = null;
                    }
                };

                covers.forEach(cover => {
                    cover.addEventListener('click', function (event) {
                        event.preventDefault();
                        event.stopPropagation();

                        const source = this.dataset.audioSrc || '';
                        if (!source) {
                            return;
                        }

                        if (activeCover === this && !nowAudio.paused) {
                            nowAudio.pause();
                            clearActive();
                            return;
                        }

                        if (nowAudio.src !== source) {
                            nowAudio.src = source;
                        }

                        if (nowTitle) {
                            nowTitle.textContent = this.dataset.title || 'Đang phát';
                        }

                        if (nowArtist) {
                            nowArtist.textContent = this.dataset.artist || '-';
                        }

                        if (nowCover) {
                            nowCover.src = this.dataset.cover || '{{ asset('images/song-placeholder.svg') }}';
                        }

                        if (nowPlaying) {
                            nowPlaying.classList.add('show');
                        }

                        nowAudio.play().then(() => {
                            clearActive();
                            activeCover = this;
                            this.classList.add('playing');
                            setIcon(this, 'fa-solid fa-pause');
                        }).catch(() => {
                            clearActive();
                        });
                    });
                });

                nowAudio.addEventListener('ended', clearActive);
                nowAudio.addEventListener('pause', () => {
                    if (activeCover) {
                        setIcon(activeCover, 'fa-solid fa-play');
                    }
                });
                nowAudio.addEventListener('play', () => {
                    if (activeCover) {
                        setIcon(activeCover, 'fa-solid fa-pause');
                    }
                });
            })();
        </script>
    @endpush
</x-admin-layout>
