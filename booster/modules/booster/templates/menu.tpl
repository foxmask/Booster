<div class="booster_menu">
    {zone 'jcommunity~status'}
{ifuserconnected}
    {zone 'booster~reported'}
    {ifacl2 'booster.admin.index'}
    <p>{@main.waiting.your.validation@} : </p>
    {zone 'boosteradmin~tasktodo'}
    {/ifacl2}
{/ifuserconnected}
    {zone 'booster~search'}
    {zone "jtags~tagscloud", array('destination'=>'booster~default:cloud', 'maxcount'=>20)}
</div>

