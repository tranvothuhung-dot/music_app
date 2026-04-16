<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));

        $newsItems = collect();

        if (Schema::hasTable('news')) {
            $hasStatusColumn = Schema::hasColumn('news', 'status');

            $newsItems = DB::table('news')
                ->when($hasStatusColumn, function ($query) {
                    $query->where('status', 1);
                })
                ->when($keyword !== '', function ($query) use ($keyword) {
                    $searchTerm = "%{$keyword}%";

                    $query->where(function ($subQuery) use ($searchTerm, $keyword) {
                        $subQuery->where('title', 'like', $searchTerm)
                            ->orWhere('description', 'like', $searchTerm)
                            ->orWhere('location', 'like', $searchTerm)
                            ->orWhereDate('event_date', $keyword);
                    });
                })
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($item) {
                    $eventDateRaw = $item->event_date ? date('Y-m-d', strtotime((string) $item->event_date)) : '';
                    $eventDate = $item->event_date ? date('d/m', strtotime((string) $item->event_date)) : '';
                    $newImage = trim((string) ($item->new_image ?? ''));

                    if ($newImage !== '' && ! Str::startsWith($newImage, ['http://', 'https://', '/'])) {
                        $imagePath = asset('images/' . ltrim($newImage, '/'));
                    } else {
                        $imagePath = $newImage !== '' ? $newImage : asset('images/song-placeholder.svg');
                    }

                    return [
                        'id' => $item->news_id,
                        'date' => $eventDate,
                        'event_date' => $eventDateRaw,
                        'title' => (string) ($item->title ?? ''),
                        'location' => (string) ($item->location ?? ''),
                        'description' => (string) ($item->description ?? ''),
                        'image' => $imagePath,
                    ];
                });
        }

        return view('admin.news', [
            'keyword' => $keyword,
            'newsItems' => $newsItems,
        ]);
    }

    public function store(Request $request)
    {
        if (! Schema::hasTable('news')) {
            return redirect()
                ->route('admin.news.index')
                ->with('error', 'Không tìm thấy bảng news trong cơ sở dữ liệu.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
        ]);

        $imageFile = $request->file('image');
        $fileName = time() . '_news_' . Str::lower(Str::random(8)) . '.' . $imageFile->getClientOriginalExtension();
        $imageFile->move(public_path('images'), $fileName);

        $insertData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'new_image' => $fileName,
            'image_url' => null,
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (Schema::hasColumn('news', 'status')) {
            $insertData['status'] = 1;
        }

        DB::table('news')->insert($insertData);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Đã thêm tin tức thành công.');
    }

    public function update(Request $request, int $news)
    {
        if (! Schema::hasTable('news')) {
            return redirect()
                ->route('admin.news.index')
                ->with('error', 'Không tìm thấy bảng news trong cơ sở dữ liệu.');
        }

        $existingNews = DB::table('news')->where('news_id', $news)->first();

        if (! $existingNews) {
            return redirect()
                ->route('admin.news.index')
                ->with('error', 'Tin tức không tồn tại để cập nhật.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
        ]);

        $updateData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'updated_at' => now(),
        ];

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $fileName = time() . '_news_' . Str::lower(Str::random(8)) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('images'), $fileName);
            $updateData['new_image'] = $fileName;
        }

        DB::table('news')
            ->where('news_id', $news)
            ->update($updateData);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Đã cập nhật tin tức thành công.');
    }

    public function destroy(int $news)
    {
        if (! Schema::hasTable('news')) {
            return redirect()
                ->route('admin.news.index')
                ->with('error', 'Không tìm thấy bảng news trong cơ sở dữ liệu.');
        }

        $newsQuery = DB::table('news')->where('news_id', $news);

        if (! $newsQuery->exists()) {
            return redirect()
                ->route('admin.news.index')
                ->with('error', 'Tin tức không tồn tại hoặc đã bị xóa.');
        }

        if (! Schema::hasColumn('news', 'status')) {
            return redirect()
                ->route('admin.news.index')
                ->with('error', 'Bảng news chưa có cột status. Hãy chạy migrate trước.');
        }

        $newsQuery->update([
            'status' => 0,
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Đã xóa tin tức thành công.');
    }
}
