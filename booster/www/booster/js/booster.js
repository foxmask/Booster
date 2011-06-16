(function(){
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
    
        var $lastChanges = $('#jforms_booster_version_last_changes');
        if($lastChanges.size() > 0){
            $lastChanges.charCount({allowed : 255, warning : 25, css : 'charCounter'});
        }
    
    
    
    });
    
})();