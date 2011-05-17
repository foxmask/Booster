   <h2>{jlocale 'main.items.tag.with', array($tag)}</h2>
   
    {foreach $items as $data}
        {include 'booster~view_item'}
    {/foreach}