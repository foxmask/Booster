{if count($tags) > 1}
<div class="booster_itemtags">
<ul>{foreach $tags as $t}<li><a href="{jurl 'booster~default:cloud',array('tag'=>$t)}" title="{@booster~main.show.all.items.with.this.tag@}">{$t}</a></li>{/foreach}</ul>
</div>
{elseif count($tags) == 1 and !empty($tags)}
<div class="booster_itemtags">
<ul><li><a href="{jurl 'booster~default:cloud',array('tag'=>$tags[0])}" title="{@booster~main.show.all.items.with.this.tag@}">{$tags[0]}</a></li></ul>
</div>
{/if}
