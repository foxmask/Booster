
{zone 'booster~search'}

{if isset($search_results)}

    {foreach $search_results as $data}
        {include 'booster~view_item'}
    {/foreach}
    
{else}

    <h2>{@booster~main.last.items.created@}</h2>
    
    {foreach $datas as $data}
        {include 'booster~view_item'}
    {/foreach}
    
{/if}

