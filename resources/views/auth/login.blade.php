<x-guest-layout>
    <div class="auth-card">
        <div class="auth-icon">
            <i class="fas fa-user"></i>
        </div>
        <h2 class="auth-title">Đăng Nhập</h2>
        <p class="auth-subtitle">Vui lòng nhập thông tin để tiếp tục</p>

        <x-auth-session-status class="mb-4 text-success text-center" style="font-size: 13px;" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="login" class="form-label">Tên đăng nhập</label>
                <input type="text" id="login" name="login" class="form-control" placeholder="Nhập username" value="{{ old('login') }}" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('login')" class="text-danger" />
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-control" placeholder="........" required autocomplete="current-password">
                    <i class="fas fa-eye" id="toggleLoginPass" onclick="togglePassword('password', 'toggleLoginPass')"></i>
                </div>
                <x-input-error :messages="$errors->get('password')" class="text-danger" />
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-pass-link">Quên mật khẩu?</a>
            @endif

            <button type="submit" class="btn btn-primary-custom">Đăng nhập</button>

            <div class="auth-links">
                Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
            </div>

            <a href="/" class="back-home"><i class="fas fa-arrow-left me-1"></i> Về trang chủ</a>
        </form>
    </div>
</x-guest-layout>