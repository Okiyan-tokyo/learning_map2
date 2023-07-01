<x-layout>

  <x-slot name="title">既存テーマの編集</x-slot>
  <script differ src={{url("js/exist_conf.js")}}></script>

  @empty(session("config_exist_edit_ok"))
  @else
  <p class="conf_message">{{session("config_exist_edit_ok")}}</p>
  @endempty

  <h2 id="conf_h2">既存テーマ編集</h2>

  @empty(session("exist_conf_error"))
  @else
    <p class="if_error">{{session("exist_conf_error")}}</p>
  @endempty

@foreach ($errors->all() as $error)
  {{-- {{dd($errors->all())}} --}}
  <li>{{$error}}</li>
@endforeach

@error("type1")
 <p class="if_error">{{$message}}</p>
@enderror

</div>
  {{-- formはjqueryからsubmit:implicit bindingを使うため 
   display:noneで非表示にする --}}
  {{-- 決定ボタンが押されたらjqueryで「①編集する大テーマを選んでください」でチェックされている番目のexist_themeのidを、implicit bindingで投稿 --}}
@foreach ($exist_theme as $et)
  <form action="{{route("conf_patch_route",$et->id)}}" method="post" class="exist_bigtheme_edit_form" >
    @method("PATCH")
    @csrf
    {{-- ②行う操作をを選んでくださいでどう変更するか。変更後の値をjqueryでセット --}}
    <input type="hidden" class="input_type1" name="type1" value="">
    {{-- ③どのように変更するかを選んでくださいでどう変更するか。変更後の値をjqueryでセット --}}
    <input type="hidden" class="input_type2" name="type2" value="">
  </form>
@endforeach

 <div class="exist_bigtheme_edit_bigclass">
    <div class="existconf_div">
      <p>①編集する大テーマを選んでください</p>
      <div class="existconf_radioparts_fulldiv">
       <?php $num=0;?>
      @foreach ($exist_theme as $et)
        <div class="existconf_bigtheme_radiodiv">
        <input type="radio" name="existconf_bigtheme" class="existconf_radio1" data-big_name="{{ $et["big_theme"]}}" value="{{$et["id"]}}" data-formeq="{{$num}}">{{$et["big_theme"]}}       
        </div>
     <?php $num++ ?>
      @endforeach
      </div>
      <span id="existconf_next1">次へ</span>
    </div>
    
    <div class="existconf_div">
      <p>②行う操作をを選んでください</p>
      <div class="existconf_radioparts_fulldiv">
        <p>大テーマ：<span class="existconf_selected_bigtheme"></span></p>
        <div  class="existconf_what_radiodiv"><input type="radio" name="existconf_editwhat_radio" value="theme_name" class="existconf_radio2" data-what="テーマ名">大テーマ名の変更</div>
        <div  class="existconf_what_radiodiv"><input type="radio" name="existconf_editwhat_radio" value="cont" class="existconf_radio2" data-what="内容有無">内容の有無の変更</div>
        <div  class="existconf_what_radiodiv"><input type="radio" name="existconf_editwhat_radio" value="file_type" class="existconf_radio2" data-what="ファイルタイプ">ファイルタイプの変更</div>
        <div  class="existconf_what_radiodiv"><input type="radio" name="existconf_editwhat_radio" value="theme_delete" class="existconf_radio2">削除</div>
      </div> 
        <div id="existconf_spanSets">
          <span id="existconf_next2">次へ</span>
          <span id="existconf_back1">戻る</span>
        </div>


    </div>
 
    <div class="existconf_div">
      <p>③どのように変更するかを選んでください</p>
      <div class="existconf_radioparts_fulldiv existconf_radioparts_fulldiv2">
        <p><span class="existconf_selected_bigtheme"></span>の<span class="existconf_selected_what"></span></p>
      </div>

      <div class="existconf_if_namechange">
        
        {{-- 名称変更 --}}
        <div class="type2_each_div">
          <p class="exist_conf_type2_p">新しい名称を設定してください</p>
          <input type="text" id="existconf_namechanege">
        </div>

        {{-- 内容設定の有無 --}}
        <div class="type2_each_div">
          <p class="exist_conf_type2_p">内容設定の有無</p>
          <div class="existconf_radiosets_type2">
            <input type="radio" name="radio_cont" class="exist_conf_contradio" value="yes">設定する
            <input type="radio" name="radio_cont" class="exist_conf_contradio" value="no">設定しない
          </div>
        </div>

        {{-- ファイル変更 --}}
        <div class="type2_each_div">
          <p class="exist_conf_type2_p">ファイルの設定</p>
          <div class="existconf_radiosets_type2">
          @foreach($file_eng as $fe)
            <input type="radio" class="exist_conf_fileradio"  name="file_cont" value="{{$fe}}">{{$file_jpn[$fe]}}
          @endforeach
          </div>
        </div>

      </div>

      <span id="existconf_back2">戻る</span>  
    </div>  
      
    <div id="existconf_button_div">
      <button id="existconfig_button">決定！</button>
    </div>
    
  </div>


<div class="back_home">
  <p><a href="{{route("indexroute")}}">戻る</a></p>
</div>

</x-layout>