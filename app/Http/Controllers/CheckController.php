<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learntheme;
use App\Models\Big_theme;

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
             return "テーマがありません";
          }   
       break;
       case "new":
          if($is_small_exist->isNotEmpty()){
             return "既存テーマです";
          }   
       break;
       default:
        return "選択されていません";
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
        $must_conf_base=Big_theme::where("cont_which","=",1)->get();

        foreach($must_conf_base as $m_conf){
           if($big_theme===$m_conf->big_theme){
              if(empty($contents)){
                return "内容は入力してください";
             }   
            }else{
               if(!empty($contents)){
                  return "内容は入力しないでください";
               }   
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
        
        // 必ず英数字のみ（空白以外）
        switch($big_theme){
            case "PHP":

       // 最後はPHP 必ず選択
                if(empty($linkurl)){
                return "URLは必ず入力してください";
                } 
                if(substr($linkurl,-4)!==".php"){
                return "リンクの拡張子をPHPにしてください";
                }

        //  重複確認

                $exists_lists=Learntheme::select("url")
                    ->where([
                    ["big_theme","=",$big_theme],
                    ["small_theme","=",$small_theme]
                    ])
                    ->get();
                foreach($exists_lists as $e){
                    if(strtolower($e["url"])===strtolower($linkurl)){
                            return "そのURLは既に存在しています";
                    }
                 }

           break;
           case "Laravel":
              // テーマごとに別々のリストが作成される
              if(!empty($linkurl)){
                 return "URLは空白にしてください(自動で作成します)";
              } 
           break;
           case "Javascript":
           case "html/css":
           case "environment":
              if(empty($linkurl)){
                 return "URLは必ず入力してください";
              } 
              if(substr($linkurl,-4)!==".php"
                 && substr($linkurl,-5)!==".html"
              ){
                 return "リンクの拡張子をHTMLかPHPにしてください";
              }

        //  重複確認
            $exists_lists=Learntheme::select("url")
            ->where([
            ["big_theme","=",$big_theme]
            ])
            ->get();
            foreach($exists_lists as $e){
                if(strtolower($e["url"])===strtolower($linkurl)){
                        return "そのURLは既に存在しています";
                }
             }

           break;
           case "Q_A":
              if(!empty($linkurl)){
                 return "リンクは無効です";
              }
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

 
// public function small_if_phporquiz_edit($after_edit_name,$big_theme,$small_theme){
//    // 既存テーマではない時、該当idのsmallthemeを全て変更
//    $exist_lists=Learntheme::select("id","small_theme")->where([
//       ["big_theme","=",$big_theme],
//       ["small_theme","=",$small_theme]
//    ])->get();
//    foreach($exist_lists as $each_list){
//       $edit_data=Learntheme::find($each_list["id"]);
//       $edit_data->small_theme=$after_edit_name;
//    }
//    }


}

