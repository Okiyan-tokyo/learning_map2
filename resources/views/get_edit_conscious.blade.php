<fieldset class="add_form">

  <legend>意識編集の場合</legend>

<form action="{{ route("edit_conscious_route") }}" method="post">
  @method("PATCH")
  @csrf

  <p>編集する項目を選んでください</p> 

 @include("changepart",["id_num"=>3])


<div class="conscious_change_frame">
  <label class="counscious_list">意識することリスト</label>
  <textarea name="edit_conscious" id="edit_conscious_textarea" placeholder="" rows="10">{{old("conscious")}}</textarea>
</div>

{{-- 意識することリストも入れたjsonをjsに --}}
{{-- 本来はこれだけでも良い！？ --}}
<input type="hidden" name="conscious_json_sets" id="conscious_sets_by_json" value="<?= $base64_conscious ?>">

<div class="plus_button_div">
  <button id="edit_button">編集！</button>
</div>
</form>

{{-- エラーページ：拡張子 --}}
@include("view_error",(["type"=>"linkurl","ver"=>"edit"]))

</fieldset>