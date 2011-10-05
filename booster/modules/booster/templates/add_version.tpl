<h3>{@booster~main.add.a.version@} : {$itemName}</h3>
{form $form, 'booster~default:saveVersion',array('itemName'=>$itemName)}
<fieldset><legend>{@booster~main.new.version@}</legend>
<table>
    <tr>
        <td>{ctrl_label 'version_name'}</td><td>{ctrl_control 'version_name'}</td>
        <td>{ctrl_label 'stability'}</td><td>{ctrl_control 'stability'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'id_jelix_version'}</td><td>{ctrl_control 'id_jelix_version'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'filename'}</td><td>{ctrl_control 'filename'}</td>
        <td>{ctrl_label 'download_url'}</td><td>{ctrl_control 'download_url'}</td>
    </tr>
    <tr>
        <td colspan="4">{ctrl_label 'last_changes'}</td>
    </tr>
    <tr>
        <td colspan="4">{ctrl_control 'last_changes'}</td>
    </tr>
</table>
</fieldset>
<div> {formsubmit} </div>
{/form}
{include 'booster~zone.syntax_wiki'}
