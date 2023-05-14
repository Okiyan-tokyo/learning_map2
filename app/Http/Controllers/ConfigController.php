<?php

// 設定はcrud全てここに集約予定

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Big_theme;
use App\Enums\Conf_Bigtheme;
use Illuminate\Support\Facades\DB;

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

        // 英語のファイルリスト
        $fileEnums=Conf_Bigtheme::engDescription();
        // 日本語のファイルリスト
        $filelists=Conf_Bigtheme::jpnDescription();
       
        return view("config/conf_big_theme")->with([
        "filelists"=>$filelists,
        "fileEnums"=>$fileEnums,
        "add_or_create"=>$add_or_create,
        "list_long"=>$list_long,
        "all_lists"=>$lists
       ]);
    }


    // 設定の追加＆変更
    public function conf_edit(Request $request){
       try{
        DB::transaction(function()use($request){
        // 入力があれば取得
        for($n=1;$n<=7;$n++){
            $word_big_theme="big_theme_sets".$n;
            $word_cont_which="cont_wihch_sets".$n;
            $word_file_wihch="file_which_sets".$n;
            $post=new Big_theme();
            if(!empty($request->$word_big_theme)){
                $post->big_theme=$request->$word_big_theme;
                // $post->cont_which=$request->$word_cont_which;
                $post->file_which=$request->$word_file_wihch;
                $post->save();
            }
         }
        });
        }catch(PDOException $e){
            return redirect(route("configroute"))->with("message",$e->getMessage());            
        }catch(Exception $e){
            return redirect(route("configroute"))->with("message"->$e->getMessage());
        }
        return redirect(route("configroute"))->with("message","ok");
    }

}
