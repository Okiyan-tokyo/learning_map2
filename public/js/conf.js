$(()=>{

  // 大テーマ→内容
  $("#conf_big_to_cont").click(()=>{
    $(".conf_choise_cont_div").css("display","block");
    $(".conf_choise_cont_div").css("opacity","1");
    $(".conf_big_theme_div").css("opacity","0.3");
    $(".conf_big_theme").css("pointer-events","none");
    $("#conf_big_to_cont").css("display","none");
    $("#conf_cont_span_sets").css("display","block");

    // テーマの入力
    $(".conf_big_theme").each((i,elem)=>{
      if($(".conf_big_theme").eq(i).val()===""){
        $(".cont_which_div").eq(i).css("display","none");
      }else{
        $(".conf_cont_label").eq(i).text($(".conf_big_theme").eq(i).val());
        $(".conf_cont_which_input").eq(i).data("baseid",$(".conf_big_theme").eq(i).data("baseid"));
      }
    })
  })
  
  // 大テーマ←内容
  $("#conf_back_bigTheme").click(()=>{
    $(".conf_choise_cont_div").css("opacity","0.3");
    $(".conf_big_theme_div").css("opacity","1");
    $(".conf_big_theme").css("pointer-events","auto");
    $("#conf_big_to_cont").css("display","block");
    $("#conf_cont_span_sets").css("display","none");
  })
  
  
  // 内容→ファイル
    $("#conf_cont_to_file").click(()=>{
      $(".conf_file_div").css("display","block");
      $(".conf_choise_cont_div").css("opacity","0.3");
      $(".conf_file_div").css("opacity","1");
      $(".conf_cont_which_input").css("pointer-events","none");
      $("#conf_cont_span_sets").css("display","none");

      // テーマの入力
    $(".conf_big_theme").each((i,elem)=>{
      if($(".conf_big_theme").eq(i).val()===""){
        $(".file_which_div").eq(i).css("display","none");
      }else{
        $(".conf_file_from_bigTheme").eq(i).text("・"+$(".conf_big_theme").eq(i).val());
        $("conf_file_which_select").eq(i).data("baseid",$(".conf_big_theme").eq(i).data("baseid"));
      }
    })


    })
    
    
    // 内容←ファイル
    $("#conf_back_cont").click(()=>{
      $(".conf_choise_cont_div").css("opacity","1");
      $(".conf_file_div").css("opacity","0.3");
      $(".conf_cont_which_input").css("pointer-events","auto");
      $("#conf_cont_span_sets").css("display","block");
      $("#conf_back_cont").css("display","none");
  
    })


})