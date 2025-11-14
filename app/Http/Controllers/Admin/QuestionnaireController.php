<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Post;
use App\Models\Questionnaire;
use Validator;
use Mail;

class QuestionnaireController extends Controller
{
    public function post(User $user, Request $request){
       
        $input = $request->except('_token');

        //-----------------------------------------------------------------
        if( isset($input['update']) || isset($input['update_and_exit']) ){
            
            $messages = [
				'required' => 'Поле required: обов\'язково до заполонення',
				'email.unique' => 'Поле E-MAIL має бути унікальним',
                'phone.unique' => 'Поле ТЕЛЕФОН має бути унікальним',
			];

            $validator = Validator::make($input, [
                'name' => 'required|string',
                'email' => 'required|unique:users,email,'.$input['id'],
                'phone' => 'required|unique:users,phone,'.$input['id']
            ],$messages);

            if ($validator->fails()) {
				return redirect()->route('admin.viewQuestionnaire', ['id' => $input['id'] ] )->withErrors($validator)->withInput();
			}

            $questionnaire = Questionnaire::find($input['id']);
            
            $questionnaire->fill($input);
			
			if( $questionnaire->update() ){
                if( isset($input['update_and_exit']) ){
				    return redirect()->route('admin.questionnaire')->with('status','Анкету оновлено');
                }else{
                    return redirect()->route('admin.viewQuestionnaire',['id' => $input['id'] ])->with('status','Анкету оновлено');
                }
			}
        }
        //-----------------------------------------------------------------

        //-----------------------------------------------------------------
        if( isset($input['dell']) ){
            $tmp = Questionnaire::where('id',$input['id'])->first();
            $tmp->delete();
            return redirect()->route('admin.questionnaire')->with('status','Анкету видалено');
        }
        //-----------------------------------------------------------------

        //-----------------------------------------------------------------
        if( isset($input['search']) && $input['search']!=null ){
            if(view()->exists('admin.questionnaire.list')){
				$search = $input['search'];
				$paginate = 25;

                $items = Questionnaire::where(function($query) use ($search) {
                    $query->orWhere('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('email', 'LIKE', '%'.$search.'%')
                            ->orWhere('project', 'LIKE', '%'.$search.'%');
                })->paginate($paginate);
               
                if( $request['page']==null ){
					$request['page'] = 1;
				}
				$page = $paginate * ($request['page']-1);
                
                $data = [
                        'title' => 'Акнети користувачів',
                        'items' => $items,
                        'search' => $search,
						'page' => $page
                    ];
				return 	view('admin.questionnaire.list',$data);
			}
			abort(404);
        }
        //-----------------------------------------------------------------

        return redirect()->route('admin.questionnaire');
    }


    public function view($id){
		if(view()->exists('admin.questionnaire.edit') ){

            $post = array();
            $postP = array();
            $tmp = Post::get();
            foreach($tmp as $item){
                $post[$item->id] = $item;
                if( $item->parrent_id == 0 ){
                    $postP[] = $item;
                }
            }
            
            $item = Questionnaire::where('id', '=', $id)->first();

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
					'title' => 'Редагувати',
					'item' => $item,
                    'post' => $post,
                    'postP' => $postP,
                    'postList' => $postList,
				];
			return 	view('admin.questionnaire.edit',$data);
		}
        abort(404);
    }
    

    public function list(Request $request){  
        
        if(view()->exists('admin.questionnaire.list')){
            $paginate = 25;

            $items = Questionnaire::orderBy('created_at','DESC')->paginate($paginate);

            if( $request['page']==null ){
				$request['page'] = 1;
			}
			$page = $paginate * ($request['page']-1);

            $data = [
                'title' => 'Акнети користувачів',
                'search' => '',
                'items' => $items,
                'page' => $page
            ];
            return 	view('admin.questionnaire.list',$data);
        }
        abort(404);    
    }
}
