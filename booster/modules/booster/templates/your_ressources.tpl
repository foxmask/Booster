<h2>{@main.your.ressources@}</h2>
    {foreach $datas as $data}
        {assign $item_not_moderated = !$data->status}
        {include 'booster~view_item'}
    {/foreach}