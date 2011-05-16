<h1>{@boosteradmin~admin.items.to.moderate@}</h1>
<h2>{@boosteradmin~admin.items.news@}</h2>
{if $datas_new->rowCount() > 0}
<table class="records-list">
    <thead>
        <tr><th>{@boosteradmin~admin.items_list.type_name@}</th><th>{@boosteradmin~admin.items_list.name@}</th><th>{@boosteradmin~admin.items_list.date_created@}</th></tr>
    </thead>
    <tbody>
{foreach $datas_new as $data}
        <tr><td>{$data->type_name}</td><td><a href="{jurl 'boosteradmin~items:editnew',array('id'=>$data->id)}">{$data->name}</a></td><td>{$data->created|jdatetime}</td></tr>
{/foreach}
    </tbody>
</table>
{else}
<p>{@boosteradmin~admin.nothing.todo@}</p>
{/if}
<h2>{@boosteradmin~admin.items.modified@}</h2>
{if $datas_mod->rowCount() > 0}
<table class="records-list">
    <thead>
        <tr><th>{@boosteradmin~admin.items_list.type_name@}</th><th>{@boosteradmin~admin.items_list.name@}</th><th>{@boosteradmin~admin.items_list.date_created@}</th></tr>
    </thead>
{foreach $datas_mod as $data}
    <tbody>
        <tr><td><a href="{jurl 'boosteradmin~items:editmod',array('id'=>$data->id)}">{$data->name}</a></td></tr>
    </tbody>
{/foreach}
</table>
{else}
<p>{@boosteradmin~admin.nothing.todo@}</p>
{/if}
