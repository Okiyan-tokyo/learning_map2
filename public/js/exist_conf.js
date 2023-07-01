"use strict"

$(()=>{

  // 初期設定
  $(".existconf_div").eq(1).css("display","none");
  $(".existconf_div").eq(2).css("display","none");


  // 大テーマ→操作選択のボタン
  $("#existconf_next1").click(()=>{
    go_to_2();
  })

  // 操作選択→具体名やfetchのボタン
  $("#existconf_next2").click(()=>{
    // 選択されてるradioで変更する
    const radio0=$("input[name='existconf_bigtheme']:checked").data("big_name");
    const radio1=$("input[name='existconf_editwhat_radio']:checked").val();
    
    switch(radio1){
      case "theme_name": 
        go_to_3(radio0,"theme_name");
      break;
      case "file_type": 
        go_to_3(radio0,"file_type");
        break;
      case "cont":
        go_to_3(radio0,"cont");    
      break;
      case "theme_delete":
        exist_conf_submit();
      break;
      default:
        alert("選択されていません");
        // return;
      break;
    }
    return;
  })

  // 操作選択→大テーマのボタン
  $("#existconf_back1").click(()=>{
    go_back_1();
  })

  // 具体名→操作選択のボタン
  $("#existconf_back2").click(()=>{
    go_back_2();
  })
 
  // 決定ボタンでサブミット
  $("#existconfig_button").click(()=>{
    exist_conf_submit();
  })

  
  // 大テーマ→操作選択のfunc
  function go_to_2(){
    $(".existconf_div").eq(0).css("display","none");
    $(".existconf_div").eq(1).css("display","block");
    $(".existconf_div").eq(2).css("display","none");
  }
  // 操作選択→大テーマのfunc
  function go_back_1(){
    $(".existconf_div").eq(0).css("display","block");
    $(".existconf_div").eq(1).css("display","none");
    $(".existconf_div").eq(2).css("display","none");
  }
  
  // 操作選択→具体選択のfunc
  function go_to_3(big_theme,type){

    $(".existconf_div").eq(0).css("display","none");
    $(".existconf_div").eq(1).css("display","none");
    $(".existconf_div").eq(2).css("display","block");
    $("#existconf_button_div").css("display","block");

    // 名称と選択内容の記入
    $(".existconf_selected_bigtheme").text(big_theme);

    // １度全てをnoneにする
    $(".type2_each_div").css("display","none");
    
    // themeごとに設定
    switch(type){
        case "theme_name":
          $(".type2_each_div").eq(0).css("display","block");
          $(".existconf_selected_what").text("テーマ名の変更");
        break;
        case "cont":
          $(".type2_each_div").eq(1).css("display","block");
          $(".existconf_selected_what").text("内容有無の変更");
        break;
        case "file_typw":
          $(".type2_each_div").eq(2).css("display","block");
          $(".existconf_selected_what").text("ファイル設定の変更");
        break;
      // case "theme_delete":
      // break;
      default:
      break;
    }
  }
  
  // 具体選択→操作選択のfunc
  function go_back_2(){
    $(".existconf_div").eq(0).css("display","none");
    $(".existconf_div").eq(1).css("display","block");
    $(".existconf_div").eq(2).css("display","none");
    $("#existconf_button_div").css("display","block");
  }

  // 内容変更のクリックからfetchのfunc
  function exist_conf_submit(){
    //  何番目のformを提出するか？
  const num=$("input[name='existconf_bigtheme']:checked").data("formeq");

   const type1= $("input[name='existconf_editwhat_radio']:checked").val();
   $(".input_type1").eq(num).val(type1);

   
   switch(type1){     
     case "theme_name":
       $(".input_type2").eq(num).val($("#existconf_namechanege").val());
     break;
        
     case "cont":
       $(".input_type2").eq(num).val($("input[name='radio_cont']:checked").val());
     break;
     
     case "file_type":
       $(".input_type2").eq(num).val($("input[name='file_cont']:checked").val());
     break;
     case "delete":
      //  何もしない
     break;
     default:
     break;
   }
  

   console.log(num);
   console.log($(".exist_bigtheme_edit_form").eq(num));
    $(".exist_bigtheme_edit_form").eq(num).submit();
  }



})