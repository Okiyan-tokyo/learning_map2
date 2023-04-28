$(()=>{

// Read処理


// 大テーマにカーソルが当たったら小テーマを表示
$(".read_big_theme").mouseover((e)=>{
  $(".read_contents_small").each((i,elem)=>{
    if($(elem).data("read_small_relatebig")===$(e.target).data("read_big")){
      $(elem).css("display","block");
      // 表示位置
      $(elem).offset({
        left:$(e.target).offset().left+20,
        top:$(elem).offset().top
       }) 

    }else{
      $(elem).css("display","none");
      $(".read_contents_cont").css("display","none");
    }
    // 小テーマにカーソルが当たったら内容を表示
    $(elem).mouseover((e2)=>{
      $(".read_contents_cont").each((i2,elem2)=>{
        if($(elem2).data("read_cont_relatesmall")===$(e2.target).text()){
          $(elem2).css("display","block");
          // 表示位置
          $(elem2).offset({
            left:$(e2.target).offset().left+20,
            top:$(elem2).offset().top,
          })
        }else{
          $(elem2).css("display","none");
        }
      })
    })
  })
})
    
  
// eachtitleの上とadd_formの下は強制的に表示を消す
$("body").mousemove((e)=>{
  let big_top=$(".each_title").offset().top;
  let add_top=$(".add_form").offset().top;
  if(big_top>e.clientY || add_top<e.clientY){
    $(".read_contents_cont").css("display","none");
    $(".read_contents_small").css("display","none");
    }
})





// Create処理

 // // 大テーマの切替で生じる変化

$("#big_theme").change(()=>{

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

  // テーマ、名前が変更がされたらformの内部を変更
  $("#change_what").change(function(){
    $("#edit_item").val($("#change_what").text());
  })
  $("#after_edit_name_base").change(function(){
    $("#after_edit_name").val($("#after_edit_name_base").val());
  })


// jqueryの終端
})