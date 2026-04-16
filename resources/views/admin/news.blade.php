<x-admin-layout title="Tin Tức - Admin">
    @php
        $newsItems = collect($newsItems ?? []);
        $keyword = $keyword ?? '';
    @endphp

    @push('styles')
        <style>
            .news-page {
                margin-top: 18px;
            }

            .news-heading {
                margin: 0 0 16px;
                color: #252b36;
                font-size: 20px;
                font-weight: 700;
                line-height: 1.1;
            }

            .news-tools {
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
                font-family: inherit;
                box-shadow: 0 3px 10px rgba(15, 23, 42, 0.06);
            }

            .search-input::placeholder {
                color: #9aa3b2;
            }

            .search-button {
                height: 44px;
                border: 0;
                min-width: 100px;
                border-radius: 0 10px 10px 0;
                background: #2f3946;
                color: #fff;
                font-size: 13px;
                font-weight: 700;
                font-family: inherit;
                cursor: pointer;
                padding: 0 10px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
                white-space: nowrap;
            }

            .search-button span:first-child,
            .news-date i,
            .news-location i {
                margin-right: 4px;
            }

            .search-button:hover {
                background: #232833;
            }

            .add-button {
                height: 44px;
                border: 0;
                border-radius: 10px;
                background: linear-gradient(135deg, #ff5897, #ff3f85);
                color: #fff;
                font-size: 13px;
                font-weight: 700;
                padding: 0 18px;
                font-family: inherit;
                cursor: pointer;
                box-shadow: 0 8px 18px rgba(255, 70, 139, 0.24);
                min-width: 158px;
                white-space: nowrap;
            }

            .add-button:hover {
                transform: none;
            }

            .news-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                max-width: 782px;
                margin-top: 6px;
            }

            .news-card {
                background: #fff;
                border-radius: 8px;
                overflow: hidden;
                border: 1px solid #e5e8ef;
                box-shadow: none;
            }

            .news-thumb {
                position: relative;
                height: 138px;
                overflow: hidden;
            }

            .news-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            .news-date {
                position: absolute;
                top: 6px;
                left: 6px;
                background: #fff;
                color: #1f2532;
                border-radius: 6px;
                padding: 2px 5px;
                font-size: 9px;
                font-weight: 700;
                box-shadow: 0 2px 8px rgba(20, 24, 36, 0.12);
            }

            .news-body {
                padding: 8px 9px 7px;
            }

            .news-title {
                margin: 0 0 3px;
                font-size: 11px;
                line-height: 1.2;
                color: #252b36;
                font-weight: 700;
            }

            .news-location {
                margin: 0 0 4px;
                font-size: 9px;
                color: #7f8796;
                font-weight: 600;
            }

            .news-description {
                margin: 0;
                color: #667084;
                font-size: 9px;
                line-height: 1.4;
                min-height: 28px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .news-actions {
                display: flex;
                justify-content: flex-end;
                padding-top: 4px;
                margin-top: 5px;
                border-top: 1px solid #edf0f6;
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

            .delete-form {
                margin: 0;
            }

            .action-btn {
                width: 26px;
                height: 24px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-size: 9px;
                background: #fff;
                border: 0;
                transition: background-color 0.2s ease;
                cursor: pointer;
            }

            .action-btn svg {
                width: 12px;
                height: 12px;
                display: block;
            }

            .news-empty {
                max-width: 782px;
                background: #fff;
                border: 1px solid #e5e8ef;
                border-radius: 8px;
                padding: 14px;
                color: #7f8796;
                font-size: 12px;
                font-weight: 600;
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

            .news-modal-overlay {
                position: fixed;
                inset: 0;
                background: rgba(18, 24, 38, 0.55);
                display: none;
                align-items: center;
                justify-content: center;
                padding: 16px;
                z-index: 2100;
            }

            .news-modal-overlay.show {
                display: flex;
            }

            .news-modal {
                width: 100%;
                max-width: 670px;
                background: #fff;
                border-radius: 6px;
                overflow: hidden;
                box-shadow: 0 22px 50px rgba(15, 23, 42, 0.35);
            }

            .news-modal-head {
                height: 52px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 14px;
                background: #1580f5;
                color: #fff;
            }

            .news-modal-title {
                margin: 0;
                font-size: 20px;
                font-weight: 700;
                line-height: 1;
            }

            .news-modal-close {
                border: 0;
                background: transparent;
                color: #7bc0ff;
                font-size: 20px;
                line-height: 1;
                cursor: pointer;
                font-weight: 700;
                padding: 0;
            }

            .news-modal-body {
                padding: 14px 16px 12px;
            }

            .news-modal-label {
                display: block;
                font-size: 14px;
                font-weight: 600;
                color: #3f4753;
                margin-bottom: 6px;
            }

            .news-modal-input,
            .news-modal-textarea,
            .news-modal-file {
                width: 100%;
                border: 1px solid #ced4da;
                border-radius: 4px;
                padding: 6px 10px;
                font-size: 14px;
                font-family: inherit;
                color: #495057;
                outline: none;
                margin-bottom: 12px;
            }

            .news-modal-input:focus,
            .news-modal-textarea:focus {
                border-color: #86b7fe;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
            }

            .news-modal-input {
                height: 44px;
            }

            .news-modal-textarea {
                min-height: 92px;
                resize: vertical;
            }

            .news-modal-row {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .news-modal-file {
                padding: 4px;
                border: 0;
                margin-bottom: 16px;
            }

            .news-modal-footer {
                display: flex;
                justify-content: flex-end;
                gap: 8px;
            }

            .news-modal-btn {
                border: 0;
                border-radius: 4px;
                padding: 8px 14px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                color: #fff;
            }

            .news-modal-btn.cancel {
                background: #6c757d;
            }

            .news-modal-btn.submit {
                background: #0d6efd;
            }

            .news-edit-modal {
                max-width: 672px;
            }

            .news-edit-modal .news-modal-head {
                height: 54px;
                background: #fff;
                color: #3b3f45;
                border-bottom: 1px solid #e5e7eb;
            }

            .news-edit-modal .news-modal-close {
                color: #7b8088;
            }

            @media (max-width: 1200px) {
                .news-heading {
                    font-size: 20px;
                }

                .news-title {
                    font-size: 12px;
                }

                .news-location {
                    font-size: 10px;
                }

                .news-description {
                    font-size: 10px;
                }

                .search-input,
                .search-button,
                .add-button {
                    font-size: 10px;
                    height: 32px;
                }

                .search-button,
                .add-button {
                    min-width: auto;
                }
            }

            @media (max-width: 860px) {
                .news-tools {
                    flex-direction: column;
                    align-items: stretch;
                    max-width: 100%;
                }

                .search-form {
                    max-width: 100%;
                }

                .search-button {
                    min-width: 90px;
                }

                .add-button {
                    width: 100%;
                }

                .news-grid {
                    grid-template-columns: 1fr;
                    max-width: 100%;
                }

                .news-modal {
                    max-width: 96vw;
                }

                .news-modal-title {
                    font-size: 20px;
                }

                .news-modal-close {
                    font-size: 20px;
                }

                .news-modal-label,
                .news-modal-input,
                .news-modal-textarea,
                .news-modal-btn {
                    font-size: 14px;
                }

                .news-modal-row {
                    grid-template-columns: 1fr;
                    gap: 0;
                }
            }
        </style>
    @endpush

    <section class="news-page">
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
            <div style="margin-bottom: 12px; padding: 10px 12px; border-radius: 8px; background: #fff4e8; color: #b54708; font-size: 14px;">
                {{ $errors->first() }}
            </div>
        @endif

        <h1 class="news-heading">Tin Tức &amp; Sự Kiện</h1>

        <div class="news-tools">
            <form class="search-form" method="GET" action="{{ route('admin.news.index') }}">
                <input class="search-input" type="text" name="q" value="{{ $keyword }}" placeholder="Tìm kiếm tin tức, địa điểm...">
                <button class="search-button" type="submit">
                    <span>🔍</span>
                    <span>Tìm kiếm</span>
                </button>
            </form>
            <button class="add-button" id="openNewsModal" type="button">+ Thêm Tin Tức</button>
        </div>

        <div class="news-grid">
            @forelse($newsItems as $item)
                <article class="news-card">
                    <div class="news-thumb">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                        @if(!empty($item['date']))
                            <span class="news-date"><i class="fa-regular fa-calendar-days"></i> {{ $item['date'] }}</span>
                        @endif
                    </div>

                    <div class="news-body">
                        <h2 class="news-title">{{ $item['title'] }}</h2>
                        <p class="news-location"><i class="fa-solid fa-location-dot"></i> {{ $item['location'] }}</p>
                        <p class="news-description">{{ $item['description'] }}</p>

                        <div class="news-actions">
                            <div class="action-buttons">
                                <button class="action-btn edit js-open-edit-news-modal" type="button" title="Sửa" aria-label="Sửa tin tức"
                                    data-id="{{ $item['id'] }}"
                                    data-title="{{ $item['title'] }}"
                                    data-description="{{ $item['description'] }}"
                                    data-event-date="{{ $item['event_date'] ?? '' }}"
                                    data-location="{{ $item['location'] }}"
                                    data-update-url="{{ route('admin.news.update', $item['id']) }}">
                                    <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.12 2.12 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                    </svg>
                                </button>
                                <form class="delete-form" method="POST" action="{{ route('admin.news.destroy', $item['id']) }}" onsubmit="return confirm('Bạn có chắc muốn xóa tin tức này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-btn delete" type="submit" title="Xóa" aria-label="Xóa tin tức">
                                        <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                            <path d="M9 6V4h6v2" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <p class="news-empty">Không tìm thấy tin tức phù hợp với từ khóa "{{ $keyword }}".</p>
            @endforelse
        </div>
    </section>

    <div class="news-modal-overlay" id="newsModalOverlay" aria-hidden="true">
        <div class="news-modal" role="dialog" aria-modal="true" aria-labelledby="newsModalTitle">
            <div class="news-modal-head">
                <h2 class="news-modal-title" id="newsModalTitle">Thêm Tin Tức</h2>
                <button class="news-modal-close" id="closeNewsModal" type="button" aria-label="Đóng">&times;</button>
            </div>

            <form class="news-modal-body" method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <label class="news-modal-label" for="newsTitle">Tiêu đề</label>
                <input class="news-modal-input" id="newsTitle" name="title" type="text" value="{{ old('title') }}" required>

                <label class="news-modal-label" for="newsDescription">Mô tả chi tiết</label>
                <textarea class="news-modal-textarea" id="newsDescription" name="description" required>{{ old('description') }}</textarea>

                <div class="news-modal-row">
                    <div>
                        <label class="news-modal-label" for="newsDate">Ngày diễn ra</label>
                        <input class="news-modal-input" id="newsDate" name="event_date" type="date" value="{{ old('event_date') }}" required>
                    </div>

                    <div>
                        <label class="news-modal-label" for="newsLocation">Địa điểm</label>
                        <input class="news-modal-input" id="newsLocation" name="location" type="text" value="{{ old('location') }}" required>
                    </div>
                </div>

                <label class="news-modal-label" for="newsImage">Ảnh tin tức</label>
                <input class="news-modal-file" id="newsImage" name="image" type="file" accept="image/*" required>

                <div class="news-modal-footer">
                    <button class="news-modal-btn cancel" id="cancelNewsModal" type="button">Hủy</button>
                    <button class="news-modal-btn submit" type="submit">Thêm</button>
                </div>
            </form>
        </div>
    </div>

    <div class="news-modal-overlay" id="editNewsModalOverlay" aria-hidden="true">
        <div class="news-modal news-edit-modal" role="dialog" aria-modal="true" aria-labelledby="editNewsModalTitle">
            <div class="news-modal-head">
                <h2 class="news-modal-title" id="editNewsModalTitle">Sửa Tin Tức</h2>
                <button class="news-modal-close" id="closeEditNewsModal" type="button" aria-label="Đóng">&times;</button>
            </div>

            <form class="news-modal-body" id="editNewsForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="form_type" value="edit">
                <input type="hidden" id="editNewsId" name="edit_news_id" value="">
                <label class="news-modal-label" for="editNewsTitle">Tiêu đề</label>
                <input class="news-modal-input" id="editNewsTitle" name="title" type="text" required>

                <label class="news-modal-label" for="editNewsDescription">Mô tả chi tiết</label>
                <textarea class="news-modal-textarea" id="editNewsDescription" name="description" required></textarea>

                <div class="news-modal-row">
                    <div>
                        <label class="news-modal-label" for="editNewsDate">Ngày diễn ra</label>
                        <input class="news-modal-input" id="editNewsDate" name="event_date" type="date" required>
                    </div>

                    <div>
                        <label class="news-modal-label" for="editNewsLocation">Địa điểm</label>
                        <input class="news-modal-input" id="editNewsLocation" name="location" type="text" required>
                    </div>
                </div>

                <label class="news-modal-label" for="editNewsImage">Đổi ảnh</label>
                <input class="news-modal-file" id="editNewsImage" name="image" type="file" accept="image/*">

                <div class="news-modal-footer">
                    <button class="news-modal-btn cancel" id="cancelEditNewsModal" type="button">Hủy</button>
                    <button class="news-modal-btn submit" type="submit">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const openNewsModalBtn = document.getElementById('openNewsModal');
        const closeNewsModalBtn = document.getElementById('closeNewsModal');
        const cancelNewsModalBtn = document.getElementById('cancelNewsModal');
        const newsModalOverlay = document.getElementById('newsModalOverlay');
        const openEditNewsButtons = document.querySelectorAll('.js-open-edit-news-modal');
        const editNewsModalOverlay = document.getElementById('editNewsModalOverlay');
        const closeEditNewsModalBtn = document.getElementById('closeEditNewsModal');
        const cancelEditNewsModalBtn = document.getElementById('cancelEditNewsModal');
        const editNewsForm = document.getElementById('editNewsForm');
        const editNewsTitleInput = document.getElementById('editNewsTitle');
        const editNewsDescriptionInput = document.getElementById('editNewsDescription');
        const editNewsDateInput = document.getElementById('editNewsDate');
        const editNewsLocationInput = document.getElementById('editNewsLocation');
        const editNewsIdInput = document.getElementById('editNewsId');

        const openNewsModal = () => {
            newsModalOverlay.classList.add('show');
            newsModalOverlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        const closeNewsModal = () => {
            newsModalOverlay.classList.remove('show');
            newsModalOverlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        const openEditNewsModal = () => {
            editNewsModalOverlay.classList.add('show');
            editNewsModalOverlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        const closeEditNewsModal = () => {
            editNewsModalOverlay.classList.remove('show');
            editNewsModalOverlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        openNewsModalBtn.addEventListener('click', openNewsModal);
        closeNewsModalBtn.addEventListener('click', closeNewsModal);
        cancelNewsModalBtn.addEventListener('click', closeNewsModal);

        if (closeEditNewsModalBtn && cancelEditNewsModalBtn) {
            closeEditNewsModalBtn.addEventListener('click', closeEditNewsModal);
            cancelEditNewsModalBtn.addEventListener('click', closeEditNewsModal);
        }

        openEditNewsButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const title = button.getAttribute('data-title') || '';
                const description = button.getAttribute('data-description') || '';
                const eventDate = button.getAttribute('data-event-date') || '';
                const location = button.getAttribute('data-location') || '';
                const updateUrl = button.getAttribute('data-update-url') || '';
                const newsId = button.getAttribute('data-id') || '';

                editNewsTitleInput.value = title;
                editNewsDescriptionInput.value = description;
                editNewsDateInput.value = eventDate;
                editNewsLocationInput.value = location;
                editNewsIdInput.value = newsId;
                editNewsForm.setAttribute('action', updateUrl);
                openEditNewsModal();
            });
        });

        newsModalOverlay.addEventListener('click', function (event) {
            if (event.target === newsModalOverlay) {
                closeNewsModal();
            }
        });

        if (editNewsModalOverlay) {
            editNewsModalOverlay.addEventListener('click', function (event) {
                if (event.target === editNewsModalOverlay) {
                    closeEditNewsModal();
                }
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && newsModalOverlay.classList.contains('show')) {
                closeNewsModal();
            }

            if (event.key === 'Escape' && editNewsModalOverlay && editNewsModalOverlay.classList.contains('show')) {
                closeEditNewsModal();
            }
        });

        @if($errors->any() && old('form_type') === 'edit' && old('edit_news_id'))
            editNewsTitleInput.value = @json(old('title', ''));
            editNewsDescriptionInput.value = @json(old('description', ''));
            editNewsDateInput.value = @json(old('event_date', ''));
            editNewsLocationInput.value = @json(old('location', ''));
            editNewsIdInput.value = @json(old('edit_news_id', ''));
            editNewsForm.setAttribute('action', '{{ route('admin.news.update', ':id') }}'.replace(':id', @json((string) old('edit_news_id', ''))));
            openEditNewsModal();
        @elseif($errors->any())
            openNewsModal();
        @endif
    </script>
</x-admin-layout>
