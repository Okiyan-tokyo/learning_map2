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
  })
}








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
function auto_input(){
  $("#change_kind").change(function(e){
    switch($(e.target).val()){
      case "small_theme":
        $("#change_what").val();
        $("#change_words").val();        
      break;
      case "contents":
        $("#change_what").val();
        $("#change_words").val();
      break;
      case "refer":
        $("#change_what").val();
        $("#change_words").val();
      break;
      case "URL":
        $("#change_what").val();
        $("#change_words").val();
      break;
    }
  })
}



});