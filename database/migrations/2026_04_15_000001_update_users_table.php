<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 100)->unique()->after('id');
            }

            if (!Schema::hasColumn('users', 'birth_day')) {
                $table->date('birth_day')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('birth_day');
            }

            if (!Schema::hasColumn('users', 'full_name')) {
                $table->string('full_name', 150)->nullable()->after('gender');
            }

            if (!Schema::hasColumn('users', 'avatar_image')) {
                $table->string('avatar_image', 255)->nullable()->after('full_name');
            }

            if (!Schema::hasColumn('users', 'avatar_url')) {
                $table->string('avatar_url', 255)->nullable()->after('avatar_image');
            }

            if (!Schema::hasColumn('users', 'role_id')) {
                $table->unsignedInteger('role_id')->default(2)->after('avatar_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'birth_day',
                'gender',
                'full_name',
                'avatar_image',
                'avatar_url',
                'role_id',
            ]);
        });
    }
};
