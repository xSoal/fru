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
        Schema::table('settings', function (Blueprint $table) {
            DB::table('settings')->insert([
                'type' => 'seo',
                'value' => '{"meta_title":"","meta_description":"","meta_keywords":"","og_title":"","og_description":"","og_img":""}',
                'created_at' => now(), 
                'updated_at' => now(), 
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            DB::table('settings')
                ->where('type', 'seo')
                ->delete();
        });
    }
};
