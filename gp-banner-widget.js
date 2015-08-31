$(document).ready(function() {
    var images = $("#gp-banner-gallery a").hide();
    var thumbs = $("#gp-banner-thumbs a");
    var thumbsLength = thumbs.length;
    var visibleThumbsNum = 3;
    var index = thumbsLength - 1;
    var timer = setInterval(sift, 8000);

    for (i = 0; i < thumbsLength; i++) {
        $(thumbs[i]).addClass("thumb-" + i);
        $(images[i]).addClass("image-" + i);
    }
    
    images.last().show()
    $(thumbs).hide()
    
    $('#gp-banner-thumbs').prepend($('#gp-banner-thumbs a').last());
    $('#gp-banner-thumbs a').slice(thumbsLength - visibleThumbsNum - 1, thumbsLength).show();
    
    $("#gp-banner-next").click(function() {
        clearInterval(timer);
        timer = setInterval(sift, 8000);
        sift();
    });
    
    function sift() {
        if (index > 0) {
            index--;
        } else {
            index = thumbsLength - 1;
        }
        show(index);
    }
    
    function show(num) {
        thumbs = $('#gp-banner-thumbs a');
        if ((thumbs.first().attr('class') != thumbs.last().attr('class'))
            && (thumbs.last().attr('class').slice(6) == num)) {
            $('#gp-banner-thumbs').prepend(thumbs.last().clone().hide());
            
/*            console.log('image-' + num + ', ' + $("#gp-banner-thumbs a").last().attr('class'));*/
        
            $('#gp-banner-thumbs a').slice(thumbsLength - visibleThumbsNum - 1, thumbsLength - visibleThumbsNum).slideDown(810, function() {
                 $("#gp-banner-thumbs a").last().remove();
            });
        
            $("#gp-banner-gallery a").fadeOut(800);
            $(".image-" + num).stop().fadeIn(800);
        }
    }
});
