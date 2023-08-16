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
        $small_theme=$request->small_theme2;      
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
      if($cont_pattern && $edit_contents!=="no_select"){
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

        // コード短縮
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
                
                   if(!$cont_pattern){
                       $change_set[0]->small_theme=$after_edit_name;
                   }else{
                        foreach($change_set as $c){
                        $c->small_theme=$after_edit_name;
                        $c->save();
                        goto already_save;
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
          already_save:
        });

    }catch(\PDOException $e){
        return redirect(route("indexroute"))->with(["PDOError"=>$e->getMessage(),"ver"=>"edit"]);
    }
        return redirect(route("indexroute"))->with("change","edit");
    }


    // 意識することの編集
    public function edit_conscious(Request $request){
    
        try{
            DB::transaction(function()use($request){
                $big_theme=$request->big_theme;
                $small_theme=$request->small_theme3;
                $conscious=$request->edit_conscious;
        
                $cont_which=Big_theme::select("cont_which")->where("big_theme",$big_theme)->pluck("cont_which")->first();
                
            if($cont_which===1){
                $contents=$request->cont_change3;
                $data=Learntheme::where([
                ["big_theme","=",$big_theme],
                ["small_theme","=",$small_theme],
                ["contents","=",$contents],
                ])->first();
            // ファイルの変更



            }elseif($cont_which===0){
                $data=Learntheme::where([
                    ["big_theme","=",$big_theme],
                    ["small_theme","=",$small_theme],
                    ["contents","=",$contents],
                ])->first();
            // ファイルの変更
            
            
            
            }else{
                throw new \PDOException("データ取得のエラーです");
                exit;
            }
            $data->conscious=$conscious;
            $data->save();
         });

        }catch(\PDOException $e){
            return redirect(route("indexroute"))->with(["PDOError"=>$e->getMessage(),"ver"=>"edit_conscious"]);
        }
        return redirect(route("indexroute"))->with(["change"=>"edit_conscious"]);
    }
}




//SQLSTATE[42S22]: Column not found: 1054 Unknown column '0' in 'where clause' (Connection: mysql, SQL: select `cont_which` from `big_themes` where (`0` = big_theme and `1` = = and `2` = sss))
