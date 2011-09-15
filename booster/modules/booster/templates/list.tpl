    
    
    <h2>{@booster~main.last.items.created@}</h2>
    
    {if $datas->rowCount() > 0}
    
        {foreach $datas as $data}
            {include 'booster~view_item'}
        {/foreach}
        
    {else}
        {@booster~main.not.items.type@}
    {/if}