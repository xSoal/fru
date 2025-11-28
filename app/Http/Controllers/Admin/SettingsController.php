<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{
    public function index(){

        $setting = DB::table('settings')
                     ->where('type', 'email')
                     ->first();

        $email = $setting->value;             
        $data = [
            'title' => 'Налаштування',
            'email' => $email
        ];
        return view('admin.settings.list', $data);
    }

    public function updateEmail(Request $request){
        $newEmail = $request['email'];

        $updated = DB::table('settings')
                     ->where('type', 'email')
                     ->update([
                         'value' => $newEmail,
                         'updated_at' => now() 
                     ]);
        
        
        if ($updated) {
            return redirect()->back()->with('success', 'Email оновлено');
        } else {
            return redirect()->back()->with('error', 'Помилка.');
        }
    }
}
