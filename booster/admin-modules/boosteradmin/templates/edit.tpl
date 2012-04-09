<h1>{$title}</h1>
<h2>{@boosteradmin~admin.item_by@} {*{$item_by}*} {zone 'booster~author', array('id' => $item_by)}</h2>

{form $form, $action, array('id'=>$id)}

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

	<div> {formsubmits}{formsubmit}{/formsubmits}</div>

{/form}

