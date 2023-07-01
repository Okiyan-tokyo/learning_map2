// エラー表示の際
$(()=>{
  
  // add_errorからのreturn
  // そもそもエラーがないと@errorと@PDOException内の.add_errorクラスは出てこない
  // 複数箇所がエラーでも移動は1つのみ。だからeq(0)
  if(!!$(".add_error") && $(".add_error").eq(0).text()!=="ok"){
    $(".add_form").css("display","block");
    let go_scroll_top=$(".add_form").eq(0)[0].getBoundingClientRect().top;
    window.scrollTo(0,go_scroll_top);

    // ２つ以上エラーが生じている時も、１つ目のエラーポイント移動で止めるためのもの
    $(".add_error").eq(0).text("ok");

  }

})
