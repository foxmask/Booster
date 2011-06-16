<h1>{@boosteradmin~admin.versions.to.moderate@}</h1>
<h2>{@boosteradmin~admin.version.news@}</h2>
{if $datas_new->rowCount() > 0}
<table class="records-list">
    <thead>
        <tr><th>{@boosteradmin~admin.versions_list.name@}</th><th>{@boosteradmin~admin.versions_list.version@}</th><th>{@boosteradmin~admin.versions_list.date_created@}</th><th>{@boosteradmin~admin.item_by@}</th></tr>
    </thead>
    <tbody>
{foreach $datas_new as $data}
        <tr class="{cycle array('even','odd')}"><td>{$data->name}</td><td><a href="{jurl 'boosteradmin~versions:editnew',array('id'=>$data->version_id)}">{$data->version_name}</a></td><td>{$data->created|jdatetime}</td><td>{$data->nickname|eschtml}</td></tr>
{/foreach}
    </tbody>
</table>
{else}
<p>{@boosteradmin~admin.nothing.todo@}</p>
{/if}
<h2>{@boosteradmin~admin.version.modified@}</h2>
{if $datas_mod->rowCount() > 0}
<table class="records-list">
    <thead>
        <tr><th>{@boosteradmin~admin.versions_list.name@}</th><th>{@boosteradmin~admin.versions_list.version@}</th><th>{@boosteradmin~admin.versions_list.date_created@}</th></tr>
    </thead>
{foreach $datas_mod as $data}
    <tbody>
        <tr class="{cycle array('even','odd')}"><td>{$data->name}</td><td><a href="{jurl 'boosteradmin~versions:editmod',array('id'=>$data->version_id)}">{$data->version_name}</a></td><td>{$data->created|jdatetime}</td></tr>
    </tbody>
{/foreach}
</table>
{else}
<p>{@boosteradmin~admin.nothing.todo@}</p>
{/if}
