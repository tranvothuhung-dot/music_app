<form method="post" action="{{ route('password.update') }}" class="mt-4">
    @csrf
    @method('put')

    <div class="mb-3">
        <x-input-label for="update_password_current_password" value="Mật khẩu hiện tại" />
        <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
    </div>

    <div class="mb-3">
        <x-input-label for="update_password_password" value="Mật khẩu mới" />
        <x-text-input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
    </div>

    <div class="mb-3">
        <x-input-label for="update_password_password_confirmation" value="Xác nhận mật khẩu mới" />
        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="d-flex justify-content-end">
        <x-primary-button>
            {{ __('Lưu thay đổi') }}
        </x-primary-button>
    </div>

    @if (session('status') === 'password-updated')
        <div class="alert alert-success mt-3">
            {{ __('Mật khẩu đã được cập nhật thành công.') }}
        </div>
    @endif
</form>
