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

        $data = [
            'title' => 'Seo',
            'seo' => $seo
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


        $updated = DB::table('settings')
                     ->where('type', 'seo')
                     ->update([
                         'value' => $newSeo,
                         'updated_at' => now() 
                     ]);
        
        
        $setting = DB::table('settings')
                     ->where('type', 'seo')
                     ->first();
        $seo = json_decode($setting->value);
        
        $data = [
            'title' => 'Seo',
            'seo' => $seo
        ];

        return view('admin.seo.edit', $data);
    }


}
