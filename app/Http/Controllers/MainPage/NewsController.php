<?php

namespace App\Http\Controllers\MainPage;

use App\Http\Controllers\Controller;
use App\Models\News;

use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function single(Request $request, $slug){
        $today = Carbon::today();
        $newsItem = News::whereDate('public_date', '<=', $today)->where('slug', '=', $slug)->firstOrFail();
        return view('main_page.singleNews')->with('newsItem', $newsItem);
    }

    public function allNews(){
        $today = Carbon::today();
        $news = News::whereDate('public_date', '<=', $today)->orderBy('public_date', 'desc')->paginate(6);
        return view('main_page.news')->with('news', $news);
    }
}
