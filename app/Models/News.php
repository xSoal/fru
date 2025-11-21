<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'content',
        'slug',
        'public_date',
        'active',
        'created_at',
        'updated_at'
    ];

    
    protected function publicDateFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->formatUkrainianDate($this->attributes['public_date']),
        );
    }

    /**
     * Функция форматирования даты (используется внутри аксессора).
     *
     * @param string|null $dateString Дата в формате '2025-11-21' или '0000-00-00'.
     * @return string Преобразованная дата или пустая строка.
     */
    protected function formatUkrainianDate(?string $dateString): string
    {
        // 1. Проверка на "пустую" или "нулевую" дату
        if (empty($dateString) || $dateString === '0000-00-00') {
            return '';
        }

        try {
            // 2. Создание объекта Carbon из значения
            $date = Carbon::parse($dateString);

            // 3. Установка локали
            $date->setLocale('uk');

            // 4. Форматирование даты в "21 листопада 2025"
            return $date->isoFormat('D MMMM YYYY');
            
        } catch (\Exception $e) {
            return ''; // Можно вернуть ошибку или пустую строку
        }
    }

}
