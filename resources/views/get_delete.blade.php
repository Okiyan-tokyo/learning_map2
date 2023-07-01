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