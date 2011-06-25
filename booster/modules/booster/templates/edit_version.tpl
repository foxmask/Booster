<h3>{@booster~main.version.edit@}</h3>
<p>{@booster~main.edit.explain.moderation@}</p>
{form $form, $action, array('id'=>$id)}
<fieldset><legend>{@booster~main.version.edit@}</legend>
<table class="jforms-table" border="0">
    <tr>
        <td>{ctrl_label 'version_name'}</th><td>{ctrl_control 'version_name'}</td>
        <td>{ctrl_label 'stability'}</th><td>{ctrl_control 'stability'}</td>
    </tr>
    <tr>
        <td colspan="4">{ctrl_label 'last_changes'}</td>
    </tr>
    <tr>
        <td colspan="4">{ctrl_control 'last_changes'}</td>
    </tr>
    <tr>
        <td >{ctrl_label 'id_jelix_version'}</td>
        <td >{ctrl_control 'id_jelix_version'}</td>
    </tr>

    <tr>
        <td >{ctrl_label 'filename'}</td>
        <td >{ctrl_control 'filename'}</td>
        <td >{ctrl_label 'download_url'}</td>
        <td >{ctrl_control 'download_url'}</td>
    </tr>


</table>
<div>
    {formsubmit}
</div>
</fieldset>
{/form}
