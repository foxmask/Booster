<h1>{@booster~main.add.a.version@} : {$itemName}</h1>
{form $form, 'booster~default:saveVersion'}
<fieldset><legend>{@booster~main.new.version@}</legend>
<table>
    <tr>
        <td>{ctrl_label 'version_name'}</td><td>{ctrl_control 'version_name'}</td>
        <td>{ctrl_label 'stability'}</td><td>{ctrl_control 'stability'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'filename'}</td><td>{ctrl_control 'filename'}</td>
        <td>{ctrl_label 'download_url'}</td><td>{ctrl_control 'download_url'}</td>
    </tr>
    <tr>
        <td>{ctrl_label 'last_changes'}</td><td colspan="3">{ctrl_control 'last_changes'}</td>
    </tr>
</table>
</fieldset>
<div> {formsubmit} </div>
{/form}
