<h1>{@boosteradmin~admin.items.validated@}</h1>
{if $datas->rowCount() > 0}
<table class="records-list">
    <thead>
        <tr><th>{@boosteradmin~admin.items_list.type_name@}</th><th>{@boosteradmin~admin.items_list.name@}</th><th>{@boosteradmin~admin.items_list.date_created@}</th><th>{@boosteradmin~admin.item_by@}</th></tr>
    </thead>
    <tbody>
{foreach $datas as $data}
        <tr><td>{$data->type_name}</td><td><a href="{jurl 'boosteradmin~items:editnew',array('id'=>$data->id)}">{$data->name}</a></td><td>{$data->created|jdatetime}</td><td>{$data->nickname}</td></tr>
{/foreach}
    </tbody>
</table>
{/if}
