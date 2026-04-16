<x-admin-layout title="Bài Hát Theo Thể Loại - Admin">
	@php
		$genre = $genre ?? ['id' => 0, 'name' => ''];
		$songs = collect($songs ?? []);
	@endphp

	<style>
		.genre-songs-page {
			margin-top: 26px;
		}

		.page-head {
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 12px;
			margin-bottom: 14px;
		}

		.page-title {
			margin: 0;
			font-size: 20px;
			font-weight: 700;
			color: #1f2937;
		}

		.back-link {
			color: #111827;
			text-decoration: none;
			font-size: 13px;
			font-weight: 700;
		}

		.back-link:hover {
			text-decoration: underline;
		}

		.now-playing {
			display: none;
			align-items: center;
			gap: 14px;
			background: #fff;
			border: 1px solid #e6ebf2;
			border-radius: 12px;
			padding: 12px 14px;
			margin-bottom: 12px;
		}

		.now-playing.show {
			display: flex;
		}

		.now-cover {
			width: 52px;
			height: 52px;
			border-radius: 10px;
			object-fit: cover;
			border: 1px solid #d6dde8;
		}

		.now-main {
			flex: 1;
			min-width: 0;
		}

		.now-title {
			margin: 0 0 4px;
			font-size: 15px;
			font-weight: 700;
			color: #1f2937;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.now-artist {
			margin: 0 0 8px;
			font-size: 13px;
			font-weight: 600;
			color: #475569;
		}

		.now-audio {
			width: 100%;
			height: 34px;
		}

		.song-table-wrap {
			overflow-x: auto;
			border: 1px solid #e5e8ef;
			border-radius: 12px;
		}

		.song-table {
			width: 100%;
			border-collapse: collapse;
			min-width: 1120px;
			font-size: 13px;
		}

		.song-table th,
		.song-table td {
			text-align: center;
			padding: 10px;
			border-bottom: 1px solid #edf1f7;
		}

		.song-table th {
			background: #f7f9fc;
			font-weight: 700;
		}

		.song-table tbody tr:last-child td {
			border-bottom: 0;
		}

		.song-cover-wrap {
			position: relative;
			display: inline-block;
			width: 46px;
			height: 46px;
			border-radius: 10px;
			overflow: hidden;
			cursor: pointer;
			border: 1px solid #d8deea;
			background: #f2f4f8;
		}

		.song-cover-wrap.playing {
			box-shadow: 0 0 0 2px #1580f5;
		}

		.song-cover {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		.song-play {
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

		.song-cover-wrap:hover .song-play,
		.song-cover-wrap.playing .song-play {
			opacity: 1;
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
			cursor: pointer;
			transition: background-color 0.2s ease;
		}

		.action-btn svg {
			width: 14px;
			height: 14px;
			display: block;
		}

		.action-btn.delete {
			color: #dc3545;
		}

		.action-btn.delete:hover {
			background: #fff4f6;
			color: #bb2d3b;
		}

		.empty-box {
			border: 1px dashed #d6dbe6;
			border-radius: 12px;
			padding: 28px 16px;
			text-align: center;
			color: #7b8593;
			font-size: 14px;
			background: #fff;
		}
	</style>

	<section class="genre-songs-page">
		<div class="page-head">
			<h1 class="page-title">Thể loại: {{ $genre['name'] }}</h1>
			<a class="back-link" href="{{ route('admin.genres.index') }}">← Quay lại Genres</a>
		</div>

		@if($songs->isEmpty())
			<div class="empty-box">Thể loại này chưa có bài hát.</div>
		@else
			<div class="now-playing" id="nowPlaying" aria-live="polite">
				<img id="nowCover" class="now-cover" src="{{ asset('images/song-placeholder.svg') }}" alt="Now playing cover">
				<div class="now-main">
					<p id="nowTitle" class="now-title">Chưa chọn bài hát</p>
					<p id="nowArtist" class="now-artist">-</p>
					<audio id="nowAudio" class="now-audio" controls preload="metadata"></audio>
				</div>
			</div>

			<div class="song-table-wrap">
				<table class="song-table">
					<thead>
						<tr>
							<th>#</th>
							<th>ẢNH</th>
							<th>TÊN BÀI HÁT</th>
							<th>CA SĨ</th>
							<th>ALBUM</th>
							<th>THỜI LƯỢNG</th>
							<th>LƯỢT XEM</th>
							<th>HÀNH ĐỘNG</th>
						</tr>
					</thead>
					<tbody>
						@foreach($songs as $song)
							<tr>
								<td>#{{ $song['id'] }}</td>
								<td>
									<div class="song-cover-wrap js-song-play"
										data-audio-src="{{ $song['audio_src'] }}"
										data-title="{{ $song['title'] }}"
										data-artist="{{ $song['artist'] }}"
										data-cover="{{ $song['cover'] }}"
										title="Phát bài hát">
										<img class="song-cover" src="{{ $song['cover'] }}" alt="{{ $song['title'] }}">
										<button type="button" class="song-play" aria-label="Phát bài hát">
											<i class="fa-solid fa-play"></i>
										</button>
									</div>
								</td>
								<td>{{ $song['title'] }}</td>
								<td>{{ $song['artist'] }}</td>
								<td>{{ $song['album'] }}</td>
								<td>{{ $song['duration'] > 0 ? $song['duration'] . 's' : '-' }}</td>
								<td>{{ $song['views'] }}</td>
								<td>
									<div class="action-buttons">
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
						@endforeach
					</tbody>
				</table>
			</div>
		@endif
	</section>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const songPlayItems = document.querySelectorAll('.js-song-play');
			const nowPlaying = document.getElementById('nowPlaying');
			const nowCover = document.getElementById('nowCover');
			const nowTitle = document.getElementById('nowTitle');
			const nowArtist = document.getElementById('nowArtist');
			const nowAudio = document.getElementById('nowAudio');

			if (songPlayItems.length === 0 || !nowPlaying || !nowCover || !nowTitle || !nowArtist || !nowAudio) {
				return;
			}

			let currentPlayItem = null;

			const resetPlayingState = function () {
				if (!currentPlayItem) {
					return;
				}

				currentPlayItem.classList.remove('playing');
				const icon = currentPlayItem.querySelector('i');
				if (icon) {
					icon.classList.remove('fa-pause');
					icon.classList.add('fa-play');
				}
			};

			songPlayItems.forEach(function (item) {
				item.addEventListener('click', function () {
					const audioSrc = item.getAttribute('data-audio-src') || '';

					if (audioSrc === '') {
						return;
					}

					if (currentPlayItem === item && !nowAudio.paused) {
						nowAudio.pause();
						resetPlayingState();
						currentPlayItem = null;
						return;
					}

					resetPlayingState();
					currentPlayItem = item;
					item.classList.add('playing');

					const icon = item.querySelector('i');
					if (icon) {
						icon.classList.remove('fa-play');
						icon.classList.add('fa-pause');
					}

					nowPlaying.classList.add('show');
					nowCover.src = item.getAttribute('data-cover') || '{{ asset('images/song-placeholder.svg') }}';
					nowTitle.textContent = item.getAttribute('data-title') || 'Không rõ tiêu đề';
					nowArtist.textContent = item.getAttribute('data-artist') || '-';
					nowAudio.src = audioSrc;

					nowAudio.play().catch(function () {
						resetPlayingState();
						currentPlayItem = null;
					});
				});
			});

			nowAudio.addEventListener('pause', function () {
				if (!nowAudio.ended) {
					resetPlayingState();
					currentPlayItem = null;
				}
			});

			nowAudio.addEventListener('ended', function () {
				resetPlayingState();
				currentPlayItem = null;
			});
		});
	</script>
</x-admin-layout>
