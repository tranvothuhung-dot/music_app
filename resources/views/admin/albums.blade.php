<x-admin-layout title="Albums - Admin">
	@php
		$albums = $albums ?? collect();
		$keyword = $keyword ?? '';
	@endphp

	<style>
		.album-page {
			margin-top: 26px;
		}

		.album-title {
			margin: 0 0 16px;
			color: #252b36;
			font-size: 20px;
			font-weight: 700;
			line-height: 1.1;
		}

		.album-toolbar {
			display: flex;
			gap: 16px;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 18px;
		}

		.search-form {
			flex: 1;
			display: flex;
			max-width: 1060px;
		}

		.search-input {
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

		.search-button {
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

		.add-button {
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

		.album-table-wrap {
			overflow-x: auto;
			border: 1px solid #e5e8ef;
			border-radius: 12px;
		}

		.album-table {
			width: 100%;
			border-collapse: collapse;
			min-width: 1400px;
			font-size: 13px;
		}

		.album-table thead th {
			text-align: center;
			font-weight: 700;
			background: #f7f9fc;
			padding: 10px;
			border-bottom: 1px solid #edf1f7;
			vertical-align: top;
			font-size: 13px;
			line-height: 1.3;
		}

		.album-table tbody td {
			text-align: center;
			border-bottom: 1px solid #edf1f7;
			padding: 10px;
			font-size: 13px;
			color: #212938;
			vertical-align: top;
		}

		.album-cover {
			width: 52px;
			height: 52px;
			object-fit: cover;
			border-radius: 10px;
			border: 1px solid #d9deea;
			background: #f2f4f8;
		}

		.cover-link {
			display: inline-block;
			max-width: 240px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
			color: #0d6efd;
			text-decoration: none;
		}

		.cover-link:hover {
			text-decoration: underline;
		}

		.album-name-link {
			color: #111827;
			text-decoration: none;
			font-weight: 700;
		}

		.album-name-link:hover {
			color: #111827;
			text-decoration: underline;
		}

		.status-chip {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			min-width: 34px;
			height: 24px;
			border-radius: 999px;
			background: #eaf8ef;
			color: #1f7a44;
			font-weight: 700;
			font-size: 12px;
			padding: 0 10px;
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

		.empty-row {
			text-align: center;
			padding: 28px 22px;
			color: #7b8593;
			font-size: 14px;
			font-weight: 500;
		}

		.album-modal-overlay {
			position: fixed;
			inset: 0;
			background: rgba(18, 24, 38, 0.55);
			display: none;
			align-items: center;
			justify-content: center;
			padding: 16px;
			z-index: 2000;
		}

		.album-modal-overlay.show {
			display: flex;
		}

		.album-modal {
			width: 100%;
			max-width: 460px;
			background: #fff;
			border-radius: 6px;
			overflow: hidden;
			box-shadow: 0 22px 50px rgba(15, 23, 42, 0.35);
		}

		.album-modal-head {
			height: 52px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 0 14px;
			background: #1580f5;
			color: #fff;
		}

		.album-modal-title {
			margin: 0;
			font-size: 20px;
			font-weight: 700;
		}

		.album-modal-close {
			border: 0;
			background: transparent;
			color: #7bc0ff;
			font-size: 20px;
			line-height: 1;
			cursor: pointer;
			font-weight: 700;
		}

		.album-modal-body {
			padding: 14px 16px 12px;
		}

		.album-modal-label {
			display: block;
			font-size: 14px;
			font-weight: 600;
			color: #3f4753;
			margin-bottom: 6px;
		}

		.album-modal-input,
		.album-modal-file {
			width: 100%;
			border: 1px solid #ced4da;
			border-radius: 4px;
			padding: 6px 10px;
			font-size: inherit;
			font-family: inherit;
			color: #495057;
			outline: none;
			margin-bottom: 12px;
			height: 44px;
		}

		.album-modal-file {
			padding: 8px 10px;
		}

		.album-modal-input:focus {
			border-color: #86b7fe;
			box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
		}

		.album-modal-footer {
			display: flex;
			justify-content: flex-end;
			gap: 8px;
		}

		.album-modal-btn {
			border: 0;
			border-radius: 4px;
			padding: 8px 14px;
			font-size: 14px;
			font-weight: 600;
			cursor: pointer;
			color: #fff;
		}

		.album-modal-btn.cancel {
			background: #6c757d;
		}

		.album-modal-btn.submit {
			background: #0d6efd;
		}

		@media (max-width: 768px) {
			.album-toolbar {
				flex-direction: column;
				align-items: stretch;
			}

			.search-form {
				max-width: 100%;
			}
		}
	</style>

	<section class="album-page">
		@if(session('success'))
			<div style="margin-bottom: 12px; padding: 10px 12px; border-radius: 8px; background: #e8f7ee; color: #1f7a44; font-size: 14px;">
				{{ session('success') }}
			</div>
		@endif

		@if(session('error'))
			<div style="margin-bottom: 12px; padding: 10px 12px; border-radius: 8px; background: #fdeaea; color: #b42318; font-size: 14px;">
				{{ session('error') }}
			</div>
		@endif

		@if($errors->any())
			<div style="margin-bottom: 12px; padding: 10px 12px; border-radius: 8px; background: #fdeaea; color: #b42318; font-size: 14px;">
				<strong>Có lỗi dữ liệu:</strong>
				<ul style="margin: 8px 0 0 18px;">
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<h1 class="album-title">Quản Lý Album</h1>

		<div class="album-toolbar">
			<form class="search-form" method="GET" action="{{ route('admin.albums.index') }}">
				<input class="search-input" type="text" name="q" value="{{ $keyword }}" placeholder="Tìm kiếm tên album, ID album, ID nghệ sĩ...">
				<button class="search-button" type="submit">
					<span>🔍</span>
					<span>Tìm kiếm</span>
				</button>
			</form>

			<button class="add-button" id="openAlbumModal" type="button">+ Thêm Album</button>
		</div>

		<div class="album-table-wrap">
			<table class="album-table">
				<thead>
					<tr>
						<th>ID</th>
						<th>ẢNH BÌA</th>
						<th>TÊN ALBUM</th>
						<th>ID NGHỆ SĨ</th>
						<th>NGÀY PHÁT HÀNH</th>
						<th>NGÀY KHỞI TẠO</th>
						<th>HÀNH ĐỘNG</th>
					</tr>
				</thead>
				<tbody>
					@forelse($albums as $album)
						<tr>
							<td>#{{ $album['id'] }}</td>
							<td>
								<img class="album-cover" src="{{ $album['cover_preview'] }}" alt="{{ $album['name'] }}">
							</td>
							<td>
								<a class="album-name-link" href="{{ route('admin.albums.songs', $album['id']) }}">{{ $album['name'] }}</a>
							</td>
							<td>{{ $album['artist_id'] }}</td>
							<td>{{ $album['release_date'] ?? '-' }}</td>
							<td>{{ $album['created_at'] }}</td>
							<td>
								<div class="action-buttons">
									<a
										class="action-btn edit js-open-edit-modal"
										href="#"
										title="Sửa"
										data-id="{{ $album['id'] }}"
										data-name="{{ $album['name'] }}"
										data-artist-id="{{ $album['artist_id'] }}"
										data-release-date="{{ $album['release_date'] ?? '' }}"
										data-cover-url="{{ $album['cover_url'] ?? '' }}"
										data-update-url="{{ route('admin.albums.update', $album['id']) }}"
									>
										<svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
											<path d="M12 20h9" />
											<path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
										</svg>
									</a>
									<form method="POST" action="{{ route('admin.albums.destroy', $album['id']) }}" onsubmit="return confirm('Bạn có chắc muốn xóa album này?');" style="display:inline;">
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
							<td colspan="7" class="empty-row">Không tìm thấy album phù hợp.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

	</section>

	<div class="album-modal-overlay" id="albumModalOverlay" aria-hidden="true">
		<div class="album-modal" role="dialog" aria-modal="true" aria-labelledby="albumModalTitle">
			<div class="album-modal-head">
				<h2 class="album-modal-title" id="albumModalTitle">Thêm Album</h2>
				<button class="album-modal-close" id="closeAlbumModal" type="button" aria-label="Đóng">&times;</button>
			</div>

			<form class="album-modal-body" method="POST" action="{{ route('admin.albums.store') }}" enctype="multipart/form-data">
				@csrf
				<label class="album-modal-label" for="albumName">Tên Album</label>
				<input class="album-modal-input" id="albumName" name="name" type="text" required>

				<label class="album-modal-label" for="albumArtistId">ID Nghệ Sĩ</label>
				<input class="album-modal-input" id="albumArtistId" name="artist_id" type="number" min="1" required>

				<label class="album-modal-label" for="albumReleaseDate">Ngày Phát Hành</label>
				<input class="album-modal-input" id="albumReleaseDate" name="release_date" type="date" required>

				<label class="album-modal-label" for="albumCoverUrl">URL Ảnh Bìa (nếu có)</label>
				<input class="album-modal-input" id="albumCoverUrl" name="cover_url" type="url">

				<label class="album-modal-label" for="albumImage">Ảnh Bìa</label>
				<input class="album-modal-file" id="albumImage" name="image" type="file" accept="image/*">

				<div class="album-modal-footer">
					<button class="album-modal-btn cancel" id="cancelAlbumModal" type="button">Hủy</button>
					<button class="album-modal-btn submit" type="submit">Thêm</button>
				</div>
			</form>
		</div>
	</div>

	<div class="album-modal-overlay" id="editAlbumModalOverlay" aria-hidden="true">
		<div class="album-modal" role="dialog" aria-modal="true" aria-labelledby="editAlbumModalTitle">
			<div class="album-modal-head" style="background:#fff;color:#3b3f45;border-bottom:1px solid #e5e7eb;">
				<h2 class="album-modal-title" id="editAlbumModalTitle">Sửa Album</h2>
				<button class="album-modal-close" id="closeEditAlbumModal" type="button" aria-label="Đóng" style="color:#7b8088;">&times;</button>
			</div>

			<form class="album-modal-body" id="editAlbumForm" method="POST" action="" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<label class="album-modal-label" for="editAlbumName">Tên Album</label>
				<input class="album-modal-input" id="editAlbumName" name="name" type="text" required>

				<label class="album-modal-label" for="editAlbumArtistId">ID Nghệ Sĩ</label>
				<input class="album-modal-input" id="editAlbumArtistId" name="artist_id" type="number" min="1" required>

				<label class="album-modal-label" for="editAlbumReleaseDate">Ngày Phát Hành</label>
				<input class="album-modal-input" id="editAlbumReleaseDate" name="release_date" type="date" required>

				<label class="album-modal-label" for="editAlbumCoverUrl">URL Ảnh Bìa (nếu có)</label>
				<input class="album-modal-input" id="editAlbumCoverUrl" name="cover_url" type="url">

				<label class="album-modal-label" for="editAlbumImage">Đổi Ảnh Bìa</label>
				<input class="album-modal-file" id="editAlbumImage" name="image" type="file" accept="image/*">

				<div class="album-modal-footer">
					<button class="album-modal-btn cancel" id="cancelEditAlbumModal" type="button">Hủy</button>
					<button class="album-modal-btn submit" type="submit">Lưu</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const openBtn = document.getElementById('openAlbumModal');
			const closeBtn = document.getElementById('closeAlbumModal');
			const cancelBtn = document.getElementById('cancelAlbumModal');
			const overlay = document.getElementById('albumModalOverlay');
			const openEditButtons = document.querySelectorAll('.js-open-edit-modal');
			const editOverlay = document.getElementById('editAlbumModalOverlay');
			const closeEditBtn = document.getElementById('closeEditAlbumModal');
			const cancelEditBtn = document.getElementById('cancelEditAlbumModal');
			const editNameInput = document.getElementById('editAlbumName');
			const editArtistIdInput = document.getElementById('editAlbumArtistId');
			const editReleaseDateInput = document.getElementById('editAlbumReleaseDate');
			const editCoverUrlInput = document.getElementById('editAlbumCoverUrl');
			const editAlbumForm = document.getElementById('editAlbumForm');

			if (!openBtn || !closeBtn || !cancelBtn || !overlay || !editOverlay || !closeEditBtn || !cancelEditBtn || !editNameInput || !editArtistIdInput || !editReleaseDateInput || !editCoverUrlInput || !editAlbumForm) {
				return;
			}

			const openModal = function () {
				overlay.classList.add('show');
				overlay.setAttribute('aria-hidden', 'false');
			};

			const closeModal = function () {
				overlay.classList.remove('show');
				overlay.setAttribute('aria-hidden', 'true');
			};

			const openEditModal = function () {
				editOverlay.classList.add('show');
				editOverlay.setAttribute('aria-hidden', 'false');
			};

			const closeEditModal = function () {
				editOverlay.classList.remove('show');
				editOverlay.setAttribute('aria-hidden', 'true');
			};

			openBtn.addEventListener('click', openModal);
			closeBtn.addEventListener('click', closeModal);
			cancelBtn.addEventListener('click', closeModal);
			closeEditBtn.addEventListener('click', closeEditModal);
			cancelEditBtn.addEventListener('click', closeEditModal);

			openEditButtons.forEach(function (btn) {
				btn.addEventListener('click', function (event) {
					event.preventDefault();
					editNameInput.value = btn.getAttribute('data-name') || '';
					editArtistIdInput.value = btn.getAttribute('data-artist-id') || '';
					editReleaseDateInput.value = btn.getAttribute('data-release-date') || '';
					editCoverUrlInput.value = btn.getAttribute('data-cover-url') || '';
					editAlbumForm.setAttribute('action', btn.getAttribute('data-update-url') || '');
					openEditModal();
				});
			});

			overlay.addEventListener('click', function (event) {
				if (event.target === overlay) {
					closeModal();
				}
			});

			editOverlay.addEventListener('click', function (event) {
				if (event.target === editOverlay) {
					closeEditModal();
				}
			});

			document.addEventListener('keydown', function (event) {
				if (event.key === 'Escape' && overlay.classList.contains('show')) {
					closeModal();
				}

				if (event.key === 'Escape' && editOverlay.classList.contains('show')) {
					closeEditModal();
				}
			});

		});
	</script>
</x-admin-layout>
