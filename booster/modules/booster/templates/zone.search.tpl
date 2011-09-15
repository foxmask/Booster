{literal}
<script type="text/javascript">
//<![CDATA[
(function(){
    $(document).ready(function(){
        var imagePath = '/booster/images/';
        // hide search
        var $search = $("#jforms_booster_search");
        $search.hide();
        // show search form
        $trigger = $("#search-trigger");
        $trigger.click(function () {
            $(this).toggleClass("active");
            $search.slideToggle("slow");
            toggleImage($trigger);
        });
    
      var add = true;
      var toggleImage = function($el){
            if(add){
                $el.find('img').attr({src:imagePath+"delete.png"});
                add = false;
            }
            else{
                $el.find('img').attr({src:imagePath+"add.png"});
                add = true;
            }
      }
    });
})();
//]]>
</script>
{/literal}
<div id="booster-search">
    <div>
        <button id="search-trigger"><img src="/booster/images/add.png" alt="Click to use search"/></button>
        <h2>{@main.search@}</h2>
    </div>

    {form $form, $submitAction, array('search' => true)}
        <div>
            {ctrl_label 'types'}
            {ctrl_control 'types'}
        </div>
        {formcontrols}
        <div>
           {ctrl_label}{ctrl_control}
        </div>
        {/formcontrols}
        <div>
        {formsubmit}
        </div>
    {/form}

</div>