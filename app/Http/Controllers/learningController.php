<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learntheme;
use App\Models\Big_Theme;
use App\Http\Requests\Learning_Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CheckController;

class learningController extends Controller
{   

   // static $big_array=["PHP","Laravel","Javascript","html/css","Environment","Q_A"];

   static public function h($moji){
      return htmlspecialchars($moji);
   }


   public function showindex(){

      $big_array=[];
      $big_theme_base=Big_theme::select("big_theme")->get();
      
      foreach($big_theme_base as $b){
         $big_array[]=$b->big_theme;
      }
      $big_array[]="Q&A";


      $cont_must_for_index=Big_theme::where("cont_which","=",1)->pluck('big_theme');



      $small_full=[];
      $cont_require_full=[];

      foreach($big_array as $b){
         // bは確実に上記列のどれか
         $small_by_big=Learntheme::select("id","small_theme")->where("big_theme","=",$b)->get();
         if(!empty($small_by_big)){
            foreach($small_by_big as $s){
               if(!array_key_exists($b,$small_full)){
                  $small_full[$b][]=$s;
               }else{
                  foreach($small_full[$b] as $sb){
                     // PHP限定：小テーマで内容を２つ以上入れてる時に表示は1回のみ
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


      // 意識することリストを返す
      $conscious_list=Learntheme::select("id","big_theme","small_theme","contents","conscious")->get();


      $base64_conscious = base64_encode(gzencode(json_encode($conscious_list),9));
      
      return view("index")->with([
         "big_array"=>$big_array,
         "small_array"=>$small_full,
         "cont_array"=>$cont_require_full,
         "cont_must_for_index"=>$cont_must_for_index,
         "base64_conscious"=>$base64_conscious
      ]);
   }

   public function learning_plus(Learning_Requests $request){
      
      DB::beginTransaction();
         try{
            $posts=new Learntheme();

            // big_themeはバリデーションで弾けてる
            $posts->big_theme=$request->big_theme;

            $returnvalue=[];
            
            // check用のクラス
            $check_class=new CheckController();

            // コードの短縮用
            $r1=$request->big_theme;
            $r2=$request->small_theme;
            $r3=$request->contents;
            $r4=$request->reference;
            $r5=$request->conscious;
            $r6=$request->linkurl;

            // 小テーマのチェック
            if($check_class->small_check($posts,$request)!=="ok"){
            $returnvalue[]=$check_class->small_check($posts,$request);
            }
      
            // 内容のチェック
            if($check_class->cont_check($r1,$r2,$r3)!=="ok"){
               $returnvalue[]=$check_class->cont_check($r1,$r2,$r3);
            }
            
            // 参考のチェック
            if($check_class->refer_check($r1,$r4)!=="ok"){
               $returnvalue[]=$check_class->refer_check($r1,$r4);
            }
            
            // 意識のチェック
            if($check_class->conscious_check($r1,$r5)!=="ok"){
               $returnvalue[]=$check_class->conscious_check($r1,$r5);
            }

            // URLのチェック
            if($check_class->url_check($r1,$r2,$r6)!=="ok"){
               $returnvalue[]=$check_class->url_check($r1,$r2,$r6);
            }
         

            // 条件を満たしていない場合は例外を投げる
            if(!empty($returnvalue)){
               $returnword=implode("\n",$returnvalue);
               throw new \PDOException($returnword);
            }
            

            $posts->small_theme=self::h($r2);
      
            if($r3){
               $posts->contents=self::h($r3);
            }
            
            if($r4){
               $posts->reference=self::h($r4);
            }
           
            if($r5){
               $posts->conscious=self::h($r5);
            }

            $posts->url=$r6;
            $posts->save();
            DB::commit();
         }catch(\PDOException $e){
            DB::rollback();
            return redirect(route("indexroute"))->with(["PDOError"=>$e->getMessage(),"ver"=>"add"]);
         }

         // ファイル＆データの作成or編集
         $this->create_file_function($request,$posts);

         $change_type="add";
         return redirect(route("indexroute"))->with("change",$change_type);

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
                  $sentence=
                  "<h1>さぁ楽しもう！</h1>\n<p>".$cons_to_file."</p>";
            break;
         }


         // contentsが必要か否か？
         $cont_which=Big_theme::select("cont_which")->where([
            ["big_theme","=",$request->big_theme]
            ])   
         ->first();

         if(empty($cont_which)){
            return redirect(route("indexroute"))->with(["PDOError"=>"大テーマが登録されていません","ver"=>"add"]);
         }


         if($cont_which->cont_which){
               $small_link=$big_link."/".$request->small_theme;
               // もう１段階ディレクトリを必ず作成
              if(!file_exists($small_link)){
                 mkdir($small_link);
               } 
               // ファイルにアウトプットして出力
                 file_put_contents($small_link."/".$posts->url,$sentence);
            }else{
               // ファイルにアウトプットして出力
               file_put_contents($big_link."/".$posts->url,$sentence);
         }
      }
   }

}
