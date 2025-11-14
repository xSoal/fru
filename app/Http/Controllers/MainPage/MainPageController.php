<?php

namespace App\Http\Controllers\MainPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\News;

class MainPageController extends Controller
{
    public function index(){
        $news = News::limit(6)->get();
        $data = [
            'title' => 'Головна',
            'news' => $news
        ];

        return view('main_page.index', $data); 
    }
}
