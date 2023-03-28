<x-layout>

<header>
  <h1>プログラミング学習サイト！</h1>
</header>

@empty(session("add"))
@else
  <p class="add_theme">項目を追加しました！</p>
@endisset

@empty(session("PDOError"))
@else
<p class="add_theme">{{session("PDOError")}}</p>
@endisset


<div class="each_title">
@foreach ($big_array as $big_str)
<div class="read_big_theme" data-read_big="{{$big_str}}">{{$big_str}}</div>
@endforeach
</div>
@foreach ($big_array as $big_str)
  @if (Arr::has($small_array, $big_str))
    @foreach($small_array[$big_str] as $small_str)
<div class="read_contents_small" data-read_small_relatebig="{{$big_str}}">{{$small_str}}</div>
     @if(Arr::has($cont_array,substr($big_str,0,3)."_".$small_str))
        @foreach($cont_array[substr($big_str,0,3)."_".$small_str] as $c)
          <div class="read_contents_cont" data-read_cont_relatesmall="{{$small_str}}">{{$c}}</div>
        @endforeach
      @endif
    @endforeach
  @else
  {{-- {{"ないぜ"}} --}}
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
          <option class="small_option" data-big="{{ $each_big }}">{{ $each_small }}</option>
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
<legend>編集の場合</legend>
<form action="" method="post">
  @method("PATCH")
  @csrf
  <p>編集する項目を選んでください</p>
  <div class="big_frame">
    <label for="big_theme2">大テーマ</label>
    <select name="big_theme2" id="big_theme2">
      <option hidden>選択してください</option>
      @foreach ($big_array as $big_str)
      <option>{{$big_str}}</option>
      @endforeach
    </select>
    </div>


  <div class="plus_button_div">
    <button>編集！</button>
  </div>
  </form>
</fieldset>

</fieldset>

</x-layout>