<?php

namespace App\Http\Controllers;

use App\Models\Big_theme;
use App\Models\Learntheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    public function themedelete(Request $request){
        try{
            DB::transaction(function()use($request){
                // 取得
                $big_theme=$request->big_theme;
                $small_theme=$request->small_theme4;
                $cont=$request->cont_change4;
                $which=$request->delete_category;
                $file_dir=dirname(__FILE__,4)."/public/titles/";
                
                // 大テーマがQ&Aの場合
                if($big_theme==="Q&A"){
                    
                }else{
                switch($which){
                    case "small_theme":

                        // 内容が必要か
                        $is_cate=Big_theme::select("cont_which")
                        ->where([
                            ["big_theme","=",$big_theme]
                        ])->first();

                        
                        // 内容がない大テーマの場合
                        if($is_cate===0){
                            $data = Learntheme::where([
                                "big_theme" => $big_theme,
                                "small_theme" => $small_theme
                            ])->first();
                                unlink($file_dir.$big_theme."/".$data->url);   
                                $d->delete();
                        }else{
                            // 内容が必要な大テーマの場合
                            $data = Learntheme::where([
                                "big_theme" => $big_theme,
                                "small_theme" => $small_theme
                            ])->get();
                            // ファイルの削除
                            $files=glob($file_dir.$big_theme."/*");
                            foreach($data as $d){
                                unlink($file_dir.$big_theme."/".$small_theme."/".$d->url);   
                                $d->delete();    
                            }
                            // ディレクトリの削除
                            rmdir($file_dir.$big_theme."/".$small_theme);
                        }
                    break;
                    case "contents":
                        if(Big_theme::where("big_theme",$big_theme)->value("cont_which")==="0"){
                            throw new \PDOException("そのテーマの内容は選択不可です");
                            return;
                        }

                        $data=Learntheme::where([
                            ["big_theme","=",$big_theme],
                            ["small_theme","=",$small_theme],
                            ["contents","=",$cont],
                            ])->first();
                        if($data){
                        //     // リンクの取得
                         if(!empty($data->url)){
                             $linkurl=$data->url;
                         //     // ファイルの削除
                             $file=$file_dir.$big_theme."/".$small_theme."/".$linkurl;
                             unlink($file);
                         }
                        }else{
                            throw new \PDOException("消去する内容が選択されていません");
                        }
                        $data->delete();
                    break;
                    default:
                        throw new \PDOException("消去カテゴリーが選択されていません");
                    break;
                }
            }
         });
        }catch(\PDOException $e){
            return redirect(route("indexroute"))->with(["PDOError"=>$e->getMessage(),"ver"=>"delete"]);
        }

        return redirect(route("indexroute"))->with(["change"=>"delete"]);
    }

    public function delete_conscious(){
        return redirect(route("indexroute"));
    }
}
