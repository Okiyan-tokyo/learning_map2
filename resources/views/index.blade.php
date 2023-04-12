<x-layout>

<header>
  <h1>プログラミング学習サイト！</h1>
</header>


@empty(session("change"))
@else
  @switch(session("change"))
    @case("add")
      <p class="add_theme">項目を追加しました！</p>
    @break
    @case("edit")
      <p class="add_theme">項目を変更しました！</p>
    @break
    @case("delete")
      <p class="add_theme">項目を削除しました！</p>
    @break
  @endswitch
@endempty

@empty(session("PDOError"))
@else
<p class="add_theme">{{session("PDOError")}}</p>
@endempty

<div class="each_title">
@foreach ($big_array as $big_str)
<div class="read_big_theme" data-read_big="{{$big_str}}">{{$big_str}}</div>
@endforeach
</div>
@foreach ($big_array as $big_str)
  @if (Arr::has($small_array, $big_str))
    @foreach($small_array[$big_str] as $small_parts)
<div class="read_contents_small" data-read_small_relatebig="{{$big_str}}">{{$small_parts["small_theme"]}}</div>
     @if(Arr::has($cont_array,substr($big_str,0,3)."_".$small_parts["small_theme"]))
        @foreach($cont_array[substr($big_str,0,3)."_".$small_parts["small_theme"]] as $c)
       
          <div class="read_contents_cont" data-read_cont_relatesmall="{{$small_parts["small_theme"]}}">
            {{$c["contents"]}}
          </div>
        @endforeach
      @endif
    @endforeach
  @else
  @endif
@endforeach


<fieldset class="add_form">
<legend>追加の場合</legend>
<form method="post" action="{{ route("plusroute") }}" >
  @csrf
  
  <div class="big_frame">
  <label for="big_theme">大テーマ</label>
  <select name="big_theme" id="big_theme">
    <option hidden>選択してください</option>
    @foreach ($big_array as $big_str)
    <option>{{$big_str}}</option>
    @endforeach
  </select>
  </div>
  @error('big_theme')
     <p class="if_error"> {{$message}}</p>
  @enderror
  
  <div class="small_frame">
  <label for="small_theme">小テーマ</label>
  <div id="small_theme">
    
    <label for="small_exist">
    <input type="radio" 
    name="small_which" 
    id="small_exist"
    value="exists">
    既存テーマ</label>
    <select id="select_small_theme">
      <option hidden id="option_hidden" value="no_select">選択してください</option>
      @foreach($big_array as $each_big)
     <optgroup data-theme="{{$each_big}}" label="{{$each_big}}">
        <?php if(array_key_exists($each_big,$small_array)){ ?>
          @foreach($small_array[$each_big] as $each_small)
          <option class="small_option" data-big="{{ $each_big }}">{{ $each_small["small_theme"] }}</option>
          @endforeach
          <?php } ?>
      </optgroup>
      @endforeach
      </select>
    <br>
    <label for="small_new">
    <input id="small_new" type="radio" name="small_which" value="new">
    新規テーマ</label>
    <input id="input_small_theme"  type="text">
 
  </div>
</div>

@error('small_theme')
  <p class="if_error"> {{$message}}</p>
@enderror


  <div class="cont_frame">
  <label for="contents">内容（クイズなら問題）</label>
  <input name="contents" type="text"  id="contents" value={{old("contents")}}>
  </div>

  <div class="refer_frame">
  <label for="reference">参考（クイズなら解答）</label>
  <input name="reference" type="text"  id="references" value={{old("reference")}}>
  </div>
  
  <div class="conscious_frame">
  <label for="concsious">意識することリスト</label>
  <textarea name="conscious" id="conscious" placeholder="空白可。改行で内容を区切ってください" rows="10">{{old("conscious")}}</textarea>
  </div>
  
  <div class="cont_frame">
    <label for="linkurl">URL</label>
    <input name="linkurl" type="text"  id="linkurl" value={{old("linkurl")}}>
  </div>

    <div class="plus_button_div">
      <button>追加！</button>
    </div>
  </form>
</fieldset>



<fieldset class="add_form">

<legend>編集の場合(意識以外)</legend>


<form action="{{ route("editroute") }}" method="post">
  @method("PATCH")
  @csrf

  <p>編集する項目を選んでください</p> 

 @include("changepart",["id_num"=>2])

 <div class="edit_decide_item_div">
  <label class="edit_decide_item" for="change_kind">変更するテーマ
    <select  id="change_kind" name="category">
      <option value="small_theme">小テーマ</option>
      <option value="contents">内容</option>
      <option value="refer">参照</option>
      <option value="URL">URL</option>
    </select>
</div>


 <div class="edit_decide_item_div">
  <label class="edit_decide_item" for="change_what">変更する項目
    <input type="hidden" id="edit_item_id" name="edit_item_id">
    <p><span id="change_words">まだ選択されていません</span></p>
  </label>
 </div>

 <div class="edit_decide_name_div">
  <label  class="edit_decide_name" for="change_name">変更後の名称
     <input id="chagne_name" type="text" name="after_edit_name">
  </label>
  @error('after_edit_name')
    <p class="if_error"> {{$message}}</p>
  @enderror
</div>



  <div class="plus_button_div">
    <button id="edit_button">名称の編集！</button>
  </div>
</form>

<p class="">意識することは<a href="{{route("indexroute")}}">こちらへ</a></p>

</fieldset>


<fieldset class="add_form">

  <legend>消去の場合</legend>

<form action="{{ route("deleteroute") }}" method="post">
  @method("DELETE")
  @csrf
  @include("changepart",["id_num"=>3])
  <div class="plus_button_div">
    <button id="delete_button">消去！</button>
  </div>
  <input type="hidden" name="delete_item">
</form>

<p class="">意識することは<a href="{{route("indexroute")}}">こちらへ</a></p>
</fieldset>


</x-layout>