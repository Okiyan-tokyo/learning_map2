<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learntheme;
use App\Http\Requests\Learning_Requests;
use Illuminate\Support\Facades\DB;

class PatchController extends Controller
{
    public function namechange(Request $request){
        
        $edit_item_id=$request->edit_item_id;
        $after_edit_name=$request->after_edit_name;
        $cate=$request->category;
        
        // エラーのフラグ
        $errortype="";

        try{
        DB::transaction(function($request){
            $change_set=Learntheme::find($edit_item_id);

            
            switch($cate){
                case "small_theme":
                    // small_themeとURLは必ず英語
                    $this->rgx_check("small_theme",$after_edit_name);
                    $change_set->small_theme=$after_edit_name;
                break;
                case "contents":
                    $change_set->contents=$after_edit_name;
                break;
                case "reference":
                break;
                case "URL":
                // small_themeとURLは必ず英語
                    $this->rgx_check("URL",$after_edit_name);
                break;
            }
            $change_set->save();
        });

    }catch(\PDOException $e){
        $errortype=$e->getMessage();

        return redirect()->route("indexroute",["PDOError"=>$errortype]);
    }
        return redirect()->route("indexroute",["change"=>"edit"]);
    }



    // 正規表現
    public function rgx_check($theme,$name){
        switch($theme){
            case "small_theme":
            break;
            case "URL":
            break;
        }
    
    }


}

