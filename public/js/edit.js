  // edit処理
$(()=>{

// ①大テーマのchange(functionでまとめたい)
for(let id_num=2;id_num<4;id_num++){

  // 初期状態ではsmall_themeと内容は選択不可に
  $("#select_small_theme"+id_num).css("opacity","0.3");
  $("#cont_change"+id_num).css("opacity","0.3");
  $("#refer_change"+id_num).css("opacity","0.3");

  $("#select_small_theme"+id_num).find("optgroup").css("display","none");
  $("#cont_change"+id_num).find("optgroup").css("display","none");

  // 参考の非表示・・・後で詳しく！
  // $("#refer_change"+id_num).find("option").css("display","none");



  $("#big_theme"+id_num).change(()=>{
    // 小テーマのopacityを戻す
    $("#select_small_theme"+id_num).css("opacity","1.0");

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

    // 内容を初期化
    $("#cont_change"+id_num).val("no_select");  
    $("#cont_change"+id_num).css("opacity","0.3");  
    $("#cont_change"+id_num).find("optgroup").css("display","none");

    $("#refer_change"+id_num).val("no_select");  
    $("#cont_change"+id_num).css("opacity","0.3");  
    // $("#cont_change"+id_num).find("optgroup").css("display","none");

  })

  // 内容を小テーマで変換
  $("#select_small_theme"+id_num).change(()=>{
    // PHPとクイズの場合のみ追加！
    if(["PHP","Q_A"].includes($("#big_theme"+id_num).val())){
      cont_from_small_change(id_num);
    }
    
    auto_input(id_num);
  })
  
  // テーマが変更→変更する名称の変更
  // 編集のみの機能
  $("#change_kind").change(()=>{
    auto_input(id_num);
  });

}






// function集
// 内容を小テーマで変換
function cont_from_small_change(id_num){
  //  opacityを戻す
  $("#cont_change"+id_num).css("opacity","1.0");
    $("#cont_change"+id_num).val("no_select");
    $(".optg_c"+id_num).each((i,elem)=>{
      if($("#select_small_theme"+id_num).val()===$(elem).data("small_theme"+id_num)){
        $(elem).css("display","inline");
      }else{
        $(elem).css("display","none");
      }
    })
    auto_input(id_num);
}

// 名称を自動入力
function auto_input(id_num){

    switch($("#change_kind").val()){

      case "small_theme":
        $("#edit_item_id").val($("#select_small_theme"+id_num).find(".small_option:selected").data("this_id"));
        $("#change_words").text($("#select_small_theme"+id_num).val());        
      break;

      case "contents":
        $("#edit_item_id").val($("#cont_change"+id_num).find(".cont_option:selected").data("this_id"));
        $("#change_words").text($("#cont_change"+id_num).val());  
      break;

      case "refer":

      let refer_base="";
      let refer_text="";
      let select_bool=true;


      if(["PHP","Q_A"].includes($("#big_theme").val())){

        refer_base=[$("$big_theme"+id_num).val(),$("select_small_theme"+id_num).val(),$("$cont_change"+id_num).val()];
      }else{
        refer_baset=[$("#big_theme"+id_num).val(),$("#select_small_theme"+id_num).val()];
       }

        refer_base.each((i,elem)=>{
          if(elem.val()==="no_select"){
            select_bool=false;
          }
        })
        if(select_bool){
          refer_text=refer_base.join("\/");
          if($("#big_theme"+id_num).val()==="Q_A"){
            $("#change_words").text(refer_text+"の解答");  
          }else{
            $("#change_words").text(refer_text+"の参照");  
          }
        }else{
          $("#change_words").text(refer_text+"の未選択");  
        }
     
  
      break;

      case "URL":
        $("#change_words").val();
      break;
    }
    if($("#change_words").text()==="no_select"){
      $("#change_words").text("未選択");
    }
}




});