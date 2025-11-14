<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TelegramController extends Controller
{
    public function index(Request $request){

        $resp = $request->except('_token');
        
        file_put_contents("upload/telegram.txt", json_encode($resp) );

        $resp = json_encode($resp);
        $resp = json_decode($resp);
        
        $id = $resp->message->chat->id!='' ? $resp->message->chat->id : $resp->callback_query->message->chat->id;
        
        $user = User::where('telegram_id',$id)->first();
        
        if( isset($resp->message->text) && strstr($resp->message->text,'/start') && !isset($user) ){
            $keyboard=array("keyboard"=> array( 
                array( 
                    array( 
                        'text'=>"Надіслати контакт",
                        'request_contact'=>true
                        )
                    )
                ),
                'one_time_keyboard' => true,
                'resize_keyboard' => true
            );
            $replyMarkup = json_encode($keyboard);

            $text = 'Натисніть надіслати контакт';

            file_get_contents('https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/sendMessage?chat_id='.$id.'&parse_mode=html&text='.urlencode($text).'&reply_markup='.$replyMarkup);
        }
        
        if( isset($resp->message->contact) && !isset($user) ){

            $phone = preg_replace("/[^0-9]/", '', $resp->message->contact->phone_number );
            if( substr($phone,0,3) == '380' ){
                $phone = substr($phone,3);
            }
            if( substr($phone,0,1) == 0 && mb_strlen($phone) == 10 ){
                $phone = substr($phone,1);
            }
            if( $phone !='' && mb_strlen($phone)== 9 ){
                $phone = '+380'.$phone;
            }
           
            $user = User::where('phone',$phone)->first();
            if( isset($user) ){
                $user->telegram_id = $id;
                $user->update();

                $text = "Привіт ".$resp->message->contact->first_name.", це Spilnota_Info_Bot. Він призначений для взаємодії з клубом Spilnota.";
                file_get_contents('https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/sendMessage?chat_id='.$id.'&parse_mode=html&text='.urlencode($text));

            }else{
                $text = "Або у вас немає облікового запису на сайті Spilnota або там не вказано телефон. Не можемо вас ідентифікувати";
                file_get_contents('https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/sendMessage?chat_id='.$id.'&parse_mode=html&text='.urlencode($text));
            }
            
        }

    }
}
