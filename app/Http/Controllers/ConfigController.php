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
        // 日本語のファイルリスト...keyは英語のファイルリスト
        $filelists=Conf_Bigtheme::jpnDescription();


        return view("config/new_or_add")->with([
        "filelists"=>$filelists,
        "fileEnums"=>$fileEnums,
        "add_or_create"=>$add_or_create,
        "list_long"=>$list_long,
        "all_lists"=>$lists
       ]);
    }


    // 設定の追加＆変更
    public function conf_add(Request $request){
       try{
        DB::transaction(function()use($request){
        // 入力があれば取得
        for($n=1;$n<=7;$n++){
            $word_big_theme="big_theme_sets".$n;
            $word_conf_which="cont_which_sets".$n;
            $word_file_wihch="file_which_sets".$n;
            $post=new Big_theme();
            
            // 大テーマが空ではない場合
            if(!empty($request->$word_big_theme)){
                $post->big_theme=$request->$word_big_theme;

                if($request->has($word_conf_which)){
                $post->cont_which=1;
                }else{
                $post->cont_which=0;
                // ファイル設定していたら消去
                $_SESSION["file_delete"]="yes";
                }

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

        // ファイルを削除する場合
        if(!empty($_SESSION["file_delete"]) && $_SESSION["file_delete"]==="yes"){

            // transactionを抜けているので例外はエラーはんどらでキャッチする

        }

        return redirect(route("configroute"))->with("message","ok");
    }

    // 既存設定変更の表示
    public function conf_edit(){
       return view("config/exist_edit")->with([
            "exist_theme"=>Big_theme::all(),
            "file_jpn"=>Conf_BigTheme::jpnDescription(),
            "file_eng"=>Conf_BigTheme::engDescription(),
        ]);
    }

    // 既存の編集
    public function conf_patch(Request $request,Big_theme $post){

        // 入力不備対策 
        $request->validate([
            "type1"=>["required","regex:/^(theme_name|cont|file_type|theme_delete)$/"],
        ],[
            "type1.required"=>"変更する項目が設定されていません",
            "type1.regex"=>"変更の値が不正です",
        ]);

        // 処理内容で変更
        DB::BeginTransaction();
        try{
            switch($request->type1){
                case "theme_name":
                    $post->big_theme=$request->type2;
                break;
                case "cont":
                    if($request->type2==="yes"){
                        $post->cont_which=1;
                    }else if($request->type2==="no"){
                        $post->cont_which=0;
                    }else{
                        throw new \Exception("内容の設定が不正です");
                    }
                break;
                case "file_type":
                    $file_type_lists=Conf_Bigtheme::engDescription();
                    if(in_array($request->type2,$file_type_lists)){
                        $post->big_theme=$request->type2;
                    }else{
                        throw new \Exception("ファイルタイプの値が無効です");
                    }
                break;
                case "theme_delete":
                    $post->delete();                   
                break;
                // validationで弾いているが念の為
                default:
                    throw new \Exception("変更箇所が設定できていません");
                break;
            }
        }catch(\Exception $e){
            DB::rollback();
            return redirect(route("conf_edit_route"))->with(["exist_conf_error"=>$e->getMessage()]);
        }
        $post->save();
        DB::commit();
        
        if($request->type1==="delete"){
            return redirect(route("conf_edit_route"))->with(["config_exist_edit_ok"=>"テーマ設定を削除しました！"]);
        }else{
            return redirect(route("conf_edit_route"))->with(["config_exist_edit_ok"=>"テーマ設定を変更しました！"]);
        }
        
    }

    // // 既存のcontの変更
    // public function conf_cont_toggle(){
        
    // }

    // // 既存の削除
    // public function conf_delete(){

    // }


}
