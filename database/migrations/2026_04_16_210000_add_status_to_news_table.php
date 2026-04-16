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
        Schema::table('news', function (Blueprint $table) {
            if (! Schema::hasColumn('news', 'status')) {
                $table->tinyInteger('status')->default(1)->after('location');
            }
        });

        if (Schema::hasColumn('news', 'status')) {
            DB::table('news')->whereNull('status')->update(['status' => 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
