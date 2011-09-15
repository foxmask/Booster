{literal}
<script type="text/javascript">
//<![CDATA[
var imagePath = '/booster/images/';
$(document).ready(function(){
  // hide search
  $("#jforms_booster_search").hide();
  // show search form
  $("#booster-search").click(function () {
     $(this).toggleClass("active").next().slideToggle("slow");
  });
  //toggle Image
  $("#booster-search").toggle(
    function () {
      $(this).find("img").attr({src:imagePath+"delete.png"});
    },
    function () {
      $(this).find("img").attr({src:imagePath+"add.png"});
    }
  );
});
//]]>
</script>
{/literal}
<div id="booster-search">
    <h2 id="search-filter">{image '/booster/images/add.png',array('alt'=>'Click to use search')}{@main.search@}</h2>
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
