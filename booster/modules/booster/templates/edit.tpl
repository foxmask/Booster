<h3>{$title}</h3>
<p>{@booster~main.edit.explain.moderation@}</p>
{form $form, $action, array('id'=>$id)}
<fieldset><legend>{$legend}</legend>
<table class="jforms-table" border="0">
    {formcontrols}
    <tr><th scope="row">{ctrl_label}</th><td>{ctrl_control}</td></tr>
    {/formcontrols}
</table>
<div>
    {formsubmit}
</div>
</fieldset>
{/form}
