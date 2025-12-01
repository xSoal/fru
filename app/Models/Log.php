<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'value',
    ];

    /**
     * Визначає, чи потрібні мітки часу (timestamps).
     * За замовчуванням (true) будуть використовуватися created_at та updated_at.
     *
     * @var bool
     */
    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
