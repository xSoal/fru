<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeoController extends Controller
{
    public function index(){
        $setting = DB::table('settings')
                ->where('type', 'seo')
                ->first();

        $seo = json_decode($setting->value);

        $titles = DB::table('settings')
            ->where('type', 'titles')
            ->first();
        $titles = json_decode($titles->value);    

        $data = [
            'title' => 'Seo',
            'seo' => $seo,
            'titles' => $titles
        ];

        return view('admin.seo.edit', $data);
    }

    public function edit(Request $request){
        $e = [
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'meta_keywords' => $request['meta_keywords'],
            'og_title' => $request['og_title'],
            'og_description' => $request['og_description'],
            'og_img' => $request['og_img'],
        ];

        $newSeo = json_encode($e);

        $setting = DB::table('settings')
                ->where('type', 'seo')
                ->first();
        
        $updated = DB::table('settings')
            ->where('type', 'seo')
            ->update([
                'value' => $newSeo,
                'updated_at' => now() 
            ]);


        $newTitles = [
            'main' => $request['main'],
            'news' => $request['news'],
            'contacts' => $request['contacts'],
            'login' => $request['login'],
            'search' => $request['search'],
            'reference' => $request['reference'],
            'support' => $request['support'],
            'rules' => $request['rules'],
        ];

        $newTitles = json_encode($newTitles);

        
        
        $updated = DB::table('settings')
            ->where('type', 'titles')
            ->update([
                'value' => $newTitles,
                'updated_at' => now() 
            ]);
        

        return redirect()->route('admin.seo');
    }


}
