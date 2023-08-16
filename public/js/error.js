// エラー表示の際
$(()=>{
  
  // add_errorからのreturn
  // そもそもエラーがないと@errorと@PDOException内の.add_errorクラスは出てこない
  // 複数箇所がエラーでも移動は1つのみ。だからeq(0)
  if(!!$(".add_error") && $(".add_error").eq(0).text()!=="ok"){


    let go_scroll_top="";
    
    // 追加/編集/削除で開ける場所を分ける
    switch($(".add_error").eq(0).text()){
      case "add":
        $(".add_form").eq(0).css("display","block");
        go_scroll_top=$(".add_form").eq(0)[0].getBoundingClientRect().top;
        window.scrollTo(0,go_scroll_top);
      break;
      case "edit":
        $(".add_form").eq(1).css("display","block");
        go_scroll_top=$(".add_form").eq(1)[0].getBoundingClientRect().top;
        window.scrollTo(0,go_scroll_top);
      break;
      case "delete":
        $(".add_form").eq(2).css("display","block");
        go_scroll_top=$(".add_form").eq(2)[0].getBoundingClientRect().top;
        window.scrollTo(0,go_scroll_top);
      break;
      default:
        // 後で書く
        
      break;
    }

    // ２つ以上エラーが生じている時も、１つ目のエラーポイント移動で止めるためのもの
    $(".add_error").eq(0).text("ok");

  }

})
