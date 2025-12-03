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
        Schema::table('logs', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users') 
                  ->onDelete('set null')
                  ->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            // 1. Видаляємо зовнішній ключ (constraint)
            $table->dropForeign(['user_id']); 
            
            // АБО краще (якщо використовували constrained()):
            // $table->dropConstrainedForeignId('user_id');
            
            // 2. Видаляємо сам стовпець
            $table->dropColumn('user_id'); 
        });
    }
};
