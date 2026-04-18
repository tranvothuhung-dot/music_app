<x-music-layout>
    <x-slot name="title">
        Music
    </x-slot>
    <div class="container py-4">
        
        <section class="mb-5">
            <div class="section-heading">
                <h2 class="title-highlight">Thịnh Hành</h2>
                <a href="{{ route('music.songs') }}">Xem tất cả</a>
            </div>
            <div class="row g-3">
                @forelse($trending as $song)
                    <div class="col-md-3">
                        <div class="card music-card h-100 shadow-sm border-0">
                            @php
                                $songImage = $song->image ?? $song->song_image ?? (isset($song->new_image) ? $song->new_image : null);
                                $songId = $song->song_id ?? $song->id ?? 0;
                            @endphp
                            
                            <div class="card-img-wrapper">
                                <img src="{{ asset($songImage ? 'storage/image/' . $songImage : 'images/s1.png') }}" class="card-img-top" alt="{{ $song->song_name }}">
                                <div class="play-overlay">
                                    @guest
                                        <button class="btn-play-circle text-decoration-none" data-bs-toggle="modal" data-bs-target="#playConfirmModal" onclick="setCurrentSong({{ $songId }}, '{{ $song->song_name }}')">
                                            <i class="fas fa-play" style="color: white !important;"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('music.song', ['id' => $songId]) }}" class="btn-play-circle text-decoration-none">
                                            <i class="fas fa-play" style="color: white !important;"></i>
                                        </a>
                                    @endguest
                                </div>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ $song->song_name }}</h5>
                                <p class="card-text text-muted mb-0">{{ $song->artist_name ?? 'Nghệ sĩ chưa rõ' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning">Không có bài hát thịnh hành để hiển thị.</div>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="mb-5">
            <div class="section-heading">
                <h2 class="title-highlight">Mới Phát Hành</h2>
                <a href="{{ route('music.songs') }}">Xem tất cả</a>
            </div>
            <div class="row g-3">
                @forelse($newReleases as $song)
                    <div class="col-md-3">
                        <div class="card music-card h-100 shadow-sm border-0">
                            @php
                                $songImage = $song->image ?? $song->song_image ?? (isset($song->new_image) ? $song->new_image : null);
                                $songId = $song->song_id ?? $song->id ?? 0;
                            @endphp
                            
                            <div class="card-img-wrapper">
                                <img src="{{ asset($songImage ? 'storage/image/' . $songImage : 'images/s2.png') }}" class="card-img-top" alt="{{ $song->song_name }}">
                                @if(!empty($song->genre_name))
                                    <span class="genre-badge">{{ $song->genre_name }}</span>
                                @endif
                                <div class="play-overlay">
                                    @guest
                                        <button class="btn-play-circle text-decoration-none" data-bs-toggle="modal" data-bs-target="#playConfirmModal" onclick="setCurrentSong({{ $songId }}, '{{ $song->song_name }}')">
                                            <i class="fas fa-play" style="color: white !important;"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('music.song', ['id' => $songId]) }}" class="btn-play-circle text-decoration-none">
                                            <i class="fas fa-play" style="color: white !important;"></i>
                                        </a>
                                    @endguest
                                </div>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ $song->song_name }}</h5>
                                <p class="card-text text-muted mb-2">{{ $song->artist_name ?? 'Nghệ sĩ chưa rõ' }}</p>
                                <div><small class="text-success"><i class="fas fa-clock me-1"></i>Mới cập nhật</small></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning">Không có bài hát mới phát hành để hiển thị.</div>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="mb-5">
            <div class="section-heading">
                <h2 class="title-highlight">Album Nổi Bật</h2>
                <a href="{{ route('music.albums') }}">Xem tất cả</a>
            </div>
            <div class="row g-3">
                @forelse($featuredAlbums as $album)
                    <div class="col-md-3">
                        <div class="card music-card h-100 shadow-sm border-0">
                            @php
                                $albumIndex = $loop->iteration <= 8 ? $loop->iteration : ($loop->iteration % 8 ?: 8);
                                $albumDefault = 'al' . $albumIndex . '.png';
                                $albumSource = $album->image ?? $album->album_image ?? (isset($album->new_image) ? $album->new_image : null);
                                $albumId = $album->album_id ?? $album->id ?? null;
                                $albumDetailUrl = $albumId ? route('music.album', $albumId) : route('music.albums');
                            @endphp
                            <div class="card-img-wrapper">
                                <img src="{{ asset($albumSource ? 'storage/image/' . $albumSource : 'images/' . $albumDefault) }}" class="card-img-top" alt="{{ $album->album_name }}">
                                <div class="play-overlay">
                                    <a href="{{ $albumDetailUrl }}" class="btn-xem-album">Xem Album</a>
                                </div>
                            </div>

                            <div class="card-body text-center">
                                <h5 class="card-title mb-1">{{ $album->album_name }}</h5>
                                <a href="{{ $albumDetailUrl }}" class="card-text text-primary text-decoration-none">{{ $album->artist_name ?? 'Nghệ sĩ chưa rõ' }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning">Không có album nổi bật để hiển thị.</div>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="mb-5">
            <div class="section-heading">
                <h2 class="title-highlight">Nghệ Sĩ Nổi Bật</h2>
                <a href="{{ route('music.artists') }}">Xem tất cả</a>
            </div>
            <div class="row">
                @forelse($featuredArtists as $artist)
                    @php
                        $artistId = $artist->artist_id ?? $artist->id ?? 0;
                        $artistIndex = $loop->iteration <= 8 ? $loop->iteration : ($loop->iteration % 8 ?: 8);
                        $artistDefault = 'a' . $artistIndex . '.png';
                        $artistSource = $artist->image ?? (isset($artist->artist_image) ? $artist->artist_image : null);
                    @endphp
                    <div class="col-md-3 mb-4">
                        <a href="{{ route('music.artist', ['id' => $artistId]) }}" class="artist-item text-center">
                            <div class="artist-avatar-box">
                                <img src="{{ asset($artistSource ? 'storage/image/' . $artistSource : 'images/' . $artistDefault) }}" alt="{{ $artist->artist_name }}">
                            </div>
                            <h5 class="card-title text-dark fw-bold mb-0">{{ $artist->artist_name }}</h5>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning">Không có nghệ sĩ nổi bật để hiển thị.</div>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="mb-5">
            <div class="section-heading">
                <h2 class="title-highlight">Tin Tức</h2>
                <a href="{{ route('music.news') }}">Xem tất cả</a>
            </div>
            <div class="row g-4">
                @forelse($news as $item)
                    <div class="col-md-6">
                        <div class="card music-card news-card-horizontal shadow-sm h-100">
                            @php
                                $newsImage = $item->image ?? (isset($item->new_image) ? $item->new_image : null);
                            @endphp
                            
                            <div class="news-img-wrapper">
                                <img src="{{ asset($newsImage ? 'storage/image/' . $newsImage : 'images/n1.jpg') }}" alt="{{ $item->title ?? 'Tin tức' }}">
                            </div>
                            
                            <div class="news-content">
                                <h5 class="card-title mb-2">{{ $item->title ?? 'Summer Music Festival 2026' }}</h5>
                                <p class="card-text text-muted small mb-3">{{ Str::limit($item->description ?? $item->excerpt ?? 'Chào mừng đến với Summer Music Festival 2026...', 60) }}</p>
                                
                                <div class="text-muted small mb-1"><i class="far fa-calendar-alt text-primary me-2"></i> {{ date('d/m/Y') }}</div>
                                <div class="text-muted small mb-2"><i class="fas fa-map-marker-alt text-danger me-2"></i> Công viên Văn hóa Lớn, TP. Hồ Chí Minh</div>
                                
                                @guest
                                    <button type="button" class="btn-news-detail restricted-action" data-bs-toggle="modal" data-bs-target="#requireLoginModal" onclick="if (!window.isAuthenticated) { bootstrap.Modal.getOrCreateInstance(document.getElementById('requireLoginModal')).show(); return false; }">Xem chi tiết</button>
                                @else
                                    <a href="#" class="btn-news-detail">Xem chi tiết</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning">Hiện chưa có tin tức âm nhạc.</div>
                    </div>
                @endforelse
            </div>
        </section>

        

    </div>
</x-music-layout>