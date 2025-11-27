<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipmentRequest;
use Symfony\Component\HttpFoundation\Request;

class EquipmentRequestController extends Controller
{
    public function index(){

        $requests = EquipmentRequest::orderBy('active', 'asc')
            ->with('user')
            ->paginate(50);



        $data = [
            'title' => 'Equipment Requests',
            'items' => $requests,
            'search' => ''
        ];

        return view('admin.equipment_request.list', $data);
    }

    public function search(Request $request){

        $search = $request['search'];

        $q = EquipmentRequest::orderBy('active', 'asc')
            ->with('user');


        if($search){
            $q->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('code', 'LIKE', '%'.$search.'%');
        }

        $requests = $q->paginate(50);


        $data = [
            'title' => 'Equipment Requests',
            'items' => $requests,
            'search' => $search
        ];

        return view('admin.equipment_request.list', $data);
    }

}
