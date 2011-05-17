
{zone 'booster~search'}

{if isset($search_results)}

    {if empty($search_results)}
        <div class="error no-result">
            <h2>{@main.search.no.results@}</h2>
            <p><a href="{jurl 'booster~default:index'}">{@main.return.to.index@}</a></p>
        </div>
    {else}    
        {foreach $search_results as $data}
            {include 'booster~view_item'}
        {/foreach}
    {/if}
    
{else}

    <h2>{@booster~main.last.items.created@}</h2>
    
    {foreach $datas as $data}
        {include 'booster~view_item'}
    {/foreach}
    
{/if}

