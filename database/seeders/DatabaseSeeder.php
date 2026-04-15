<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        DB::table('danh_muc_am_nhac')->insert([
            ['ten_danh_muc' => 'Pop', 'created_at' => now(), 'updated_at' => now()],
            ['ten_danh_muc' => 'Rock', 'created_at' => now(), 'updated_at' => now()],
            ['ten_danh_muc' => 'Nhạc Trữ Tình', 'created_at' => now(), 'updated_at' => now()],
            ['ten_danh_muc' => 'EDM', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
