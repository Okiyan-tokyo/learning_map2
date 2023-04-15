  // edit処理
$(()=>{

// ①大テーマのchange(functionでまとめたい)
for(let id_num=1;id_num<4;id_num++){
  $("#big_theme"+id_num).change(()=>{
    // ①小テーマを変更
    // １度現在表示のものを非表示
    $("#select_small_theme"+id_num).val("no_select");
    // 小テーマの動的変更
    $(".optg_s"+id_num).each((i,opt)=>{
      if(($(opt).data("theme"+id_num))===$("#big_theme"+id_num).val()){
        $(opt).css("display","block");
      }else{
        $(opt).css("display","none");
      }
    // optgroupの区切りタグはなくせるか？
    // divで表示させてoptionを生成する方がuiは綺麗かな？
    })   
    // 内容を小テーマで変換
    cont_from_small_change(id_num);
  })

  // 内容を小テーマで変換
  $("#select_small_theme"+id_num).change(()=>{
    cont_from_small_change(id_num);
    auto_input(id_num);
  })


  
}

// テーマが変更→変更する名称の変更
// 編集のみの機能
$("#change_kind").change(function(){
  console.log("a");
  auto_input(2);
});






// function集
// 内容を小テーマで変換
function cont_from_small_change(id_num){
    $("#cont_change"+id_num).val("no_select");
    $(".optg_c"+id_num).each((i,elem)=>{
      if($("#select_small_theme"+id_num).val()===$(elem).data("small_theme"+id_num)){
        $(elem).css("display","inline");
      }else{
        $(elem).css("display","none");
      }
    })
}

// 名称を自動入力
function auto_input(id_num){

    switch($("#change_kind").val()){
      case "small_theme":
        $("#edit_item_id").val($("#select_small_theme"+id_num).find(".small_option:selected").data("this_id"));
        $("#change_words").text($("#select_small_theme"+id_num).val());        
        console.log($("#edit_item_id").val());
      break;
      case "contents":
        $("#edit_item_id").val($("#cont_change"+id_num).find(".cont_option:selected").data("this_id"));
        $("#change_words").text($("#cont_change"+id_num).val());  
      break;
      case "refer":

        $("#change_words").val();
      break;
      case "URL":
        $("#change_words").val();
      break;
    }
}




});