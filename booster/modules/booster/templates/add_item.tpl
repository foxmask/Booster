<h3>{@booster~main.add.an.item@}</h3>
{form $form, 'booster~default:saveItem'}
<fieldset><legend>{@booster~main.new.item@}</legend>
<table>
    <tr>
        <td>{ctrl_label 'name'}</td><td>{ctrl_control 'name'}</td>
        <td>{ctrl_label 'item_info_id'}</td><td>{ctrl_control 'item_info_id'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'jelix_versions'}</td>
        <td colspan="3">{ctrl_control 'jelix_versions'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'type_id'}</td><td>{ctrl_control 'type_id'}</td>
        <td>{ctrl_label 'tags'}</td><td>{ctrl_control 'tags'}</td>
    </tr>
    <tr>
        <td colspan="4">{ctrl_label 'short_desc'}</td>
    </tr>
    <tr>
        <td colspan="4">{ctrl_control 'short_desc'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'url_website'}</td><td>{ctrl_control 'url_website'}</td>
        <td>{ctrl_label 'url_repo'}</td><td>{ctrl_control 'url_repo'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'author'}</td><td colspan="3">{ctrl_control 'author'}</td>
    </tr>
</table>
</fieldset>
<div> {formsubmit} </div>
{/form}
{include 'booster~zone.syntax_wiki'}
