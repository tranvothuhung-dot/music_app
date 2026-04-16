<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AlbumsController extends Controller
{
	public function index(Request $request): View
	{
		$keyword = trim((string) $request->query('q', ''));

		$query = DB::table('albums');

		if (Schema::hasColumn('albums', 'status')) {
			$query->where('status', 1);
		}

		if ($keyword !== '') {
			$query->where(function ($builder) use ($keyword) {
				$builder->where('album_name', 'like', '%' . $keyword . '%');

				if (is_numeric($keyword)) {
					$builder->orWhere('album_id', (int) $keyword)
						->orWhere('artist_id', (int) $keyword);
				}
			});
		}

		$albums = $query
			->orderBy('album_id')
			->get()
			->map(function ($album) {
				return [
					'id' => $album->album_id,
					'name' => $album->album_name,
					'artist_id' => $album->artist_id,
					'release_date' => !empty($album->release_date)
						? Carbon::parse($album->release_date)->format('Y-m-d')
						: null,
					'cover_image' => $album->cover_image ?? null,
					'cover_url' => $album->cover_url ?? null,
					'cover_preview' => $this->resolveCoverUrl($album),
					'created_at' => !empty($album->created_at)
						? Carbon::parse($album->created_at)->format('d/m/Y H:i')
						: '-',
					'status' => isset($album->status) ? (int) $album->status : 1,
				];
			});

		return view('admin.albums', [
			'albums' => $albums,
			'keyword' => $keyword,
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:150'],
			'artist_id' => ['required', 'integer', 'min:1'],
			'release_date' => ['required', 'date'],
			'cover_url' => ['nullable', 'url', 'max:255'],
			'image' => ['nullable', 'image', 'max:2048'],
		]);

		$artistId = (int) $validated['artist_id'];

		$artistExists = DB::table('artists')
			->where('artist_id', $artistId)
			->exists();

		if (! $artistExists) {
			$newArtistData = [
				'artist_id' => $artistId,
				'artist_name' => 'Nghệ sĩ #' . $artistId,
				'bio' => null,
				'avatar_image' => 'admin.png',
				'avatar_url' => null,
			];

			if (Schema::hasColumn('artists', 'status')) {
				$newArtistData['status'] = 1;
			}

			if (Schema::hasColumn('artists', 'created_at')) {
				$newArtistData['created_at'] = now();
			}

			if (Schema::hasColumn('artists', 'updated_at')) {
				$newArtistData['updated_at'] = now();
			}

			DB::table('artists')->insert($newArtistData);
		}

		$insertData = [
			'album_name' => $validated['name'],
			'artist_id' => $artistId,
			'release_date' => $validated['release_date'],
			'cover_url' => $validated['cover_url'] ?? null,
		];

		if (Schema::hasColumn('albums', 'status')) {
			$insertData['status'] = 1;
		}

		$coverFileName = $this->storeCoverImage($request);

		if ($coverFileName !== null) {
			$insertData['cover_image'] = $coverFileName;
		}

		if (Schema::hasColumn('albums', 'created_at')) {
			$insertData['created_at'] = now();
		}

		DB::table('albums')->insert($insertData);

		return redirect()
			->route('admin.albums.index')
			->with('success', 'Đã thêm album thành công.');
	}

	public function update(Request $request, int $album): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:150'],
			'artist_id' => ['required', 'integer', 'min:1'],
			'release_date' => ['required', 'date'],
			'cover_url' => ['nullable', 'url', 'max:255'],
			'image' => ['nullable', 'image', 'max:2048'],
		]);

		$exists = DB::table('albums')
			->where('album_id', $album)
			->exists();

		if (! $exists) {
			return redirect()
				->route('admin.albums.index')
				->with('error', 'Không tìm thấy album để cập nhật.');
		}

		$updateData = [
			'album_name' => $validated['name'],
			'artist_id' => (int) $validated['artist_id'],
			'release_date' => $validated['release_date'],
			'cover_url' => $validated['cover_url'] ?? null,
		];

		$coverFileName = $this->storeCoverImage($request);

		if ($coverFileName !== null) {
			$updateData['cover_image'] = $coverFileName;
		}

		DB::table('albums')
			->where('album_id', $album)
			->update($updateData);

		return redirect()
			->route('admin.albums.index')
			->with('success', 'Đã cập nhật album thành công.');
	}

	public function destroy(int $album): RedirectResponse
	{
		if (! Schema::hasColumn('albums', 'status')) {
			return back()->with('error', 'Thiếu cột status trong bảng albums.');
		}

		$exists = DB::table('albums')
			->where('album_id', $album)
			->exists();

		if (! $exists) {
			return redirect()
				->route('admin.albums.index')
				->with('error', 'Không tìm thấy album để xóa.');
		}

		DB::table('albums')
			->where('album_id', $album)
			->update(['status' => 0]);

		return redirect()
			->route('admin.albums.index')
			->with('success', 'Đã xóa album thành công.');
	}

	private function storeCoverImage(Request $request): ?string
	{
		if (! $request->hasFile('image')) {
			return null;
		}

		$file = $request->file('image');
		$extension = strtolower($file->getClientOriginalExtension());
		$fileName = Str::uuid()->toString() . '.' . $extension;

		$destinationPath = public_path('images');

		if (! is_dir($destinationPath)) {
			mkdir($destinationPath, 0755, true);
		}

		$file->move($destinationPath, $fileName);

		return $fileName;
	}

	private function resolveCoverUrl(object $album): string
	{
		$coverImage = (string) ($album->cover_image ?? '');
		$coverUrl = (string) ($album->cover_url ?? '');

		if ($coverUrl !== '') {
			return $coverUrl;
		}

		if ($coverImage !== '' && file_exists(public_path('images/' . $coverImage))) {
			return asset('images/' . $coverImage);
		}

		return asset('images/admin.png');
	}
}
