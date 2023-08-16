"use strict"

// edit処理
$(()=>{

// ①大テーマのchange(functionでまとめたい)
for(let id_num=2;id_num<5;id_num++){

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
    cont_auto_format(id_num,"n");

    // 参照を初期化
    // refer_auto_format(id_num);

    // 変更するテーマの入力状況
    change_kind_change(id_num);

    // 入力初期化
    auto_input(id_num);

  })

  // 小テーマが変化した時
  // 内容を小テーマで変換
  $("#select_small_theme"+id_num).change(()=>{
    // 内容必ず組は変更、意識することもリストも内容必ず組はいらない
    if($("#cont_must_for_index").val().includes($("#big_theme"+id_num).val())){
      cont_auto_format(id_num,"y");
      cont_from_small_change(id_num);
      auto_input(id_num);
    }else if(id_num===3){
     // 内容必ず組ではない時、かつ意識変更の際
     // 意識することの記入
     set_conscious_to_html(base64_to_string($("#conscious_sets_by_json").val()),false)
    }
  })


  // 内容が変化したらinputの内容を変更
  $("#cont_change"+id_num).change(()=>{
    if(id_num===3){
      // 内容ありの意識変更の際
      set_conscious_to_html(base64_to_string($("#conscious_sets_by_json").val()),true)
    }else{
      // 意識変更ではない場合
      // inputの内容を変更
      auto_input(id_num); 
    }
  })

  
  // テーマが変更→変更する名称の変更
  // 編集のみの機能
  if(id_num===2){
    $("#change_kind").change(()=>{
      auto_input(id_num);
    });
  }

}


// 意識することにセット
function set_conscious_to_html(all_data,which){
  const its_small=($("#select_small_theme3").val()) 

  all_data.forEach((aaa)=>{
    // contentが必要かで処理を分ける
    if(which){
      if(aaa.big_theme===$("#big_theme3").val() 
      && aaa.small_theme===$("#select_small_theme3").val()
      && aaa.contents===$("#cont_change3").val()
      ){
        $("#edit_conscious_textarea").text(aaa.conscious);
      }
    }else{
      if(aaa.big_theme===$("#big_theme3").val() 
      && aaa.small_theme===$("#select_small_theme3").val()
      ){
        $("#edit_conscious_textarea").text(aaa.conscious);
      }
    }
  })

}

// base64→string
function base64_to_string(compressData){
  const decodeData=atob(compressData);
  return JSON.parse(pako.inflate(decodeData, { to: 'string' }));
}




// 内容の初期化
function cont_auto_format(id_num,y_or_n){
  if(y_or_n==="y"){
    $("#cont_change"+id_num).val("no_select");  
    $("#cont_change"+id_num).css("opacity","1");  
    $("#cont_change"+id_num).find("optgroup").css("display","inline");
  }else if(y_or_n==="n"){
    $("#cont_change"+id_num).val("no_select");  
    $("#cont_change"+id_num).css("opacity","0.3");  
    $("#cont_change"+id_num).find("optgroup").css("display","none");
  }else{
    console.log("error!");
  }
}

function refer_auto_format(id_num){
  $("#cont_change"+id_num).val("no_select");  
  $("#cont_change"+id_num).css("opacity","0.3");  
  $("#cont_change"+id_num).find("optgroup").css("display","none");
}




// 内容を小テーマで変換
function cont_from_small_change(id_num){
 
    $(".optg_c"+id_num).each((i,elem)=>{
     if($("#select_small_theme"+id_num).val()===$(elem).data("small_theme"+id_num)){
        $(elem).css("display","inline");
      }else{
        $(elem).css("display","none");
      }
    })
    
}


// 大テーマ変更によるテーマ選択の変更
function change_kind_change(id_num){
  // 内容を非表示にする場合
    if(!$("#cont_must_for_index").val().includes($("#big_theme"+id_num).val())){

      // 以下の例文コードを行う！
      // 特定のオプションタグを非表示にする方法
    //       var select = document.getElementById("mySelect");  // <select>要素を取得

    // for (var i = 0; i < select.options.length; i++) {
    //   var option = select.options[i];  // 各<option>要素を取得

    //   if (option.value === "hide") {
    //     option.style.display = "none";  // 特定の値を持つ<option>要素を非表示にする
    //   }
    // }
    }
  // URLを非表示にする場合

}



// 名称を自動入力
function auto_input(id_num){

    switch($("#change_kind").val()){
      case "small_theme":
        $("#edit_item_id").val($("#select_small_theme"+id_num).find(".small_option:selected").data("this_id"));
        $("#change_words").text($("#select_small_theme"+id_num).val());
        cont_auto_format(id_num,"n");
      break;

      case "contents":
        if($("#cont_must_for_index").val().includes($("#big_theme"+id_num).val())){
          // 他のchange_kindからcontentsに移動した時のみ表示を再設定
          if($("#cont_change"+id_num).css("opacity")=="0.3"){
            cont_auto_format(id_num,"y");
          }
          cont_from_small_change(id_num);
        }else{
          cont_auto_format(id_num,"n");
        }
        $("#edit_item_id").val($("#cont_change"+id_num).find(".cont_option:selected").data("this_id"));
        $("#change_words").text($("#cont_change"+id_num).val());  

      break;

      case "refer":

      let refer_base="";
      let refer_text="";
      let select_bool=true;


      if($("#cont_must_for_index").val().includes($("#big_theme").val())){

        refer_base=[$("$big_theme"+id_num).val(),$("#select_small_theme"+id_num).val(),$("#cont_change"+id_num).val()];
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
          $("#change_words").text("未選択");  
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


// 意識することリストに自動入力




});