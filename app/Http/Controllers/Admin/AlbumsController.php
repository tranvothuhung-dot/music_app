<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AlbumsController extends Controller
{
	public function index(Request $request): View
	{
		$keyword = trim((string) $request->query('q', ''));
		$perPage = (int) $request->query('per_page', 5);
		$perPage = in_array($perPage, [5, 10, 15, 25, 50]) ? $perPage : 5;
		$selectedAlbumId = (int) $request->query('album', 0);

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

		$albumsPage = $query
			->orderBy('album_id')
			->paginate($perPage)
			->withQueryString();

		$albums = $albumsPage->getCollection()->map(function ($album) {
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

		$selectedAlbum = null;
		$albumSongs = collect();

		if ($selectedAlbumId > 0) {
			$selectedAlbum = $albums->firstWhere('id', $selectedAlbumId);

			if ($selectedAlbum !== null) {
				$albumSongsQuery = DB::table('songs as s')
					->leftJoin('artists as a', 's.artist_id', '=', 'a.artist_id')
					->select(
						's.song_id',
						's.song_name',
						's.song_image',
						's.song_url',
						's.duration',
						's.view_count',
						'a.artist_name'
					)
					->where('s.album_id', $selectedAlbumId)
					->orderBy('s.song_id');

				if (Schema::hasColumn('songs', 'status')) {
					$albumSongsQuery->where('s.status', 1);
				}

				$albumSongs = $albumSongsQuery
					->get()
					->map(function ($song) {
						return [
							'id' => (int) $song->song_id,
							'title' => (string) ($song->song_name ?? ''),
							'artist' => (string) ($song->artist_name ?? 'Chưa có ca sĩ'),
							'duration' => (int) ($song->duration ?? 0),
							'views' => number_format((int) ($song->view_count ?? 0)),
							'cover' => $this->resolveSongImageUrl((string) ($song->song_image ?? '')),
							'audio_src' => $this->resolveSongAudioUrl((string) ($song->song_url ?? '')),
						];
					});
			}
		}

		return view('admin.albums', [
			'albums' => $albums,
			'pagination' => $albumsPage,
			'keyword' => $keyword,
			'perPage' => $perPage,
			'selectedAlbumId' => $selectedAlbumId,
			'selectedAlbum' => $selectedAlbum,
			'albumSongs' => $albumSongs,
		]);
	}

	public function songs(int $album): View
	{
		$perPage = 5;
		if (request()->has('per_page')) {
			$requestedPerPage = (int) request()->query('per_page', 5);
			$perPage = in_array($requestedPerPage, [5, 10, 15, 25, 50]) ? $requestedPerPage : 5;
		}

		$albumQuery = DB::table('albums')->where('album_id', $album);

		if (Schema::hasColumn('albums', 'status')) {
			$albumQuery->where('status', 1);
		}

		$albumData = $albumQuery->first();

		if ($albumData === null) {
			abort(404);
		}

		$songsQuery = DB::table('songs as s')
			->leftJoin('artists as a', 's.artist_id', '=', 'a.artist_id')
			->select(
				's.song_id',
				's.song_name',
				's.song_image',
				's.song_url',
				's.duration',
				's.view_count',
				'a.artist_name'
			)
			->where('s.album_id', $album)
			->orderBy('s.song_id');

		if (Schema::hasColumn('songs', 'status')) {
			$songsQuery->where('s.status', 1);
		}

		$songsPage = $songsQuery
			->paginate($perPage)
			->withQueryString();

		$songs = $songsPage->getCollection()->map(function ($song) {
				return [
					'id' => (int) $song->song_id,
					'title' => (string) ($song->song_name ?? ''),
					'artist' => (string) ($song->artist_name ?? 'Chưa có ca sĩ'),
					'duration' => (int) ($song->duration ?? 0),
					'views' => number_format((int) ($song->view_count ?? 0)),
					'cover' => $this->resolveSongImageUrl((string) ($song->song_image ?? '')),
					'audio_src' => $this->resolveSongAudioUrl((string) ($song->song_url ?? '')),
				];
			});

		return view('admin.album-songs', [
			'album' => [
				'id' => (int) $albumData->album_id,
				'name' => (string) $albumData->album_name,
			],
			'songs' => $songs,
			'pagination' => $songsPage,
			'perPage' => $perPage,
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

	private function resolveSongImageUrl(string $songImage): string
	{
		if ($songImage === '') {
			return asset('images/song-placeholder.svg');
		}

		if (str_starts_with($songImage, 'http://') || str_starts_with($songImage, 'https://')) {
			return $songImage;
		}

		if (Storage::disk('public')->exists('song_images/' . $songImage)) {
			return asset('storage/song_images/' . $songImage);
		}

		if (file_exists(public_path('images/' . $songImage))) {
			return asset('images/' . $songImage);
		}

		return asset('images/song-placeholder.svg');
	}

	private function resolveSongAudioUrl(string $songUrl): string
	{
		if ($songUrl === '') {
			return '';
		}

		if (str_starts_with($songUrl, 'http://') || str_starts_with($songUrl, 'https://')) {
			return $songUrl;
		}

		if (str_starts_with($songUrl, '/')) {
			return asset(ltrim($songUrl, '/'));
		}

		if (str_starts_with($songUrl, 'storage/')) {
			return asset($songUrl);
		}

		$fileName = basename($songUrl);

		if (Storage::disk('public')->exists('song/' . $fileName)) {
			return asset('storage/song/' . $fileName);
		}

		if (file_exists(public_path($songUrl))) {
			return asset($songUrl);
		}

		if (file_exists(public_path('song/' . $fileName))) {
			return asset('song/' . $fileName);
		}

		return $songUrl;
	}
}
