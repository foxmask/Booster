    
    
<h2>{@booster~main.last.items.created@}</h2>

{if $datas->rowCount() > 0}

    {foreach $datas as $data}
        {include 'booster~view_item'}
    {/foreach}
    

    {if $datas->rowCount() < $count}
    	<div class="pagination">
    		{pagelinks_custom $action, array(), $count, $index_result, $per_page, $param_name}
    	</div>
	{/if}


{else}
    {@booster~main.not.items.type@}
{/if}