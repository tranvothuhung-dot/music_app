<div class="text-danger">
    <h5 class="mb-3">Xóa tài khoản</h5>
    <p class="text-muted mb-4">
        Khi xóa tài khoản, tất cả dữ liệu và tài nguyên của bạn sẽ bị xóa vĩnh viễn.
        Trước khi xóa tài khoản, vui lòng tải xuống bất kỳ dữ liệu nào bạn muốn giữ lại.
    </p>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        Xóa tài khoản
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deleteAccountModalLabel">Xác nhận xóa tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-body">
                    <p class="mb-3">
                        Bạn có chắc chắn muốn xóa tài khoản không? Khi xóa tài khoản,
                        tất cả dữ liệu và tài nguyên của bạn sẽ bị xóa vĩnh viễn.
                    </p>

                    <div class="mb-3">
                        <x-input-label for="password" value="Nhập mật khẩu để xác nhận" />
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control"
                            placeholder="Mật khẩu"
                            required
                        />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <x-danger-button>
                        Xóa tài khoản vĩnh viễn
                    </x-danger-button>
                </div>
            </form>
        </div>
    </div>
</div>
