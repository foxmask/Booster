<h1>{@boosteradmin~admin.items.to.moderate@}</h1>
<h2>{@boosteradmin~admin.items.news@}</h2>
{if $datas_new->rowCount() > 0}
<table>
{foreach $datas_new as $data}
    <tr><td><a href="{jurl 'boosteradmin~items:editnew',array('id'=>$data->id)}">{$data->name}</a></td></tr>
{/foreach}
</table>
{else}
<p>{@boosteradmin~admin.nothing.todo@}</p>
{/if}
<h2>{@boosteradmin~admin.items.modified@}</h2>
{if $datas_mod->rowCount() > 0}
<table>
{foreach $datas_mod as $data}
    <tr><td><a href="{jurl 'boosteradmin~items:editmod',array('id'=>$data->id)}">{$data->name}</a></td></tr>
{/foreach}
</table>
{else}
<p>{@boosteradmin~admin.nothing.todo@}</p>
{/if}
