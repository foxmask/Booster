
{*zone 'booster~search'*}

<h2>{@booster~main.last.items.created@}</h2>

{foreach $datas as $data}
    {include 'booster~view_item'}
{/foreach}
