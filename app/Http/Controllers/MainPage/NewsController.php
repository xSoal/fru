<?php

namespace App\Http\Controllers\MainPage;

use App\Http\Controllers\Controller;
use App\Models\News;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function single(Request $request, $slug){
        $type = $this->getNewsType($request->path());
        if(($type === 'rules' || $type === 'support') && !Auth::user()){
            return redirect()->route('login');
        }
        $today = Carbon::today();
        $newsItem = News::whereDate('public_date', '<=', $today)->where('type', $type)->where('active', 1)->where('slug', '=', $slug)->firstOrFail();
        
        $view_name = 'main_page.single_'.$this->getNewsType($request->path()); 
        return view($view_name)->with('newsItem', $newsItem);
    }

    public function allNews(Request $request){
        $type = $this->getNewsType($request->path());
        if(($type === 'rules' || $type === 'support') && !Auth::user()){
            return redirect()->route('login');
        }
        $today = Carbon::today();
        $news = News::whereDate('public_date', '<=', $today)->where('type', $type)->where('active', 1)->orderBy('public_date', 'desc')->paginate(9);
        return view('main_page.'.$type)->with('news', $news);
    }

    private function getNewsType(string $url) {
        $pattern = '~^/?([^/]+)~';
        preg_match($pattern, $url, $matches);
        $final_string = $matches[1] ?? 'news';
        return $final_string;
    }

    public function reference(){
        if(!Auth::user()){
            return redirect()->route('login');
        }
        $today = Carbon::today();
        $news = News::whereDate('public_date', '<=', $today)
        ->where('active', 1)
        ->where(function ($query) {
            $query->where('type', 'support')
                  ->orWhere('type', 'rules');
        })
        
        ->orderBy('public_date', 'desc')->paginate(9);
        return view('main_page.reference_information')->with('news', $news);
    }
}
