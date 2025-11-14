<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function post(Post $post, Request $request){

        $input = $request->except('_token');

        $pid = isset($input['pid']) ? $input['pid'] : '';
        //-----------------------------------------------------------------
        if( isset($input['save']) || isset($input['save_and_exit']) ){

            if( !isset($input['slug']) || $input['slug'] == '' ){
                $input['slug'] = Str::slug( mb_strtolower( str_replace('/','-',$input['name']) ) , '-','ru');
            }
            
            $post->fill($input);
            
            if( $post->save() ){
                if( isset($input['save_and_exit']) ){
                    return redirect()->route('admin.post')->with('status','Добавлен');
                }else{
                    return redirect()->route('admin.addPost',['pid' => $pid ] )->with('status','Добавлен');
                }
            }
        }
        //-----------------------------------------------------------------

        //-----------------------------------------------------------------
        if( isset($input['update']) || isset($input['update_and_exit']) ){

            if( !isset($input['slug']) || $input['slug'] == '' ){
                $input['slug'] = Str::slug( mb_strtolower( str_replace('/','-',$input['name']) ) , '-','ru');
            }

            $post = Post::find($input['id']); 
            $post->fill($input);

            if( $post->update() ){

                if( isset($input['update_and_exit']) ){
                    return redirect()->route('admin.post')->with('status','Обновлён');
                }else{
                    return redirect()->route('admin.viewPost', ['id'=> $input['id'] ] )->with('status','Обновлён');
                }
            }
        }
        //-----------------------------------------------------------------



        //-----------------------------------------------------------------
        if( isset($input['dell']) ){
            $tmp = Post::where('id',$input['id'])->first();
            $tmp->delete();
            return redirect()->route('admin.post')->with('status','Удалён');
        }
        //-----------------------------------------------------------------

        //-----------------------------------------------------------------
        if( isset($input['search']) && $input['search']!=null ){
            if(view()->exists('admin.post.list')){
                $search = $input['search'];
                $paginate = 25;

                $postP = array();
                $tmp = Post::get();
                foreach($tmp as $item){
                    $post[$item->id] = $item;
                    if( $item->parrent_id == 0 ){
                        $postP[] = $item;
                    }
                }
                
                $parrent_id = isset($input['parrent_id']) ? $input['parrent_id'] : '';

                $items = Post::where('name', 'LIKE', '%'.$search.'%');
                if( $parrent_id !='' ){
                    $items = $items->where('parrent_id',$parrent_id);
                }
                $items = $items->paginate($paginate);

                $post = array();
                $tmp = Post::get();
                foreach($tmp as $item){
                    $post[$item->id] = $item;
                }
                
                if( $request['page']==null ){
                    $request['page'] = 1;
                }
                $page = $paginate * ($request['page']-1);

                $data = [
                        'title' => 'Посади',
                        'items' => $items,
                        'search' => $search,
                        'page' => $page,
                        'post' => $post,
                        'postP' => $postP,
                        'parrent_id' => $parrent_id,
                    ];
                return 	view('admin.post.list',$data);
            }
            abort(404);
        }
        //-----------------------------------------------------------------


        return redirect()->route('admin.post');
        
    }

    
    public function view($id){
		if(view()->exists('admin.post.edit') ){

            $post = array();
            $postP = array();
            $tmp = Post::get();
            foreach($tmp as $item){
                $post[$item->id] = $item;
                if( $item->parrent_id == 0 ){
                    $postP[] = $item;
                }
            }
            
            $item = Post::where('id', '=', $id)->first();

            $data = [
					'title' => 'Редагувати',
					'item' => $item,
                    'post' => $post,
                    'postP' => $postP,
				];
			return 	view('admin.post.edit',$data);
		}
        abort(404);
    }

    public function add(Request $request){
		if(view()->exists('admin.post.edit') ){

            $input = $request->except('_token');
            $pid = isset($input['pid']) ? $input['pid'] : '';
            
            $post = array();
            $postP = array();
            $tmp = Post::get();
            foreach($tmp as $item){
                $post[$item->id] = $item;
                if( $item->parrent_id == 0 ){
                    $postP[] = $item;
                }
            }

            $data = [
                'title' => 'Додати',
                'post' => $post,
                'postP' => $postP,
                'pid' => $pid
                ];
			return 	view('admin.post.edit',$data);
		}
		abort(404);
	}
    
    public function list(Request $request){
		if(view()->exists('admin.post.list') ){
            $paginate = 25;

            $input = $request->except('_token');
            $parrent_id = isset($input['parrent_id']) ? $input['parrent_id'] : '';
            $search = isset($input['search']) ? $input['search'] : '';
            
            $post = array();
            $postP = array();
            $tmp = Post::get();
            foreach($tmp as $item){
                $post[$item->id] = $item;
                if( $item->parrent_id == 0 ){
                    $postP[] = $item;
                }
            }

            if( $parrent_id !='' || $search !='' ){
                $items = Post::where('created_at','<>','');
                
                if( $parrent_id !='' ){
                    $items = $items->where('parrent_id',$parrent_id);
                }

                if( $search !='' ){
                    $items = $items->where('name', 'LIKE', '%'.$search.'%');
                }
                
                $items = $items->paginate($paginate);

            }else{
                $items = Post::paginate($paginate);
            }

            
			if( $request['page']==null ){
				$request['page'] = 1;
			}
			$page = $paginate * ($request['page']-1);
			
            
            $data = [
					'title' => 'Посади',
                    'search' => '',
                    'items' => $items,
                    'page' => $page,
                    'post' => $post,
                    'postP' => $postP,
                    'parrent_id' => $parrent_id,
				];
			return 	view('admin.post.list',$data);
		}
		abort(404);
	}
}
