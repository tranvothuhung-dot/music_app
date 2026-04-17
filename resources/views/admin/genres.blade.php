<x-admin-layout title="Thể Loại - Admin">
	@php
		$genres = $genres ?? collect();
		$keyword = $keyword ?? '';
		$pagination = $pagination ?? null;
		$perPage = $perPage ?? 5;
		$covers = [
			'linear-gradient(135deg, #ffd7e5, #ffd1a8)',
			'linear-gradient(135deg, #c9f2ff, #d9d1ff)',
			'linear-gradient(135deg, #d8ffd8, #bfe9ff)',
			'linear-gradient(135deg, #ffe6b5, #ffc8d1)',
			'linear-gradient(135deg, #e1dcff, #cff7ff)',
		];
	@endphp

	<style>
		.genre-page {
			margin-top: 26px;
		}

		.genre-title {
			margin: 0 0 16px;
			color: #252b36;
			font-size: 20px;
			font-weight: 700;
			line-height: 1.1;
		}

		.genre-toolbar {
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

		.genre-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
			gap: 16px;
		}

		.genre-per-page-row {
			display: flex;
			gap: 12px;
			align-items: center;
			padding: 12px 0;
		}

		.genre-per-page-label {
			font-size: 13px;
			color: #667084;
		}

		.genre-per-page-select {
			padding: 6px 10px;
			border: 1px solid #dee2e6;
			border-radius: 4px;
			font-size: 13px;
			color: #495057;
			background: #fff;
			cursor: pointer;
			transition: all 0.2s ease;
		}

		.genre-per-page-select:hover {
			border-color: #ff5897;
		}

		.genre-per-page-select:focus {
			outline: none;
			border-color: #ff5897;
			box-shadow: 0 0 0 0.2rem rgba(255, 88, 151, 0.1);
		}

		.genre-pagination-top {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 12px 16px;
			background: #f7f9fc;
			border: 1px solid #e5e8ef;
			border-top: 0;
			border-radius: 0 0 12px 12px;
			margin-top: 12px;
			gap: 16px;
			flex-wrap: wrap;
		}

		.genre-pagination-info {
			font-size: 13px;
			color: #667084;
		}

		.genre-pagination-controls {
			display: flex;
			gap: 6px;
			align-items: center;
			flex-wrap: wrap;
		}

		.genre-pagination-controls a,
		.genre-pagination-controls span {
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

		.genre-pagination-controls a:hover {
			background: #fff5f8;
			border-color: #ff5897;
		}

		.genre-pagination-controls span.active {
			background: #ff5897;
			color: #fff;
			border-color: #ff5897;
			font-weight: 600;
		}

		.genre-pagination-controls span.disabled {
			color: #999;
			border-color: #dee2e6;
			cursor: not-allowed;
		}

		.genre-card {
			background: #fff;
			border: 1px solid #e4e8f1;
			border-radius: 14px;
			overflow: hidden;
			box-shadow: 0 8px 24px rgba(16, 24, 40, 0.08);
			transition: transform 0.2s ease, box-shadow 0.2s ease;
		}

		.genre-card:hover {
			transform: translateY(-3px);
			box-shadow: 0 14px 28px rgba(16, 24, 40, 0.12);
		}

		.genre-cover {
			height: 165px;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #24324a;
			font-size: 38px;
			border-bottom: 1px solid rgba(255, 255, 255, 0.4);
		}

		.genre-body {
			padding: 12px;
		}

		.genre-id {
			margin: 0 0 6px;
			color: #7b8593;
			font-size: 13px;
			font-weight: 700;
		}

		.genre-name {
			margin: 0;
			color: #212938;
			font-size: 18px;
			font-weight: 700;
			min-height: 52px;
		}

		.genre-name-link {
			color: #111827;
			text-decoration: none;
		}

		.genre-name-link:hover {
			color: #111827;
			text-decoration: underline;
		}

		.genre-footer {
			margin-top: 10px;
			display: flex;
			justify-content: flex-end;
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

		.empty-box {
			border: 1px dashed #d6dbe6;
			border-radius: 12px;
			padding: 28px 16px;
			text-align: center;
			color: #7b8593;
			font-size: 14px;
			background: #fff;
		}

		.genre-modal-overlay {
			position: fixed;
			inset: 0;
			background: rgba(18, 24, 38, 0.55);
			display: none;
			align-items: center;
			justify-content: center;
			padding: 16px;
			z-index: 2000;
		}

		.genre-modal-overlay.show {
			display: flex;
		}

		.genre-modal {
			width: 100%;
			max-width: 420px;
			background: #fff;
			border-radius: 6px;
			overflow: hidden;
			box-shadow: 0 22px 50px rgba(15, 23, 42, 0.35);
		}

		.genre-modal-head {
			height: 52px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 0 14px;
			background: #1580f5;
			color: #fff;
		}

		.genre-modal-title {
			margin: 0;
			font-size: 20px;
			font-weight: 700;
		}

		.genre-modal-close {
			border: 0;
			background: transparent;
			color: #7bc0ff;
			font-size: 20px;
			line-height: 1;
			cursor: pointer;
			font-weight: 700;
		}

		.genre-modal-body {
			padding: 14px 16px 12px;
		}

		.genre-modal-label {
			display: block;
			font-size: 14px;
			font-weight: 600;
			color: #3f4753;
			margin-bottom: 6px;
		}

		.genre-modal-input {
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

		.genre-modal-input:focus {
			border-color: #86b7fe;
			box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
		}

		.genre-modal-footer {
			display: flex;
			justify-content: flex-end;
			gap: 8px;
		}

		.genre-modal-btn {
			border: 0;
			border-radius: 4px;
			padding: 8px 14px;
			font-size: 14px;
			font-weight: 600;
			cursor: pointer;
			color: #fff;
		}

		.genre-modal-btn.cancel {
			background: #6c757d;
		}

		.genre-modal-btn.submit {
			background: #0d6efd;
		}

		@media (max-width: 768px) {
			.genre-toolbar {
				flex-direction: column;
				align-items: stretch;
			}

			.search-form {
				max-width: 100%;
			}
		}
	</style>

	<section class="genre-page">
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

		<h1 class="genre-title">Quản Lý Thể Loại</h1>

		<div class="genre-toolbar">
			<form class="search-form" method="GET" action="{{ route('admin.genres.index') }}">
				<input class="search-input" type="text" name="q" value="{{ $keyword }}" placeholder="Tìm kiếm tên thể loại hoặc ID...">
				<button class="search-button" type="submit">
					<span>🔍</span>
					<span>Tìm kiếm</span>
				</button>
			</form>

			<button class="add-button" id="openGenreModal" type="button">+ Thêm Thể Loại</button>
		</div>

		<div class="genre-per-page-row">
			<form method="GET" action="{{ route('admin.genres.index') }}" style="display:flex; gap:8px; align-items:center;">
				<input type="hidden" name="q" value="{{ $keyword }}">
				<label class="genre-per-page-label" for="genrePerPageSelect">Bản ghi mỗi trang:</label>
				<select class="genre-per-page-select" id="genrePerPageSelect" name="per_page" onchange="this.form.submit()">
					<option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
					<option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
					<option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
					<option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
					<option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
				</select>
			</form>
		</div>

		@if($genres->isEmpty())
			<div class="empty-box">Không tìm thấy thể loại phù hợp.</div>
		@else
			<div class="genre-grid">
				@foreach($genres as $genre)
					@php
						$cover = $covers[$genre['id'] % count($covers)];
					@endphp
					<div class="genre-card">
						<div class="genre-cover" style="background: {{ $cover }};">
							<i class="fa-solid fa-compact-disc"></i>
						</div>
						<div class="genre-body">
							<p class="genre-id">ID: #{{ $genre['id'] }}</p>
							<p class="genre-name">
								<a class="genre-name-link" href="{{ route('admin.genres.songs', $genre['id']) }}">{{ $genre['name'] }}</a>
							</p>
							<div class="genre-footer">
								<div class="action-buttons">
									<a
										class="action-btn edit js-open-edit-modal"
										href="#"
										title="Sửa"
										data-id="{{ $genre['id'] }}"
										data-name="{{ $genre['name'] }}"
										data-update-url="{{ route('admin.genres.update', $genre['id']) }}"
									>
										<svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
											<path d="M12 20h9" />
											<path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
										</svg>
									</a>
									<form method="POST" action="{{ route('admin.genres.destroy', $genre['id']) }}" onsubmit="return confirm('Bạn có chắc muốn xóa thể loại này?');" style="display:inline;">
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
							</div>
						</div>
					</div>
				@endforeach
			</div>
		@endif

		@if($pagination && $pagination->hasPages())
			<div class="genre-pagination-top">
				<div class="genre-pagination-info">
					Hiển thị {{ $pagination->firstItem() }} đến {{ $pagination->lastItem() }} trong {{ $pagination->total() }} bản ghi
				</div>
				<div class="genre-pagination-controls">
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

	<div class="genre-modal-overlay" id="genreModalOverlay" aria-hidden="true">
		<div class="genre-modal" role="dialog" aria-modal="true" aria-labelledby="genreModalTitle">
			<div class="genre-modal-head">
				<h2 class="genre-modal-title" id="genreModalTitle">Thêm Thể Loại</h2>
				<button class="genre-modal-close" id="closeGenreModal" type="button" aria-label="Đóng">&times;</button>
			</div>

			<form class="genre-modal-body" method="POST" action="{{ route('admin.genres.store') }}">
				@csrf
				<label class="genre-modal-label" for="genreName">Tên Thể Loại</label>
				<input class="genre-modal-input" id="genreName" name="name" type="text" required>

				<div class="genre-modal-footer">
					<button class="genre-modal-btn cancel" id="cancelGenreModal" type="button">Hủy</button>
					<button class="genre-modal-btn submit" type="submit">Thêm</button>
				</div>
			</form>
		</div>
	</div>

	<div class="genre-modal-overlay" id="editGenreModalOverlay" aria-hidden="true">
		<div class="genre-modal" role="dialog" aria-modal="true" aria-labelledby="editGenreModalTitle">
			<div class="genre-modal-head" style="background:#fff;color:#3b3f45;border-bottom:1px solid #e5e7eb;">
				<h2 class="genre-modal-title" id="editGenreModalTitle">Sửa Thể Loại</h2>
				<button class="genre-modal-close" id="closeEditGenreModal" type="button" aria-label="Đóng" style="color:#7b8088;">&times;</button>
			</div>

			<form class="genre-modal-body" id="editGenreForm" method="POST" action="">
				@csrf
				@method('PUT')
				<label class="genre-modal-label" for="editGenreName">Tên Thể Loại</label>
				<input class="genre-modal-input" id="editGenreName" name="name" type="text" required>

				<div class="genre-modal-footer">
					<button class="genre-modal-btn cancel" id="cancelEditGenreModal" type="button">Hủy</button>
					<button class="genre-modal-btn submit" type="submit">Lưu</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const openBtn = document.getElementById('openGenreModal');
			const closeBtn = document.getElementById('closeGenreModal');
			const cancelBtn = document.getElementById('cancelGenreModal');
			const overlay = document.getElementById('genreModalOverlay');
			const openEditButtons = document.querySelectorAll('.js-open-edit-modal');
			const editOverlay = document.getElementById('editGenreModalOverlay');
			const closeEditBtn = document.getElementById('closeEditGenreModal');
			const cancelEditBtn = document.getElementById('cancelEditGenreModal');
			const editNameInput = document.getElementById('editGenreName');
			const editGenreForm = document.getElementById('editGenreForm');

			if (!openBtn || !closeBtn || !cancelBtn || !overlay || !editOverlay || !closeEditBtn || !cancelEditBtn || !editNameInput || !editGenreForm) {
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
					editGenreForm.setAttribute('action', btn.getAttribute('data-update-url') || '');
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
