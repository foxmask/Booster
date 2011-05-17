<h1>{@boosteradmin~admin.versions.validated@}</h1>
{if $datas->rowCount() > 0}
<table class="records-list">
    <thead>
        <tr><th>{@boosteradmin~admin.versions_list.name@}</th><th>{@boosteradmin~admin.versions_list.version@}</th><th>{@boosteradmin~admin.versions_list.date_created@}</th></tr>
    </thead>
    <tbody>
{foreach $datas as $data}
        <tr><td>{$data->name}</td><td><a href="{jurl 'boosteradmin~versions:editnew',array('id'=>$data->version_id)}">{$data->version_name}</a></td><td>{$data->created|jdatetime}</td></tr>
{/foreach}
    </tbody>
</table>
{/if}
