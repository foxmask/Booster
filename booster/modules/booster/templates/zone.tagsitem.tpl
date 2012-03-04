{if count($tags) > 0}
    <div class="booster-item-tags section">
        <ul>
            {foreach $tags as $t}
                <li>
                    <a href="{jurl 'booster~default:cloud',array('tag'=>$t)}" title="{jlocale 'booster~main.show.all.items.with.tag', array($t)}">{$t}</a>
                </li>
            {/foreach}
        </ul>
    </div>
{/if}
