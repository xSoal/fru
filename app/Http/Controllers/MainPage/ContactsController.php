<?php

namespace App\Http\Controllers\MainPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;



class ContactsController extends Controller
{
    public function index(Request $request){
        $data = [];

        return view('main_page.contacts', $data);

    }

    public function submit(Request $request){
        $name = $request['name'];
        $phone = $request['phone'];
        $email = $request['email'];
        $message = $request['message'];


        $setting = DB::table('settings')
                ->where('type', 'email')
                ->first();

        $emailAdmin = $setting->value;

        $html = "
            <p>Им'я $name</p>
            <p>Телефон $phone</p>
            <p>Пошта $email</p>
            <p>Текст повідомлення $message</p>
        ";


        if ($emailAdmin) {
            $test = Mail::send([], [], function ($message) use ($emailAdmin, $html) {
                $message->to($emailAdmin)
                        ->subject("Нове повідомлення з форми зворотнього зв'язку")
                        ->html($html);
            });

        }

        $data = ['message' => 'Повідомлення відправлене'];

        return view('main_page.contacts', $data);

    }
}


