<div class="homepage-block block-type-{$type}">

    <h2>{jlocale 'booster~main.type.id.'.$type}</h2>


    <ul class="tabs">
        <li class="selected">{@booster~main.last.created@}</li>
    </ul>

    <div class="content">
        {if $results->rowCount() > 0}
        <ul>
        {foreach $results as $item}

            <li>
                <strong><a href="{jurl 'booster~default:viewItem', array('id' => $item->id, 'name' => $item->name)}">{$item->name}</a></strong>
                {@booster~main.by@}
                {$item->author}
                <span class="date"> - {$item->created |date_format:'%d/%m %H:%M'}</span>
            </li>
        {/foreach}
        </ul>
        {/if}

        {if $results->rowCount() > 0}
            <p class="browse-list">
                {if $type == 1}
                    <a href="{jurl 'booster~default:applis'}">
                {elseif $type == 2}
                    <a href="{jurl 'booster~default:modules'}">
                {elseif $type == 3}
                    <a href="{jurl 'booster~default:plugins'}">
                {elseif $type == 4}
                    <a href="{jurl 'booster~default:packlang'}">
                {/if}

                {jlocale 'booster~main.see.list.type.id.'.$type}</a>
            </p>
        {else}
            {@booster~main.not.items.type@}
        {/if}


    </div>
</div>
