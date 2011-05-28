$(document).ready(function(){

    var $liste = $('#my-items').find('ul');
    var timeoutFadeIn;
    var timeoutFadeOut;

    $('#my-items').bind('mouseenter' , function(){
        clearTimeout(timeoutFadeIn);
        clearTimeout(timeoutFadeOut);
        timeoutFadeIn = setTimeout( function(){
                $liste.fadeIn();
            }, 200);
    });

    $('#my-items').bind('mouseleave' , function(){
        clearTimeout(timeoutFadeOut);
        timeoutFadeOut = setTimeout( function(){
                $liste.fadeOut();
            }, 500);
    });

    var $listeStatus = $('#my-status').find('ul');
    var timeoutFadeIn;
    var timeoutFadeOut;

    $('#my-status').bind('mouseenter' , function(){
        clearTimeout(timeoutFadeIn);
        clearTimeout(timeoutFadeOut);
        timeoutFadeIn = setTimeout( function(){
                $listeStatus.fadeIn();
            }, 200);
    });

    $('#my-status').bind('mouseleave' , function(){
        clearTimeout(timeoutFadeOut);
        timeoutFadeOut = setTimeout( function(){
                $listeStatus.fadeOut();
            }, 500);
    });
});
