<fieldset class="add_form">

<legend>消去の場合</legend>

<form action="{{ route("deleteroute") }}" method="post">
  @method("DELETE")
  @csrf
  @include("changepart",["id_num"=>4])

  <div class="edit_decide_tehem_frame">
    <label class="edit_decide_theme" for="delete_kind">消去するテーマ
      <select  id="delete_kind" name="delete_category">
        <option type="hidden" id="delete_category_default">選択してください</option>
        <option value="small_theme">小テーマ</option>
        <option value="contents">内容</option>
      </select>
  </div>

  @include("view_error", ["type" => "", "ver" => "delete"])

  <div class="plus_button_div">
    <button id="delete_button">消去！</button>
  </div>
  <input type="hidden" name="delete_item">
</form>

</fieldset>