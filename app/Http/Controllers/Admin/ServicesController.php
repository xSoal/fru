<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Hash;
use App\Models\Service;
use App\Models\Post;

use Validator;

class ServicesController extends Controller
{
       
    public function post(Service $user, Request $request){
       
        $input = $request->except('_token');

        $input['photo'] = isset($input['photo']) ? $input['photo'] : '';

        if( isset($input['phone']) && trim($input['phone']) !='' ){

            $phone = preg_replace("/[^0-9]/", '',$input['phone']);
            if( substr($phone,0,3) == '380' ){
                $phone = substr($phone,3);
            }
            if( substr($phone,0,1) == 0 && mb_strlen($phone) == 10 ){
                $phone = substr($phone,1);
            }
            if( $phone !='' && mb_strlen($phone)== 9 ){
                $input['phone'] = '+380'.$phone;
            }
        }
        
        //-----------------------------------------------------------------
        if( isset($input['save']) ||  isset($input['save_and_exit']) ){

			$messages = [
				'required' => 'Поле required: обязательно к заполению',
				'email.unique' => 'Поле E-MAIL должно быть уникальным',
			];
			
			$validator = Validator::make($input, [
					'name' => 'required|string',
					'email' => 'required|unique:services',
				],$messages);
            
			if ($validator->fails()) {
				return redirect()->route('admin.addService')->withErrors($validator)->withInput();
			}

            $user->fill($input);

            if( $user->save() ){
                if( isset($input['save_and_exit']) ){
				    return redirect()->route('admin.services')->with('status','Користувач доданий');
                }else{
                    return redirect()->route('admin.addService')->with('status','Користувач доданий');
                }
			}
			
		}
        //-----------------------------------------------------------------



        //-----------------------------------------------------------------
        if( isset($input['update']) || isset($input['update_and_exit']) ){
            
            $messages = [
				'required' => 'Поле required: обязательно к заполению',
				'email.unique' => 'Поле E-MAIL должно быть уникальным',
			];

			$validator = Validator::make($input, [
                'name' => 'required|string',
                'email' => 'required|unique:services,email,'.$input['id'],
            ],$messages);


            if ($validator->fails()) {
				return redirect()->route('admin.viewService', ['id' => $input['id'] ] )->withErrors($validator)->withInput();
			}

            $user = Service::find($input['id']);

            $user->fill($input);
			if( $user->update() ){
                if( isset($input['update_and_exit']) ){
				    return redirect()->route('admin.services')->with('status','Пользователь обновлен');
                }else{
                    return redirect()->route('admin.viewService',['id' => $input['id'] ])->with('status','Пользователь обновлен');
                }
			}
        }
        //-----------------------------------------------------------------



        //-----------------------------------------------------------------
        if( isset($input['dell']) ){
            $tmp = Service::where('id',$input['id'])->first();
            $tmp->delete();
            return redirect()->route('admin.services')->with('status','Пользователь удалён');
        }
        //-----------------------------------------------------------------


        //-----------------------------------------------------------------
        if( isset($input['search']) && $input['search']!=null ){
            if(view()->exists('admin.services.list')){
				$search = $input['search'];
				$paginate = 25;
				

                $items = Service::where(function($query) use ($search) {
                                        $query->orWhere('name', 'LIKE', '%'.$search.'%')
                                            ->orWhere('email', 'LIKE', '%'.$search.'%');
                                        })
                                        ->paginate($paginate);
                
				
                if( $request['page']==null ){
					$request['page'] = 1;
				}
				$page = $paginate * ($request['page']-1);
                
                $data = [
                        'title' => 'Пользователи',
                        'items' => $items,
                        'search' => $search,
						'page' => $page
                    ];
				return 	view('admin.services.list',$data);
			}
			abort(404);
        }
        //-----------------------------------------------------------------
        
        return redirect()->route('admin.services');
    }


    public function view($id){
		if(view()->exists('admin.services.edit')){
            
            $post = array();
            $postP = array();
            $tmp = Post::get();
            foreach($tmp as $item){
                $post[$item->id] = $item;
                if( $item->parrent_id == 0 ){
                    $postP[] = $item;
                }
            }


            $item = Service::where('id', '=', $id)->first();

            $postList = array();
            if($item->post_id !=0){
                $tmp = Post::where('id',$item->post_id)->first();
                $postList[] = $tmp;
                while( isset($tmp) && $tmp->parrent_id !=0 ){
                    $tmp = Post::where('id',$tmp->parrent_id)->first();
                    array_unshift($postList, $tmp);
                }
            }
            
            $data = [
					'title' => 'Редактировать пользователя',
					'item' => $item,
                    'post' => $post,
                    'postP' => $postP,
                    'postList' => $postList
				];
			return 	view('admin.services.edit',$data);
		}
        abort(404);
    }

    public function add(){
		if(view()->exists('admin.services.edit') ){

            $postList = array();
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
                'title' => 'Добавить пользователя',
                'post' => $post,
                'postP' => $postP,
                'postList' => $postList
                ];
			return 	view('admin.services.edit',$data);
		}
		abort(404);
	}

    public function list(Request $request){
		if(view()->exists('admin.services.list')){

			$paginate = 25;

            $items = Service::paginate($paginate);
            
			if( $request['page']==null ){
				$request['page'] = 1;
			}
			$page = $paginate * ($request['page']-1);

			$data = [
					'title' => 'Пользователи',
					'items' => $items,
					'search' => '',
					'page' => $page
				];
			return 	view('admin.services.list',$data);
		}
		abort(404);
	}

}
