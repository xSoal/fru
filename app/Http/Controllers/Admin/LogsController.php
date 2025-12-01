<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(){
        $items = Log::with('user')->orderBy('created_at', 'desc')->paginate(25);

        $data = [
            'title' => 'Логіювання',
            'items' => $items,
            'search' => ''
        ]; 

        return view('admin.logs.list', $data);
    }

    public function search(Request $request){
        $search = $request['search'];

        $items = Log::where('value', 'LIKE', "%$search%")
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        $data = [
            'title' => 'Логіювання',
            'items' => $items,
            'search' => $search
        ]; 

        return view('admin.logs.list', $data);
    }
}
