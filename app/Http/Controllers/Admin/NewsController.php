<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\News;
use Illuminate\Support\Str;


// use Carbon\Carbon;

class NewsController extends Controller
{
    public function list(Request $request){
        $search = trim($request->input('search', ''));

        $input = $request->except('_token');

        $paginate = 5;
        
        $getItems = function($search) use ($paginate) {
            if(!$search){
                return News::orderBy('public_date', 'desc')->paginate($paginate);
            }
            return News::where('title', 'LIKE', '%' . $search . '%' )
                ->orderBy('public_date', 'asc')
                ->paginate($paginate);
        };
        $items = $getItems($search);

        
        if( $request['page']==null ){
            $request['page'] = 1;
        }

        $page = $paginate * ($request['page']-1);
                
        $data = [
                'title' => 'Новини',
                'search' => $search,
                'items' => $items,
                'page' => $page,
            ];


        return 	view('admin.news.list',$data);
		
	}

    public function post(News $news, Request $request){

        $input = $request->except('_token');

        //-----------------------------------------------------------------
        if( isset($input['save']) || isset($input['save_and_exit']) ){
            $news->fill($input);
            $news->slug = Str::slug($input['title']);
            if( $news->save() ){

                if( isset($input['save_and_exit']) ){
                    return redirect()->route('admin.news')->with('status','Додано');
                }else{
                    return redirect()->route('admin.addNews')->with('status','Додано');
                }
            }
        }
        //-----------------------------------------------------------------

        //-----------------------------------------------------------------
        if( isset($input['update']) || isset($input['update_and_exit']) ){

            $project = News::find($input['id']); 
            $project->fill($input);

            if( $project->update() ){
                if( isset($input['update_and_exit']) ){
                    return redirect()->route('admin.news')->with('status','Оновлено');
                }else{
                    return redirect()->route('admin.viewNews', ['id'=> $input['id'] ] )->with('status','Оновлено');
                }
            }
        }
        //-----------------------------------------------------------------


        //-----------------------------------------------------------------
        if( isset($input['dell']) ){
            $tmp = News::where('id',$input['id'])->first();
            $tmp->delete();
            return redirect()->route('admin.news')->with('status','Вилучено');
        }
        //-----------------------------------------------------------------



        return redirect()->route('admin.news');
        
    }

    public function add(){
        $data = [
            'title' => 'Новини',
            'search' => '',
        ];
        return 	view('admin.news.edit',$data);
    }

    public function view($id){

        $item = News::where('id', '=', $id)->first();

        
        $data = [
                'title' => 'Редагувати',
                'item' => $item,
            ];
        return 	view('admin.news.edit',$data);
    
    }
}
