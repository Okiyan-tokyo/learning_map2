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
</div>

<div class="plus_button_div">
  <button id="edit_button">名称の編集！</button>
</div>
</form>

{{-- エラーページ：拡張子 --}}
@include("view_error",(["type"=>"linkurl","ver"=>"edit"]))    



<p class="to_conscious">意識することは<a href="{{route("edit_conscious_route")}}">こちらへ</a></p>

</fieldset>