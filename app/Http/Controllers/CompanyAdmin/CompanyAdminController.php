<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;


use App\Models\EquipmentRequest;
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
        $company = User::where('id', $id)->firstOrFail(); 

        // СТРОГИЙ ПОРЯДОК ID
        $chat = Conversation::where('user_one_id', Auth::id()) // Убедитесь, что это всегда user_one_id
            ->where('user_two_id', $id) // Убедитесь, что это всегда user_two_id
            // ЖАДНО загружаем сообщения, отсортированные по убыванию (новые сверху)
            ->with(['messages' => function ($query) {
                $query->latest(); 
            }, 'userOne', 'userTwo']) 
            ->first();

        $messages = collect(); 
        $activeConversation = null;
        $currentUserId = Auth::id();

        if ($chat) {
            $activeConversation = $chat;
            
            $messages = $activeConversation->messages->values()->map(function ($message) use ($currentUserId) {
                $message->is_sender = $message->sender_id === $currentUserId;
                return $message;
            });
        }

        $equipmentsRequests = EquipmentRequest::where('user_id', $id)->latest()->get();

        $data = [
            'company' => $company, 
            'chat' => $chat,     // текущий
            'messages' => $messages, // Коллекция сообщений только из ПЕРВОГО чата
            'equipmentsRequests' => $equipmentsRequests
        ];

        // В шаблоне 'company_admin.company' теперь доступна переменная $messages
        return view('company_admin.client', $data);
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

        // // 2. Нормализация ID для поиска (самый маленький ID идет первым)
        // $userOneId = min($senderId, $receiverId);
        // $userTwoId = max($senderId, $receiverId);
        
         // СТРОГИЙ ПОРЯДОК ID
        $conversation = Conversation::firstOrCreate([
            'user_one_id' => $senderId,
            'user_two_id' => $receiverId,
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


    public function search(Request $request){
        $search = trim($request->input('search'));
        $perPage = 1;

        if(!$search){
            // Создание пустого пагинатора, без запроса к БД
            $resultSearch = new LengthAwarePaginator(
                new Collection(), 
                0,
                $perPage,
                LengthAwarePaginator::resolveCurrentPage(),
                ['path' => $request->url(), 'query' => $request->query()]
            );

        } else {
            $searchPattern = '%' . $search . '%';
            $resultSearch = EquipmentRequest::where('country', 'LIKE', $searchPattern)
                ->with('user')
                ->paginate($perPage)
                ->appends(['search' => $search]);
        }
        // dd($resultSearch);
        $data = [
            'search' => $search,
            'resultSearch' => $resultSearch
        ];

        return view('company_admin.search', $data);
    }




}
