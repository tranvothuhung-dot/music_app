<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
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

    public function index(Request $request): View
    {
        $rangeDays = (int) $request->query('range_days', 7);
        if (! in_array($rangeDays, [7, 30], true)) {
            $rangeDays = 7;
        }

        $rangeStart = Carbon::today()->subDays($rangeDays - 1);
        $labels = collect(range(0, $rangeDays - 1))
            ->map(fn (int $offset) => $rangeStart->copy()->addDays($offset));

        $listeningRaw = DB::table('listening_history')
            ->selectRaw('DATE(listened_at) as listen_date, COUNT(*) as total_listens')
            ->whereDate('listened_at', '>=', $rangeStart->toDateString())
            ->groupByRaw('DATE(listened_at)')
            ->orderBy('listen_date')
            ->pluck('total_listens', 'listen_date');

        $visitRaw = collect();
        if (Schema::hasTable('site_visits')) {
            $visitRaw = DB::table('site_visits')
                ->selectRaw('visit_date, SUM(visit_count) as total_visits')
                ->whereDate('visit_date', '>=', $rangeStart->toDateString())
                ->groupBy('visit_date')
                ->orderBy('visit_date')
                ->pluck('total_visits', 'visit_date');
        }

        $chartLabels = $labels->map(fn (Carbon $date) => $date->format('d/m'));
        $listeningSeries = $labels->map(fn (Carbon $date) => (int) ($listeningRaw[$date->toDateString()] ?? 0));
        $visitSeries = $labels->map(fn (Carbon $date) => (int) ($visitRaw[$date->toDateString()] ?? 0));

        $artistsCountQuery = DB::table('artists');
        if (Schema::hasColumn('artists', 'status')) {
            $artistsCountQuery->where('status', 1);
        }

        $albumsCountQuery = DB::table('albums');
        if (Schema::hasColumn('albums', 'status')) {
            $albumsCountQuery->where('status', 1);
        }

        $songsCountQuery = DB::table('songs');
        if (Schema::hasColumn('songs', 'status')) {
            $songsCountQuery->where('status', 1);
        }

        $songViewsQuery = DB::table('songs');
        if (Schema::hasColumn('songs', 'status')) {
            $songViewsQuery->where('status', 1);
        }

        $totalArtists = $artistsCountQuery->count();
        $totalAlbums = $albumsCountQuery->count();
        $totalSongs = $songsCountQuery->count();
        $totalSongViews = (int) ($songViewsQuery->sum('view_count') ?? 0);

        $usersCountQuery = DB::table('users');
        if (Schema::hasColumn('users', 'status')) {
            $usersCountQuery->where('status', 1);
        }
        $totalUsers = $usersCountQuery->count();

        $totalWebsiteVisits = 0;
        if (Schema::hasTable('site_visits')) {
            $totalWebsiteVisits = (int) (DB::table('site_visits')->sum('visit_count') ?? 0);
        }

        $topSongsQuery = DB::table('songs as s')
            ->leftJoin('artists as a', 'a.artist_id', '=', 's.artist_id')
            ->select([
                's.song_id',
                's.song_name',
                's.song_image',
                's.song_url',
                'a.artist_name',
                's.view_count',
            ]);

        if (Schema::hasColumn('songs', 'status')) {
            $topSongsQuery->where('s.status', 1);
        }

        $topSongs = $topSongsQuery
            ->orderByDesc('s.view_count')
            ->limit(5)
            ->get()
            ->map(function ($song) {
                $song->audio_src = $this->resolveSongAudioUrl((string) ($song->song_url ?? ''));

                return $song;
            });

        $topArtistsQuery = DB::table('artists as a')
            ->leftJoin('songs as s', 's.artist_id', '=', 'a.artist_id')
            ->selectRaw('a.artist_id, a.artist_name, a.avatar_image, COALESCE(SUM(s.view_count), 0) as total_views, COUNT(s.song_id) as total_songs')
            ->groupBy('a.artist_id', 'a.artist_name', 'a.avatar_image');

        if (Schema::hasColumn('artists', 'status')) {
            $topArtistsQuery->where('a.status', 1);
        }
        if (Schema::hasColumn('songs', 'status')) {
            $topArtistsQuery->where(function ($query) {
                $query->whereNull('s.status')->orWhere('s.status', 1);
            });
        }

        $topArtists = $topArtistsQuery
            ->orderByDesc('total_views')
            ->limit(5)
            ->get();

        $topAlbumsQuery = DB::table('albums as al')
            ->leftJoin('songs as s', 's.album_id', '=', 'al.album_id')
            ->selectRaw('al.album_id, al.album_name, al.cover_image, COALESCE(SUM(s.view_count), 0) as total_views, COUNT(s.song_id) as total_songs')
            ->groupBy('al.album_id', 'al.album_name', 'al.cover_image');

        if (Schema::hasColumn('albums', 'status')) {
            $topAlbumsQuery->where('al.status', 1);
        }
        if (Schema::hasColumn('songs', 'status')) {
            $topAlbumsQuery->where(function ($query) {
                $query->whereNull('s.status')->orWhere('s.status', 1);
            });
        }

        $topAlbums = $topAlbumsQuery
            ->orderByDesc('total_views')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'rangeDays' => $rangeDays,
            'totalUsers' => $totalUsers,
            'totalArtists' => $totalArtists,
            'totalAlbums' => $totalAlbums,
            'totalSongs' => $totalSongs,
            'totalSongViews' => $totalSongViews,
            'totalWebsiteVisits' => $totalWebsiteVisits,
            'chartLabels' => $chartLabels,
            'listeningSeries' => $listeningSeries,
            'visitSeries' => $visitSeries,
            'topSongs' => $topSongs,
            'topArtists' => $topArtists,
            'topAlbums' => $topAlbums,
        ]);
    }
}
