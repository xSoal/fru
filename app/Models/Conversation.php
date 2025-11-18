<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one_id',
        'user_two_id',
    ];

    /**
     * Сообщения в этом чате.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Первый участник чата.
     */
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    /**
     * Второй участник чата.
     */
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }
}
