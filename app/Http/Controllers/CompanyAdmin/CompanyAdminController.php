<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;


use App\Models\EquipmentRequest;
use App\Models\Message;

use App\Models\News;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class CompanyAdminController extends Controller
{
    
    public function index(User $user, Request $request){
        $user = User::where('id', '=', Auth::id())->firstOrFail();
        $clients = User::where('role', '=', '0')->where('active',1)->get();

        $data = [
            'user' => $user,
            'clients' => $clients
        ];


        return 	view('company_admin.index', $data);
    }


    public function client($id) {
        $company = User::where('id', $id)->where('active', 1)->firstOrFail(); 

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

        $equipmentsRequests = EquipmentRequest::where('user_id', $id)
            ->where('active', 1)
            ->latest()
            ->get();

        $data = [
            'company' => $company, 
            'chat' => $chat,     // текущий
            'messages' => $messages, // Коллекция сообщений только из ПЕРВОГО чата
            'equipmentsRequests' => $equipmentsRequests, 
            'user' => Auth::user()
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
        $perPage = 25;
        $user = Auth::user();

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
                ->where('active', 1)
                ->paginate($perPage)
                ->appends(['search' => $search]);
        }
        // dd($resultSearch);
        $data = [
            'search' => $search,
            'resultSearch' => $resultSearch,
            'user' => $user
        ];

        return view('company_admin.search', $data);
    }


    public function equipment(){
        $user = Auth::user();
        $e = EquipmentRequest::with('user')
            ->where('active', 1)
            ->paginate(25);
        
        $countriesWithCount = EquipmentRequest::select('country', DB::raw('COUNT(*) as count'))
            ->where('active', 1)    
            ->groupBy('country')
            ->orderBy('country', 'asc') 
            ->get();


        $data = [
            'resultSearch' => $e,
            'countries' => $countriesWithCount,
            'user' => $user
        ];


        return view('company_admin.equipment', $data);
    }


    public function equipmentSearch(Request $request, $filterStr){
  
        $allowedCountries = explode('|', $filterStr);

        $e = EquipmentRequest::whereIn('country', $allowedCountries)
            ->where('active', 1)
            ->with('user')
            ->paginate(25);

        $countriesWithCount = EquipmentRequest::select('country', DB::raw('COUNT(*) as count'))
            ->where('active', 1)
            ->groupBy('country')
            ->orderBy('country', 'asc') 
            ->get();


        $data = [
            'resultSearch' => $e,
            'countries' => $countriesWithCount,
            'allowedCountries' => $allowedCountries,
            'user' => Auth::user()
        ];


        return view('company_admin.equipment', $data);
    }

    public function reference(){
        $today = Carbon::today();
        $news = News::whereDate('public_date', '<=', $today)
            ->where('type', 'support')
            ->orWhere('type', 'rules')
            ->where('active', 1)
            ->orderBy('public_date', 'desc')
            ->get();

        $data =  [
            'news' => $news,
            'user' => Auth::user()
        ];

        return view('company_admin.reference', $data);
    }




}
