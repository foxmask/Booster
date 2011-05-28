<li id="my-items" {if $selected}class="selected"{/if}>
    <span><a href="{jurl 'booster~default:yourressources'}">{@main.your.ressources@}</a></span>
    <ul class="dropdown">
        {foreach $items as $item}
            <li>
                <a href="{jurl 'booster~default:viewItem', array('id' => $item->id, "name" => $item->name)}">
                    {$item->name}</a> {if $item->status == 0}({@main.status.not_validated@}){/if}
            </li>
        {/foreach}
        {if $more}<li><a href="{jurl 'booster~default:yourressources'}">...</a></li>{/if}
    </ul>
</li>
{meta_html js $j_basepath .'booster/js/booster.js'}
