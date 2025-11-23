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

        $paginate = 25;

        $getItems = function($search) use ($paginate, $request) {
            if(!$search){
                return News::where('type', $this->getNewsType($request->path()))->orderBy('public_date', 'desc')->paginate($paginate);
            }
            return News::where('type', $this->getNewsType($request->path()))
                ->where('title', 'LIKE', '%' . $search . '%' )
                ->orderBy('public_date', 'desc')
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

        $view_name = 'admin.'.$this->getNewsType($request->path()).'.list'; 
        return 	view($view_name, $data);
		
	}

    public function post(News $news, Request $request){
        $type = $request->path();
        $type = str_replace('admin/', '', $type);

        $input = $request->except('_token');

        //-----------------------------------------------------------------
        if( isset($input['save']) || isset($input['save_and_exit']) ){
            $news->fill($input);
            $news->slug = Str::slug($input['title']);

            $type = $this->getNewsType($request->path());
            if($type === 'rules' || $type === 'support'){
                $news->slug = $type . '-' . Str::slug($input['title']);
            }
            
            if( $news->save() ){
                
                if( isset($input['save_and_exit']) ){
                    $view_name = 'admin.'.$this->getNewsType($request->path()); 
                    return redirect()->route($view_name)->with('status','Додано');
                }else{
                    $view_name = 'admin.add_'.$this->getNewsType($request->path()); 
                    return redirect()->route($view_name)->with('status','Додано');
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
                    $view_name = 'admin.'.$this->getNewsType($request->path()); 
                    return redirect()->route($view_name)->with('status','Оновлено');
                }else{
                    $view_name = 'admin.view_'.$this->getNewsType($request->path()); 
                    return redirect()->route($view_name, ['id'=> $input['id'] ] )->with('status','Оновлено');
                }
            }
        }
        //-----------------------------------------------------------------


        //-----------------------------------------------------------------
        if( isset($input['dell']) ){
            $tmp = News::where('id',$input['id'])->first();
            $tmp->delete();
            $view_name = 'admin.'.$this->getNewsType($request->path()); 
            return redirect()->route($view_name)->with('status','Вилучено');
        }
        //-----------------------------------------------------------------


        $view_name = 'admin.'.$this->getNewsType($request->path()); 
        return redirect()->route($view_name);
        
    }

    public function add(Request $request){
        $data = [
            'title' => 'Новини',
            'search' => '',
        ];
        $view_name = 'admin.'.$this->getNewsType($request->path()).'.edit'; 
        return 	view($view_name,$data);
    }

    public function view(Request $request, $id){

        $item = News::where('id', '=', $id)->first();

        
        $data = [
                'title' => 'Редагувати',
                'item' => $item,
            ];

        $view_name = 'admin.'.$this->getNewsType($request->path()).'.edit'; 
        return 	view($view_name, $data);
    
    }


    private function getNewsType(string $input_string) {
        $pattern = '~^/?([^/]+)~';
        preg_match($pattern, $url, $matches);
        $final_string = $matches[1] ?? 'news';
        return $final_string;
    }
}
