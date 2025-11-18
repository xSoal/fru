<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
    ];

    /**
     * Чат, к которому относится сообщение.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Отправитель сообщения (компания/пользователь).
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
