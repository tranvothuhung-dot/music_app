@extends('layouts.user-music')

@section('content')
<style>
    .filter-chips { display: flex; gap: 10px; margin-bottom: 25px; overflow-x: auto; padding-bottom: 5px; }
    .filter-chip { 
        padding: 8px 22px; border-radius: 25px; background: #fff; border: 1px solid #eee; 
        color: #555; font-weight: 700; cursor: pointer; transition: all 0.3s; white-space: nowrap; font-size: 14px;
    }
    .filter-chip:hover { background: #f8f9fa; border-color: #ff4081; color: #ff4081; }
    .filter-chip.active { background: #ff4081; color: #fff; border-color: #ff4081; box-shadow: 0 4px 12px rgba(255,64,129,0.25); }

    .song-bar { 
        display: flex; align-items: center; padding: 12px 16px; background: #fff; 
        border-radius: 15px; margin-bottom: 10px; transition: 0.25s; border: 1px solid transparent; cursor: pointer;
    }
    .song-bar:hover { background: #fff; box-shadow: 0 8px 20px rgba(0,0,0,0.06); transform: translateY(-2px); border-color: #ffeef4; }
    .song-bar.active-song { border-color: #ff4081; background: #fffcfd; }
    
    .song-bar-img-wrap { width: 52px; height: 52px; border-radius: 10px; overflow: hidden; margin-right: 16px; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .song-bar-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    
    .song-bar-info { flex-grow: 1; overflow: hidden; }
    .song-bar-title { font-size: 15px; font-weight: 800; color: #1a1a1a; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .song-bar-artist { font-size: 13px; color: #888; margin: 2px 0 0 0; font-weight: 500; }
    
    .song-bar-stats { display: flex; align-items: center; gap: 20px; color: #999; font-size: 13px; margin-right: 20px; font-weight: 600; }
    .song-bar-stats i { color: #ff4081; opacity: 0.8; }
    
    .btn-more { background: #f8f9fa; border: none; color: #aaa; width: 36px; height: 36px; border-radius: 10px; transition: 0.2s; }
    .btn-more:hover { background: #ff4081; color: #fff; }

    .result-section { display: flex; flex-direction: column; }
    .section-header { font-weight: 800; color: #333; margin-bottom: 18px; display: flex; align-items: center; gap: 10px; }
    .section-header::before { content: ''; width: 4px; height: 20px; background: #ff4081; border-radius: 10px; }
</style>

<div class="container py-2">
    <div class="d-flex align-items-center mb-4 gap-2">
        <h3 class="m-0 fw-bold" style="letter-spacing: -1px;">Kết quả cho:</h3>
        <span class="badge fs-5 px-3 py-2" style="background: rgba(255,64,129,0.1); color: #ff4081; border-radius: 12px;">"{{ $keyword }}"</span>
    </div>

    @if($keyword === '')
        <div class="text-center py-5 bg-white shadow-sm rounded-4">
            <i class="fas fa-search fa-3x mb-3 text-light"></i>
            <h5 class="text-secondary">Vui lòng nhập từ khóa để tìm kiếm.</h5>
        </div>
    @elseif($songs->isEmpty() && $artists->isEmpty() && $albums->isEmpty())
        <div class="text-center py-5 bg-white shadow-sm rounded-4">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="mb-3" style="opacity: 0.3;">
            <h5 class="text-muted fw-bold">Rất tiếc, không tìm thấy kết quả nào.</h5>
        </div>
    @else
        <div class="filter-chips">
            <div class="filter-chip active" data-filter="all">Tất cả</div>
            @if($songs->isNotEmpty()) <div class="filter-chip" data-filter="songs">Bài hát</div> @endif
            @if($artists->isNotEmpty()) <div class="filter-chip" data-filter="artists">Nghệ sĩ</div> @endif
            @if($albums->isNotEmpty()) <div class="filter-chip" data-filter="albums">Album</div> @endif
        </div>

        <div id="search-results-wrapper" class="d-flex flex-column">
            {{-- NGHỆ SĨ --}}
            @if($artists->isNotEmpty())
                <div class="result-section mb-5" id="section-artists" style="order: {{ $priority == 'artist' ? 1 : 4 }};">
                    <h5 class="section-header">Nghệ sĩ</h5>
                    <div class="row g-4">
                        @foreach($artists as $artist)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <a href="{{ route('dashboard.artists') }}?artist_id={{ $artist->artist_id }}" class="text-decoration-none text-center d-block custom-card p-3 bg-white" style="border-radius: 20px;">
                                    <div class="position-relative d-inline-block mb-3">
                                        <img src="{{ asset('images/'.$artist->avatar_image) }}" class="rounded-circle shadow-sm object-fit-cover" style="width: 110px; height: 110px; border: 4px solid #fff;">
                                        <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 30px; height: 30px; border: 2px solid #fff;">
                                            <i class="fas fa-check text-white" style="font-size: 10px;"></i>
                                        </div>
                                    </div>
                                    <h6 class="text-dark fw-bold text-truncate mb-1">{{ $artist->artist_name }}</h6>
                                    <small class="text-muted fw-bold uppercase" style="font-size: 10px; letter-spacing: 1px;">NGHỆ SĨ</small>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- BÀI HÁT --}}
            @if($songs->isNotEmpty())
                <div class="result-section mb-5" id="section-songs" style="order: {{ $priority == 'song' ? 2 : 5 }};">
                    <h5 class="section-header">Bài hát</h5>
                    <div>
                        @foreach($songs as $song)
                            <div class="song-bar song-card" 
                                 data-song-card 
                                 data-song-id="{{ $song->song_id }}"
                                 data-song-name="{{ $song->song_name }}"
                                 data-song-artist="{{ $song->artist_name }}"
                                 data-song-image="{{ $song->song_image }}"
                                 data-song-url="{{ $song->song_url }}"
                                 data-song-duration="{{ $song->duration }}">
                                
                                <div class="song-bar-img-wrap">
                                    <img src="{{ asset('images/'.$song->song_image) }}" onerror="this.src='{{ asset('images/default_song.png') }}'">
                                </div>

                                <div class="song-bar-info">
                                    <p class="song-bar-title">{{ $song->song_name }}</p>
                                    <p class="song-bar-artist">{{ $song->artist_name }}</p>
                                </div>

                                <div class="song-bar-stats d-none d-md-flex">
                                    <span title="Lượt nghe"><i class="fas fa-play-circle me-1"></i> {{ $song->formatted_views }}</span>
                                    <span title="Thời lượng"><i class="far fa-clock me-1"></i> {{ $song->formatted_duration }}</span>
                                </div>

                                <div class="dropdown">
                                    <button class="btn-more" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2" style="border-radius: 12px; min-width: 230px;">
                                        <li>
                                            <button class="dropdown-item rounded-3 py-2 fw-bold" type="button" 
                                            data-action="share" 
                                            data-song-id="{{ $song->song_id }}" 
                                            data-song-name="{{ e($song->song_name) }}" 
                                            data-song-artist="{{ e($song->artist_name) }}">
                                                <i class="fas fa-share me-2 text-secondary"></i> Chia sẻ
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item rounded-3 py-2 fw-bold" type="button" 
                                            onclick="handleCopyLink('{{ url('/music?song_id='.$song->song_id) }}')">
                                                <i class="fas fa-link me-2 text-primary"></i> Sao chép liên kết
                                            </button>
                                        </li>
                                        <li><hr class="dropdown-divider opacity-50"></li>
                                        
                                        @auth
                                            <li>
                                                <button class="dropdown-item rounded-3 py-2 fw-bold" type="button" 
                                                data-action="like" data-song-id="{{ $song->song_id }}">
                                                    <i class="far fa-heart me-2 text-danger"></i> Thêm vào yêu thích
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item rounded-3 py-2 fw-bold" type="button" 
                                                data-action="playlist" data-song-id="{{ $song->song_id }}">
                                                    <i class="fas fa-plus-circle me-2 text-success"></i> Thêm vào Playlist
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item rounded-3 py-2 fw-bold" type="button" 
                                                data-action="queue" data-song-id="{{ $song->song_id }}">
                                                    <i class="fas fa-list-ul me-2 text-info"></i> Thêm vào hàng đợi
                                                </button>
                                            </li>
                                        @else
                                            <li>
                                                <button class="dropdown-item rounded-3 py-2 fw-bold" type="button" onclick="showLoginModal()">
                                                    <i class="far fa-heart me-2 text-muted"></i> Thêm vào yêu thích
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item rounded-3 py-2 fw-bold" type="button" onclick="showLoginModal()">
                                                    <i class="fas fa-plus-circle me-2 text-muted"></i> Thêm vào Playlist
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item rounded-3 py-2 fw-bold" type="button" onclick="showLoginModal()">
                                                    <i class="fas fa-list-ul me-2 text-muted"></i> Thêm vào hàng đợi
                                                </button>
                                            </li>
                                        @endauth
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ALBUM --}}
            @if($albums->isNotEmpty())
                <div class="result-section mb-5" id="section-albums" style="order: {{ $priority == 'album' ? 1 : 6 }};">
                    <h5 class="section-header">Album</h5>
                    <div class="row g-4">
                        @foreach($albums as $album)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <a href="{{ route('dashboard.albums') }}?album_id={{ $album->album_id }}" class="text-decoration-none d-block custom-card p-2 bg-white" style="border-radius: 18px;">
                                    <div class="overflow-hidden mb-2 shadow-sm" style="border-radius: 14px;">
                                        <img src="{{ asset('images/'.$album->cover_image) }}" class="w-100 object-fit-cover transition" style="aspect-ratio: 1/1;">
                                    </div>
                                    <h6 class="text-dark fw-bold text-truncate mb-0 px-1">{{ $album->album_name }}</h6>
                                    <small class="text-muted px-1">{{ $album->artist_name }}</small>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Logic lọc Album/Bài hát/Nghệ sĩ
        const chips = document.querySelectorAll('.filter-chip');
        chips.forEach(chip => {
            chip.addEventListener('click', function() {
                chips.forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                const sections = document.querySelectorAll('.result-section');

                sections.forEach(sec => {
                    if (filter === 'all') {
                        sec.style.display = 'flex';
                    } else {
                        sec.style.display = (sec.id === 'section-' + filter) ? 'flex' : 'none';
                    }
                });
            });
        });

        // 2. Click vào bài hát để nghe (chỉ khi đã đăng nhập)
        const isLogged = {{ auth()->check() ? 'true' : 'false' }};
        document.querySelectorAll('.song-bar').forEach(bar => {
            bar.addEventListener('click', function(e) {
                // Nếu click vào nút menu (...) thì không phát nhạc
                if (e.target.closest('.dropdown')) return;

                if (!isLogged) {
                    showLoginModal();
                    return;
                }
                
                // Hàm playSongById đã có sẵn trong Layout JS
                if (typeof window.playSongById === 'function') {
                    window.playSongById(this.dataset.songId, true, this);
                }
            });
        });
        
        // Kích hoạt việc tự động bôi đỏ icon yêu thích nếu bài hát đã được like trước đó
        if (typeof window.refreshLikeActionButtons === 'function') {
            window.refreshLikeActionButtons();
        }
    });

    // 3. Thông báo Copy Link dùng Toast có sẵn trong Layout
    function handleCopyLink(url) {
        navigator.clipboard.writeText(url).then(() => {
            if (typeof window.showToast === 'function') {
                window.showToast('Đã sao chép liên kết bài hát', 'success');
            } else {
                alert('Đã sao chép liên kết!');
            }
        });
    }

    function showLoginModal() {
        const modalEl = document.getElementById('loginRequireModal');
        if (modalEl) {
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }
    }
</script>
@endsection