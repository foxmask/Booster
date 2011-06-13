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
{zone 'booster~search'}
{zone "jtags~tagscloud", array('destination'=>'booster~default:cloud', 'maxcount'=>20)}
