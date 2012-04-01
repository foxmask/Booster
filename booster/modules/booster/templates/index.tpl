{if isset($search_results)}
    {if empty($search_results)}
        <div id="article" class="error no-result">
            <h2>{@main.search.no.results@}</h2>
            <p><a href="{jurl 'booster~default:index'}">{@main.return.to.index@}</a></p>
        </div>
    {else}
        {foreach $search_results as $data}
            {include 'booster~view_item'}
        {/foreach}
    {/if}
{else}
    
    <div id="homepage-wrapper">
        {zone 'booster~homepage_block', array('type'=>1)}
        {zone 'booster~homepage_block', array('type'=>2)}
        <div class="clear"></div>
        {zone 'booster~homepage_block', array('type'=>3)}
        {zone 'booster~homepage_block', array('type'=>4)}
    </div>
    {*
    
    <h2>{@booster~main.last.items.created@}</h2>
    
    {foreach $datas as $data}
        {include 'booster~view_item'}
    {/foreach}
    
    *}

{/if}
