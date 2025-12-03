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
        DB::table('settings')->insert([
            'type' => 'titles',
            'value' => '{"main":"","contacts":"","search":"","news":"","login":"","reference":"","support":"","rules":""}',
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            DB::table('settings')
                ->where('type', 'titles')
                ->delete();
        });
    }
};
