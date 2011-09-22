<h1>{@boosteradmin~admin.items.validated@}</h1>
{if $datas->rowCount() > 0}
<table class="records-list">
    <thead>
        <tr>
            <th>{@boosteradmin~admin.items_list.type_name@}</th>
            <th>{@boosteradmin~admin.items_list.name@}</th>
            <th>{@boosteradmin~admin.items_list.date_created@}</th>
            <th>{@boosteradmin~admin.item_by@}</th>
            <th>{@boosteradmin~admin.action@}</th>            
        </tr>
    </thead>
    <tbody>
{foreach $datas as $data}
        <tr class="{cycle array('even','odd')}">
            <td>{$data->type_name}</td>
            <td><a href="{jurl 'boosteradmin~items:editnew',array('id'=>$data->id)}">{$data->name|eschtml}</a></td>
            <td>{$data->created|jdatetime}</td>
            <td>{zone 'booster~author', array('id' => $data->item_by)}</td>
            <td><a href="{jurl 'boosteradmin~items:delete',array('id'=>$data->id)}"
                   alt="{@boosteradmin~admin.action.delete@}"
                   onclick="return confirm('{jlocale 'boosteradmin~admin.confirm.deletion',array($data->name)}')">{@boosteradmin~admin.action.delete@}</a></td>

        </tr>
{/foreach}
    </tbody>
</table>
{/if}
