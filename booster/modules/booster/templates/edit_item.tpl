<h3>{@booster~main.item.edit@}</h3>
<p>{@booster~main.edit.explain.moderation@}</p>
{form $form, $action, array('id'=>$id)}
<fieldset><legend>{@booster~main.item.edit@}</legend>
<table class="jforms-table" border="0">
    <tr>
        <td>{ctrl_label 'name'}</td><td>{ctrl_control 'name'}</td>
        <td>{ctrl_label 'type_id'}</td><td>{ctrl_control 'type_id'}</td>
    </tr>
    <tr>
        <td colspan="4">{ctrl_label 'short_desc'}</td>
    </tr>
    <tr>
        <td colspan="4">{ctrl_control 'short_desc'}</td>
    </tr>
    
    <tr>
        <td colspan="4">{ctrl_label 'short_desc_fr'}</td>
    </tr>
    <tr>
        <td colspan="4">{ctrl_control 'short_desc_fr'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'tags'}</td><td colspan="3">{ctrl_control 'tags'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'author'}</td><td>{ctrl_control 'author'}</td>
        <td>{ctrl_label 'item_info_id'}</td><td>{ctrl_control 'item_info_id'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'url_repo'}</td><td>{ctrl_control 'url_repo'}</td>
        <td>{ctrl_label 'url_website'}</td><td>{ctrl_control 'url_website'}</td>
    </tr>

</table>
<div>
    {formsubmit}
</div>
</fieldset>
{/form}
