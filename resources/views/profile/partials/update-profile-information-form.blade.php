<form method="post" action="{{ route('profile.update') }}" class="mt-4">
    @csrf
    @method('patch')

    <div class="mb-3">
        <x-input-label for="name" value="Họ tên" />
        <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div class="mb-3">
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <div class="mb-3">
        <x-input-label for="username" value="Tên đăng nhập" />
        <x-text-input id="username" name="username" type="text" class="form-control" :value="old('username', $user->username)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('username')" />
    </div>

    <div class="mb-3">
        <x-input-label for="birth_day" value="Ngày sinh" />
        <x-text-input id="birth_day" name="birth_day" type="date" class="form-control" :value="old('birth_day', $user->birth_day)" />
        <x-input-error class="mt-2" :messages="$errors->get('birth_day')" />
    </div>

    <div class="mb-3">
        <x-input-label for="gender" value="Giới tính" />
        <select id="gender" name="gender" class="form-select">
            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
    </div>

    <div class="mb-3">
        <x-input-label for="full_name" value="Họ tên đầy đủ" />
        <x-text-input id="full_name" name="full_name" type="text" class="form-control" :value="old('full_name', $user->full_name)" />
        <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
    </div>

    <div class="d-flex justify-content-end">
        <x-primary-button>
            {{ __('Lưu thay đổi') }}
        </x-primary-button>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success mt-3">
            {{ __('Hồ sơ đã được cập nhật thành công.') }}
        </div>
    @endif
</form>
