<?php

namespace App\Http\Controllers\MainPage;

use App\Http\Controllers\Controller;
use App\Models\News;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainPageController extends Controller
{
    public function index(){
        $today = Carbon::today();
        $news = News::whereDate('public_date', '<=', $today)->where('active', 1)->where('type', 'news')->orderBy('public_date', 'desc')->limit(6)->get();
        
        $setting = DB::table('settings')
                ->where('type', 'seo')
                ->first();

        $seo = json_decode($setting->value);
        
        
        $data = [
            'title' => 'Головна',
            'news' => $news,
            'seo' => $seo
        ];



        return view('main_page.index', $data); 
    }
}
