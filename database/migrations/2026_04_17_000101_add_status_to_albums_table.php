<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('albums', 'status')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->unsignedTinyInteger('status')->default(1)->after('created_at');
            });
        }

        DB::table('albums')->whereNull('status')->update(['status' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('albums', 'status')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
