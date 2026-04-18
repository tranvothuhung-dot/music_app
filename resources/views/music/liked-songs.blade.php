<x-music-layout :title="$title">
    <style>
        .library-wrapper {
            max-width: 1320px;
            margin: 0 auto;
            padding: 18px 20px 32px;
            display: grid;
            grid-template-columns: 320px 320px 1fr;
            gap: 24px;
        }

        .left-panel,
        .center-panel,
        .right-panel {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.06);
        }

        .left-panel {
            padding: 18px 16px 22px;
        }

        .center-panel {
            padding: 22px 20px;
            text-align: center;
        }

        .right-panel {
            padding: 18px 0 8px;
            overflow: hidden;
        }

        .library-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .library-title {
            font-size: 18px;
            font-weight: 800;
            color: #333;
            margin: 0;
        }

        .add-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: #f2f2f2;
            color: #555;
            font-weight: bold;
            cursor: pointer;
        }

        .liked-box,
        .playlist-toggle-box,
        .history-box {
            background: linear-gradient(135deg, #ff67a3, #ff3f87);
            border-radius: 14px;
            color: white;
            padding: 14px 16px;
            margin-bottom: 12px;
            box-shadow: 0 8px 20px rgba(255,64,129,0.18);
        }

        .liked-box-title,
        .playlist-toggle-title,
        .history-title {
            font-size: 15px;
            font-weight: 700;
            margin: 0;
        }

        .liked-box-sub {
            font-size: 13px;
            opacity: 0.95;
            margin-top: 4px;
        }

        .left-song-list {
            margin-top: 8px;
            max-height: 500px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .left-song-item {
            display: grid;
            grid-template-columns: 26px 1fr 20px;
            gap: 10px;
            align-items: start;
            padding: 10px 6px;
            border-radius: 10px;
            transition: 0.2s;
        }

        .left-song-item:hover {
            background: #fafafa;
        }

        .left-song-number {
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-top: 2px;
        }

        .left-song-name {
            font-weight: 700;
            font-size: 15px;
            color: #222;
            margin-bottom: 2px;
            line-height: 1.3;
        }

        .left-song-artist {
            font-size: 13px;
            color: #7a7a7a;
        }

        .left-song-menu {
            color: #777;
            font-size: 18px;
            line-height: 1;
            text-align: center;
            margin-top: 2px;
        }

        .clear-all {
            text-align: center;
            color: #ff4f92;
            font-size: 14px;
            margin: 10px 0 16px;
            font-weight: 600;
        }

        .playlist-list-title {
            font-size: 16px;
            font-weight: 800;
            color: #333;
            margin-top: 10px;
            margin-bottom: 12px;
        }

        .playlist-item {
            padding: 9px 0;
            border-bottom: 1px dashed #ececec;
            font-size: 14px;
            color: #555;
        }

        .liked-cover-box {
            width: 100%;
            border-radius: 18px;
            background: #fff;
            box-shadow: inset 0 0 0 1px #f2f2f2;
            padding: 26px 20px 20px;
        }

        .liked-cover-img {
            width: 210px;
            height: 210px;
            object-fit: contain;
            margin: 0 auto 16px;
            display: block;
            border-radius: 14px;
            background: #fff;
        }

        .liked-title {
            font-size: 26px;
            font-weight: 800;
            color: #222;
            margin-bottom: 6px;
        }

        .liked-subtitle {
            color: #ff4081;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 18px;
        }

        .play-all-btn {
            border: none;
            border-radius: 999px;
            background: #ff4081;
            color: white;
            font-weight: 700;
            padding: 12px 28px;
            min-width: 220px;
        }

        .play-all-btn:hover {
            background: #e73474;
        }

        .right-header {
            padding: 0 22px 14px;
            border-bottom: 1px solid #efefef;
        }

        .right-title {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #222;
            border-left: 4px solid #ff4f92;
            padding-left: 12px;
        }

        .right-song-row {
            display: grid;
            grid-template-columns: 50px 64px 1fr auto;
            gap: 14px;
            align-items: center;
            padding: 14px 22px;
            border-bottom: 1px solid #f1f1f1;
        }

        .right-song-index {
            font-size: 26px;
            font-weight: 800;
            color: #555;
            text-align: center;
        }

        .right-song-thumb {
            width: 54px;
            height: 54px;
            border-radius: 10px;
            object-fit: cover;
        }

        .right-song-name {
            font-size: 15px;
            font-weight: 800;
            color: #222;
            margin-bottom: 4px;
        }

        .right-song-artist {
            font-size: 14px;
            color: #777;
        }

        .right-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remove-btn {
            border: 1px solid #ff5b8f;
            background: #fff;
            color: #ff4f92;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 14px;
        }

        .remove-btn:hover {
            background: #fff0f5;
        }

        .dot-btn {
            border: none;
            background: transparent;
            font-size: 24px;
            color: #666;
            line-height: 1;
        }

        .alert {
            max-width: 1320px;
            margin: 12px auto 0;
        }

        .modal-content {
            border-radius: 18px;
            border: none;
        }

        .modal-header,
        .modal-footer {
            border: none;
        }

        .form-control {
            border-radius: 12px;
            min-height: 46px;
        }

        @media (max-width: 1100px) {
            .library-wrapper {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="library-wrapper">
        <div class="left-panel">
            <div class="library-header">
                <h3 class="library-title">📖 My Library</h3>
                <button class="add-btn" data-toggle="modal" data-target="#createPlaylistModal">+</button>
            </div>

            <div class="liked-box">
                <div class="liked-box-title">🤍 Liked Songs</div>
                <div class="liked-box-sub">{{ count($likedSongs) }} bài hát</div>
            </div>

            <div class="playlist-toggle-box">
                <div class="playlist-toggle-title">☰ Danh sách phát</div>
            </div>

            <div class="left-song-list">
                @forelse($likedSongs as $index => $song)
                    <div class="left-song-item">
                        <div class="left-song-number">{{ $index + 1 }}</div>
                        <div>
                            <div class="left-song-name">{{ $song->song_name }}</div>
                            <div class="left-song-artist">{{ $song->artist_name ?? 'Chưa có nghệ sĩ' }}</div>
                        </div>
                        <div class="dropdown">
    <button class="dot-btn" data-toggle="dropdown">⋮</button>
    <div class="dropdown-menu dropdown-menu-right">
        <button class="dropdown-item open-add-playlist"
                type="button"
                data-toggle="modal"
                data-target="#addToPlaylistModal"
                data-song-id="{{ $song->song_id }}">
            Add to playlist
        </button>

        <form action="{{ route('liked.songs.remove', $song->song_id) }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item text-danger">
                Remove
            </button>
        </form>
    </div>
</div>
                    </div>
                @empty
                    <div class="text-muted p-2">Chưa có bài hát yêu thích.</div>
                @endforelse
            </div>

            <div class="clear-all">Xóa hết</div>

            <div class="history-box">
                <div class="history-title">🕘 Lịch sử nghe</div>
            </div>

            <div class="playlist-list-title">Playlist của bạn</div>
            @forelse($playlists as $playlist)
                <div class="playlist-item">{{ $playlist->playlist_name }}</div>
            @empty
                <div class="text-muted">Chưa có playlist nào</div>
            @endforelse
        </div>

        <div class="center-panel">
            <div class="liked-cover-box">
                <img src="{{ asset('images/liked-song-logo.jpg') }}" alt="Liked Songs" class="liked-cover-img">
                <div class="liked-title">Liked Songs</div>
                <div class="liked-subtitle">Danh sách yêu thích</div>
                <button class="play-all-btn">▶ Phát Tất Cả</button>
            </div>
        </div>

        <div class="right-panel">
            <div class="right-header">
                <h3 class="right-title">Danh sách bài hát</h3>
            </div>

            @forelse($likedSongs as $index => $song)
                <div class="right-song-row">
                    <div class="right-song-index">{{ $index + 1 }}</div>

                    <div>
                        @if(!empty($song->song_image))
                            <img src="{{ asset('images/' . $song->song_image) }}" class="right-song-thumb" alt="{{ $song->song_name }}">
                        @else
                            <img src="{{ asset('images/default-song.png') }}" class="right-song-thumb" alt="{{ $song->song_name }}">
                        @endif
                    </div>

                    <div>
                        <div class="right-song-name">{{ $song->song_name }}</div>
                        <div class="right-song-artist">{{ $song->artist_name ?? 'Chưa có nghệ sĩ' }}</div>
                    </div>

                    <div class="right-actions">
                        <form action="{{ route('liked.songs.remove', $song->song_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>

                        <div class="dropdown">
                            <button class="dot-btn" data-toggle="dropdown">⋮</button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item open-add-playlist"
                                        type="button"
                                        data-toggle="modal"
                                        data-target="#addToPlaylistModal"
                                        data-song-id="{{ $song->song_id }}">
                                    Add to playlist
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-muted">Chưa có bài hát yêu thích nào.</div>
            @endforelse
        </div>
    </div>

    <div class="modal fade" id="createPlaylistModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('playlist.create') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tạo Playlist mới</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" name="playlist_name" class="form-control" placeholder="Nhập tên playlist...">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-pink" style="background:#ff4081;color:white;">Tạo mới</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addToPlaylistModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('playlist.add.song') }}" method="POST" class="modal-content">
                @csrf
                <input type="hidden" name="song_id" id="song_id_add_playlist">

                <div class="modal-header">
                    <h5 class="modal-title">Thêm vào Playlist</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label class="mb-2">Chọn Playlist có sẵn:</label>
                    <select name="playlist_id" class="form-control">
                        <option value="">-- Chọn playlist --</option>
                        @foreach($playlists as $playlist)
                            <option value="{{ $playlist->playlist_id }}">{{ $playlist->playlist_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background:#ff4081;color:white;width:100%;border-radius:999px;">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.open-add-playlist').on('click', function () {
                $('#song_id_add_playlist').val($(this).data('song-id'));
            });
        });
    </script>
</x-music-layout>