(function(){
    $(document).ready(function(){
    
        var $lastChanges = $('#jforms_booster_version_last_changes');
        if($lastChanges.size() > 0){
            $lastChanges.charCount({allowed : 255, warning : 25, css : 'charCounter'});
        }
    
    });
    
})();