<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    public function index(){
        if(Auth::user()->role !== 3) abort(403);

        $items = Log::with('user')->orderBy('created_at', 'desc')->paginate(25);

        $data = [
            'title' => 'Логіювання',
            'items' => $items,
            'search' => ''
        ]; 

        return view('admin.logs.list', $data);
    }

    public function search(Request $request){
        if(Auth::user()->role !== 3) abort(403);
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
