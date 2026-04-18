<x-guest-layout>
    <div class="auth-card">
        <div class="auth-icon">
            <i class="fas fa-key"></i>
        </div>
        
        <h2 class="auth-title">Quên mật khẩu?</h2>
        
        <x-auth-session-status class="mb-4 text-success text-center fw-bold" style="font-size: 13px;" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    placeholder="example@gmail.com" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                >
                <x-input-error :messages="$errors->get('email')" class="text-danger mt-1" />
            </div>

            <button type="submit" class="btn btn-primary-custom">
                Đặt lại mật khẩu
            </button>

            <div class="auth-links">
                <a href="{{ route('login') }}">Quay lại Đăng nhập</a>
            </div>

            <a href="/" class="back-home">
                <i class="fas fa-arrow-left me-1"></i> Về trang chủ
            </a>
        </form>
    </div>
</x-guest-layout>