<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;

use App\Models\EquipmentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ClientAdminController extends Controller
{
    public function index(){
        $equipmentRequests = EquipmentRequest::where('user_id', Auth::id())->get();

        $data = [
            'client' => Auth::user(),
            'equipmentRequests' => $equipmentRequests
        ];

        return view('client_admin.index', $data);
    }


    public function addRequestEquipment(Request $request){
        $input = $request->except('_token');
        $equipmentRequest = new EquipmentRequest();
        $equipmentRequest->fill($input);
        $equipmentRequest->user_id = Auth::id();
        $count = EquipmentRequest::where('user_id', Auth::id())->count();
        $equipmentRequest->code = 1000 + +(Auth::id()) . '-' . $count + 1;

        if( $equipmentRequest->save() ){
            return redirect()->route('admin.clientAdmin')->with('status','Request was added');
        }
        
    }

    public function editRequestEquipment(Request $request){
        $input = $request->except('_token');
        $equipmentRequest = EquipmentRequest::findOrFail($input['id']);
        $equipmentRequest->name = $input["name"];
        $equipmentRequest->model = $input["model"];
        $equipmentRequest->manufacturer = $input["manufacturer"];
        $equipmentRequest->country = $input["country"];
        $equipmentRequest->quantity = $input["quantity"];

        if( $equipmentRequest->save() ){
            return redirect()->route('admin.clientAdmin')->with('status','Request was edited');
        }
    }


    public function messagesList(){
        $chats = Conversation::where('user_two_id', Auth::id())
            ->with(['messages' => function ($query) {
                $query->latest(); 
            }, 'userOne', 'userTwo']) 
            ->get();
        
        return view('client_admin.dialoges', $data);    
    }


    public function partnersList(){
        $partners = User::where('role', 1)->get();
        $data = [
            'partners' => $partners
        ];

        return view('client_admin.partners', $data);
    }


    public function partnerSingle($id){
        $partner = User::where('id', $id)->firstOrFail(); 

        // СТРОГИЙ ПОРЯДОК ID
        $chat = Conversation::where('user_one_id', $id) // Убедитесь, что это всегда user_one_id
            ->where('user_two_id', Auth::id()) // Убедитесь, что это всегда user_two_id
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
            'partner' => $partner, 
            'chat' => $chat,     // текущий
            'messages' => $messages, // Коллекция сообщений только из ПЕРВОГО чата
            'equipmentsRequests' => $equipmentsRequests
        ];

        // В шаблоне 'company_admin.company' теперь доступна переменная $messages
        return view('client_admin.partnerSingle', $data);
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
            'user_one_id' => $receiverId,
            'user_two_id' => $senderId,
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

        return redirect()->route('admin.clientAdminPartnerSingle', ['id' => $receiverId]);
    }



}
