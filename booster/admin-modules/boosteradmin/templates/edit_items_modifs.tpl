<h1>{$title}</h1>
<h2>{@boosteradmin~admin.item_by@} {$item_by}</h2>

<p><a href="{jurl 'booster~default:viewItem', array('id' => $id, 'name' => $name)}">{$name}</a>

<ul class="modifs">
{foreach $modified as $mod}
    <li>
        <strong>{jlocale 'booster~main.'.$mod->field}</strong> : 
        <span class="old-value">
            {if empty($mod->old_value)}
                " "
            {else}
                {$mod->old_value} 
            {/if}
        </span>
        => 
        <span class="new-value">
            {if empty($mod->new_value)}
                " "
            {else}
                {$mod->new_value} 
            {/if}
        </span>
    </li>
{/foreach}
</ul>


{form $form, $action, array('id'=>$id)}
    {formsubmit '_submit'}
    <table class="jforms-table">

      {formcontrols}
        {ifctrl 'image'}
            <tr>
                <td class="valign-middle">{@booster~main.image.current@}</td>
                <td>{zone 'booster~itemimage', array('id' => $id)} <a href="{jurl 'boosteradmin~items:deleteImage', array('id' => $id, 'submitAction' => $action)}" onclick="return confirm('{jlocale 'boosteradmin~admin.confirm.deletion.image'}')">{@booster~main.image.delete@}</a></td>
            </tr>
            <tr>
                <td>{@booster~main.image.replace.by@}</td><td colspan="3">{ctrl_control 'image'}</td>
            </tr>
        {else}
            <tr><td>{ctrl_label}</td><td>{ctrl_control}</td></tr>
        {/ifctrl}
      {/formcontrols}

    </table>

    <div> {formsubmit '_submit'}</div>

{/form}

