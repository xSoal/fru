<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    public function index(Request $request, $user_for_chat_view_id){
        $user_for_chat_view = User::where('id', $user_for_chat_view_id)->first();

        // проверка, что если роль не не админ, переписки смотреть можно только свои
        if(in_array($user_for_chat_view->role, ['0','1'])){
            $current_user_id = Auth::id();
            if($current_user_id !== (int)$user_for_chat_view_id){
                abort(404);
            }
        }

        $chats = [];

        if((int)$user_for_chat_view->role === 1){
            $chats = Conversation::where('user_one_id', $user_for_chat_view_id) 
                ->with(['messages', 'userOne', 'userTwo'])
                ->get();
        }

        if((int)$user_for_chat_view->role === 0){
            $chats = Conversation::where('user_two_id', $user_for_chat_view_id) 
                ->with(['messages', 'userOne', 'userTwo'])
                ->get();
        }



        $data = [
            'chats' => $chats,
            'user_for_chat_view' => $user_for_chat_view
        ];

        return view('messenger.messenger', $data);
    }
}
