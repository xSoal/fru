<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'is_read'
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

    public function setMessageReadStatus(){
        unset($this->is_sender);
        $this->is_read = 1;
        return $this->update();
    }

/**
     * Реєструємо замикання подій моделі (Model Events).
     */
    protected static function boot()
    {
        parent::boot();

        // --- Подія: Створення нового повідомлення (CREATE) ---
        // Логуємо та сповіщаємо адміністратора про нове повідомлення.
        static::created(function (Message $message) {
            self::sendNotification($message, 'created');
        });

        // Подію 'updated' ми не обробляємо, оскільки повідомлення рідко редагуються.
    }

    /**
     * Логіка відправлення повідомлення адміністратору та логування.
     */
    private static function sendNotification(Message $message, string $action): void
    {
        // 1. Отримання email адміністратора
        $setting = DB::table('settings')->where('type', 'email')->first();
        $emailAdmin = $setting->value ?? null;
        
        // Пропускаємо відправку, якщо email не знайдено
        if (!$emailAdmin) {
            return;
        }

        // 2. Визначення відправника
        $sender = $message->sender;
        $senderName = $sender ? $sender->name : 'Невідомий користувач';
        
        $subject = "НОВЕ ПОВІДОМЛЕННЯ у чаті ID: {$message->conversation_id}";
        
        // 3. Генерація тіла листа
        $html = self::generateEmailBody($message, $senderName);
        
        // 4. Відправка листа
        Mail::send([], [], function ($msg) use ($emailAdmin, $html, $subject) {
            $msg->to($emailAdmin)
                ->subject($subject)
                ->html($html); 
        });

        // 5. Логування (якщо ви вже створили модель Log)
        Log::create([
            'user_id' => $message->sender_id, // Зберігаємо ID відправника
            'type' => 'message_new',
            // 'value' => "Надіслано повідомлення у чаті ID {$message->conversation_id}. Відправник: {$senderName}. Вміст: " . substr($message->content, 0, 100) . "...",
            'value' => $html
        ]);
    }

    /**
     * Формує HTML-тіло листа для нового повідомлення.
     */
    private static function generateEmailBody(Message $message, string $senderName): string
    {
        $created_at = $message->created_at ? $message->created_at->format('Y-m-d H:i') : 'N/A';
        $isRead = $message->is_read ? 'Так' : 'Ні';
        
        $html = "
            <div style='font-family: sans-serif; padding: 15px; border: 1px solid #ddd; background-color: #f4f7fb;'>
                <h3 style='color: green;'>
                    Нове Повідомлення в Чаті
                </h3>
                <p>Відправник: <b>{$senderName}</b></p>
                <p>ID Чату: <b>{$message->conversation_id}</b></p>
                <hr style='border: 0; border-top: 1px solid #ccc;'>
                
                <h4>Текст повідомлення:</h4>
                <div style='padding: 15px; border-left: 3px solid #157c57; background-color: white; margin: 15px 0;'>
                    {$message->content}
                </div>
                
                <!-- <p>Статус: " . ($isRead === 'Так' ? 'Прочитано' : '<b>Не прочитано</b>') . "</p> -->
                <p style='margin-top: 20px;'>Час відправки: {$created_at}</p>
            </div>
        ";
        
        return $html;
    }


}
