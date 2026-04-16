<x-admin-layout title="Nghệ Sĩ - Admin">
    @php
        $artists = $artists ?? collect();
        $keyword = $keyword ?? '';
    @endphp

    <style>
        .artist-page {
            margin-top: 26px;
        }

        .artist-title {
            margin: 0 0 16px;
            color: #252b36;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.1;
        }

        .artist-toolbar {
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

        .search-input::placeholder {
            color: #9aa3b2;
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

        .artist-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(18, 24, 38, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            z-index: 2000;
        }

        .artist-modal-overlay.show {
            display: flex;
        }

        .artist-modal {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.35);
        }

        .artist-modal-head {
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 14px;
            background: #1580f5;
            color: #fff;
        }

        .artist-modal-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }

        .artist-modal-close {
            border: 0;
            background: transparent;
            color: #7bc0ff;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            font-weight: 700;
        }

        .artist-modal-body {
            padding: 14px 16px 12px;
        }

        .artist-modal-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #3f4753;
            margin-bottom: 6px;
        }

        .artist-modal-input,
        .artist-modal-textarea,
        .artist-modal-file {
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 14px;
            color: #495057;
            outline: none;
            margin-bottom: 12px;
        }

        .artist-modal-input:focus,
        .artist-modal-textarea:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
        }

        .artist-modal-input {
            height: 44px;
        }

        .artist-modal-textarea {
            min-height: 84px;
            resize: vertical;
        }

        .artist-modal-file {
            padding: 4px;
            border: 0;
            margin-bottom: 16px;
        }

        .artist-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .artist-modal-btn {
            border: 0;
            border-radius: 4px;
            padding: 8px 14px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            color: #fff;
        }

        .artist-modal-btn.cancel {
            background: #6c757d;
        }

        .artist-modal-btn.submit {
            background: #0d6efd;
        }

        .artist-edit-modal {
            max-width: 422px;
        }

        .artist-edit-modal .artist-modal-head {
            height: 54px;
            background: #fff;
            color: #3b3f45;
            border-bottom: 1px solid #e5e7eb;
        }

        .artist-edit-modal .artist-modal-close {
            color: #7b8088;
        }

        .artist-edit-modal .artist-modal-btn.submit {
            background: #0d6efd;
        }

        .artist-table-wrap {
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 8px 26px rgba(15, 23, 42, 0.08);
        }

        .artist-table {
            width: 100%;
            border-collapse: collapse;
        }

        .artist-table thead th {
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            color: #7b8593;
            background: #fff;
            border-bottom: 2px solid #e2e8f0;
            padding: 14px 22px;
        }

        .artist-table tbody td {
            border-top: 1px solid #e8edf5;
            padding: 12px 22px;
            font-size: 14px;
            font-weight: 600;
            color: #212938;
            vertical-align: middle;
        }

        .artist-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
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

        @media (max-width: 1280px) {
            .artist-title {
                font-size: 20px;
            }

            .search-input,
            .search-button,
            .add-button {
                font-size: 14px;
                height: 40px;
            }

            .search-button,
            .add-button {
                min-width: auto;
            }

            .artist-table thead th {
                font-size: 14px;
            }

            .artist-table tbody td {
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .artist-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-form {
                max-width: 100%;
            }

            .artist-table-wrap {
                overflow-x: auto;
            }

            .artist-table {
                min-width: 760px;
            }
        }
    </style>

    <section class="artist-page">
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

        <h1 class="artist-title">Quản Lý Nghệ Sĩ</h1>

        <div class="artist-toolbar">
            <form class="search-form" method="GET" action="{{ route('admin.artists.index') }}">
                <input class="search-input" type="text" name="q" value="{{ $keyword }}" placeholder="Tìm kiếm tên/ID...">
                <button class="search-button" type="submit">
                    <span>🔍</span>
                    <span>Tìm kiếm</span>
                </button>
            </form>

            <button class="add-button" id="openArtistModal" type="button">+ Thêm Nghệ Sĩ</button>
        </div>

        <div class="artist-table-wrap">
            <table class="artist-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 16%;">AVATAR</th>
                        <th style="width: 24%;">TÊN NGHỆ SĨ</th>
                        <th style="width: 20%;">BIO</th>
                        <th style="width: 14%;">NGÀY KHỞI TẠO</th>
                        <th style="width: 16%;">HÀNH ĐỘNG</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artists as $artist)
                        <tr>
                            <td>#{{ $artist['id'] }}</td>
                            <td>
                                <img class="artist-avatar" src="{{ $artist['avatar'] }}" alt="{{ $artist['name'] }}">
                            </td>
                            <td>{{ $artist['name'] }}</td>
                            <td>{{ $artist['bio'] }}</td>
                            <td>{{ $artist['created_at'] }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a class="action-btn edit js-open-edit-modal" href="#" title="Sửa" data-id="{{ $artist['id'] }}" data-name="{{ $artist['name'] }}" data-bio="{{ $artist['bio'] }}" data-update-url="{{ route('admin.artists.update', $artist['id']) }}">
                                        <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.artists.destroy', $artist['id']) }}" onsubmit="return confirm('Bạn có chắc muốn xóa nghệ sĩ này?');" style="display:inline;">
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
                            <td colspan="6" class="empty-row">Không tìm thấy nghệ sĩ phù hợp.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="artist-modal-overlay" id="artistModalOverlay" aria-hidden="true">
        <div class="artist-modal" role="dialog" aria-modal="true" aria-labelledby="artistModalTitle">
            <div class="artist-modal-head">
                <h2 class="artist-modal-title" id="artistModalTitle">Thêm Nghệ Sĩ</h2>
                <button class="artist-modal-close" id="closeArtistModal" type="button" aria-label="Đóng">&times;</button>
            </div>

            <form class="artist-modal-body" method="POST" action="{{ route('admin.artists.store') }}" enctype="multipart/form-data">
                @csrf
                <label class="artist-modal-label" for="artistName">Tên Nghệ Sĩ</label>
                <input class="artist-modal-input" id="artistName" name="name" type="text">

                <label class="artist-modal-label" for="artistBio">Bio</label>
                <textarea class="artist-modal-textarea" id="artistBio" name="bio"></textarea>

                <label class="artist-modal-label" for="artistImage">Ảnh</label>
                <input class="artist-modal-file" id="artistImage" name="image" type="file" accept="image/*">

                <div class="artist-modal-footer">
                    <button class="artist-modal-btn cancel" id="cancelArtistModal" type="button">Hủy</button>
                    <button class="artist-modal-btn submit" type="submit">Thêm</button>
                </div>
            </form>
        </div>
    </div>

    <div class="artist-modal-overlay" id="editArtistModalOverlay" aria-hidden="true">
        <div class="artist-modal artist-edit-modal" role="dialog" aria-modal="true" aria-labelledby="editArtistModalTitle">
            <div class="artist-modal-head">
                <h2 class="artist-modal-title" id="editArtistModalTitle">Sửa Nghệ Sĩ</h2>
                <button class="artist-modal-close" id="closeEditArtistModal" type="button" aria-label="Đóng">&times;</button>
            </div>

            <form class="artist-modal-body" id="editArtistForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label class="artist-modal-label" for="editArtistName">Tên Nghệ Sĩ</label>
                <input class="artist-modal-input" id="editArtistName" name="name" type="text">

                <label class="artist-modal-label" for="editArtistBio">Bio</label>
                <textarea class="artist-modal-textarea" id="editArtistBio" name="bio"></textarea>

                <label class="artist-modal-label" for="editArtistImage">Đổi ảnh</label>
                <input class="artist-modal-file" id="editArtistImage" name="image" type="file" accept="image/*">

                <div class="artist-modal-footer">
                    <button class="artist-modal-btn cancel" id="cancelEditArtistModal" type="button">Hủy</button>
                    <button class="artist-modal-btn submit" type="submit">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openBtn = document.getElementById('openArtistModal');
            const closeBtn = document.getElementById('closeArtistModal');
            const cancelBtn = document.getElementById('cancelArtistModal');
            const overlay = document.getElementById('artistModalOverlay');
            const openEditButtons = document.querySelectorAll('.js-open-edit-modal');
            const editOverlay = document.getElementById('editArtistModalOverlay');
            const closeEditBtn = document.getElementById('closeEditArtistModal');
            const cancelEditBtn = document.getElementById('cancelEditArtistModal');
            const editNameInput = document.getElementById('editArtistName');
            const editBioInput = document.getElementById('editArtistBio');
            const editArtistForm = document.getElementById('editArtistForm');

            if (!openBtn || !closeBtn || !cancelBtn || !overlay || !editOverlay || !closeEditBtn || !cancelEditBtn || !editNameInput || !editBioInput || !editArtistForm) {
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
                    const name = btn.getAttribute('data-name') || '';
                    const bio = btn.getAttribute('data-bio') || '';
                    const updateUrl = btn.getAttribute('data-update-url') || '';
                    editNameInput.value = name;
                    editBioInput.value = bio;
                    editArtistForm.setAttribute('action', updateUrl);
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
