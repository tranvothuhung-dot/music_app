<x-admin-layout title="Người Dùng - Admin">
    @push('styles')
        <style>
            .users-wrap {
                margin-top: 18px;
                background: #fff;
                border: 1px solid #e5e8ef;
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 10px 24px rgba(21, 32, 56, 0.08);
            }

            .users-head {
                display: flex;
                gap: 10px;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 14px;
                flex-wrap: wrap;
            }

            .users-head h1 {
                margin: 0;
                font-size: 22px;
            }

            .users-actions {
                display: flex;
                gap: 8px;
                align-items: center;
                flex-wrap: wrap;
            }

            .search-form {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            .search-form input {
                min-width: 260px;
                border-radius: 10px;
                border: 1px solid #d9deea;
                padding: 10px 12px;
                font-family: inherit;
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
                width: min(1050px, 100%);
                max-height: 90vh;
                overflow: auto;
                background: #fff;
                border-radius: 16px;
                border: 1px solid #e5e8ef;
                box-shadow: 0 20px 50px rgba(15, 22, 37, 0.22);
                padding: 18px;
            }

            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
                margin-bottom: 12px;
            }

            .modal-header h3 {
                margin: 0;
                font-size: 20px;
            }

            .form-grid input,
            .form-grid select {
                width: 100%;
                border: 1px solid #d9deea;
                border-radius: 8px;
                padding: 9px 10px;
                font-family: inherit;
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
                text-align: left;
                vertical-align: top;
            }

            th {
                background: #f7f9fc;
                font-weight: 700;
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

            .row-actions {
                display: flex;
                gap: 6px;
                align-items: center;
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
                .form-grid {
                    grid-template-columns: 1fr;
                }

                .search-form input {
                    min-width: 100%;
                }

                .users-actions {
                    width: 100%;
                }

                .users-actions .btn {
                    width: 100%;
                    text-align: center;
                }
            }
        </style>
    @endpush

    <div class="users-wrap">
        <div class="users-head">
            <h1>Quản lý người dùng</h1>
            <div class="users-actions">
                <form class="search-form" method="GET" action="{{ route('admin.users.index') }}">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Tìm theo mã người dùng, vai trò, tên đăng nhập, email, họ tên...">
                    <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                    @if($search)
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="text-decoration:none;display:inline-flex;align-items:center;">Xóa lọc</a>
                    @endif
                </form>
                <button type="button" class="btn btn-primary" id="openCreateUserModal">+ Thêm người dùng</button>
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
                    <th>Ảnh</th>
                    <th>Mã người dùng</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Họ tên</th>
                    <th>Vai trò</th>
                    <th>Ngày tạo</th>
                    <th>Cập nhật</th>
                    <th>Hành động</th>
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
                        <td>
                            @if($preview)
                                <img src="{{ $preview }}" alt="Ảnh đại diện" class="thumb">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td class="cell-text">{{ $user->user_id }}</td>
                        <td class="cell-text">{{ $user->username }}</td>
                        <td class="cell-text">{{ $user->email }}</td>
                        <td class="cell-text">{{ $user->birth_day ? date('d/m/Y', strtotime($user->birth_day)) : '-' }}</td>
                        <td class="cell-text">{{ $user->gender === 'male' ? 'Nam' : ($user->gender === 'female' ? 'Nữ' : 'Khác') }}</td>
                        <td class="cell-text">{{ $user->full_name }}</td>
                        <td class="cell-text">{{ $roleLabel }}</td>
                        <td class="cell-text">{{ $user->created_at }}</td>
                        <td class="cell-text">{{ $user->updated_at }}</td>
                        <td>
                            <div class="row-actions">
                                <button
                                    type="button"
                                    class="btn btn-primary openEditUserModal"
                                    data-user-id="{{ $user->user_id }}"
                                >
                                    Sửa
                                </button>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa người dùng này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
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
                <button type="button" class="btn btn-light" id="closeCreateUserModal">Đóng</button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}">
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
                <button type="submit" class="btn btn-primary">Lưu người dùng</button>
            </form>
        </div>
    </div>

    @foreach($users as $user)
        <div class="modal-overlay edit-user-modal" id="editUserModal{{ $user->user_id }}" aria-hidden="true">
            <div class="modal-card">
                <div class="modal-header">
                    <h3>Sửa người dùng #{{ $user->user_id }}</h3>
                    <button type="button" class="btn btn-light closeEditUserModal">Đóng</button>
                </div>
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
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
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            const createUserModal = document.getElementById('createUserModal');
            const openCreateUserModal = document.getElementById('openCreateUserModal');
            const closeCreateUserModal = document.getElementById('closeCreateUserModal');
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
