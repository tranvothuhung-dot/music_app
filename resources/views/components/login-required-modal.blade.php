<div class="modal fade" id="requireLoginModal" tabindex="-1" aria-labelledby="requireLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content rounded-4 border-0 shadow-lg p-3" style="background: #ffffff;">
            <div class="modal-header border-bottom-0 pb-0 pt-2">
                <h5 class="modal-title fw-bold text-danger d-flex align-items-center" id="requireLoginLabel">
                    <i class="fas fa-lock me-2"></i>Yêu cầu quyền truy cập
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-headphones fa-4x text-secondary opacity-50"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark fs-5">Bạn cần đăng nhập để sử dụng tính năng này</h5>
                <p class="text-muted small">Vui lòng đăng nhập hoặc tạo tài khoản mới để tiếp tục.</p>
            </div>
            <div class="modal-footer border-top-0 justify-content-center pb-2 pt-0 gap-3">
                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 fw-bold" style="min-width: 140px;">Đăng Nhập</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold" style="min-width: 140px;">Đăng Ký</a>
            </div>
        </div>
    </div>
</div>
