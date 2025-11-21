<?php

namespace App\Http\Controllers\MainPage;

use App\Http\Controllers\Controller;
use App\Models\News;

use Carbon\Carbon;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function index(){
        $today = Carbon::today();
        $news = News::whereDate('public_date', '<=', $today)->where('active', 1)->orderBy('public_date', 'desc')->limit(6)->get();
        $data = [
            'title' => 'Головна',
            'news' => $news
        ];

        return view('main_page.index', $data); 
    }
}
