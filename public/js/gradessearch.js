$(document).ready(function() {
    console.log('jsファイル読み込みできている');


    //① grade-cardをクリックしたらgrade-idを取得して変数gradeIdにいれる
    $('.grade-card').click(function() {
        console.log('学年ボタン押下連動');
        var gradeId = $(this).data('grade-id');
    
        console.log(gradeId);

    //②ajax通信を使用して対象のデータを表示する    
    $.ajax({
        // ③web.phpのURLと連動させて先ほど取得したgradeIdも渡す
        url: 'curriculum_list/' + gradeId,
        type: 'GET',
        dataType:'html'
    }).done(function(data) {
        // dataが取れているか確認
        
        // console.log(data);
        //④まずは既存の内容をクリア
        $('#lesson-list').html('');
        // ⑤変数newDataにarticleタグidがlessonsの情報を格納して置き換える
        // 取得したdataから#lessonsの内容を抽出して置き換える
        // $('#lesson-list').html(data);
        // let newData = $(data).find('#lesson-list');
        // console.log(newData);
        // $('#lesson-list').replaceWith(newData);
        let newLessonList = $(data).find('#lesson-list').html();
            $('#lesson-list').html(newLessonList);
            

         // 'current-grade-name'の更新
         let newGradeName = $(data).find('.grade-title').text();
         $('.grade-title').text(newGradeName);
        
      
    }) // ここで 'done' が終了
    .fail(function(jqXHR, textStatus, errorThrown) { // ここから 'fail'
        alert('通信を失敗しました');
        console.log("jqXHR          : " + jqXHR.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown);
    });
    
});
})