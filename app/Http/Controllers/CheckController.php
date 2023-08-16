<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learntheme;
use App\Models\Big_theme;
use Illuminate\Support\Facades\DB;

class CheckController extends Controller
{

    // 小テーマのチェック
   public function small_check($posts,$request){

    //  新規が既存ではないか？既存が新規ではないか？
    $is_small_exist=$posts->select("small_theme")->where([
       ["big_theme","=",$request->big_theme],
       ["small_theme","=",$request->small_theme]
    ])->get();


    switch($request->small_which){
       case "exists":
          if(!$is_small_exist->isNotEmpty()){
             return "小テーマがありません";
          }   
       break;
       case "new":
          if($is_small_exist->isNotEmpty()){
             return "小テーマが既存です";
          }   
       break;
       default:
        return "小テーマの既存/新規にチェックを入れてください";
       break;
    }
    return "ok";
 }


    // 内容のチェック
    public function cont_check($big_theme,$small_theme,$contents){
        // 全体…既存か否か
        if(!empty($contents)){
            $exists_lists=Learntheme::select("contents")
                ->where([
                ["big_theme","=",$big_theme],
                ["small_theme","=",$small_theme]
                ])
                ->get();
            foreach($exists_lists as $e){
                if(strtolower($e["contents"])===strtolower($contents)){
                    if($big_theme==="Q_A"){
                        return "その問題は既に存在しています";
                    }else{
                        return "その内容は既に存在しています";
                    }
                }
            }
        }
        
        //   内容が必須のリストは内容必須
        $the_theme=Big_theme::where("big_theme","=",$big_theme)->get();
           if($the_theme[0]->cont_which){
              if(empty($contents)){
                return "内容は入力してください";
             } 
            }else{
               if(!empty($contents)){
                  return "内容は入力しないでください";
               }   
           }

        
      //   Q&Aなら内容必須
        if($big_theme==="Q&A"){
           if(empty($contents)){
              return "問題は内容に入力してください";
           }
        }
        
        return "ok";
      }
    
    
        // 意識のチェック
        public function conscious_check($big_theme,$conscious){
         return "ok";
        }
    
    
           // 参照のチェック
       public function refer_check($big_theme,$reference){
        switch($big_theme){
           case "Q_A":
              if(empty($reference)){
                 return "解答がありません\n(参照に入力してください)";
              }else{
                 return "ok";
              }
           break;
           default:
              return "ok";
           break;
        }
     }
    

// URLのチェック
    public function url_check($big_theme,$small_theme,$linkurl){

      // Q&Aの場合
      if($big_theme==="Q&A"){
         if(!empty($linkurl)){
            return "URLは空白にしてください";
         }
      }

      //  重複確認
      // URLなしの場合は除く
      $url_none=Big_theme::where("file_which","=","No file")->pluck("big_theme")->toArray();
      if(!in_array($big_theme,$url_none)){
         $exists_lists=Learntheme::select("url")->where([["big_theme","=",$big_theme]])->get();
         foreach($exists_lists as $e){
            if(strtolower($e["url"])===strtolower($linkurl)){
                     return "そのURLは既に存在しています";
            }
         }
      }
      

      //  big_themeごとのurlタイプの取得
      $url_type=Big_theme::where("big_theme","=",$big_theme)->get();

      switch(strtolower($url_type[0]->file_which)){
         case "html only":
            if(empty($linkurl)){
               return "URLは必ず入力してください";
               } 
            if(substr($linkurl,-5)!==".html"){
               return "リンクの拡張子をhtmlにしてください";
            }
         break;
         case "php only":
            if(empty($linkurl)){
               return "URLは必ず入力してください";
            } 
            if(substr($linkurl,-4)!==".php"){
            return "リンクの拡張子をPHPにしてください";
            }
         break;
         case "html and php":
            if(empty($linkurl)){
               return "URLは必ず入力してください";
            } 
            if(substr($linkurl,-4)!==".php"
               && substr($linkurl,-5)!==".html"
            ){
               return "リンクの拡張子をHTMLかPHPにしてください";
            }
         break;
         case "no file":
            if(!empty($linkurl)){
               return "URLは空白にしてください";
            }
         break;
         default:
         break;
      }        

        return "ok";
    }





//  編集の時：小テーマが既に存在していないか？
public function small_edit($after_edit_name,$big_theme){
   // 重複がないか確認する
   $exist_lists=Learntheme::select("id","small_theme")->where([
      ["big_theme","=",$big_theme],
   ])->get();

   // after_edit_nameが既存のものと重複していないかの確認
   foreach($exist_lists as $each_list){
      if($each_list["small_theme"]===$after_edit_name){
         return "既存テーマです";
      }
   }
   return "ok";
}




}

