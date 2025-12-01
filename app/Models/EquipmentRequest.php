<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class EquipmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'code', 
        'name', 
        'model', 
        'manufacturer', 
        'country', 
        'quantity', 
        'active'
    ];

    /**
     * Відношення: Заявка належить Користувачу.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Реєструємо замикання подій моделі (Model Events).
     */
    protected static function boot()
    {
        parent::boot();

        // --- Подія: Створення нового запису (CREATE) ---
        static::created(function (EquipmentRequest $equipmentRequest) {
            self::sendNotification($equipmentRequest, 'created');
        });

        // --- Подія: Оновлення існуючого запису (UPDATE) ---
        static::updated(function (EquipmentRequest $equipmentRequest) {
            // Відправляємо лише якщо щось реально змінилося
            if ($equipmentRequest->isDirty()) {
                self::sendNotification($equipmentRequest, 'updated');
            }
        });
    }

    /**
     * Логіка відправлення повідомлення адміністратору.
     */
    private static function sendNotification(EquipmentRequest $equipmentRequest, string $action): void
    {
        // 1. Отримання email адміністратора
        $setting = DB::table('settings')->where('type', 'email')->first();
        $emailAdmin = $setting->value ?? null;
        
        // Пропускаємо відправку, якщо email не знайдено
        if (!$emailAdmin) {
            return;
        }

        $userName = Auth::check() ? Auth::user()->name : 'Система/Гість';
        
        $subject = ($action === 'created') 
            ? "НОВИЙ ЗАПИТ на обладнання" 
            : "ЗМІНА ЗАПИТУ на обладнання ID: {$equipmentRequest->id}";
        
        // 2. Генерація тіла листа
        $html = self::generateEmailBody($equipmentRequest, $action, $userName);
        
        // 3. Відправка листа
        Mail::send([], [], function ($message) use ($emailAdmin, $html, $subject) {
            // Рекомендується використовувати queue() для асинхронної відправки
            $message->to($emailAdmin)
                    ->subject($subject)
                    ->html($html); 
        });

        Log::create([
            'type' => 'request',
            'value' => $html
        ]);

    }

    /**
     * Формує HTML-тіло листа, включаючи деталі змін при редагуванні.
     */
    private static function generateEmailBody(EquipmentRequest $equipmentRequest, string $action, string $userName): string
    {
        $fields = [
            'code' => 'Код', 
            'name' => 'Назва', 
            'model' => 'Модель', 
            'manufacturer' => 'Виробник', 
            'country' => 'Країна', 
            'quantity' => 'Кількість',
            'active' => 'Активний',
        ];
        
        $output = '';

        // Функція для форматування значення (для булевих полів)
        $formatValue = fn($key, $value) => $key === 'active' ? ($value ? 'Так' : 'Ні') : $value;

        if ($action === 'created') {
            // Якщо створено, виводимо всі поля
            foreach ($fields as $key => $label) {
                $value = $equipmentRequest->$key;
                $output .= "<p>{$label}: <b>{$value}</b></p>";
            }
        } elseif ($action === 'updated') {
            // Якщо оновлено, виводимо тільки зміни (Було -> Стало)
            $changedFields = $equipmentRequest->getDirty();
            
            foreach ($changedFields as $key => $newValue) {
                // Ігноруємо timestamps та поля, які не потрібно відображати
                if (!array_key_exists($key, $fields)) continue;

                $oldValue = $equipmentRequest->getOriginal($key);
                $label = $fields[$key];

                $output .= "
                    <p style='margin-bottom: 5px;'>
                        <b>{$label}</b> змінено:
                    </p>
                    <ul style='list-style-type: none; padding-left: 15px; margin: 0;'>
                        <li><span style='color: gray;'>Було:</span> {$formatValue($key, $oldValue)}</li>
                        <li><span style='color: darkred;'>Стало:</span> <b>{$formatValue($key, $newValue)}</b></li>
                    </ul>
                    <hr style='margin: 10px 0; border: 0; border-top: 1px dashed #eee;'>
                ";
            }
        }

        // Базовий HTML-шаблон листа
        $created_at = $equipmentRequest->created_at ? $equipmentRequest->created_at->format('Y-m-d H:i') : 'N/A';
        
        $html = "
            <div style='font-family: sans-serif; padding: 15px; border: 1px solid #ddd;'>
                <h3 style='color: " . ($action === 'created' ? 'green' : 'orange') . ";'>
                    " . ($action === 'created' ? 'Новий Запит' : 'Запит Змінено') . "
                </h3>
                <p>Користувач: <b>{$userName}</b></p>
                <p>Код Заявки: <b>{$equipmentRequest->code}</b></p>
                <hr>
                
                " . ($action === 'created' ? '<h4>Деталі заявки:</h4>' : '<h4>Змінені поля:</h4>') . "
                
                {$output}
                
                <p style='margin-top: 20px;'>Створено: {$created_at}</p>
            </div>
        ";
        
        return $html;
    }
}