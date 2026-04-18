<div class="modal fade guest-login-modal" id="requireLoginModal" tabindex="-1" aria-labelledby="requireLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <div class="modal-title" id="requireLoginLabel">
                    <i class="fas fa-lock"></i>Yêu cầu quyền truy cập
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-icon">
                    <i class="fas fa-headphones"></i>
                </div>
                <h5>Bạn cần đăng nhập để sử dụng tính năng này</h5>
                <p>Vui lòng đăng nhập hoặc tạo tài khoản mới để tiếp tục.</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('login') }}" class="btn btn-pink">Đăng Nhập</a>
                <a href="{{ route('register') }}" class="btn btn-outline-pink">Đăng Ký</a>
            </div>
        </div>
    </div>
</div>