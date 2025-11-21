<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Post;
use App\Models\ProjectKPPItems;
use App\Models\Telegram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;

class APIController extends Controller
{
    public function genSlug(Request $request){
        $input = $request->except('_token');

        return Str::slug( mb_strtolower( str_replace('/','-',$input['name']) ) , '-','ru');
    }


    public function changeActive(Request $request){
        $input = $request->except('_token');
        switch( $input['type'] ){
            case 'user' : $tmp = User::where('id',$input['id'])->first(); break;
            case 'post' : $tmp = Post::where('id',$input['id'])->first(); break;
            case 'news' : $tmp = News::where('id',$input['id'])->first(); break;
        }

        $tmp->active = (int)$input['active'];
        $tmp->update();
    }


    public function findNextPost(Request $request){
        $input = $request->except('_token');

        return Post::where('parrent_id',$input['id'])->orderBy('order','ASC')->get();
    }

    public function getUserInfo(Request $request){
        $input = $request->except('_token');

        $users = User::where('name','LIKE', '%'.$input['name'].'%')->orderBy('name','ASC')->get();

        foreach($users as $user){
            switch( $user->employment ){
                case 0 : $user->employment_text = 'Штат'; break;
                case 1 : $user->employment_text = 'ЦПХ'; break;
                case 2 : $user->employment_text = 'ФОП'; break;
            }
        }

        return $users;
    }
    

    public function createRow(Request $request){
        $input = $request->except('_token');
        $item = new ProjectKPPItems;
        $item->fill($input);
        $item->save();
    }

    public function removeRow(Request $request){
        $input = $request->except('_token');
        $tmp = ProjectKPPItems::where('project_id',$input['project_id'])->where('row_id',$input['row_id'])->where('count_id',$input['count_id'])->delete();
    }

    public function updateRowName(Request $request){
        $input = $request->except('_token');
        ProjectKPPItems::where('project_id',$input['project_id'])->where('row_id',$input['row_id'])->where('count_id',$input['count_id'])->update(['title' => $input['title'] ]);
    }

    public function updateRowColor(Request $request){
        $input = $request->except('_token');

        $item = ProjectKPPItems::where('project_id',$input['project_id'])->where('row_id',$input['row_id'])->where('count_id',$input['count_id'])->first();
        
        if( !isset($item) ){ 
            $item = new ProjectKPPItems;
            $item->fill($input);
            $item->save();
        }

        $json = json_decode($item->json,true);
        if( !isset($json) ){
            $json = array();
        }
        $json[$input['day']] = $input['color'];
        $json = json_encode($json);
        ProjectKPPItems::where('project_id',$input['project_id'])->where('row_id',$input['row_id'])->where('count_id',$input['count_id'])->update(['json' => $json ]);
    }

    
}
