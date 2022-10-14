$(function () {
    var like = $('.js-like-toggle');
    var likeReviewId;
    
    $(like).on('click', function () {
        var $this = $(this);
        console.log($this);
        likeReviewId = $this.data('reviewid');
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/ajaxlike',  
                type: 'POST', 
                data: {
                    'review_id': likeReviewId 
                },
        })

            .done(function (data) {
    
                $this.toggleClass('loved');  
    
            })
            .fail(function (data, xhr, err) {
    
                console.log('エラー');
                console.log(err);
                console.log(xhr);
            });
        
        return false;
    });
    });

