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
    @case("edit_conscious")
      <p class="add_theme">項目の意識することを<br>変更しました！</p>
    @break
    @case("delete")
      <p class="add_theme">項目を削除しました！</p>
    @break
  @endswitch
@endempty


{{-- エラーページ --}}
@include("view_error",(["type"=>"","ver"=>""]))


{{-- 実験用 --}}
@include("view_error",(["type"=>"","ver"=>"edit_conscious"]))




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
  <p class="field_display">Edit_Conscious</p>
  <p class="field_display">Delete</p>
  <p class="to_config_page"><a href="{{route("configroute")}}">Config</a></p>
</div>

{{-- jquery用：contents必要リスト --}}
<input type="hidden" id="cont_must_for_index" value="{{$cont_must_for_index}}">


{{-- 追加ページの呼び出し --}}
@include("addpart",([
  "big_array"=>$big_array,
  "small_array"=>$small_array,
]))


{{-- 編集ページの呼び出し --}}
@include("get_edit")

{{-- 編集ページの呼び出し --}}
@include("get_edit_conscious")

{{-- 消去ページの呼び出し --}}
@include("get_delete")


</x-layout>