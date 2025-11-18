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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // Ссылка на родительский чат
            $table->foreignId('conversation_id')
                  ->constrained() // По умолчанию ищет таблицу conversations
                  ->onDelete('cascade'); // При удалении чата, удаляются и все сообщения

            // ID пользователя/компании, который отправил сообщение
            $table->foreignId('sender_id') 
                  ->constrained('users')
                  ->onDelete('cascade');
                  
            $table->text('content'); // Текст сообщения
            $table->integer('is_read')->default(0);          
            // Индекс для быстрого поиска сообщений по чату
            $table->index('conversation_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
