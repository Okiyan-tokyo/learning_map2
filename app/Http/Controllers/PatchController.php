<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learntheme;
use App\Http\Requests\Edit_Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CheckController;
use App\Models\Big_theme;

class PatchController extends Controller
{
    public function namechange(Request $request){
        
    
        $check_class=new CheckController();

        try{
            
         DB::transaction(function()use($request,$check_class){
        
        $big_theme=$request->big_theme;
        $small_theme=$request->small_theme;        
        $edit_contents=$request->cont_change2;
        $edit_item_id=$request->edit_item_id;
        $after_edit_name=$request->after_edit_name;
        $cate=$request->category;

        if(empty($big_theme) ||empty($small_theme) ||empty($after_edit_name) ||empty($cate)){
            throw new \PDOException("何らかのデータが入力できていません");
        }

    
        // エラーのフラグ
        $returnvalue=[];

        // contentsが必要かでパターンわけ
        $must_cont_lists=Big_theme::where("cont_which","=",1)->pluck("big_theme")->toArray();

        $cont_pattern=false;

        if(in_array($big_theme,$must_cont_lists)){
            $cont_pattern=true;
        }
    
        // contentsあり版
      if($cont_pattern){
          $change_set=Learntheme::where([
              ["big_theme","=",$big_theme],
              ["small_theme","=",$small_theme],
              ["contents","=",$edit_contents],
          ])->get();
        }else{
            $change_set=Learntheme::where([
                ["big_theme","=",$big_theme],
                ["small_theme","=",$small_theme]
            ])->get();
        }
        // 内容なしの場合コードを短種する

          $c1=$change_set[0]->big_theme;
          $c2=$change_set[0]->small_theme;
          $c3=$change_set[0]->contents;
          $c4=$change_set[0]->reference;
          $c5=$change_set[0]->concsious;
          $c6=$change_set[0]->url;


            switch($cate){
                case "small_theme":
                    $small_isok=$check_class->small_edit($after_edit_name,$big_theme,$small_theme);
                    // 重複
                    if($small_isok!=="ok"){
                        $returnvalue[]=$small_isok;
                    }
                // 内容必要かによってパターン分け
                   if(!$cont_pattern){
                        $change_set->small_theme=$after_edit_name;
                        }else{
                        foreach($change_set as $c){
                        $c->small_theme=$after_edit_name;
                        }
                    }
                break;

                case "contents":
                    // 内容は通常チェックと同じ
                    if($check_class->cont_check($c1,$c2,$after_edit_name)!=="ok"){
                        $returnvalue[]=$check_class->cont_check($c1,$c2,$after_edit_name);
                        $returnvalue[]=$check_class->cont_check($c1,$c2,$after_edit_name);
                    }else{
                        $change_set[0]->contents=$after_edit_name;
                    }                
                break;
                case "reference":
                    // 参照は通常チェックと同じ
                    if($check_class->refer_check($c1,$after_edit_name)!=="ok"){
                        $returnvalue[]=$check_class->refer_check($c1,$after_edit_name);
                    }else{
                        $change_set[0]->reference=$after_edit_name;
                    }                  
                break;
                case "URL":
                    if($cont_pattern){
                        // 内容設定あり＝そもそも内容まで設定されていなければエラー
                        if(empty($request->cont_change2) ||$request->cont_change2==="no_select"){
                        throw new \PDOException("内容を設定してください");
                      }
                    }
                    // URLのチェック
                    if($check_class->url_check($c1,$c2,$after_edit_name)!=="ok"){
                        $returnvalue[]=$check_class->url_check($c1,$c2,$after_edit_name);
                    }else{
                        $change_set[0]->URL=$after_edit_name;
                    }   
                break;
            }

            if(!empty($returnvalue)){
                throw new \PDOException(implode("\n",$returnvalue));
            }
          $change_set[0]->save();
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

