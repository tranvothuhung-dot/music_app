<x-admin-layout title="Admin Dashboard">
	@php
		$chartLabels = $chartLabels ?? collect();
		$listeningSeries = $listeningSeries ?? collect();
		$visitSeries = $visitSeries ?? collect();
		$topSongs = $topSongs ?? collect();
		$topArtists = $topArtists ?? collect();
		$topAlbums = $topAlbums ?? collect();

		$toImageUrl = function (?string $fileName): string {
			if (!$fileName) {
				return asset('images/admin.png');
			}

			if (str_starts_with($fileName, 'http://') || str_starts_with($fileName, 'https://')) {
				return $fileName;
			}

			return asset('images/' . $fileName);
		};
	@endphp

	@push('styles')
		<style>
			.dash-wrap {
				margin-top: 14px;
			}

			.kpi-grid {
				display: grid;
				grid-template-columns: repeat(5, minmax(0, 1fr));
				gap: 12px;
				margin-bottom: 14px;
			}

			.kpi-card {
				background: #fff;
				border: 1px solid #e8ecf3;
				border-radius: 10px;
				padding: 10px;
				text-align: center;
			}

			.kpi-title {
				margin: 0;
				color: #8791a1;
				font-size: 11px;
				font-weight: 700;
				text-transform: uppercase;
				letter-spacing: 0.4px;
			}

			.kpi-value {
				margin: 6px 0 0;
				color: #283142;
				font-size: 20px;
				font-weight: 800;
				line-height: 1;
			}

			.chart-grid {
				display: grid;
				grid-template-columns: 2fr 1fr;
				gap: 12px;
				margin-bottom: 12px;
			}

			.chart-range-form {
				display: inline-flex;
				align-items: center;
				gap: 6px;
			}

			.chart-range-select {
				height: 26px;
				border: 1px solid #d8e0ed;
				border-radius: 999px;
				padding: 0 8px;
				font-size: 11px;
				font-weight: 700;
				color: #2f3a4f;
				background: #fff;
				outline: none;
			}

			.panel {
				background: #fff;
				border: 1px solid #e8ecf3;
				border-radius: 10px;
				padding: 12px;
			}

			.panel-head {
				display: flex;
				align-items: center;
				justify-content: space-between;
				gap: 8px;
				margin-bottom: 10px;
			}

			.panel-title {
				margin: 0;
				font-size: 13px;
				font-weight: 700;
				color: #2f3a4f;
			}

			.list-grid {
				display: grid;
				grid-template-columns: repeat(3, minmax(0, 1fr));
				gap: 12px;
			}

			.top-list {
				display: flex;
				flex-direction: column;
				gap: 8px;
			}

			.top-item {
				display: flex;
				gap: 8px;
				align-items: center;
				border: 1px solid #ecf0f6;
				background: #fafbfe;
				border-radius: 8px;
				padding: 7px;
			}

			.top-compact-item {
				width: 100%;
			}

			.top-song-item {
				position: relative;
				display: flex;
				flex-direction: column;
				gap: 8px;
				cursor: pointer;
				transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
			}

			.top-song-item:hover {
				transform: translateY(-1px);
				box-shadow: 0 10px 22px rgba(15, 23, 42, 0.08);
				border-color: #dbe3ef;
			}

			.top-song-head {
				display: flex;
				gap: 8px;
				align-items: center;
				width: 100%;
			}

			.top-song-thumb-wrap {
				position: relative;
				width: 42px;
				height: 42px;
				flex-shrink: 0;
				border-radius: 8px;
				overflow: hidden;
			}

			.top-song-thumb {
				width: 42px;
				height: 42px;
				border-radius: 8px;
				object-fit: cover;
				display: block;
			}

			.top-compact-item .top-song-thumb-wrap,
			.top-compact-item .top-song-thumb {
				width: 36px;
				height: 36px;
			}

			.top-song-play-btn {
				position: absolute;
				inset: 0;
				border: 0;
				background: rgba(17, 24, 39, 0.44);
				color: #fff;
				display: flex;
				align-items: center;
				justify-content: center;
				opacity: 0;
				transition: opacity 0.18s ease, background 0.18s ease;
				cursor: pointer;
			}

			.top-song-play-btn span {
				font-size: 10px;
				font-weight: 800;
				text-transform: uppercase;
				letter-spacing: 0.3px;
			}

			.top-song-thumb-wrap:hover .top-song-play-btn,
			.top-song-item.playing .top-song-play-btn {
				opacity: 1;
			}

			.top-song-play-btn:hover {
				background: rgba(255, 77, 139, 0.84);
			}

			.top-meta {
				min-width: 0;
				flex: 1;
			}

			.top-name {
				margin: 0;
				color: #1f2938;
				font-size: 13px;
				font-weight: 700;
				line-height: 1.25;
				white-space: nowrap;
				overflow: hidden;
				text-overflow: ellipsis;
			}

			.top-sub {
				margin: 2px 0 0;
				color: #7e8898;
				font-size: 11px;
				white-space: nowrap;
				overflow: hidden;
				text-overflow: ellipsis;
			}

			.top-song-inline-player {
				display: none;
				width: 100%;
				padding-top: 2px;
			}

			.top-song-item.playing .top-song-inline-player {
				display: block;
			}

			.top-song-inline-player audio {
				width: 100%;
				height: 34px;
			}

			.top-song-item.playing {
				border-color: #ffbfd3;
				background: #fff7fb;
			}

			.badge-rank {
				width: 24px;
				height: 24px;
				border-radius: 999px;
				display: inline-flex;
				align-items: center;
				justify-content: center;
				font-size: 11px;
				font-weight: 800;
				color: #fff;
				background: #ff4d8b;
				flex-shrink: 0;
			}

			.empty {
				color: #8a94a5;
				font-size: 12px;
				padding: 4px 0;
			}

			.chart-box {
				height: 260px;
			}

			@media (max-width: 1200px) {
				.kpi-grid {
					grid-template-columns: repeat(3, minmax(0, 1fr));
				}

				.list-grid {
					grid-template-columns: 1fr;
				}
			}

			@media (max-width: 900px) {
				.chart-grid {
					grid-template-columns: 1fr;
				}

				.kpi-grid {
					grid-template-columns: repeat(2, minmax(0, 1fr));
				}
			}
		</style>
	@endpush

	<section class="dash-wrap">
		<div class="kpi-grid">
			<article class="kpi-card">
				<p class="kpi-title">Users đã đăng ký</p>
				<p class="kpi-value">{{ number_format((int) $totalUsers) }}</p>
			</article>
			<article class="kpi-card">
				<p class="kpi-title">Nghệ sĩ</p>
				<p class="kpi-value">{{ number_format((int) $totalArtists) }}</p>
			</article>
			<article class="kpi-card">
				<p class="kpi-title">Bài hát</p>
				<p class="kpi-value">{{ number_format((int) $totalSongs) }}</p>
			</article>
			<article class="kpi-card">
				<p class="kpi-title">Tổng lượt nghe</p>
				<p class="kpi-value" style="color:#0ea77d;">{{ number_format((int) $totalSongViews) }}</p>
			</article>
			<article class="kpi-card">
				<p class="kpi-title">Lượt truy cập web</p>
				<p class="kpi-value" style="color:#ff4d8b;">{{ number_format((int) $totalWebsiteVisits) }}</p>
			</article>
		</div>

		<div class="chart-grid">
			<div class="panel">
				<div class="panel-head">
					<h2 class="panel-title">Xu Hướng Lượt Nghe</h2>
					<form class="chart-range-form" method="GET" action="{{ route('admin.dashboard') }}">
						<select class="chart-range-select" name="range_days" onchange="this.form.submit()" aria-label="Khoảng thời gian biểu đồ lượt nghe">
							<option value="7" {{ (int) ($rangeDays ?? 7) === 7 ? 'selected' : '' }}>7 ngày</option>
							<option value="30" {{ (int) ($rangeDays ?? 7) === 30 ? 'selected' : '' }}>30 ngày</option>
						</select>
					</form>
				</div>
				<div class="chart-box"><canvas id="listeningTrendChart"></canvas></div>
			</div>
			<div class="panel">
				<div class="panel-head">
					<h2 class="panel-title">Lượt Truy Cập Website</h2>
					<form class="chart-range-form" method="GET" action="{{ route('admin.dashboard') }}">
						<select class="chart-range-select" name="range_days" onchange="this.form.submit()" aria-label="Khoảng thời gian biểu đồ lượt truy cập">
							<option value="7" {{ (int) ($rangeDays ?? 7) === 7 ? 'selected' : '' }}>7 ngày</option>
							<option value="30" {{ (int) ($rangeDays ?? 7) === 30 ? 'selected' : '' }}>30 ngày</option>
						</select>
					</form>
				</div>
				<div class="chart-box"><canvas id="siteVisitChart"></canvas></div>
			</div>
		</div>

		<div class="list-grid">
			<div class="panel">
				<h2 class="panel-title">Top Bài Hát</h2>
				<div class="top-list">
					@forelse($topSongs as $index => $song)
						<div class="top-item js-top-song top-song-item" data-audio-src="{{ $song->audio_src ?? '' }}" data-title="{{ e($song->song_name) }}" data-artist="{{ e($song->artist_name ?? 'N/A') }}" data-cover="{{ $toImageUrl($song->song_image ?? null) }}">
							<div class="top-song-head">
								<span class="badge-rank">{{ $index + 1 }}</span>
								<div class="top-song-thumb-wrap">
									<img class="top-song-thumb" src="{{ $toImageUrl($song->song_image ?? null) }}" alt="{{ $song->song_name }}">
									<button type="button" class="top-song-play-btn" aria-label="Phát nhạc" title="Phát nhạc">
										<span>Phát nhạc</span>
									</button>
								</div>
								<div class="top-meta">
									<p class="top-name">{{ $song->song_name }}</p>
									<p class="top-sub">{{ $song->artist_name ?? 'N/A' }} • {{ number_format((int) ($song->view_count ?? 0)) }} lượt nghe</p>
								</div>
							</div>
							<div class="top-song-inline-player">
								<audio controls preload="none"></audio>
							</div>
						</div>
					@empty
						<div class="empty">Chưa có dữ liệu bài hát.</div>
					@endforelse
				</div>
			</div>

			<div class="panel">
				<h2 class="panel-title">Top Nghệ Sĩ</h2>
				<div class="top-list">
					@forelse($topArtists as $index => $artist)
							<div class="top-item top-compact-item">
								<span class="badge-rank">{{ $index + 1 }}</span>
								<div class="top-song-head">
									<div class="top-song-thumb-wrap">
										<img class="top-song-thumb" src="{{ $toImageUrl($artist->avatar_image ?? null) }}" alt="{{ $artist->artist_name }}">
									</div>
									<div class="top-meta">
										<p class="top-name">{{ $artist->artist_name }}</p>
										<p class="top-sub">{{ number_format((int) ($artist->total_views ?? 0)) }} lượt nghe • {{ (int) ($artist->total_songs ?? 0) }} bài</p>
									</div>
								</div>
							</div>
					@empty
						<div class="empty">Chưa có dữ liệu nghệ sĩ.</div>
					@endforelse
				</div>
			</div>

			<div class="panel">
				<h2 class="panel-title">Top Album</h2>
				<div class="top-list">
					@forelse($topAlbums as $index => $album)
							<div class="top-item top-compact-item">
								<span class="badge-rank">{{ $index + 1 }}</span>
								<div class="top-song-head">
									<div class="top-song-thumb-wrap">
										<img class="top-song-thumb" src="{{ $toImageUrl($album->cover_image ?? null) }}" alt="{{ $album->album_name }}">
									</div>
									<div class="top-meta">
										<p class="top-name">{{ $album->album_name }}</p>
										<p class="top-sub">{{ number_format((int) ($album->total_views ?? 0)) }} lượt nghe • {{ (int) ($album->total_songs ?? 0) }} bài</p>
									</div>
								</div>
							</div>
					@empty
						<div class="empty">Chưa có dữ liệu album.</div>
					@endforelse
				</div>
			</div>
		</div>
	</section>

	@push('scripts')
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script>
			const labels = @json($chartLabels->values());
			const listeningData = @json($listeningSeries->values());
			const visitData = @json($visitSeries->values());
			const topSongItems = document.querySelectorAll('.js-top-song');
			let activeTopSongItem = null;
			let activeTopSongAudio = null;

			const clearTopSongState = function () {
				if (activeTopSongItem) {
					activeTopSongItem.classList.remove('playing');
				}

				if (activeTopSongAudio) {
					activeTopSongAudio.pause();
				}

				activeTopSongItem = null;
				activeTopSongAudio = null;
			};

			topSongItems.forEach(function (item) {
				const playButton = item.querySelector('.top-song-play-btn');
				const audio = item.querySelector('audio');

				if (!playButton || !audio) {
					return;
				}

				const togglePlay = function (event) {
					event.preventDefault();
					event.stopPropagation();

					const audioSrc = String(item.dataset.audioSrc || '').trim();
					if (!audioSrc) {
						return;
					}

					if (activeTopSongItem && activeTopSongItem !== item) {
						clearTopSongState();
					}

					if (activeTopSongItem === item && !audio.paused) {
						audio.pause();
						clearTopSongState();
						return;
					}

					if (audio.src !== audioSrc) {
						audio.src = audioSrc;
					}

					item.classList.add('playing');
					activeTopSongItem = item;
					activeTopSongAudio = audio;

					audio.play().catch(function () {
						clearTopSongState();
					});
				};

				playButton.addEventListener('click', togglePlay);
				item.addEventListener('click', function (event) {
					if (event.target.closest('audio')) {
						return;
					}
					togglePlay(event);
				});

				audio.addEventListener('ended', clearTopSongState);
				audio.addEventListener('pause', function () {
					if (!audio.ended && activeTopSongItem === item) {
						item.classList.remove('playing');
					}
				});
			});

			const listeningCtx = document.getElementById('listeningTrendChart');
			if (listeningCtx) {
				new Chart(listeningCtx, {
					type: 'line',
					data: {
						labels: labels,
						datasets: [{
							label: 'Lượt nghe',
							data: listeningData,
							borderColor: '#ff4d8b',
							backgroundColor: 'rgba(255, 77, 139, 0.12)',
							tension: 0.35,
							fill: true,
							pointRadius: 3,
							pointHoverRadius: 4,
						}]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,
						plugins: {
							legend: { display: false }
						},
						scales: {
							y: {
								beginAtZero: true,
								ticks: { precision: 0 }
							}
						}
					}
				});
			}

			const visitCtx = document.getElementById('siteVisitChart');
			if (visitCtx) {
				new Chart(visitCtx, {
					type: 'bar',
					data: {
						labels: labels,
						datasets: [{
							label: 'Lượt truy cập',
							data: visitData,
							borderRadius: 6,
							backgroundColor: 'rgba(14, 167, 125, 0.55)',
							borderColor: '#0ea77d',
							borderWidth: 1,
						}]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,
						plugins: {
							legend: { display: false }
						},
						scales: {
							y: {
								beginAtZero: true,
								ticks: { precision: 0 }
							}
						}
					}
				});
			}
		</script>
	@endpush
</x-admin-layout>
