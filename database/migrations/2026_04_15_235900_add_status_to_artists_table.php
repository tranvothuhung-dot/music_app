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
        if (! Schema::hasTable('artists')) {
            Schema::create('artists', function (Blueprint $table) {
                $table->increments('artist_id');
                $table->string('artist_name', 150);
                $table->string('avatar_image', 255)->nullable();
                $table->text('bio')->nullable();
                $table->unsignedTinyInteger('status')->default(1);
                $table->timestamps();
            });

            return;
        }

        Schema::table('artists', function (Blueprint $table) {
            if (! Schema::hasColumn('artists', 'status')) {
                if (Schema::hasColumn('artists', 'bio')) {
                    $table->unsignedTinyInteger('status')->default(1)->after('bio');
                } else {
                    $table->unsignedTinyInteger('status')->default(1);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('artists')) {
            return;
        }

        Schema::table('artists', function (Blueprint $table) {
            if (Schema::hasColumn('artists', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
