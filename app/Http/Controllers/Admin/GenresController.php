<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GenresController extends Controller
{
	public function index(Request $request): View
	{
		$keyword = trim((string) $request->query('q', ''));

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

		$genres = $query
			->orderBy('genre_id')
			->get()
			->map(function ($genre) {
				return [
					'id' => $genre->genre_id,
					'name' => $genre->genre_name,
				];
			});

		return view('admin.genres', [
			'genres' => $genres,
			'keyword' => $keyword,
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
}
