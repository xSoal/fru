<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telegram extends Model
{
    use HasFactory;

    public static function sendMessTelegram($chatIds,$text){

        $mh = curl_multi_init();
		$chArray = array();
		$count = 0;
		foreach($chatIds as $id){

			/* отправка текста в телеграм */
				$url = "https://api.telegram.org/bot".env('TELEGRAM_BOT_TOKEN')."/sendMessage?chat_id=".$id;
				$post_fields = array( 'chat_id'   => $id,
									'text'   => $text,
									'parse_mode' => 'html'
								);
			
            $ch = curl_init(); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
			curl_multi_add_handle($mh, $ch);
			$chArray[$url] = $ch;

			$count++;

			if( $count == 50 ){
				//-------------------------------------------------
				$active = null;
				do{
					$mrc = curl_multi_exec($mh, $active);
				}while($mrc == CURLM_CALL_MULTI_PERFORM);
			
				while ($active && $mrc == CURLM_OK) {
					if (curl_multi_select($mh) === -1) {
						usleep(100);
					}
					while (curl_multi_exec($mh, $active) == CURLM_CALL_MULTI_PERFORM);
				}

				foreach ($chArray as $ch) {
					curl_multi_remove_handle($mh, $ch);
				}
				curl_multi_close($mh); 

				$result = [];
				foreach ($chArray as $key => $ch) {
					$result[$key] = curl_multi_getcontent($ch);
				}
				//-------------------------------------------------

				$mh = curl_multi_init();
				$chArray = array();
				$count = 0;
			}

		}
		
		$active = null;
		do{
			$mrc = curl_multi_exec($mh, $active);
		}while($mrc == CURLM_CALL_MULTI_PERFORM);

		while ($active && $mrc == CURLM_OK) {
			if (curl_multi_select($mh) === -1) {
				usleep(100);
			}
			while (curl_multi_exec($mh, $active) == CURLM_CALL_MULTI_PERFORM);
		}

		foreach ($chArray as $ch) {
			curl_multi_remove_handle($mh, $ch);
		}
		curl_multi_close($mh); 

		$result = [];
		foreach ($chArray as $key => $ch) {
			$result[$key] = curl_multi_getcontent($ch);
		}
        
    }
}
