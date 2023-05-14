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
  let big_top=$(".each_title").eq(0).offset().top;
  let add_top=$(".crud_list").eq(0).offset().top;
  if(big_top>e.clientY || add_top<e.clientY){
    $(".read_contents_cont").css("display","none");
    $(".read_contents_small").css("display","none");
    }
})


// crud表示
$(".field_display").each((i,elem)=>{
  $(elem).click(()=>{
    $("fieldset").css("display","none");
    $("fieldset").eq(i).css("display","block");
  })
});




// jqueryの終端
})