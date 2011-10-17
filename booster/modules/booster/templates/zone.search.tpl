

<div id="booster-search">
    
    {literal}
<script type="text/javascript">
//<![CDATA[
(function(){
    $(document).ready(function(){
        var imagePath = '/booster/images/';
        // hide search
        var $adv_search = $("#advanced-search");
        $adv_search.hide();
        // show search form
        $("#search-trigger").click(function () {
            $(this).toggleClass("active");
            $adv_search.slideToggle("slow");
            toggleImage($("#search-trigger"));
        });
    
      var flag = true;
      var toggleImage = function($el){
            if(flag){
                $el.find('img').attr({src:imagePath+"delete.png"});
                flag = false;
            }
            else{
                $el.find('img').attr({src:imagePath+"add.png"});
                flag = true;
            }
      }
    });
})();
//]]>
</script>
{/literal}
    
    
    
    
    
        <h2>{@main.search@}</h2>

    {form $form, $submitAction, array('search' => true)}

            <div class="classic-search">
                
                {ctrl_label 'name'}
                {ctrl_control 'name'}
                
                {ctrl_label 'tags'}
                {ctrl_control 'tags'}
                
                {formsubmit}
           <button type="button" id="search-trigger" class="jforms-submit"><img src="/booster/images/add.png" alt="Click to use search"/>{@booster~main.search.advanced@}</button>
                
            </div>
        
        <div id="advanced-search">
            <div>
                {ctrl_label 'types'}
                {ctrl_control 'types'}
            </div>
           <div>
                {ctrl_label 'jelix_versions'}
                {ctrl_control 'jelix_versions'}
           </div>
            <div>
                {ctrl_label 'author_by'}
                {ctrl_control 'author_by'}
           </div>
        </div>
        
        
        
        <p>
        
        </p>
        
        
    {/form}

</div>