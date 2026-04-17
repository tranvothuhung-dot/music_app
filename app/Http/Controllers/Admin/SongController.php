<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $keyword = trim((string) $request->query('q', ''));
        $perPage = (int) $request->query('per_page', 5);
        $perPage = in_array($perPage, [5, 10, 15, 25, 50]) ? $perPage : 5;

        $query = DB::table('songs as s')
            ->leftJoin('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->leftJoin('albums as al', 's.album_id', '=', 'al.album_id')
            ->leftJoin('genres as g', 's.genre_id', '=', 'g.genre_id')
            ->select(
                's.song_id',
                's.song_name',
                's.song_image',
                's.song_url',
                's.artist_id',
                's.album_id',
                's.genre_id',
                's.duration',
                's.view_count',
                's.created_at',
                'a.artist_name',
                'al.album_name',
                'g.genre_name'
            )
            ->orderBy('s.song_id');

        if (Schema::hasColumn('songs', 'status')) {
            $query->where('s.status', 1);
        }

        if ($keyword !== '') {
            $query->where(function ($builder) use ($keyword) {
                $builder->where('s.song_name', 'like', '%' . $keyword . '%')
                    ->orWhere('a.artist_name', 'like', '%' . $keyword . '%');

                if (is_numeric($keyword)) {
                    $builder->orWhere('s.song_id', (int) $keyword);
                }
            });
        }

        $songsPage = $query
            ->paginate($perPage)
            ->withQueryString();

        $songs = $songsPage->getCollection()->map(function ($song) {
                return [
                    'id' => (int) $song->song_id,
                    'title' => (string) ($song->song_name ?? ''),
                    'artist' => (string) ($song->artist_name ?? 'Chưa có ca sĩ'),
                    'artist_id' => (int) ($song->artist_id ?? 0),
                    'album_id' => (int) ($song->album_id ?? 0),
                    'genre_id' => (int) ($song->genre_id ?? 0),
                    'song_url' => (string) ($song->song_url ?? ''),
                    'album' => (string) ($song->album_name ?? ''),
                    'genre' => (string) ($song->genre_name ?? ''),
                    'duration' => (string) ($song->duration ?? '-'),
                    'views' => number_format((int) ($song->view_count ?? 0)),
                    'posted_at' => ! empty($song->created_at)
                        ? date('d/m/Y', strtotime((string) $song->created_at))
                        : '-',
                    'cover' => $this->resolveSongImageUrl((string) ($song->song_image ?? '')),
                    'audio_src' => $this->resolveSongAudioUrl((string) ($song->song_url ?? '')),
                ];
            });

        $artistsOptions = Schema::hasTable('artists')
            ? DB::table('artists')
                ->select('artist_id', 'artist_name')
                ->orderBy('artist_name')
                ->get()
            : collect();

        $albumsOptions = Schema::hasTable('albums')
            ? DB::table('albums')
                ->select('album_id', 'album_name', 'artist_id')
                ->orderBy('album_name')
                ->get()
            : collect();

        $genresOptions = Schema::hasTable('genres')
            ? DB::table('genres')
                ->select('genre_id', 'genre_name')
                ->orderBy('genre_name')
                ->get()
            : collect();

        return view('admin.songs', [
            'songs' => $songs,
            'pagination' => $songsPage,
            'keyword' => $keyword,
            'perPage' => $perPage,
            'artistsOptions' => $artistsOptions,
            'albumsOptions' => $albumsOptions,
            'genresOptions' => $genresOptions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            $this->songValidationRules(),
            $this->songValidationMessages(),
            $this->songValidationAttributes()
        );

        $insertData = [
            'song_name' => $validated['song_name'],
            'artist_id' => (int) $validated['artist_id'],
            'album_id' => (int) $validated['album_id'],
            'genre_id' => (int) $validated['genre_id'],
        ];

        if (Schema::hasColumn('songs', 'duration')) {
            $insertData['duration'] = (int) $validated['duration'];
        }

        if (Schema::hasColumn('songs', 'view_count')) {
            $insertData['view_count'] = 0;
        }

        if (Schema::hasColumn('songs', 'status')) {
            $insertData['status'] = 1;
        }

        $imageFileName = $this->storeSongAsset($request, 'song_image', 'song_images');
        if (Schema::hasColumn('songs', 'song_image')) {
            if ($imageFileName !== null) {
                $insertData['song_image'] = $imageFileName;
            } elseif ($this->isRequiredColumnWithoutDefault('songs', 'song_image')) {
                $songImageValue = $this->resolveRequiredSongFieldValue('song_image');

                if ($songImageValue === null) {
                    return back()
                        ->withInput()
                        ->withErrors(['song_image' => 'Trường ảnh bài hát đang bắt buộc nhưng chưa có giá trị mặc định.']);
                }

                $insertData['song_image'] = $songImageValue;
            }
        }

        $audioFileName = $this->storeSongAsset($request, 'song_file', 'song');
        if (Schema::hasColumn('songs', 'song_file')) {
            if ($audioFileName !== null) {
                $insertData['song_file'] = $audioFileName;
            } elseif ($this->isRequiredColumnWithoutDefault('songs', 'song_file')) {
                $songFileValue = $this->resolveRequiredSongFieldValue('song_file');

                if ($songFileValue === null) {
                    return back()
                        ->withInput()
                        ->withErrors(['song_file' => 'Trường tệp nhạc đang bắt buộc nhưng chưa có giá trị mặc định.']);
                }

                $insertData['song_file'] = $songFileValue;
            }
        }

        if (Schema::hasColumn('songs', 'song_url')) {
            $songUrlInput = trim((string) ($validated['song_url'] ?? ''));

            if ($songUrlInput !== '') {
                $insertData['song_url'] = $songUrlInput;
            } elseif ($audioFileName !== null) {
                $insertData['song_url'] = 'storage/song/' . $audioFileName;
            } elseif ($this->isRequiredColumnWithoutDefault('songs', 'song_url')) {
                $songUrlValue = $this->resolveRequiredSongFieldValue('song_url');

                if ($songUrlValue === null) {
                    return back()
                        ->withInput()
                        ->withErrors(['song_url' => 'Trường liên kết bài hát đang bắt buộc nhưng chưa có giá trị mặc định.']);
                }

                $insertData['song_url'] = $songUrlValue;
            }
        }

        if (Schema::hasColumn('songs', 'created_at')) {
            $insertData['created_at'] = now();
        }

        if (Schema::hasColumn('songs', 'updated_at')) {
            $insertData['updated_at'] = now();
        }

        DB::table('songs')->insert($insertData);

        return redirect()
            ->route('admin.songs.index')
            ->with('success', 'Thêm bài hát thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        // Keep supporting status-only PATCH used by the delete button.
        if ($request->has('status') && ! $request->filled('song_name') && ! $request->filled('artist_name')) {
            $validated = $request->validate(
                ['status' => 'required|in:0,1'],
                $this->songValidationMessages(),
                $this->songValidationAttributes()
            );

            $updateData = ['status' => (int) $validated['status']];

            if (Schema::hasColumn('songs', 'updated_at')) {
                $updateData['updated_at'] = now();
            }

            DB::table('songs')
                ->where('song_id', $song->song_id)
                ->update($updateData);

            return redirect()->route('admin.songs.index')->with('success', 'Cập nhật bài hát thành công.');
        }

        $validated = $request->validate(
            $this->songValidationRules(),
            $this->songValidationMessages(),
            $this->songValidationAttributes()
        );

        $updateData = [
            'song_name' => $validated['song_name'],
        ];

        $updateData['artist_id'] = (int) $validated['artist_id'];
        $updateData['album_id'] = (int) $validated['album_id'];
        $updateData['genre_id'] = (int) $validated['genre_id'];

        if (Schema::hasColumn('songs', 'duration')) {
            $updateData['duration'] = (int) $validated['duration'];
        }

        $imageFileName = $this->storeSongAsset($request, 'song_image', 'song_images');
        if ($imageFileName !== null && Schema::hasColumn('songs', 'song_image')) {
            $updateData['song_image'] = $imageFileName;
        }

        $audioFileName = $this->storeSongAsset($request, 'song_file', 'song');
        if ($audioFileName !== null && Schema::hasColumn('songs', 'song_file')) {
            $updateData['song_file'] = $audioFileName;
        }

        if (Schema::hasColumn('songs', 'song_url')) {
            $songUrlInput = trim((string) ($validated['song_url'] ?? ''));
            if ($songUrlInput !== '') {
                $updateData['song_url'] = $songUrlInput;
            } elseif ($audioFileName !== null) {
                $updateData['song_url'] = 'storage/song/' . $audioFileName;
            }
        }

        if (Schema::hasColumn('songs', 'updated_at')) {
            $updateData['updated_at'] = now();
        }

        DB::table('songs')
            ->where('song_id', $song->song_id)
            ->update($updateData);

        return redirect()->route('admin.songs.index')->with('success', 'Chỉnh sửa bài hát thành công.');
    }

    /**
     * Remove the specified resource from storage (soft delete via status).
     */
    public function destroy(Song $song)
    {
        $updateData = ['status' => 0];

        if (Schema::hasColumn('songs', 'updated_at')) {
            $updateData['updated_at'] = now();
        }

        DB::table('songs')
            ->where('song_id', $song->song_id)
            ->update($updateData);

        return redirect()->route('admin.songs.index')->with('success', 'Xóa bài hát thành công.');
    }

    private function storeSongAsset(Request $request, string $inputName, string $directory): ?string
    {
        if (! $request->hasFile($inputName)) {
            return null;
        }

        $file = $request->file($inputName);
        $extension = strtolower((string) $file->getClientOriginalExtension());
        $fileName = Str::uuid()->toString() . '.' . $extension;

        Storage::disk('public')->putFileAs($directory, $file, $fileName);

        return $fileName;
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

        if (Storage::disk('public')->exists('song/' . $songUrl)) {
            return asset('storage/song/' . $songUrl);
        }

        // Backward compatibility for old uploads saved under song_files.
        if (Storage::disk('public')->exists('song_files/' . $songUrl)) {
            return asset('storage/song_files/' . $songUrl);
        }

        if (Storage::disk('public')->exists($songUrl)) {
            return asset('storage/' . ltrim($songUrl, '/'));
        }

        if (str_starts_with($songUrl, 'storage/')) {
            return asset($songUrl);
        }

        if (file_exists(public_path('music/' . $songUrl))) {
            return asset('music/' . $songUrl);
        }

        if (file_exists(public_path($songUrl))) {
            return asset(ltrim($songUrl, '/'));
        }

        return asset('music/' . $songUrl);
    }

    private function isRequiredColumnWithoutDefault(string $tableName, string $columnName): bool
    {
        $column = $this->getColumnMetadata($tableName, $columnName);

        if (! $column) {
            return false;
        }

        return strtoupper((string) $column->IS_NULLABLE) === 'NO'
            && $column->COLUMN_DEFAULT === null;
    }

    private function resolveRequiredSongFieldValue(string $columnName)
    {
        $column = $this->getColumnMetadata('songs', $columnName);

        if (! $column) {
            return null;
        }

        $dataType = strtolower((string) ($column->DATA_TYPE ?? ''));
        $columnType = strtolower((string) ($column->COLUMN_TYPE ?? ''));

        if ($dataType === 'time') {
            return '00:00:00';
        }

        if (in_array($dataType, ['tinyint', 'smallint', 'mediumint', 'int', 'bigint'], true)) {
            return 0;
        }

        if (in_array($dataType, ['decimal', 'float', 'double'], true)) {
            return 0;
        }

        if (in_array($dataType, ['varchar', 'char', 'text', 'tinytext', 'mediumtext', 'longtext'], true)) {
            return '';
        }

        if ($dataType === 'date') {
            return now()->toDateString();
        }

        if (in_array($dataType, ['datetime', 'timestamp'], true)) {
            return now();
        }

        if (($dataType === 'enum' || $dataType === 'set') && preg_match("/^{$dataType}\\('(.*?)'\\)$/", $columnType, $matches) === 1) {
            $parts = explode("','", $matches[1]);

            return $parts[0] ?? null;
        }

        return null;
    }

    private function getColumnMetadata(string $tableName, string $columnName): ?object
    {
        $column = DB::table('information_schema.columns')
            ->select('IS_NULLABLE', 'COLUMN_DEFAULT', 'DATA_TYPE', 'COLUMN_TYPE')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', $tableName)
            ->where('COLUMN_NAME', $columnName)
            ->first();

        return $column ?: null;
    }

    private function songValidationRules(): array
    {
        return [
            'song_name' => ['required', 'string', 'max:150'],
            'artist_id' => ['required', 'integer', 'exists:artists,artist_id'],
            'album_id' => ['required', 'integer', 'exists:albums,album_id'],
            'genre_id' => ['required', 'integer', 'exists:genres,genre_id'],
            'duration' => ['required', 'integer', 'min:1'],
            'song_url' => ['nullable', 'string', 'max:255'],
            'song_image' => ['nullable', 'image', 'max:2048'],
            'song_file' => ['nullable', 'file', 'mimes:mp3,mpeg', 'max:10240'],
        ];
    }

    private function songValidationMessages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'max.string' => ':attribute không được vượt quá :max ký tự.',
            'max.file' => ':attribute không được lớn hơn :max KB.',
            'image' => ':attribute phải là tệp ảnh hợp lệ.',
            'file' => ':attribute phải là tệp hợp lệ.',
            'mimes' => ':attribute chỉ chấp nhận định dạng: :values.',
            'in' => ':attribute không hợp lệ.',
            'integer' => ':attribute phải là số nguyên.',
            'exists' => ':attribute không tồn tại trong hệ thống.',
            'min.numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
        ];
    }

    private function songValidationAttributes(): array
    {
        return [
            'song_name' => 'Tên bài hát',
            'artist_id' => 'Ca sĩ',
            'album_id' => 'Album',
            'genre_id' => 'Thể loại',
            'duration' => 'Thời lượng',
            'song_url' => 'Liên kết bài hát',
            'song_image' => 'Ảnh bài hát',
            'song_file' => 'Tệp nhạc',
            'status' => 'Trạng thái bài hát',
        ];
    }
}
