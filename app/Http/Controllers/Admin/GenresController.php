<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GenresController extends Controller
{
	public function index(Request $request): View
	{
		$keyword = trim((string) $request->query('q', ''));
		$perPage = (int) $request->query('per_page', 5);
		$perPage = in_array($perPage, [5, 10, 15, 25, 50]) ? $perPage : 5;

		$query = DB::table('genres');

		if (Schema::hasColumn('genres', 'status')) {
			$query->where('status', 1);
		}

		if ($keyword !== '') {
			$query->where(function ($builder) use ($keyword) {
				$builder->where('genre_name', 'like', '%' . $keyword . '%');

				if (is_numeric($keyword)) {
					$builder->orWhere('genre_id', (int) $keyword);
				}
			});
		}

		$genresPage = $query
			->orderBy('genre_id')
			->paginate($perPage)
			->withQueryString();

		$genres = $genresPage->getCollection()->map(function ($genre) {
				return [
					'id' => $genre->genre_id,
					'name' => $genre->genre_name,
				];
			});

		return view('admin.genres', [
			'genres' => $genres,
			'pagination' => $genresPage,
			'keyword' => $keyword,
			'perPage' => $perPage,
		]);
	}

	public function songs(int $genre): View
	{
		$perPage = 5;
		if (request()->has('per_page')) {
			$requestedPerPage = (int) request()->query('per_page', 5);
			$perPage = in_array($requestedPerPage, [5, 10, 15, 25, 50]) ? $requestedPerPage : 5;
		}

		$genreQuery = DB::table('genres')->where('genre_id', $genre);

		if (Schema::hasColumn('genres', 'status')) {
			$genreQuery->where('status', 1);
		}

		$genreData = $genreQuery->first();

		if ($genreData === null) {
			abort(404);
		}

		$songsQuery = DB::table('songs as s')
			->leftJoin('artists as a', 's.artist_id', '=', 'a.artist_id')
			->leftJoin('albums as al', 's.album_id', '=', 'al.album_id')
			->select(
				's.song_id',
				's.song_name',
				's.song_image',
				's.song_url',
				's.duration',
				's.view_count',
				'a.artist_name',
				'al.album_name'
			)
			->where('s.genre_id', $genre)
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
					'album' => (string) ($song->album_name ?? 'Chưa có album'),
					'duration' => (int) ($song->duration ?? 0),
					'views' => number_format((int) ($song->view_count ?? 0)),
					'cover' => $this->resolveSongImageUrl((string) ($song->song_image ?? '')),
					'audio_src' => $this->resolveSongAudioUrl((string) ($song->song_url ?? '')),
				];
			});

		return view('admin.genre-songs', [
			'genre' => [
				'id' => (int) $genreData->genre_id,
				'name' => (string) $genreData->genre_name,
			],
			'songs' => $songs,
			'pagination' => $songsPage,
			'perPage' => $perPage,
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:100', 'unique:genres,genre_name'],
		]);

		$insertData = [
			'genre_name' => $validated['name'],
		];

		if (Schema::hasColumn('genres', 'status')) {
			$insertData['status'] = 1;
		}

		DB::table('genres')->insert($insertData);

		return redirect()
			->route('admin.genres.index')
			->with('success', 'Đã thêm thể loại thành công.');
	}

	public function update(Request $request, int $genre): RedirectResponse
	{
		$validated = $request->validate([
			'name' => [
				'required',
				'string',
				'max:100',
				Rule::unique('genres', 'genre_name')->ignore($genre, 'genre_id'),
			],
		]);

		$exists = DB::table('genres')
			->where('genre_id', $genre)
			->exists();

		if (! $exists) {
			return redirect()
				->route('admin.genres.index')
				->with('error', 'Không tìm thấy thể loại để cập nhật.');
		}

		DB::table('genres')
			->where('genre_id', $genre)
			->update([
				'genre_name' => $validated['name'],
			]);

		return redirect()
			->route('admin.genres.index')
			->with('success', 'Đã cập nhật thể loại thành công.');
	}

	public function destroy(int $genre): RedirectResponse
	{
		$exists = DB::table('genres')
			->where('genre_id', $genre)
			->exists();

		if (! $exists) {
			return redirect()
				->route('admin.genres.index')
				->with('error', 'Không tìm thấy thể loại để xóa.');
		}

		if (Schema::hasColumn('genres', 'status')) {
			DB::table('genres')
				->where('genre_id', $genre)
				->update(['status' => 0]);
		} else {
			DB::table('genres')
				->where('genre_id', $genre)
				->delete();
		}

		return redirect()
			->route('admin.genres.index')
			->with('success', 'Đã xóa thể loại thành công.');
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
