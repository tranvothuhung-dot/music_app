@extends('layouts.user-music')

@section('content')
    @php
        $displayName = old('full_name', $user->full_name ?: $user->name);
        $avatarPath = !empty($user->avatar_image)
            ? asset('images/'.$user->avatar_image)
            : 'https://ui-avatars.com/api/?background=fce7f3&color=be185d&name='.urlencode($displayName ?: 'User');
    @endphp

    <style>
        .profile-shell {
            background: #f8fafc;
            border: 1px solid #e8ebf1;
            border-radius: 20px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.07);
            padding: 26px;
        }

        .profile-title {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 52px;
            padding: 10px 22px;
            border-radius: 999px;
            background: linear-gradient(135deg, #ff3f86 0%, #ff5f9a 100%);
            font-size: 1.45rem;
            font-weight: 800;
            color: #fff;
            margin: 0 auto 20px;
            box-shadow: 0 10px 24px rgba(255, 63, 134, 0.22);
        }

        .profile-avatar-wrap {
            text-align: center;
        }

        .profile-avatar {
            width: 182px;
            height: 182px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16);
        }

        .profile-upload-btn {
            margin-top: 16px;
            border-radius: 999px;
            border: 1.5px solid #ff3f86;
            background: #fff;
            color: #ff3f86;
            font-weight: 700;
            padding: 9px 18px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .profile-upload-btn:hover {
            background: #fff1f7;
        }

        .profile-form label {
            font-size: 1.05rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 6px;
        }

        .profile-form .form-control,
        .profile-form .form-select {
            height: 52px;
            border-radius: 10px;
            border: 1px solid #d6dce6;
            font-size: 1.1rem;
            box-shadow: none;
        }

        .profile-form .form-control:focus,
        .profile-form .form-select:focus {
            border-color: #ff3f86;
            box-shadow: 0 0 0 3px rgba(255, 63, 134, 0.14);
        }

        .profile-save-btn {
            border: 0;
            border-radius: 999px;
            background: linear-gradient(135deg, #ff3f86 0%, #ff5f9a 100%);
            color: #fff;
            font-weight: 800;
            font-size: 1.08rem;
            padding: 11px 30px;
            min-width: 200px;
        }

        @media (max-width: 991.98px) {
            .profile-shell {
                padding: 18px;
            }

            .profile-title {
                font-size: 1.25rem;
                min-height: 46px;
                padding: 9px 18px;
            }

            .profile-avatar {
                width: 150px;
                height: 150px;
            }
        }
    </style>

    <div class="profile-shell mb-4">
        <div class="d-flex align-items-center mb-3 gap-3 flex-wrap position-relative" style="min-height: 58px;">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3 position-absolute start-0" data-home-link>
                <i class="fas fa-arrow-left me-1"></i> Trở về
            </a>
            <h2 class="profile-title m-0 position-absolute start-50 translate-middle-x">Hồ Sơ Cá Nhân</h2>
        </div>

        <form id="profile-edit-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-form">
            @csrf
            @method('patch')

            <input type="hidden" name="name" value="{{ old('name', $user->name) }}">
            <input type="hidden" name="username" value="{{ old('username', $user->username) }}">

            <div class="row g-4 align-items-start">
                <div class="col-lg-4 col-12 profile-avatar-wrap">
                    <img src="{{ $avatarPath }}" id="profile-avatar-preview" class="profile-avatar" alt="Avatar" onerror="this.src='https://ui-avatars.com/api/?background=fce7f3&color=be185d&name=User'">

                    <label for="avatar_image" class="profile-upload-btn">
                        <i class="fas fa-camera"></i>
                        <span>Chọn ảnh</span>
                    </label>
                    <input id="avatar_image" type="file" name="avatar_image" accept="image/*" class="d-none">
                    @error('avatar_image')<div class="text-danger mt-2 small">{{ $message }}</div>@enderror
                </div>

                <div class="col-lg-8 col-12">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Họ và tên</label>
                            <input id="full_name" name="full_name" type="text" class="form-control" value="{{ old('full_name', $user->full_name) }}">
                            @error('full_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="birth_day" class="form-label">Ngày sinh</label>
                            <input id="birth_day" name="birth_day" type="date" class="form-control" value="{{ old('birth_day', $user->birth_day) }}">
                            @error('birth_day')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="gender" class="form-label">Giới tính</label>
                            <select id="gender" name="gender" class="form-select">
                                <option value="">Chọn giới tính</option>
                                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Nam</option>
                                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Nữ</option>
                                <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('gender')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Mật khẩu mới</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Để trống nếu không đổi" autocomplete="new-password">
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="profile-save-btn">Lưu thay đổi</button>
                    </div>

                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success mt-3 mb-0">Đã lưu thay đổi hồ sơ thành công.</div>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('avatar_image');
            const preview = document.getElementById('profile-avatar-preview');
            const form = document.getElementById('profile-edit-form');

            if (!input || !preview || !form) {
                return;
            }

            input.addEventListener('change', function () {
                const file = input.files && input.files[0];

                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (event) {
                    preview.src = event.target && event.target.result ? String(event.target.result) : preview.src;
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
