<x-admin-layout title="Người Dùng - Admin">
    @push('styles')
        <style>
            .users-wrap {
                margin-top: 26px;
            }

            .users-title {
                margin: 0 0 16px;
                color: #252b36;
                font-size: 20px;
                font-weight: 700;
                line-height: 1.1;
            }

            .users-head {
                display: flex;
                gap: 16px;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 18px;
            }

            .users-actions {
                display: flex;
                gap: 16px;
                align-items: center;
                flex: 1;
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
                min-width: 168px;
                white-space: nowrap;
            }

            .btn {
                border: 0;
                border-radius: 10px;
                padding: 10px 14px;
                cursor: pointer;
                color: #fff;
                font-weight: 600;
                font-family: inherit;
            }

            .btn-primary {
                background: linear-gradient(135deg, #ff5b96, #ff3f83);
            }

            .btn-secondary {
                background: #7f8796;
            }

            .btn-danger {
                background: #d04747;
            }

            .btn-light {
                background: #e7ebf4;
                color: #2e3440;
            }

            .form-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 16px;
            }

            .modal-overlay {
                position: fixed;
                inset: 0;
                background: rgba(18, 24, 39, 0.55);
                z-index: 1200;
                display: none;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .modal-overlay.show {
                display: flex;
            }

            .modal-card {
                width: 100%;
                max-width: 980px;
                max-height: 90vh;
                overflow: auto;
                background: #fff;
                border-radius: 6px;
                box-shadow: 0 22px 50px rgba(15, 23, 42, 0.35);
            }

            .modal-header {
                height: 52px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0 14px;
                background: #1580f5;
                color: #fff;
            }

            .modal-header h3 {
                margin: 0;
                font-size: 20px;
                font-weight: 700;
            }

            .modal-close-btn {
                border: 0;
                background: transparent;
                color: #7bc0ff;
                font-size: 20px;
                line-height: 1;
                cursor: pointer;
                font-weight: 700;
            }

            .edit-modal-card .modal-header {
                height: 54px;
                background: #fff;
                color: #3b3f45;
                border-bottom: 1px solid #e5e7eb;
            }

            .edit-modal-card .modal-close-btn {
                color: #7b8088;
            }

            .modal-body {
                padding: 14px 16px 12px;
            }

            .modal-body .form-grid {
                margin-bottom: 12px;
            }

            .form-grid input,
            .form-grid select {
                width: 100%;
                border: 1px solid #ced4da;
                border-radius: 4px;
                padding: 6px 10px;
                height: 44px;
                font-family: inherit;
                color: #495057;
                outline: none;
            }

            .form-grid input:focus,
            .form-grid select:focus {
                border-color: #86b7fe;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
            }

            .modal-footer {
                display: flex;
                justify-content: flex-end;
                gap: 8px;
            }

            .modal-action-btn {
                border: 0;
                border-radius: 4px;
                padding: 8px 14px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                color: #fff;
            }

            .modal-action-btn.cancel {
                background: #6c757d;
            }

            .modal-action-btn.submit {
                background: #0d6efd;
            }

            .table-wrap {
                overflow-x: auto;
                border: 1px solid #e5e8ef;
                border-radius: 12px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                min-width: 1250px;
                font-size: 13px;
            }

            th,
            td {
                padding: 10px;
                border-bottom: 1px solid #edf1f7;
                vertical-align: top;
            }

            th {
                text-align: center;
            }

            td {
                text-align: center;
            }

            th {
                background: #f7f9fc;
                font-weight: 700;
                font-size: 13px;
                line-height: 1.3;
            }

            .table-wrap thead th {
                font-size: 13px;
            }

            .thumb {
                width: 46px;
                height: 46px;
                border-radius: 10px;
                object-fit: cover;
                border: 1px solid #d8deea;
                background: #f2f4f8;
            }

            .msg {
                padding: 10px 12px;
                border-radius: 10px;
                margin-bottom: 12px;
                font-size: 14px;
            }

            .msg-success {
                background: #eaf8ef;
                color: #1b7c3a;
                border: 1px solid #ccefd8;
            }

            .msg-error {
                background: #fff1f1;
                color: #b33636;
                border: 1px solid #ffd3d3;
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

            .pagination-wrap {
                margin-top: 14px;
            }

            .text-muted {
                color: #7f8796;
            }

            .cell-text {
                white-space: nowrap;
            }

            @media (max-width: 1200px) {
                .form-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 640px) {
                .users-head {
                    flex-direction: column;
                    align-items: stretch;
                }

                .form-grid {
                    grid-template-columns: 1fr;
                }

                .users-actions {
                    width: 100%;
                    flex-direction: column;
                    align-items: stretch;
                }

                .search-form {
                    max-width: 100%;
                }

                .search-input,
                .search-button,
                .add-button {
                    width: 100%;
                }

                .search-input {
                    border-radius: 10px;
                    margin-bottom: 8px;
                }

                .search-button {
                    border-radius: 10px;
                    margin-bottom: 8px;
                }

                .users-actions .btn,
                .users-actions .add-button {
                    width: 100%;
                    text-align: center;
                }
            }
        </style>
    @endpush

    <div class="users-wrap">
        <h1 class="users-title">Quản Lý Người Dùng</h1>

        <div class="users-head">
            <div class="users-actions">
                <form class="search-form" method="GET" action="{{ route('admin.users.index') }}">
                    <input class="search-input" type="text" name="search" value="{{ $search }}" placeholder="Tìm kiếm tên/ID...">
                    <button type="submit" class="search-button">
                        <span>🔍</span>
                        <span>Tìm kiếm</span>
                    </button>
                </form>
                <button type="button" class="add-button" id="openCreateUserModal">+ Thêm Người Dùng</button>
            </div>
        </div>

        @if(session('success'))
            <div class="msg msg-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="msg msg-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="msg msg-error">
                <strong>Có lỗi dữ liệu:</strong>
                <ul style="margin: 6px 0 0 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ẢNH</th>
                    <th>TÊN ĐĂNG NHẬP</th>
                    <th>EMAIL</th>
                    <th>NGÀY SINH</th>
                    <th>GIỚI TÍNH</th>
                    <th>HỌ TÊN</th>
                    <th>VAI TRÒ</th>
                    <th>NGÀY TẠO</th>
                    <th>CẬP NHẬT</th>
                    <th>HÀNH ĐỘNG</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    @php
                        $preview = $user->avatar_url;
                        if (!$preview && $user->avatar_image) {
                            $preview = asset('images/' . $user->avatar_image);
                        }
                        $roleLabel = (int) $user->role_id === 1 ? 'Admin' : 'User';
                    @endphp
                    <tr>
                        <td class="cell-text">#{{ $user->user_id }}</td>
                        <td>
                            @if($preview)
                                <img src="{{ $preview }}" alt="Ảnh đại diện" class="thumb">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td class="cell-text">{{ $user->username }}</td>
                        <td class="cell-text">{{ $user->email }}</td>
                        <td class="cell-text">{{ $user->birth_day ? date('d/m/Y', strtotime($user->birth_day)) : '-' }}</td>
                        <td class="cell-text">{{ $user->gender === 'male' ? 'Nam' : ($user->gender === 'female' ? 'Nữ' : 'Khác') }}</td>
                        <td class="cell-text">{{ $user->full_name }}</td>
                        <td class="cell-text">{{ $roleLabel }}</td>
                        <td class="cell-text">{{ $user->created_at }}</td>
                        <td class="cell-text">{{ $user->updated_at }}</td>
                        <td>
                            <div class="action-buttons">
                                <button
                                    type="button"
                                    class="action-btn edit openEditUserModal"
                                    data-user-id="{{ $user->user_id }}"
                                    title="Sửa"
                                >
                                    <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                    </svg>
                                </button>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa người dùng này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Xóa">
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
                        <td colspan="11" class="text-muted">Không tìm thấy người dùng nào.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $users->links() }}
        </div>
    </div>

    <div class="modal-overlay" id="createUserModal" aria-hidden="true">
        <div class="modal-card">
            <div class="modal-header">
                <h3>Thêm người dùng mới</h3>
                <button type="button" class="modal-close-btn" id="closeCreateUserModal" aria-label="Đóng">&times;</button>
            </div>
            <form class="modal-body" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <div class="form-grid">
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Tên đăng nhập" required>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                    <input type="date" name="birth_day" value="{{ old('birth_day') }}">
                    <select name="gender" required>
                        <option value="">Chọn giới tính</option>
                        <option value="male" @selected(old('gender') === 'male')>Nam</option>
                        <option value="female" @selected(old('gender') === 'female')>Nữ</option>
                        <option value="other" @selected(old('gender') === 'other')>Khác</option>
                    </select>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Họ và tên" required>
                    <select name="role_id" required>
                        <option value="2" @selected(old('role_id', '2') == '2')>User (2)</option>
                        <option value="1" @selected(old('role_id') == '1')>Admin (1)</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-action-btn cancel" id="cancelCreateUserModal">Hủy</button>
                    <button type="submit" class="modal-action-btn submit">Lưu người dùng</button>
                </div>
            </form>
        </div>
    </div>

    @foreach($users as $user)
        <div class="modal-overlay edit-user-modal" id="editUserModal{{ $user->user_id }}" aria-hidden="true">
            <div class="modal-card edit-modal-card">
                <div class="modal-header">
                    <h3>Sửa người dùng #{{ $user->user_id }}</h3>
                    <button type="button" class="modal-close-btn closeEditUserModal" aria-label="Đóng">&times;</button>
                </div>
                <form class="modal-body" method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="hidden" name="form_type" value="edit">
                    <input type="hidden" name="edit_user_id" value="{{ $user->user_id }}">
                    <div class="form-grid">
                        <input type="text" name="username" value="{{ old('edit_user_id') == $user->user_id ? old('username') : $user->username }}" placeholder="Tên đăng nhập" required>
                        <input type="email" name="email" value="{{ old('edit_user_id') == $user->user_id ? old('email') : $user->email }}" placeholder="Email" required>
                        <input type="date" name="birth_day" value="{{ old('edit_user_id') == $user->user_id ? old('birth_day') : ($user->birth_day ? date('Y-m-d', strtotime($user->birth_day)) : '') }}">
                        <select name="gender" required>
                            <option value="male" @selected((old('edit_user_id') == $user->user_id ? old('gender') : $user->gender) === 'male')>Nam</option>
                            <option value="female" @selected((old('edit_user_id') == $user->user_id ? old('gender') : $user->gender) === 'female')>Nữ</option>
                            <option value="other" @selected((old('edit_user_id') == $user->user_id ? old('gender') : $user->gender) === 'other')>Khác</option>
                        </select>
                        <input type="text" name="full_name" value="{{ old('edit_user_id') == $user->user_id ? old('full_name') : $user->full_name }}" placeholder="Họ và tên" required>
                        <select name="role_id" required>
                            <option value="2" @selected((int) (old('edit_user_id') == $user->user_id ? old('role_id', $user->role_id) : $user->role_id) === 2)>User (2)</option>
                            <option value="1" @selected((int) (old('edit_user_id') == $user->user_id ? old('role_id', $user->role_id) : $user->role_id) === 1)>Admin (1)</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-action-btn cancel closeEditUserModal">Hủy</button>
                        <button type="submit" class="modal-action-btn submit">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            const createUserModal = document.getElementById('createUserModal');
            const openCreateUserModal = document.getElementById('openCreateUserModal');
            const closeCreateUserModal = document.getElementById('closeCreateUserModal');
            const cancelCreateUserModal = document.getElementById('cancelCreateUserModal');
            const editUserModalButtons = document.querySelectorAll('.openEditUserModal');
            const closeEditUserModalButtons = document.querySelectorAll('.closeEditUserModal');
            const editUserModals = document.querySelectorAll('.edit-user-modal');

            const showModal = (modal) => {
                if (!modal) {
                    return;
                }

                modal.classList.add('show');
                modal.setAttribute('aria-hidden', 'false');
            };

            const hideModal = (modal) => {
                if (!modal) {
                    return;
                }

                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
            };

            openCreateUserModal.addEventListener('click', function () {
                showModal(createUserModal);
            });

            closeCreateUserModal.addEventListener('click', function () {
                hideModal(createUserModal);
            });

            cancelCreateUserModal.addEventListener('click', function () {
                hideModal(createUserModal);
            });

            createUserModal.addEventListener('click', function (event) {
                if (event.target === createUserModal) {
                    hideModal(createUserModal);
                }
            });

            editUserModalButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const userId = button.getAttribute('data-user-id');
                    const modal = document.getElementById(`editUserModal${userId}`);
                    showModal(modal);
                });
            });

            closeEditUserModalButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const modal = button.closest('.modal-overlay');
                    hideModal(modal);
                });
            });

            editUserModals.forEach(function (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        hideModal(modal);
                    }
                });
            });

            @if($errors->any() && old('form_type') === 'create')
                showModal(createUserModal);
            @endif

            @if($errors->any() && old('form_type') === 'edit' && old('edit_user_id'))
                showModal(document.getElementById('editUserModal{{ old('edit_user_id') }}'));
            @endif
        </script>
    @endpush
</x-admin-layout>
