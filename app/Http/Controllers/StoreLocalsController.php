<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\StoreLocals;
use Illuminate\Http\Request;

class StoreLocalsController extends Controller
{
    public function store($store ,$request){

        $languages = Language::all();
        $store_id = $store->id;
            // dd($request);   
        foreach ($languages as $key => $value) {
               
            $tagLocals = StoreLocals::create([
                    'name' => $request->input($languages[$key]['lang'].'_name'),
                    'store_id'=>$store_id,
                    'status'=>1,
                    'lang'=>$languages[$key]['lang']
               ]);
            
        }
        return response([
            'message'=>'Store added !!!'
        ],201);
    }

}
