<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learntheme;
use App\Http\Requests\Edit_Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CheckController;

class PatchController extends Controller
{
    public function namechange(Request $request){
        
    
        $check_class=new CheckController();

        try{
    
         DB::transaction(function()use($request,$check_class){

        $big_theme=$request->big_theme;
        $small_theme=$request->small_theme;
        $edit_item_id=$request->edit_item_id;
        $after_edit_name=$request->after_edit_name;
        $cate=$request->category;
        
        if(empty($big_theme) ||empty($small_theme) ||empty($edit_item_id) ||empty($after_edit_name) ||empty($cate)){
            throw new \PDOException("何らかのデータが入力できていません");
        }
        
        // エラーのフラグ
        $returnvalue=[];


             $all_set=Learntheme::all();
             // small_theme以外は一意に決まる。
            $change_set=Learntheme::find($edit_item_id);

            // コードを短種する
            $c1=$change_set->big_theme;
            $c2=$change_set->small_theme;
            $c3=$change_set->contents;
            $c4=$change_set->reference;
            $c5=$change_set->concsious;
            $c6=$change_set->url;
            
            switch($cate){
                case "small_theme":
                    // phpとクイズの場合、idが一意に決まらない
                    $small_isok=$check_class->small_edit($after_edit_name,$big_theme,$small_theme);
                    if($small_isok!=="ok"){
                        $returnvalue[]=$small_isok;
                    }else{
                        // 既に行っている
                        // 例外であってもtransactionで戻る
                    }
                break;
                case "contents":
                    // 内容は通常チェックと同じ
                    if($check_class->cont_check($c1,$c2,$after_edit_name)!=="ok"){
                        $returnvalue[]=$check_class->cont_check($c1,$c2,$after_edit_name);
                        $returnvalue[]=$check_class->cont_check($c1,$c2,$after_edit_name);
                    }else{
                        $change_set->contents=$after_edit_name;
                    }                
                break;
                case "reference":
                    // 参照は通常チェックと同じ
                    if($check_class->refer_check($c1,$after_edit_name)!=="ok"){
                        $returnvalue[]=$check_class->refer_check($c1,$after_edit_name);
                    }else{
                        $change_set->reference=$after_edit_name;
                    }                  
                break;
                case "URL":
                // URLは通常チェックと同じ
                    if($check_class->url_check($c1,$c2,$after_edit_name)!=="ok"){
                        $returnvalue[]=$check_class->refer_check($c1,$c2,$after_edit_name);
                    }else{
                        $change_set->URL=$after_edit_name;
                    }   
                break;
            }

            if(!empty($returnvalue)){
                throw new \PDOException(implode("\n",$returnvalue));
            }
            $change_set->save();
        });

    }catch(\PDOException $e){
        return redirect(route("indexroute"))->with("PDOError",$e->getMessage());
    }
        return redirect(route("indexroute"))->with("change","edit");
    }


}

