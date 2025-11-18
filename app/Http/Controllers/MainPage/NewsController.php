<?php

namespace App\Http\Controllers\MainPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\News;

class NewsController extends Controller
{
    public function single(Request $request, $slug){
        $newsItem = News::where('slug', '=', $slug)->firstOrFail();

        return view('main_page.singleNews')->with('newsItem', $newsItem);
    }

    public function allNews(){
        $news = News::latest()->paginate(6);

        return view('main_page.news')->with('news', $news);
    }
}
