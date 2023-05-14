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
        
        if(empty($big_theme) ||empty($small_theme) ||empty($after_edit_name) ||empty($cate)){
            throw new \PDOException("何らかのデータが入力できていません");
        }

        if(!(in_array($big_theme,["PHP","Q_A"]) && $cate==="small_theme") && empty($edit_item_id)){
            throw new \PDOException("何らかのエラーです");
        }

        // エラーのフラグ
        $returnvalue=[];

        // PHPかクイズでかつ小テーマ変更のフラグ
        if(in_array($big_theme,["PHP","Q_A"]) && $cate==="small_theme"){
            $php_or_quiz=true;
        }else{
            $php_or_quiz=false;
        }

        if($php_or_quiz){
            $change_set=Learntheme::select("id","big_theme","small_theme")->where([
                ["big_theme","=",$big_theme],
                ["small_theme","=",$small_theme],
            ])->get();
        }else{
            $change_set=Learntheme::find($edit_item_id);
            // コードを短種する
            $c1=$change_set->big_theme;
            $c2=$change_set->small_theme;
            $c3=$change_set->contents;
            $c4=$change_set->reference;
            $c5=$change_set->concsious;
            $c6=$change_set->url;
        }

            switch($cate){
                case "small_theme":
                    $small_isok=$check_class->small_edit($after_edit_name,$big_theme,$small_theme);
                    // 重複
                    if($small_isok!=="ok"){
                        $returnvalue[]=$small_isok;
                    }
                    // phpとクイズの場合、idが一意に決まらない
                    if(!$php_or_quiz){
                        $change_set->small_theme=$after_edit_name;
                      }else{
                        foreach($change_set as $c){
                        // ここだけtransaction内で別処理のsaveになってしまう！！
                            $original[$c->id]=$c->small_theme;
                            $c->small_theme=$after_edit_name;
                            $c->save();
                            
                            // エラーの場合（どう定義する？）
                            // if(error){ $c->small_theme=$original[$c->id]};

                        }
                     }
                break;

                // PHPとQ_Aのカテゴリーを変更したい場合
                case "small_category_change":

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
            if(!$php_or_quiz){
                $change_set->save();
            }
        });

    }catch(\PDOException $e){
        return redirect(route("indexroute"))->with("PDOError",$e->getMessage());
    }
        return redirect(route("indexroute"))->with("change","edit");
    }


    // 意識することの編集
    public function edit_counscious(){
        return redirect(route("indexroute"));
    }

}

