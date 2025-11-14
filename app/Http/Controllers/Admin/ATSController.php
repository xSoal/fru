<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;


class ATSController extends Controller
{

    public function post(User $user, Request $request){
        $input = $request->except('_token');

        //-----------------------------------------------------------------
        if( isset($input['search']) && $input['search']!=null ){
            if(view()->exists('admin.users.list')){
				$search = $input['search'];
				
                $items = User::where(function($query) use ($search) {
                                        $query->orWhere('name', 'LIKE', '%'.$search.'%')
                                              ->orWhere('email', 'LIKE', '%'.$search.'%')
                                              ->orWhere('phone', 'LIKE', '%'.$search.'%');
                                        })
                                        ->get();



                foreach($items as $item){
                    $postList = array();
                    if($item->post_id !=0){
                        $tmp = Post::where('id',$item->post_id)->first();
                        if( isset($tmp) ){
                            $postList[] = $tmp->name;
                            while( isset($tmp) && $tmp->parrent_id !=0 ){
                                $tmp = Post::where('id',$tmp->parrent_id)->first();
                                array_unshift($postList, $tmp->name);
                            }
                        }
                    }
                    $item->post = implode(',', $postList);
                }
                
                
                $data = [
                        'title' => 'Довідник',
                        'items' => $items,
                        'search' => $search,
                    ];
				return 	view('admin.ats.list',$data);
			}
			abort(404);
        }
        //-----------------------------------------------------------------
        
        return redirect()->route('admin.ats');
    }

    public function list(Request $request){
		if(view()->exists('admin.ats.list')){

			$items = User::where('active',1)->get();
            foreach($items as $item){
                $postList = array();
                if($item->post_id !=0){
                    $tmp = Post::where('id',$item->post_id)->first();
                    if( isset($tmp) ){
                        $postList[] = $tmp->name;
                        while( isset($tmp) && $tmp->parrent_id !=0 ){
                            $tmp = Post::where('id',$tmp->parrent_id)->first();
                            array_unshift($postList, $tmp->name);
                        }
                    }
                }
                $item->post = implode(',', $postList);
            }
			
			$data = [
					'title' => 'Довідник',
					'items' => $items,
                    'search' => ''
				];
			return 	view('admin.ats.list',$data);
		}
		abort(404);
	}
}
