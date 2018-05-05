$(document).ready(function(){
    $('.js-like-user').on('click', function(e){
        e.preventDefault();
        var $link = $(e.currentTarget);
        $link.toggleClass('fa-heart-o').toggleClass('fa-heart');

        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function(data){
            $('.js-like-user-count').html(data.hearts);
        });


    })

});

