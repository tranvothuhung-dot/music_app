# Hệ thống Đăng nhập Yêu cầu - Guest User Integration

## Tổng quan
Hệ thống cho phép người dùng chưa đăng nhập (guest) xem nội dung, nhưng các tính năng nhất định sẽ yêu cầu đăng nhập.

## Các thành phần chính

### 1. Modal Yêu cầu Đăng nhập
**Vị trí:** `resources/views/components/login-required-modal.blade.php`

Modal này được sử dụng khi guest user cố gắng sử dụng tính năng giới hạn.

**Cách sử dụng:**
```blade
<!-- Trigger modal -->
<button data-bs-toggle="modal" data-bs-target="#requireLoginModal">
    Yêu cầu tính năng
</button>
```

### 2. Kiểm tra Xác thực
Sử dụng các directive Laravel blade:

```blade
@auth
    <!-- Hiển thị cho user đã đăng nhập -->
    <button>Nghe ngay</button>
@else
    <!-- Hiển thị cho guest user -->
    <button data-bs-toggle="modal" data-bs-target="#requireLoginModal">
        Đăng nhập để nghe
    </button>
@endauth
```

### 3. Restricted Actions (Tính năng Giới hạn)
Các nút có class `.restricted-action` sẽ tự động yêu cầu đăng nhập:

```blade
<button class="restricted-action" data-bs-toggle="modal" data-bs-target="#requireLoginModal">
    Thêm vào Liked Songs
</button>
```

## Các trang hiện đã hỗ trợ

### ✅ Trang Chi tiết Bài hát
**File:** `resources/views/music/song-detail.blade.php`
- ✓ Hiển thị nút Phát nhạc cho auth
- ✓ Hiển thị nút Đăng nhập cho guest

### ✅ Danh sách Bài hát
**File:** `resources/views/music/songs.blade.php`
- ✓ Nút "Nghe ngay" cho auth
- ✓ Nút "Đăng nhập để nghe" cho guest

### ✅ Thể loại
**File:** `resources/views/music/genres.blade.php`
- ✓ Hiển thị tất cả thể loại cho guest

## Cách Thêm Auth Check vào View Mới

### Bước 1: Thêm Directive @auth/@else/@endauth
```blade
@auth
    <!-- Nội dung cho user đã đăng nhập -->
@else
    <!-- Nội dung cho guest user -->
    <button data-bs-toggle="modal" data-bs-target="#requireLoginModal">
        Cần đăng nhập
    </button>
@endauth
```

### Bước 2: Sử dụng .restricted-action Class
```blade
<button class="restricted-action" data-bs-toggle="modal" data-bs-target="#requireLoginModal">
    Tính năng giới hạn
</button>
```

## JavaScript Helpers (trong music-layout.blade.php)

```javascript
// Kiểm tra trạng thái xác thực
if (!window.isAuthenticated) {
    var modal = new bootstrap.Modal(document.getElementById('requireLoginModal'));
    modal.show();
}
```

## Ví dụ Thực tế

### Thêm vào Liked Songs
```blade
@auth
    <button class="btn btn-link" onclick="addToLiked({{ $song->id }})">
        <i class="far fa-heart"></i> Thích
    </button>
@else
    <button class="btn btn-link restricted-action" data-bs-toggle="modal" data-bs-target="#requireLoginModal">
        <i class="far fa-heart"></i> Thích
    </button>
@endauth
```

### Thêm vào Playlist
```blade
@auth
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#playlistModal">
        Thêm vào Playlist
    </button>
@else
    <button class="btn btn-sm btn-primary restricted-action" data-bs-toggle="modal" data-bs-target="#requireLoginModal">
        Thêm vào Playlist
    </button>
@endauth
```

## Controller (MusicController2.php)

✅ **Tất cả methods đều cho phép guest access:**
- `index()` - Trang chủ
- `songs()` - Danh sách bài hát
- `songDetail($id)` - Chi tiết bài hát
- `albums()` - Danh sách album
- `artists()` - Danh sách nghệ sĩ
- `genres()` - Danh sách thể loại
- `news()` - Tin tức
- `search()` - Tìm kiếm

Không có middleware `auth` nên guest có thể xem tất cả nội dung.

## Routing

**Routes cho guest access:**
```php
Route::get('/', [MusicController2::class, 'index']);
Route::get('/music', [MusicController2::class, 'index'])->name('music.index');
Route::get('/music/bai-hat', [MusicController2::class, 'songs'])->name('music.songs');
Route::get('/music/bai-hat/{id}', [MusicController2::class, 'songDetail'])->name('music.song');
Route::get('/music/the-loai', [MusicController2::class, 'genres'])->name('music.genres');
// ... etc
```

Tất cả routes đều mở cho guest (không có middleware auth).

## Best Practices

1. **Luôn sử dụng @auth directive** cho tính năng yêu cầu login
2. **Trigger modal thay vì chuyển hướng** - Giữ user ở trang hiện tại
3. **Cung cấp feedback rõ ràng** - Cho user biết tại sao cần đăng nhập
4. **Sử dụng consistent modal** - Dùng `#requireLoginModal` hoặc `#guestLoginModal`

## Modal Options

### requireLoginModal (Được Recommended)
- Hiện đại, gọn gàng
- Phù hợp cho tất cả tính năng giới hạn
- **File:** `resources/views/components/login-required-modal.blade.php`

### guestLoginModal (Legacy - từ music-layout)
- Dùng cho bài hát/nhạc
- Có icon headphones
- **File:** `resources/views/components/music-layout.blade.php`

## Tổng kết

✅ Hệ thống cho phép guest xem tất cả nội dung
✅ Các tính năng tương tác yêu cầu đăng nhập
✅ UX tốt với modal popup thay vì page redirect
✅ Dễ mở rộng cho thêm tính năng yêu cầu auth
