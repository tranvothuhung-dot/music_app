<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ArtistController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = trim((string) $request->query('q', ''));

        $query = DB::table('artists');

        if (Schema::hasColumn('artists', 'status')) {
            $query->where('status', 1);
        }

        if ($keyword !== '') {
            $query->where(function ($builder) use ($keyword) {
                $builder->where('artist_name', 'like', '%' . $keyword . '%');

                if (is_numeric($keyword)) {
                    $builder->orWhere('artist_id', (int) $keyword);
                }
            });
        }

        $artists = $query
            ->orderBy('artist_id')
            ->get()
            ->map(function ($artist) {
                return [
                    'id' => $artist->artist_id,
                    'name' => $artist->artist_name,
                    'bio' => $artist->bio ?? '',
                    'avatar' => $this->resolveAvatarUrl($artist),
                    'created_at' => !empty($artist->created_at)
                        ? Carbon::parse($artist->created_at)->format('d/m/Y H:i')
                        : '-',
                ];
            });

        return view('admin.artists', [
            'artists' => $artists,
            'keyword' => $keyword,
        ]);
    }

    public function destroy(int $artist): RedirectResponse
    {
        if (! Schema::hasColumn('artists', 'status')) {
            return back()->with('error', 'Thiếu cột status trong bảng artists. Hãy chạy migrate trước.');
        }

        $exists = DB::table('artists')
            ->where('artist_id', $artist)
            ->exists();

        if (! $exists) {
            return redirect()
                ->route('admin.artists.index')
                ->with('error', 'Bản ghi nghệ sĩ không còn trong DB (đã bị xóa cứng từ trước).');
        }

        $updateData = ['status' => 0];

        if (Schema::hasColumn('artists', 'updated_at')) {
            $updateData['updated_at'] = now();
        }

        DB::table('artists')
            ->where('artist_id', $artist)
            ->update($updateData);

        return redirect()
            ->route('admin.artists.index')
            ->with('success', 'Đã xóa nghệ sĩ thành công');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'bio' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $insertData = [
            'artist_name' => $validated['name'],
            'bio' => $validated['bio'] ?? null,
        ];

        if (Schema::hasColumn('artists', 'status')) {
            $insertData['status'] = 1;
        }

        $avatarFileName = $this->storeAvatarImage($request);

        if ($avatarFileName !== null && Schema::hasColumn('artists', 'avatar_image')) {
            $insertData['avatar_image'] = $avatarFileName;
        }

        if (Schema::hasColumn('artists', 'created_at')) {
            $insertData['created_at'] = now();
        }

        if (Schema::hasColumn('artists', 'updated_at')) {
            $insertData['updated_at'] = now();
        }

        DB::table('artists')->insert($insertData);

        return redirect()
            ->route('admin.artists.index')
            ->with('success', 'Đã thêm nghệ sĩ thành công');
    }

    public function update(Request $request, int $artist): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'bio' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $exists = DB::table('artists')
            ->where('artist_id', $artist)
            ->exists();

        if (! $exists) {
            return redirect()
                ->route('admin.artists.index')
                ->with('error', 'Không tìm thấy nghệ sĩ để cập nhật.');
        }

        $updateData = [
            'artist_name' => $validated['name'],
            'bio' => $validated['bio'] ?? null,
        ];

        $avatarFileName = $this->storeAvatarImage($request);

        if ($avatarFileName !== null && Schema::hasColumn('artists', 'avatar_image')) {
            $updateData['avatar_image'] = $avatarFileName;
        }

        if (Schema::hasColumn('artists', 'updated_at')) {
            $updateData['updated_at'] = now();
        }

        DB::table('artists')
            ->where('artist_id', $artist)
            ->update($updateData);

        return redirect()
            ->route('admin.artists.index')
            ->with('success', 'Đã cập nhật nghệ sĩ thành công');
    }

    private function storeAvatarImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');
        $extension = strtolower($file->getClientOriginalExtension());
        $fileName = Str::uuid()->toString() . '.' . $extension;
        Storage::disk('public')->putFileAs('image', $file, $fileName);

        return $fileName;
    }

    private function resolveAvatarUrl(object $artist): string
    {
        $avatar = (string) ($artist->avatar_image ?? $artist->artist_image ?? '');

        if ($avatar === '') {
            return asset('images/admin.png');
        }

        if (str_starts_with($avatar, 'http://') || str_starts_with($avatar, 'https://')) {
            return $avatar;
        }

        if (Storage::disk('public')->exists('image/' . $avatar)) {
            return asset('storage/image/' . $avatar);
        }

        if (file_exists(public_path('images/' . $avatar))) {
            return asset('images/' . $avatar);
        }

        return asset('images/admin.png');
    }
}
