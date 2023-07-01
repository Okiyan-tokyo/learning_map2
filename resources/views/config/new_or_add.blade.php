
<x-layout>
  <x-slot name="title">
    {{
      $add_or_create==="create" ? "初期設定" : "設定の編集"
      }}
      </x-slot>
  <script differ src={{url("js/conf.js")}}></script>

@empty(session("message"))
@else
<p class="conf_message">{{session("message")}}</p>
@endempty

<h2 id="conf_h2">{{
  $add_or_create==="create" ? "初期テーマ設定" : "テーマの追加"
  }}</h2>

  <p id="go_to_exist_conf">既存テーマを編集する場合は、<br class="br500"><a href="{{route("conf_edit_route")}}">こちら</a>をクリックしてください</p>

  {{-- 初期設定か編集かによって変更する --}}
  {{-- ひとまず初期設定を記入 --}}
  <form action="{{route("conf_add_route")}}" method="post" class="conf_change_form">
    @csrf
    <div class="conf_big_theme_div">
      <p>①「Q&A」以外の大テーマを<br class="br500">決めてください (0~7個)</p>

      @if($add_or_create==="create")
        {{-- 新規作成の場合 --}}
        @for($n=1;$n<=7;$n++)
          <input type="text" name="big_theme_sets{{$n}}" class="conf_big_theme"
          data-baseid="null">
        @endfor
      @else
        {{-- 追加の場合 --}}
        {{-- そのままセクション --}}
        <ul class="non_operate_ul">
        @for($n_add0=1;$n_add0<=$list_long;$n_add0++)
          <li class="non_operate_li">{{$all_lists[$n_add0-1]->big_theme}}</li>      
        @endfor
        </ul>
        {{-- 追加セクション --}}
        @if($list_long<7)
           @for($n_add1=$list_long+1;$n_add1<=7;$n_add1++)
            <input type="text" name="big_theme_sets{{$n_add1}}" class="conf_big_theme" data-baseid="null">
          @endfor
        @endif
      @endif
      <span id="conf_big_to_cont">次へ</span>
    </div>
    <div class="conf_choise_cont_div">
      <p class="conf_choise_p">②大テーマ＞小テーマまでは全ての項目に設定が必要です。その下を、”内容”という括りで、さらに分割するものを選択してください(複数可)</p>
      <div class="conf_which_sets">
        <ul class="non_operate_ul">
        @for($n_add0=1;$n_add0<=$list_long;$n_add0++)
          @if($all_lists[$n_add0-1]->cont_which===1)
          <li class="non_operate_li">{{$all_lists[$n_add0-1]->big_theme}}</li> 
          @endif     
        @endfor
        </ul>
        
        @for($n=$list_long+1;$n<=7;$n++)
        <div class="cont_which_div">
          <input type="checkbox" 
          class="conf_cont_which_input"
        name="cont_which_sets{{$n}}" value="number{{$n}}" id="conf_chk{{$n}}">
        <label class="conf_cont_label" for="conf_chk{{$n}}"></label>
        </div>
        @endfor
      </div>
        <div id="conf_cont_span_sets">
          <span id="conf_cont_to_file">次へ</span>
          <span id="conf_back_bigTheme">戻る</span>
        </div>
      </div>
      <div class="conf_file_div">
        <p>③初期ファイルはどのような形式にするか選んでください</p>
        <ul class="non_operate_ul">
          @for($n_add0=1;$n_add0<=$list_long;$n_add0++)
            <li class="non_operate_li">{{$all_lists[$n_add0-1]->big_theme."・・・".$filelists[$all_lists[$n_add0-1]->file_which]}}</li>   
          @endfor
          </ul>
        @for($n=$list_long+1;$n<=7;$n++)
          <div class="file_which_div">
            <label class="conf_file_from_bigTheme" for="conf_select"></label>
          <select id="conf_select{{$n}}" class="conf_file_which_select"   
            name="file_which_sets{{$n}}" data-baseid="">
            @foreach ($filelists as $f_key=>$f_value)
             <option value="{{$f_key}}">{{$f_value}}</option>    
            @endforeach
            </select>
          </div>
         @endfor
         <span id="conf_back_cont">戻る</span>
    </div>
    <div id="config_button_div">
      <button id="config_button">決定！</button>
    </div>
  </form>

  <div class="back_home">
    <p><a href="{{route("indexroute")}}">戻る</a></p>
  </div>

</x-layout>