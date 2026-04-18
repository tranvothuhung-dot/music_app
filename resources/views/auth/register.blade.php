<x-guest-layout>
    <div class="auth-card register-card">
        <div class="auth-icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <h2 class="auth-title">Đăng Ký</h2>
        <p class="auth-subtitle">Tạo tài khoản mới miễn phí</p>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <div class="mb-3">
                <label for="full_name" class="form-label">Họ và Tên</label>
                <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Nguyễn Văn A" value="{{ old('full_name') }}" required autofocus
                       oninvalid="this.setCustomValidity('Vui lòng nhập họ và tên của bạn.')"
                       oninput="this.setCustomValidity('')">
                <x-input-error :messages="$errors->get('full_name')" class="text-danger" />
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="user123" value="{{ old('username') }}" required
                           pattern="^[a-zA-Z0-9_]{3,50}$"
                           oninvalid="this.setCustomValidity('Username từ 3-50 ký tự, không dấu, không khoảng trắng (VD: user123).')"
                           oninput="this.setCustomValidity('')">
                    <x-input-error :messages="$errors->get('username')" class="text-danger" />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="example@gmail.com" value="{{ old('email') }}" required 
                           pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" 
                           oninvalid="this.setCustomValidity('Vui lòng nhập đúng định dạng email (VD: example@gmail.com)')"
                           oninput="this.setCustomValidity('')">
                    <x-input-error :messages="$errors->get('email')" class="text-danger" />
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu (Tối thiểu 8 ký tự)</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-control" placeholder="********" required minlength="8"
                           oninvalid="this.setCustomValidity('Mật khẩu của bạn quá ngắn, phải có ít nhất 8 ký tự.')"
                           oninput="this.setCustomValidity('')">
                    <i class="fas fa-eye" id="toggleRegPass" onclick="togglePassword('password', 'toggleRegPass')"></i>
                </div>
                <x-input-error :messages="$errors->get('password')" class="text-danger" />
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="********" required minlength="8"
                           oninvalid="this.setCustomValidity('Vui lòng nhập lại mật khẩu xác nhận.')"
                           oninput="this.setCustomValidity('')">
                    <i class="fas fa-eye" id="toggleConfirmPass" onclick="togglePassword('password_confirmation', 'toggleConfirmPass')"></i>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger" />
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="birth_day" class="form-label">Ngày sinh</label>
                    <input type="date" id="birth_day" name="birth_day" class="form-control" value="{{ old('birth_day') }}" required
                           oninvalid="this.setCustomValidity('Vui lòng chọn ngày sinh của bạn.')"
                           oninput="this.setCustomValidity('')">
                    <x-input-error :messages="$errors->get('birth_day')" class="text-danger" />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">Giới tính</label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="text-danger" />
                </div>
            </div>

            <button type="submit" class="btn btn-primary-custom">Đăng ký ngay</button>

            <div class="auth-links">
                Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
            </div>
            <a href="/" class="back-home"><i class="fas fa-arrow-left me-1"></i> Về trang chủ</a>
        </form>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            var pwd = document.getElementById('password').value;
            var confirmPwd = document.getElementById('password_confirmation').value;
            var confirmInput = document.getElementById('password_confirmation');
            
            if(pwd !== confirmPwd) {
                e.preventDefault(); // Dừng việc gửi form
                confirmInput.setCustomValidity('Mật khẩu xác nhận không khớp! Vui lòng nhập lại.');
                confirmInput.reportValidity(); // Hiển thị popup lỗi
            } else {
                confirmInput.setCustomValidity('');
            }
        });

        // Xóa thông báo lỗi khi người dùng sửa lại ô xác nhận
        document.getElementById('password_confirmation').addEventListener('input', function() {
            this.setCustomValidity('');
        });
    </script>
</x-guest-layout>