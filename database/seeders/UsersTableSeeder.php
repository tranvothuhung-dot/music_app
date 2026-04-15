<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'user_id' => 1,
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$0o0CfHZJMTylxFDi1zCG4evxZH1.Ub9i8WrWE82QbeoWeCHvQdW.6',
                'birth_day' => '1999-01-01',
                'gender' => 'male',
                'full_name' => 'Administrator',
                'avatar_image' => 'admin.png',
                'avatar_url' => null,
                'role_id' => 1,
                'created_at' => '2026-01-07 15:39:24',
                'updated_at' => '2026-04-14 22:40:07',
            ],
            [
                'user_id' => 2,
                'username' => 'hung',
                'email' => 'hung@gmail.com',
                'password' => '$2y$12$q4HgAGrZ.AnCghbkucPqM./rhWgwSpPGjToDn0aMLRjj6NlV6IdlG',
                'birth_day' => '2005-07-17',
                'gender' => 'female',
                'full_name' => 'Thu Hưng',
                'avatar_image' => 'u1.png',
                'avatar_url' => null,
                'role_id' => 2,
                'created_at' => '2026-01-07 15:39:24',
                'updated_at' => '2026-04-14 23:10:27',
            ],
            [
                'user_id' => 3,
                'username' => 'minh',
                'email' => 'minh@gmail.com',
                'password' => '$2y$10$qMfU54Lk2IlNNU5Vqg0XpOO/5lAY7XdCk8/3nx/1kVAnoAkyqGb5S',
                'birth_day' => '2003-03-12',
                'gender' => 'male',
                'full_name' => 'Minh Nguyễn',
                'avatar_image' => 'u2.png',
                'avatar_url' => null,
                'role_id' => 2,
                'created_at' => '2026-01-07 15:39:24',
                'updated_at' => '2026-04-15 05:38:03',
            ],
            [
                'user_id' => 4,
                'username' => 'hoa',
                'email' => 'hoa@gmail.com',
                'password' => '$2y$10$qMfU54Lk2IlNNU5Vqg0XpOO/5lAY7XdCk8/3nx/1kVAnoAkyqGb5S',
                'birth_day' => '2004-09-20',
                'gender' => 'female',
                'full_name' => 'Hoa Trần',
                'avatar_image' => 'u3.png',
                'avatar_url' => null,
                'role_id' => 2,
                'created_at' => '2026-01-07 15:39:24',
                'updated_at' => '2026-04-15 05:38:03',
            ],
            [
                'user_id' => 5,
                'username' => 'nam',
                'email' => 'nam@gmail.com',
                'password' => '$2y$10$qMfU54Lk2IlNNU5Vqg0XpOO/5lAY7XdCk8/3nx/1kVAnoAkyqGb5S',
                'birth_day' => '2002-06-10',
                'gender' => 'male',
                'full_name' => 'Nam Phạm',
                'avatar_image' => 'u4.png',
                'avatar_url' => null,
                'role_id' => 2,
                'created_at' => '2026-01-07 15:39:24',
                'updated_at' => '2026-04-15 05:38:03',
            ],
            [
                'user_id' => 6,
                'username' => 'linh',
                'email' => 'linh@gmail.com',
                'password' => '$2y$10$qMfU54Lk2IlNNU5Vqg0XpOO/5lAY7XdCk8/3nx/1kVAnoAkyqGb5S',
                'birth_day' => '2001-11-22',
                'gender' => 'female',
                'full_name' => 'Linh Võ',
                'avatar_image' => 'u5.png',
                'avatar_url' => null,
                'role_id' => 2,
                'created_at' => '2026-01-07 15:39:24',
                'updated_at' => '2026-04-15 05:38:03',
            ],
            [
                'user_id' => 7,
                'username' => 'Eirlys131',
                'email' => 'hong0868804927@gmail.com',
                'password' => '$2y$10$L.vCludu1S5c5ZpbXs/VyOLVtrSePQBbms2B01JPLzHhE.yBPsC6q',
                'birth_day' => '2005-01-13',
                'gender' => 'female',
                'full_name' => 'Trương Thị Cẩm Hồng',
                'avatar_image' => 'user_7_1767909311.jpg',
                'avatar_url' => null,
                'role_id' => 2,
                'created_at' => '2026-01-08 14:53:52',
                'updated_at' => '2026-04-15 05:38:03',
            ],
            [
                'user_id' => 8,
                'username' => 'tan33',
                'email' => 'tan@gmail.com',
                'password' => '$2y$10$qMfU54Lk2IlNNU5Vqg0XpOO/5lAY7XdCk8/3nx/1kVAnoAkyqGb5S',
                'birth_day' => '2005-02-09',
                'gender' => 'female',
                'full_name' => 'Tần',
                'avatar_image' => 'user_8_1767970463.png',
                'avatar_url' => null,
                'role_id' => 2,
                'created_at' => '2026-01-09 14:52:13',
                'updated_at' => '2026-04-15 05:38:03',
            ],
        ]);
    }
}
