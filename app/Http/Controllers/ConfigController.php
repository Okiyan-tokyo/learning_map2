<?php

// 設定はcrud全てここに集約予定

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Big_theme;
use App\Enums\Conf_Bigtheme;

class ConfigController extends Controller
{
    // 初期設定
    public function conf_base(){

        $lists=Big_theme::all();
        $add_or_create="";
        $list_long="";

        if($lists->isNotEmpty()){
            $add_or_create="edit";
            $list_long=count($lists);
        }else{
            $add_or_create="create";
        }

        
        $filelists=Conf_Bigtheme::jpnDescription();
       return view("config/conf_big_theme")->with([
        "filelists"=>$filelists,
        "add_or_create"=>$add_or_create,
        "list_long"=>$list_long,
        "all_lists"=>$lists
       ]);
    }


    // 設定の追加＆変更
    public function conf_edit(Request $request){
       try{
        DB::transaction();
        // 入力があれば取得
        for($n=1;$n<=7;$n++){
            $post=new Big_theme();
            $post->big_theme=$request->big_theme_sets.$n;
            $post->cont_which=$request->cont_which;
            $post->big_theme=$request->big_theme_sets.$n;
            $post->save();
        }
        
        }catch(PDOException $e){
            return redirect(route("configroute"),["error"->$e->getMessage()]);            
        }catch(Exception $e){
            return redirect(route("configroute"),["error"->$e->getMessage()]);
        }
    }

}
