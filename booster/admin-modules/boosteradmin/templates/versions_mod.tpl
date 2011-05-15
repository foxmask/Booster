<h1>{@boosteradmin~admin.versions.to.moderate@}</h1>
<h2>{@boosteradmin~admin.version.news@}</h2>
{if $datas_new->rowCount() > 0}
<table>
    <tr><th>Name</th><th>Version</th></tr>
{foreach $datas_new as $data}
    <tr><td>{$data->name}</td><td><a href="{jurl 'boosteradmin~versions:editnew',array('id'=>$data->id)}">{$data->version_name}</a></td></tr>
{/foreach}
</table>
{else}
<p>{@boosteradmin~admin.nothing.todo@}</p>
{/if}
<h2>{@boosteradmin~admin.version.modified@}</h2>
{if $datas_mod->rowCount() > 0}
<table>
    <tr><th>Name</th><th>Version</th></tr>
{foreach $datas_mod as $data}
    <tr><td>{$data->name}</td><td><a href="{jurl 'boosteradmin~versions:editmod',array('id'=>$data->id)}">{$data->version_name}</a></td></tr>
{/foreach}
</table>
{else}
<p>{@boosteradmin~admin.nothing.todo@}</p>
{/if}
