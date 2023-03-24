$(()=>{
  
  // // 大テーマの切替で生じる変化

$("#big_theme").change(()=>{
console.log($("#select_small_theme").val());
  // ①小テーマを変更
    
  // １度現在表示のものを非表示
  $("#select_small_theme").val("no_select");
  // 小テーマの動的変更
  $("optgroup").each((i,opt)=>{
    if(($(opt).data("theme"))===$("#big_theme").val()){
      $(opt).css("display","inline");
    }else{
      $(opt).css("display","none");
    }
  
  // optgroupの区切りタグはなくせるか？
  // divで表示させてoptionを生成する方がuiは綺麗かな？

  })


    //②内容や参考やURLの表示を場合によって切替

  })


  // 小テーマの新規か既存かの切替でnameの変更
  $("input[name='small_which']").click(function(){
    if($("input[name='small_which']:checked").val()==="exists"){
      $("#select_small_theme").attr("name","small_theme")
                              .css("opacity",1)
                              .css("pointer-events","auto");
      $("#input_small_theme").attr("name","")
                             .val("")
                             .css("opacity","0.3")
                             .css("pointer-events","none");
    }else if($("input[name='small_which']:checked").val()==="new"){
      $("#select_small_theme").attr("name","")
                              .css("pointer-events","none")
                              .css("opacity",0.3);
      $("#input_small_theme").attr("name","small_theme")
                              .css("opacity",1)
                              .css("pointer-events","auto");
    }
  })
  
  // 小テーマの選択が押されたらボタン移動
  $("#select_small_theme").change(function(){
    $("input[name='small_which']:eq(0)").prop("checked",true);
  });
  $("#input_small_theme").focus(function(){
    $("input[name='small_which']:eq(1)").prop("checked",true);
  });

})