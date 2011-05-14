<h1>{@boosteradmin~admin.versions.to.moderate@}</h1>
{if $datas->rowCount() > 0}
<table>
{foreach $datas as $data}
    <tr><td><a href="{jurl 'boosteradmin~versions:edit',array('id'=>$data->id)}">{$data->version_name}</a></td></tr>
{/foreach}
</table>
{else}
<p>{@boosteradmin~admin.nothing.todo@}</p>
{/if}
