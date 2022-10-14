// $(function () {
//     var like = $('.js-like-toggle');
//     var likeReviewId;
    
//     $(like).on('click', function () {
//         var $this = $(this);
//         console.log($this);
//         likeReviewId = $this.data('reviewid');
//         $.ajax({
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 },
//                 url: '/ajaxlike',  
//                 type: 'POST', 
//                 data: {
//                     'review_id': likeReviewId 
//                 },
//         })
    
//             // Ajaxリクエストが成功した場合
//             .done(function (data) {
    
//                 $this.toggleClass('loved');  
    
//             })
//             // Ajaxリクエストが失敗した場合
//             .fail(function (data, xhr, err) {
    
//                 console.log('エラー');
//                 console.log(err);
//                 console.log(xhr);
//             });
        
//         return false;
//     });
//     });

function like(reviewId) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: `/like/${reviewId}`,
      type: "POST",
    })
      .done(function (data, status, xhr) {
        console.log(data);
      })
      .fail(function (xhr, status, error) {
        console.log();
      });
  }