<div class="big_frame">
  <label>大テーマ</label>
<select name="big_theme" id="big_theme{{$id_num}}">
    <option hidden>選択してください</option>
    @foreach ($big_array as $big_str)
    <option>{{$big_str}}</option>
    @endforeach
  </select>
  </div>

 <div class="small_frame">
  <label>小テーマ</label>
  <select name="small_theme" id="select_small_theme{{$id_num}}">
    <option hidden value="no_select">選択してください</option>
        @foreach($big_array as $each_big)
        @if(Arr::has($small_array,$each_big))
          <optgroup class="optg_s{{$id_num}}" data-theme{{$id_num}}="{{$each_big}}" label="{{$each_big}}">
            @foreach($small_array[$each_big] as $each_small)
          <option class="small_option" data-big{{$id_num}}="{{ $each_big }}" data-this_id="{{$each_small["id"]}}" value="{{$each_small["small_theme"]}}">{{ $each_small["small_theme"] }}</option>
            @endforeach
          </optgroup>
        @endif
    @endforeach
  </select>
  </div> 

 <div class="cont_frame">
  <label>内容</label>
 <select name="cont_change{{$id_num}}" id="cont_change{{$id_num}}">
    <option hidden value="no_select">選択してください</option>
    {{-- 大テーマを見ていく --}}
    @foreach ($big_array as $each_big)
    {{-- それぞれの大テーマをキーに持つ小テーマを見ていく --}}
    @if(Arr::has($small_array,$each_big))
      @foreach($small_array[$each_big] as $small_parts)
     {{-- その大テーマ＆小テーマのキーがセットされている、内容の配列を見ていく --}}
      @if(Arr::has($cont_array,substr($each_big,0,3)."_".$small_parts["small_theme"]))
      <optgroup  class="optg_c{{$id_num}}" data-small_theme{{$id_num}}="{{$small_parts["small_theme"]}}" label="{{$small_parts["small_theme"]}}">
        @foreach ($cont_array[substr($each_big,0,3)."_".$small_parts["small_theme"]] as $cont_parts)
        ))
        <option class="cont_option" data-this_id="{{$cont_parts["id"]}}">{{$cont_parts["contents"]}}</option>
        @endforeach 
      </optgroup>
      @endif
     @endforeach
     @endif
    @endforeach
  </select>
  </div> 
