<?php

namespace App\Http\Controllers\SuperAdminCabinet;

use App\Http\Controllers\Controller;
use App\Models\Conversation;


use App\Models\EquipmentRequest;
use App\Models\Message;

use App\Models\News;


use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class SuperAdminCabinetController extends Controller
{
    
    public function index(User $user, Request $request){
        $clients = User::where('role', '=', '0')->where('active',1)->get();

        $data = [
            'clients' => $clients,
        ];

        return 	view('super_admin.index', $data);
    }


    public function client($id) {
        $client = User::where('id', $id)->where('active', 1)->firstOrFail(); 


        $equipmentsRequests = EquipmentRequest::where('user_id', $id)
            ->where('active', 1)
            ->latest()
            ->get();

        $data = [
            'client' => $client, 
            'equipmentsRequests' => $equipmentsRequests, 
            'user_target' => $client
        ];

        // В шаблоне 'company_admin.company' теперь доступна переменная $messages
        return view('super_admin.client', $data);
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
        // $companyId = $request->company_id;
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

        // $client = User::where('id', '=', $receiverId)->firstOrFail();

        return redirect()->route('admin.companyAdminClient', ['id' => $receiverId, 'companyId' =>  Auth::id()]);
    }


    public function search(Request $request, $companyId){
        $search = trim($request->input('search'));
        $perPage = 25;
        $user = User::where('id', $companyId)->first();

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

        $data = [
            'search' => $search,
            'resultSearch' => $resultSearch,
            'user' => $user,
            'companyId' => $companyId
        ];

        return view('company_admin.search', $data);
    }


    public function equipment(){

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
        ];


        return view('super_admin.equipment', $data);
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
        ];


        return view('super_admin.equipment', $data);
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
        ];

        return view('super_admin.reference', $data);
    }

    public function service(){
        $services = User::where('is_service', '=', 1)->get();

        $data =  [
            'services' => $services
        ];

        return view('super_admin.service', $data);
    }

    
    public function serviceSingle(Request $request, $serviceId){
        $service = User::where('id', $serviceId)->firstOrFail();
        $data =  [
            'service' => $service
        ];

        return view('super_admin.serviceSingle', $data);
    }




    public function partnersList(){
        $partners = User::where('role', 1)->where('active', 1)->get();
        $data = [
            'partners' => $partners,
        ];

        return view('super_admin.partners', $data);
    }


    public function partnerSingle($id){
        $partner = User::where('id', $id)->where('active', 1)->firstOrFail(); 


        $data = [
            'partner' => $partner,
            'user_target' => $partner
        ];

        return view('super_admin.partnerSingle', $data);
    }



}
