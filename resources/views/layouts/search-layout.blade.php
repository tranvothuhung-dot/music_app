<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Search Box CSS */
        .search-container { position: relative; width: 400px; margin: 15px auto; }
        .search-input-wrapper { position: relative; }
        .search-input-wrapper i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888; }
        #searchInput { 
            padding-left: 40px; border-radius: 20px; border: 1px solid #ddd; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s ease;
        }
        #searchInput:focus { outline: none; border-color: #ff4081; box-shadow: 0 4px 15px rgba(255,64,129,0.2); }
        
        /* Dropdown CSS */
        #searchDropdown { 
            position: absolute; top: 110%; left: 0; width: 100%; background: #fff; 
            border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            display: none; z-index: 1000; padding: 15px; max-height: 400px; overflow-y: auto;
        }
        .dropdown-title { font-size: 13px; font-weight: bold; color: #888; margin-bottom: 10px; text-transform: uppercase;}
        
        /* Lịch sử tìm kiếm tags */
        .history-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;}
        .history-tag { 
            background: #f1f3f4; padding: 5px 12px; border-radius: 15px; 
            font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 5px;
        }
        .history-tag:hover { background: #e2e6ea; }
        .history-tag .del-btn { color: #888; font-size: 10px; }
        .history-tag .del-btn:hover { color: #ff4081; }

        /* Kết quả live search */
        .live-item { 
            display: flex; align-items: center; padding: 8px; border-radius: 8px; 
            cursor: pointer; transition: background 0.2s; text-decoration: none; color: inherit;
        }
        .live-item:hover { background: #f8f9fa; }
        .live-item img { width: 40px; height: 40px; border-radius: 6px; margin-right: 12px; object-fit: cover; }
        .live-item .info { flex-grow: 1; }
        .live-item .title { font-weight: 600; color: #000; font-size: 14px; margin: 0; }
        .live-item .subtitle { font-size: 12px; color: #666; margin: 0; }
        
        /* Nút Clear History */
        #clearHistoryBtn { float: right; font-size: 12px; color: #ff4081; cursor: pointer; text-transform: none; font-weight: normal;}

        /* CSS Mini Player (giữ nguyên của mày, tút lại tí) */
        #music-bar { position: fixed; bottom: 0; left: 0; width: 100%; background: rgba(34, 34, 34, 0.95); backdrop-filter: blur(10px); color: #fff; padding: 10px 15px; display: none; z-index: 1050; border-top: 1px solid #444;}
    </style>
</head>
<body>

    <nav class="navbar bg-white shadow-sm">
        <div class="container-fluid justify-content-center">
            <div class="search-container">
                <form action="{{ route('music.search') }}" method="GET" id="searchForm">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="q" id="searchInput" class="form-control" placeholder="Tìm bài hát, ca sĩ, album..." autocomplete="off">
                    </div>
                </form>
                <div id="searchDropdown">
                    </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <div id="music-bar">
        <div class="container d-flex align-items-center">
            <img id="bar-img" src="" alt="" style="width: 45px; height: 45px; border-radius: 6px; margin-right: 15px;">
            <div class="song-info me-auto">
                <div id="bar-title" class="fw-bold" style="font-size: 15px;"></div>
                <div id="bar-artist" class="small" style="color: #ccc;"></div>
            </div>
            <audio id="audio-player" controls style="display:none;"></audio>
            <button id="play-pause-btn" class="btn text-white fs-4"><i class="fas fa-play"></i></button>
        </div>
    </div>

    <div class="modal fade" id="loginRequireModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                <div class="modal-body text-center p-5">
                    <i class="fas fa-lock" style="font-size: 40px; color: #ff4081; margin-bottom: 20px;"></i>
                    <h4 class="fw-bold mb-3">Đăng nhập để nghe/sử dụng</h4>
                    <p class="text-muted mb-4">Bạn cần tài khoản để thưởng thức trọn vẹn và sử dụng tính năng này.</p>
                    <a href="#" class="btn btn-primary px-5 py-2" style="background-color: #ff4081; border: none; border-radius: 25px; font-weight: bold;">Đăng nhập ngay</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check trạng thái login từ Laravel
        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
        let searchTimeout;

        // Quản lý LocalStorage
        const HistoryManager = {
            getKey: () => isLoggedIn ? 'music_search_history_auth' : 'music_search_history_guest',
            get: function() { return JSON.parse(localStorage.getItem(this.getKey())) || []; },
            add: function(keyword) {
                if(!keyword) return;
                let h = this.get();
                h = h.filter(k => k !== keyword); // Xóa trùng
                h.unshift(keyword); // Thêm lên đầu
                if(h.length > 5) h.pop(); // Giữ 5 cái mới nhất
                localStorage.setItem(this.getKey(), JSON.stringify(h));
            },
            remove: function(keyword) {
                let h = this.get().filter(k => k !== keyword);
                localStorage.setItem(this.getKey(), JSON.stringify(h));
            },
            clear: function() { localStorage.removeItem(this.getKey()); }
        };

        // UI Builder cho Dropdown
        const DropdownUI = {
            box: $('#searchDropdown'),
            show: function() { this.box.fadeIn(200); },
            hide: function() { this.box.fadeOut(200); },
            renderDefault: function(trendingData) {
                let history = HistoryManager.get();
                let html = '';
                
                // Render History (Chỉ hiện nếu đã đăng nhập và có lịch sử)
                if (isLoggedIn && history.length > 0) {
                    html += `<div class="dropdown-title">Lịch sử tìm kiếm <span id="clearHistoryBtn">Xóa tất cả</span></div>
                             <div class="history-tags">`;
                    history.forEach(k => {
                        html += `<div class="history-tag" data-key="${k}">
                                    <i class="fas fa-history text-muted"></i> 
                                    <span class="h-text">${k}</span>
                                    <i class="fas fa-times del-btn"></i>
                                 </div>`;
                    });
                    html += `</div>`;
                }

                // Render Trending
                if (trendingData && trendingData.length > 0) {
                    html += `<div class="dropdown-title">Gợi ý thịnh hành</div>`;
                    trendingData.forEach(song => {
                        // Ảnh ảo hoặc ghép path thực tế
                        let imgSrc = song.song_image ? `/images/${song.song_image}` : 'https://via.placeholder.com/40';
                        html += `
                        <div class="live-item suggestion-item" data-id="${song.song_id}">
                            <img src="${imgSrc}" alt="">
                            <div class="info">
                                <p class="title">${song.song_name}</p>
                                <p class="subtitle">${song.artist_name} • <i class="fas fa-headphones"></i> ${formatView(song.view_count)}</p>
                            </div>
                        </div>`;
                    });
                }
                
                this.box.html(html);
            },
            renderLiveSearch: function(data) {
                let html = '';
                if(data.artists.length > 0) {
                    html += `<div class="dropdown-title">Nghệ sĩ</div>`;
                    data.artists.forEach(a => {
                        let imgSrc = a.avatar_image ? `/images/${a.avatar_image}` : 'https://via.placeholder.com/40';
                        html += `
                        <a href="/timkiem?q=${a.artist_name}" class="live-item">
                            <img src="${imgSrc}" style="border-radius: 50%;">
                            <div class="info"><p class="title">${a.artist_name}</p></div>
                        </a>`;
                    });
                }
                if(data.songs.length > 0) {
                    html += `<div class="dropdown-title mt-3">Bài hát</div>`;
                    data.songs.forEach(s => {
                        let imgSrc = s.song_image ? `/images/${s.song_image}` : 'https://via.placeholder.com/40';
                        html += `
                        <div class="live-item suggestion-item" data-id="${s.song_id}" data-url="${s.song_url}" data-name="${s.song_name}" data-img="${imgSrc}" data-artist="${s.artist_name}">
                            <img src="${imgSrc}">
                            <div class="info">
                                <p class="title">${s.song_name}</p>
                                <p class="subtitle">${s.artist_name}</p>
                            </div>
                        </div>`;
                    });
                }
                if(html === '') html = '<div class="text-center text-muted py-3">Không tìm thấy kết quả</div>';
                this.box.html(html);
            }
        };

        function formatView(views) {
            if(views >= 1000000) return (views/1000000).toFixed(1) + 'M';
            if(views >= 1000) return (views/1000).toFixed(1) + 'K';
            return views;
        }

        // Logic Input & AJAX
        $('#searchInput').on('focus', function() {
            let q = $(this).val().trim();
            if(q === '') fetchDefault();
            else fetchLive(q);
            DropdownUI.show();
        }).on('input', function() {
            clearTimeout(searchTimeout);
            let q = $(this).val().trim();
            if(q === '') { fetchDefault(); return; }
            searchTimeout = setTimeout(() => fetchLive(q), 300);
        });

        function fetchDefault() {
            $.get("{{ route('search.ajax') }}", function(res) {
                if(res.type === 'trending') DropdownUI.renderDefault(res.data);
            });
        }

        function fetchLive(q) {
            $.get("{{ route('search.ajax') }}", {q: q}, function(res) {
                if(res.type === 'search') DropdownUI.renderLiveSearch(res);
            });
        }

        // Submit Form -> Lưu lịch sử
        $('#searchForm').on('submit', function() {
            let q = $('#searchInput').val().trim();
            if(q) HistoryManager.add(q);
        });

        // Tương tác Dropdown
        $(document).on('click', '.history-tag .h-text', function() {
            let q = $(this).closest('.history-tag').data('key');
            $('#searchInput').val(q);
            $('#searchForm').submit();
        });

        $(document).on('click', '.del-btn', function(e) {
            e.stopPropagation();
            let q = $(this).closest('.history-tag').data('key');
            HistoryManager.remove(q);
            fetchDefault(); // render lại
        });

        $(document).on('click', '#clearHistoryBtn', function() {
            HistoryManager.clear();
            fetchDefault();
        });

        // Click vào 1 bài hát gợi ý -> Chặn bắt Login nếu chưa Auth
        $(document).on('click', '.suggestion-item', function() {
            if(!isLoggedIn) {
                DropdownUI.hide();
                $('#loginRequireModal').modal('show');
                return;
            }
            // Đã login -> Phát nhạc (Gắn hàm playSong của m vào đây)
            let url = $(this).data('url');
            let name = $(this).data('name');
            let artist = $(this).data('artist');
            let img = $(this).data('img');
            playSong(url, name, artist, img);
            DropdownUI.hide();
        });

        // Ẩn dropdown khi click ngoài
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-container').length) DropdownUI.hide();
        });

        function playSong(url, name, artist, image) {
            $('#bar-title').text(name);
            $('#bar-artist').text(artist);
            $('#bar-img').attr('src', image);
            let audio = document.getElementById('audio-player');
            audio.src = url; // Mày cần map đúng URL file tĩnh hoặc route stream
            $('#music-bar').slideDown();
            audio.play();
            $('#play-pause-btn i').removeClass('fa-play').addClass('fa-pause');
        }
    </script>
</body>
</html>