<x-layout>
  <x-slot name="title">プログラミング学習サイト</x-slot>
  <script defer src="{{url("js/learn.js")}}"></script>
  <script defer src="{{url("js/create.js")}}"></script>
  <script defer src="{{url("js/edit.js")}}"></script>
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

<p class="add_theme">{!! nl2br(e(session("PDOError")))!!}</p>
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


{{-- crud_list--}}
<div class="crud_list">
  <p class="field_display">Add</p>
  <p class="field_display">Edit</p>
  <p class="field_display">Delete</p>
  <p class="to_config_page"><a href="{{route("configroute")}}">Config</a></p>
</div>

{{-- 追加ページの呼び出し --}}
@include("addpart",([
  "big_array"=>$big_array,
  "small_array"=>$small_array,
]))



<fieldset class="add_form">

<legend>編集の場合(意識以外)</legend>


<form action="{{ route("editroute") }}" method="post">
  @method("PATCH")
  @csrf

  <p>編集する項目を選んでください</p> 

 @include("changepart",["id_num"=>2])

 <div class="edit_decide_tehem_frame">
  <label class="edit_decide_theme" for="change_kind">変更するテーマ
    <select  id="change_kind" name="category">
      <option type="hidden" id="edit_category_default">選択してください</option>
      <option value="small_theme">小テーマ</option>
      <option value="contents">内容</option>
      <option value="refer">参照</option>
      <option value="URL">URL</option>
    </select>
</div>


 <div class="edit_decide_item_frame">
  <label class="edit_decide_item">変更する項目：<span id="change_words">まだ選択されていません</span>
  <input type="hidden" id="edit_item_id" name="edit_item_id">
  </label>
 </div>

 <div class="edit_decide_name_frame">
  <label  class="edit_decide_name" for="change_name">変更後の名称
     <input id="change_name" type="text" name="after_edit_name">
  </label>
  @error('after_edit_name')
    <p class="if_error"> {{$message}}</p>
  @enderror
</div>



  <div class="plus_button_div">
    <button id="edit_button">名称の編集！</button>
  </div>
</form>

<p class="to_conscious">意識することは<a href="{{route("edit_conscious_route")}}">こちらへ</a></p>

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

<p class="to_conscious">意識することは<a href="{{route("delete_conscious_route")}}">こちらへ</a></p>
</fieldset>



</x-layout>