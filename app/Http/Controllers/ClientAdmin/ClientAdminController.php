<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;

use App\Models\EquipmentRequest;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;


class ClientAdminController extends Controller
{
    public function index($clientId){
        $equipmentRequests = EquipmentRequest::where('user_id', $clientId)->get();

        $data = [
            'clientId' => $clientId,
            'client' => User::where('id', $clientId)->first(),
            'equipmentRequests' => $equipmentRequests,
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
        $equipmentRequest->active = isset($input["active"]) && $input['active'] === 'on';

        if( $equipmentRequest->save() ){
            // $setting = DB::table('settings')
            //     ->where('type', 'email')
            //     ->first();

            // $emailAdmin = $setting->value;

            // $userName = Auth::user()->name;
            // $code = $equipmentRequest->code;
            // $name = $equipmentRequest->name;
            // $model = $equipmentRequest->model;
            // $manufacturer = $equipmentRequest->manufacturer;
            // $country = $equipmentRequest->country;
            // $quantity = $equipmentRequest->quantity;
            // $created_at = $equipmentRequest->created_at;

            // $html = "
            //     <p>Користувач <h6>$userName</h6></p>
            //     <p>Додав запит на обладнання:</p>
            //     <p>Code : $code</p>
            //     <p>Назва : $name</p>
            //     <p>Модель : $model</p>
            //     <p>Виробник : $manufacturer</p>
            //     <p>Країна : $country</p>
            //     <p>Кількість : $quantity</p>
            //     <p>Створено : $created_at</p>
            // ";


            // if ($emailAdmin) {
            //     $test = Mail::send([], [], function ($message) use ($emailAdmin, $html) {
            //         $message->to($emailAdmin)
            //                 ->subject("Нове повідомлення з форми зворотнього зв'язку")
            //                 ->html($html);
            //     });

            // }


            return redirect()->route('admin.clientAdmin', ['clientId' => Auth::id()])
                ->with(
                    ['status' => 'Request was added']
                );
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

        $equipmentRequest->active = isset($input["active"]) && $input['active'] === 'on';


        if( $equipmentRequest->update() ){
            return redirect()->route('admin.clientAdmin', Auth::id())->with('status','Request was edited');
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


    public function partnersList($clientId){
        $partners = User::where('role', 1)->where('active', 1)->get();
        $data = [
            'partners' => $partners,
            'client' => User::where('id', $clientId)->first(),
            'clientId' => $clientId
        ];

        return view('client_admin.partners', $data);
    }


    public function partnerSingle($id, $clientId){
        $partner = User::where('id', $id)->where('active', 1)->firstOrFail(); 

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
            'equipmentsRequests' => $equipmentsRequests,
            'client' => User::where('id', $clientId)->first(),
            'clientId' => $clientId
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

        return redirect()->route('admin.clientAdminPartnerSingle', ['id' => $receiverId, 'clientId' => Auth::id()]);
    }

    public function reference($clientId){
        $today = Carbon::today();
        $news = News::whereDate('public_date', '<=', $today)
            ->where('type', 'support')
            ->orWhere('type', 'rules')
            ->where('active', 1)
            ->orderBy('public_date', 'desc')
            ->get();

        $data =  [
            'news' => $news,
            'client' => User::where('id', $clientId)->first(),
            'clientId' => $clientId
        ];

        return view('client_admin.reference', $data);
    }


    public function updateRequestStatus(Request $request, $id){
        $equipment = EquipmentRequest::find($id);

        if (!$equipment) {
            return response()->json(['message' => 'Запис не знайдено'], 404);
        }

        $newStatus = $request->input('status');

        if (!in_array($newStatus, ['active', 'disabled'])) {
            return response()->json(['message' => 'Недійсне значення статусу'], 400);
        }


        $equipment->active = $newStatus === 'active' ? 1 : 0;
        $equipment->save();

        return response()->json(['message' => 'Статус успішно оновлено.'], 200);
    }

    public function service(Request $request, $clientId){

        $data =  [
            'client' =>  User::where('id', $clientId)->first(),
            'clientId' => $clientId
        ];

        return view('client_admin.service', $data);
    }


    public function updateUserData(Request $request, $userId){
        if((int)$userId !== Auth::user()->id){
            abort(403);
        }

        $user = User::findOrFail($userId);

        // $request->validate([
        //     'name' => 'required',
        // ], [
        //     'name' => 'Вы не можете отправить сообщение самому себе.'
        // ]);

        $validator = Validator::make($request->all(), [
            'name'  => 'required|max:255',
            'email' => [
                'required', 
                'email', 
                Rule::unique('users')->ignore($user->id)
            ],
            'description' => 'required|string',
            'phone' => 'required|max:255',
            'web_page' => 'required|max:255',
            'contact_person' => 'required|max:255',
            'password' => 'required_with:new_password',
            'new_password' => 'nullable|min:8|same:new_password_confirm',
        ]);

        $validator->after(function ($validator) use ($request, $user) {
            if ($request->filled('new_password')) {
                if (!Hash::check($request->password, $user->password)) {
                    $validator->errors()->add('password', 'Incorrect old password');
                }
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors() 
            ], 422);
        }

        $updateData = [];

        $updateData['name'] = $request->name;
        $updateData['email'] = $request->email;
        $updateData['description'] = $request->description;
        $updateData['phone'] = $request->phone;
        $updateData['web_page'] = $request->web_page;
        $updateData['contact_person'] = $request->contact_person;

        if($request->has('password') && $request->has('new_password')){
            $updateData['password'] = Hash::make($request->new_password);
        }


        $user->update($updateData);


        return response()->json([
            'message' => 'ok',
        ], 201);
    }


}
