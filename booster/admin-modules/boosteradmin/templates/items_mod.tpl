<h1>{@boosteradmin~admin.items.to.moderate@}</h1>
{if $datas->rowCount() > 0}
<table>
{foreach $datas as $data}
    <tr><td><a href="{jurl 'boosteradmin~items:edit',array('id'=>$data->id)}">{$data->name}</a></td></tr>
{/foreach}
</table>
{else}
<p>{@boosteradmin~admin.nothing.todo@}</p>
{/if}
