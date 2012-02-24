    <h2>Booster : What's that ?</h2>
    <p id="booster_description">
		Booster is the portal that provides all the existing Jelix ressources provided by the community :
        Applications, Modules, Plugins, and Language Packs. <a href="{jurl 'booster~default:add'}">You can now add your own work</a> on <em>Booster</em>.    
    </p>
    
{ifuserconnected}
<h2>{@main.item@}</h2>
<a class="jforms-submit" href="{jurl 'booster~add'}">{@main.add.an.item@}</a>
{ifacl2 'booster.admin.index'}
<div class="booster_tasktodo">
<span>{@main.waiting.your.validation@} : </span>
{zone 'boosteradmin~tasktodo'}
</div>
{/ifacl2}
{/ifuserconnected}
{zone "jtags~tagscloud", array('destination'=>'booster~default:cloud', 'maxcount'=>20)}
