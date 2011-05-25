<p>{@main.your.items@} : </p>

<ul>
    {foreach $items as $item}
        <li>
            <a href="{jurl 'booster~default:viewItem', array('id' => $item->id, "name" => $item->name)}">
                {$item->name}</a> {if $item->status == 0}({@main.status.not_validated@}){/if}
            </a>
        </li>
    {/foreach}
</ul>
