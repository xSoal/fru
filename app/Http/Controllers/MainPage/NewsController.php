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
            abort('404');
        }
        $today = Carbon::today();
        $newsItem = News::whereDate('public_date', '<=', $today)->where('type', $type)->where('active', 1)->where('slug', '=', $slug)->firstOrFail();
        
        $view_name = 'main_page.single_'.$this->getNewsType($request->path()); 
        return view($view_name)->with('newsItem', $newsItem);
    }

    public function allNews(Request $request){
        $type = $this->getNewsType($request->path());
        if(($type === 'rules' || $type === 'support') && !Auth::user()){
            abort('404');
        }
        $today = Carbon::today();
        $paginate = 6;
        if($type === 'support' || $type === 'rules'){
            $paginate = 9;
        }
        $news = News::whereDate('public_date', '<=', $today)->where('type', $type)->where('active', 1)->orderBy('public_date', 'desc')->paginate($paginate);
        return view('main_page.'.$type)->with('news', $news);
    }

    private function getNewsType(string $input_string) {
       // Регулярное выражение для поиска всего, КРОМЕ:
        // 1. Пробельных символов (\s)
        // 2. Слов 'news', 'support', 'rules'
        
        // Шаблон: [^...] - означает "не символ из списка".
        // (news|support|rules) - это позитивный список, который мы ИСКЛЮЧАЕМ из удаления.
        // \s - исключаем пробелы.
        
        $pattern = '/[^\s]*(news|support|rules)[^\s]*(*SKIP)(*FAIL)|[^\s]+/i';
        
        // *SKIP)(*FAIL) - это более продвинутый метод, который позволяет пропустить 
        // найденные ключевые слова и обработать только остальной текст.
        // Однако для простоты и эффективности, часто используют подход с заменой.
    
        // --- Более простой и часто используемый подход ---
        
        // 1. Сначала удаляем все, что НЕ является ключевым словом, пробелом или границей слова.
        // 2. Затем удаляем лишние пробелы.
    
        // Шаблон для поиска всего, что не является буквой, пробелом или одним из ключевых слов.
        // В данном случае, проще всего инвертировать.
    
        // Ищем все, что НЕ является (news|support|rules|\s) и заменяем на пробел.
        // Затем удаляем повторяющиеся пробелы и пробелы по краям.
        
        // Шаг 1: Оставляем только ключевые слова и пробелы, заменяя все остальное на один пробел.
        // /[^a-z\s]/i - ищет все, что не является буквой A-Z или пробелом.
        $temp_string = preg_replace('/[^a-z\s]/i', ' ', $input_string);
        
        // Шаг 2: Удаляем лишние пробелы (оставляем только одинарные).
        $temp_string = preg_replace('/\s+/', ' ', $temp_string);
        
        // Шаг 3: Очищаем строку от всех слов, которые НЕ являются целевыми (news, support, rules).
        // Мы заменяем ЛЮБОЕ слово (\w+) на пустую строку, ЕСЛИ оно не совпадает с (news|support|rules).
        // (\b(news|support|rules)\b) - это слова, которые мы хотим СОХРАНИТЬ.
        // *SKIP|(*FAIL) заставляет движок пропустить совпадения, которые мы хотим сохранить.
        // \w+ - это любое слово, которое мы хотим удалить.
        $final_string = preg_replace('/\b(news|support|rules)\b(*SKIP)(*FAIL)|\w+/i', '', $temp_string);
        
        // Шаг 4: Удаляем пробелы по краям и лишние пробелы (снова, если появились).
        $final_string = trim(preg_replace('/\s+/', ' ', $final_string));
        
        return $final_string;
    }
}
