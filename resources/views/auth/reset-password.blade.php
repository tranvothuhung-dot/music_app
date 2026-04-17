<x-guest-layout>
    <div class="auth-card">
        <div class="auth-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <h2 class="auth-title">Đặt lại mật khẩu</h2>
        <p class="auth-subtitle">Vui lòng nhập mật khẩu mới cho tài khoản của bạn.</p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="{{ old('email', $request->email) }}" required autofocus readonly>
                <x-input-error :messages="$errors->get('email')" class="text-danger mt-1" />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu mới (Tối thiểu 8 ký tự)</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-control" 
                           placeholder="********" required minlength="8">
                    <i class="fas fa-eye" id="togglePass" onclick="togglePassword('password', 'togglePass')"></i>
                </div>
                <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="form-control" placeholder="********" required minlength="8">
                    <i class="fas fa-eye" id="toggleConfirm" onclick="togglePassword('password_confirmation', 'toggleConfirm')"></i>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger mt-1" />
            </div>

            <button type="submit" class="btn btn-primary-custom">
                Xác nhận đổi mật khẩu
            </button>
        </form>
    </div>
</x-guest-layout>