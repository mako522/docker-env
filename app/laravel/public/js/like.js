$(function ()
{
    //「toggle_wish」というクラスを持つタグがクリックされたときに以下の処理が走る
    $('.love hide-text').on('click', function ()
    {
        //表示しているプロダクトのIDと状態、押下し他ボタンの情報を取得
        review_id = $(this).attr("review_id");
        like_review = $(this).attr("like_review");
        click_button = $(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  //基本的にはデフォルトでOK
            },
            url: '/like_review',  //route.phpで指定したコントローラーのメソッドURLを指定
            type: 'POST',   //GETかPOSTメソットを選択
            data: { 'id': id, 'caption': caption,'user_id':user_id }, //コントローラーに送るに名称をつけてデータを指定
                })
            //正常にコントローラーの処理が完了した場合

            .done(function (data) //コントローラーからのリターンされた値をdataとして指定
            {   console.log(data);
                if ( data == 0 )
                {
                    //クリックしたタグのステータスを変更
                    click_button.attr("like_review", "1");
                    //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
                    click_button.children().attr("class", "love");
                }
                if ( data == 1 )
                {
                    //クリックしたタグのステータスを変更
                    click_button.attr("like_review", "0");
                    //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
                    click_button.children().attr("class", "loved");
                }
            })
            ////正常に処理が完了しなかった場合

            .fail(function (data)
            {
                console.log("失敗");
                alert('いいね処理失敗');
                alert(JSON.stringify(data));
            });
    });
});