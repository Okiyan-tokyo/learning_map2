<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learntheme;
use App\Http\Requests\Learning_Requests;
use Illuminate\Support\Facades\DB;

class learningController extends Controller
{   

   static $big_array=["PHP","Laravel","Javascript","html/css","Environment","Q_A"];

   static public function h($moji){
      return htmlspecialchars($moji);
   }


   public function showindex(){

      $small_full=[];
      $cont_require_full=[];


// ミスしてsmall_fullとcontに悪意のある文字列が含まれた場合を考慮していない！


      foreach(self::$big_array as $b){
         // bは確実に上記列のどれか
         $small_by_big=Learntheme::select("id","small_theme")->where("big_theme","=",$b)->get();
         if(!empty($small_by_big)){
            foreach($small_by_big as $s){
               if(!array_key_exists($b,$small_full)){
                  $small_full[$b][]=$s;
               }else{
                  foreach($small_full[$b] as $sb){
                     if($sb["small_theme"]===$s["small_theme"]){
                        goto not_to_small_full;
                     }
                  }
                  $small_full[$b][]=$s;
                  not_to_small_full:
               }
            }
         }

         // それぞれのsmall_themeにcont表示
         if(array_key_exists($b,$small_full)){

            foreach($small_full[$b] as $sb){
   
               // 該当するcont
               $conts=Learntheme::select("id","contents")->where([
                  ["big_theme","=",$b],
                  ["small_theme","=",$sb["small_theme"]],
               ])->get();
   
               // indexに渡すcontのキー=大テーマの前３文字＆小テーマ
               $btop=substr($b,0,3);
               $key_str=$btop."_".$sb["small_theme"];
   
               foreach($conts as $cont){
                  if(!empty($cont["contents"])){
                     if(array_key_exists($key_str,$cont_require_full)){
                        $cont_require_full[$key_str][]=$cont;
                     }else{
                        $cont_require_full[$key_str]=[$cont];
                     }
                  }
               }

            }
         }

      }  
      
      return view("index")->with([
         "big_array"=>self::$big_array,
         "small_array"=>$small_full,
         "cont_array"=>$cont_require_full
      ]);
   }

   public function learning_plus(Learning_Requests $request){
      
      DB::beginTransaction();
         try{
            $posts=new Learntheme();

            // big_themeはバリデーションで弾けてる
            $posts->big_theme=$request->big_theme;

            $returnvalue=[];

            // 小テーマのチェック
            if($this->small_check($posts,$request)!=="ok"){
            $returnvalue[]=$this->small_check($posts,$request);
            }
      
    
            // 内容のチェック
            if($this->cont_check($posts,$request)!=="ok"){
               $returnvalue[]=$this->cont_check($posts,$request);
            }
            
            // 参考のチェック
            if($this->refer_check($posts,$request)!=="ok"){
               $returnvalue[]=$this->refer_check($posts,$request);
            }

            // URLのチェック
            if($this->url_check($posts,$request)!=="ok"){
               $returnvalue[]=$this->url_check($posts,$request);
            }

            // 意識のチェック
            if($this->conscious_check($posts,$request)!=="ok"){
               $returnvalue[]=$this->conscious_check($posts,$request);
            }

            // 条件を満たしていない場合は例外を投げる
            if(!empty($returnvalue)){
               $returnword=implode(",",$returnvalue);
               throw new \PDOException($returnword);
            }
            

            $posts->small_theme=$request->small_theme;
      
            if($request->contents){
               $posts->contents=self::h($request->contents);
            }
            
            if($request->reference){
               $posts->reference=self::h($request->reference);
            }
           
            if($request->conscious){
               $posts->conscious=self::h($request->conscious);
            }

            $posts->url=$request->linkurl;

            $posts->save();
            DB::commit();
         }catch(\PDOException $e){
            DB::rollback();
            return redirect(route("indexroute"))->with("PDOError",$e->getMessage());
         }

         // ファイル＆データの作成or編集
         $this->create_file_function($request,$posts);

         $change_type="add";
         return redirect(route("indexroute"))->with("change",$change_type);

   }

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
   public function cont_check($posts,$request){
      switch($request->contents){
         case "PHP":
         case "Laravel":
         case "Q_A":
            if(empty($request->contents)){
               return "問題は内容に入力してください";
            }else{
               return "ok";
            }
         break;
         default:
            return "ok";
         break;
      }
   }

   // 参照のチェック
   public function refer_check($posts,$request){
      switch($request->reference){
         case "Q_A":
            if(empty($request->contents)){
               return "解答は内容に入力してください";
            }else{
               return "ok";
            }
         break;
         default:
            return "ok";
         break;
      }
   }

   // 意識のチェック
   public function conscious_check($posts,$request){
      return "ok";
   }

   // urlのチェック
   public function url_check($posts,$request){
      switch($request->big_theme){
         case "PHP":
            // 最後はPHP 必ず選択
            if(empty($request->linkurl)){
               return "URLは必ず入力してください";
            } 
            if(substr($request->linkurl,-4)!==".php"){
               return "リンクの拡張子をPHPにしてください";
            }
         break;
         case "Laravel":
            // テーマごとに別々のリストが作成される
            if(!empty($request->linkurl)){
               return "URLは空白にしてください(自動で作成します)";
            } 
         break;
         case "Javascript":
         case "html/css":
         case "environment":
            if(empty($request->linkurl)){
               return "URLは必ず入力してください";
            } 
            if(substr($request->linkurl,-4)!==".php"
               && substr($request->linkurl,-5)!==".html"
            ){
               return "リンクの拡張子をHTMLかPHPにしてください";
            }
         break;
         case "Q_A":
            if(!empty($request->linkurl)){
               return "リンクは無効です";
            }
         break;
      }
      return "ok";
   }


   // ファイルの作成
   public function create_file_function($request,$posts){

      if(!empty($request->conscious)){
         $cons_to_file=$request->conscious;
      }else{
         $cons_to_file="";
      }

      // urlのあるものは記入していく
      if($request->linkurl){
         $file_dir=dirname(__FILE__,4)."/public/titles/";
         $big_link=$file_dir.$request->big_theme;
         if(!file_exists($big_link)){
            mkdir($big_link);
         }

         // 最初に書く文面
         // linkurlがphpかhtmlかで分ける
         switch(substr($request->linkurl,-3)){
            case "php":
              $sentence= "<?php\n echo('さぁ楽しもう！');\n echo nl2br(\"\\n\\n\");\n echo nl2br(\"".$cons_to_file."\"); ";
            break;
            case "tml":
               switch($request->big_theme){
                  case "html/css":
                  case "Javascript":
                  $sentence=
                  "<h1>さぁ楽しもう！</h1>\n<p>".$cons_to_file."</p>";
                  break;
                  case "Environment":
                     $sentence=
                     "<h3>現在の環境を考えて不都合のない範囲でやってみよう！！<br>無理そうだったり時間のない場合は暗証してみよう！！</h3>\n<p>".$cons_to_file."</p>";                  
                  break;
                 }
            break;
         }


         // PHP,の時＝中テーマ以下にもリンクを作成
         switch($request->big_theme){
            case "PHP":
               $small_link=$big_link."/".$request->small_theme;
               // もう１段階ディレクトリを必ず作成
              if(!file_exists($small_link)){
                 mkdir($small_link);
               } 
               // ファイルにアウトプットして出力
                 file_put_contents($small_link."/".$posts->url,$sentence);
               break;
            case "Javascript":
            case "HTML/CSS":
            case "Environment":
               // ファイルにアウトプットして出力
               file_put_contents($big_link."/".$posts->url,$sentence);
            break;
         }
      }
   }

}
