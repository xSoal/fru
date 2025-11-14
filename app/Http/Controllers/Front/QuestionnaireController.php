<?php

namespace App\Http\Controllers\Front;

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
    public function index(){  
        
        if(view()->exists('front.questionnaire')){

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
                'post' => $post,
                'postP' => $postP,
                'meta_title' => '',
                'meta_decs' => '',
                'og_title' => '',
                'og_desc' => '',
                'og_img' => '',
            ];
            return 	view('front.questionnaire',$data);
        }
        abort(404);    
    }

    public function post(Questionnaire $questionary, Request $request){  
        $input = $request->except('_token');

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


        $questionary->fill($input);
        
        if( $questionary->save() ){
            return redirect()->route('front.questionary')->with('status','Дякуємо за відповіді, ваша анкета збережена');
        }
    }

}
