<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use App\Models\EquipmentRequest;

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

}
