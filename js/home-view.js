$(document).ready(function(){
    let maxHeight = 0;
    let maxWidth = 0;
    $(".home-article").each(function(){
        if ($(this).height() > maxHeight) {
            maxHeight = $(this).height();
        }
        if ($(this).width() > maxWidth) {
            maxWidth = $(this).width();
        }
    });
    $(".home-article").each(function(){
        $(this).height(maxHeight);
        $(this).width(maxWidth);
    });

});