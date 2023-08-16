
  {{-- typeのエラーメッセージがあれば表示 --}}
  

 @error($type)
    <div class="add_error" style="display:none"></div>
    <p class="if_error"> {{$message}}</p>
    <script src="{{url("js/error.js")}}"></script>
  @enderror

  {{-- PDOERRORは内容により表示を分ける --}}
  @empty(session("PDOError"))
  @else
   @empty(session("ver"))
   @else
    @if($ver===session("ver"))
      @switch($type)
        @case("big_theme")
          @foreach(explode("\n",session("PDOError")) as $each)
            @if(str_contains($each,"大テーマ"))
              <div class="add_error" style="display:none;">{{$ver}}</div>
              <p class="add_theme">{{$each}}</p>
              <script src="{{url("js/error.js")}}"></script>
            @endif
          @endforeach
        @break;
        @case("small_theme")
          @foreach(explode("\n",session("PDOError")) as $each)
            @if(str_contains($each,"小テーマ"))
              <div class="add_error" style="display:none;">{{$ver}}</div>
              <p class="add_theme">{{$each}}</p>
              <script src="{{url("js/error.js")}}"></script>
            @endif
          @endforeach
        @break;
        @case("contents")
          @foreach(explode("\n",session("PDOError")) as $each)
          @if(str_contains($each,"内容は入力") || str_contains($each,"問題は内容"))
            <div class="add_error" style="display:none;">{{$ver}}</div>
              <p class="add_theme">{{$each}}</p>
              <script src="{{url("js/error.js")}}"></script>
          @endif
          @endforeach
        @break
        @case("linkurl")
          @foreach(explode("\n",session("PDOError")) as $each )
            @if(str_contains($each,"URL") ||  str_contains($each,"拡張子"))
            <div class="add_error" style="display:none;">{{$ver}}</div>
            <p class="add_theme">{{$each}}</p>
            <script src="{{url("js/error.js")}}"></script>
            @endif
            @endforeach
        @break
        @default
        @foreach(explode("\n",session("PDOError")) as $each)
            <div class="add_error" style="display:none;">{{$ver}}</div>
              <p class="add_theme">{{$each}}</p>
              <script src="{{url("js/error.js")}}"></script>
          @endforeach
        @break              
      @endswitch
     @endif
    @endempty
  @endempty