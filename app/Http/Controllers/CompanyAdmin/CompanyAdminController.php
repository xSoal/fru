<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;


use App\Models\Message;
use App\Models\User;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class CompanyAdminController extends Controller
{
    
    public function index(User $user, Request $request){
        $user = User::where('id', '=', Auth::id())->firstOrFail();
        $clients = User::where('role', '=', '0')->get();

        $data = [
            'user' => $user,
            'clients' => $clients
        ];

        return 	view('company_admin.index', $data);
    }


    public function client($id) {
        // 1. Находим пользователя (компанию)
        $company = User::where('id', $id)->firstOrFail(); 

        // 2. Находим ВСЕ чаты с жадной загрузкой
        $chats = Conversation::where(function ($query) use ($id) {
        $query->where('user_one_id', $id)
            ->orWhere('user_two_id', $id);
        })->with(['messages.sender', 'userOne', 'userTwo']) 
        ->get();

        // 3. Извлекаем сообщения из ПЕРВОГО найденного чата (если чаты существуют)
        $messages = collect(); // Создаем пустую коллекцию по умолчанию
        $activeConversation = null;
        $currentUserId = Auth::id();

        if ($chats->isNotEmpty()) {
            $activeConversation = $chats->first();
            $messages = $activeConversation->messages->map(function ($message) use ($currentUserId) {
                $message->is_sender = ($message->sender_id === $currentUserId);
                return $message;
            });
        }

        $data = [
            'company' => $company, // Объект компании
            'chats' => $chats,     // Коллекция ВСЕХ чатов пользователя
            'messages' => $messages // Коллекция сообщений только из ПЕРВОГО чата
        ];

        // В шаблоне 'company_admin.company' теперь доступна переменная $messages
        return view('company_admin.company', $data);
    }

    public function addMessage(Request $request){
        $request->validate([
            'receiver_id' => 'required|exists:users,id|not_in:' . Auth::id(),
            'content' => 'required|string|max:2000',
        ], [
            'receiver_id.not_in' => 'Вы не можете отправить сообщение самому себе.'
        ]);

        $senderId = Auth::id();
        $receiverId = (int) $request->receiver_id;
        $content = $request->input('content');

        // 2. Нормализация ID для поиска (самый маленький ID идет первым)
        $userOneId = min($senderId, $receiverId);
        $userTwoId = max($senderId, $receiverId);
        
        // 3. Поиск или создание чата (Conversation)
        $conversation = Conversation::firstOrCreate([
            'user_one_id' => $userOneId,
            'user_two_id' => $userTwoId,
        ]);
        
        // 4. Создание сообщения
        $message = $conversation->messages()->create([
            'sender_id' => $senderId,
            'content' => $content,
        ]);

        $company = User::where('id', '=', $receiverId)->firstOrFail();
        $data = [
            'company' => $company
        ];

        return redirect()->route('admin.companyAdminClient', ['id' => $receiverId]);
    }

}
