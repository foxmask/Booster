<h3>{$data->type_name}: <a href="{jurl 'booster~viewItem',array('name'=>$data->name,'id'=>$data->id)}">{$data->name}</a></h3>
<div class="booster_item">
    <div class="booster_itemauthor">
        <ul class="member-ident">
            <li class="user-name user-image">{@booster~main.author@} {$data->author}</li>
            <li class="user-rank user-image">{@booster~main.item_by@} {$data->nickname}</li>
        </ul>
        <ul class="member-info">
            <li class="booster_url">
                {if $data->url_website != null}<a href="{$data->url_website}">{@booster~main.website@}</a>{/if}
                {if $data->url_website != null && $data->url_repo != null}::{/if}
                {if $data->url_repo != null }<a href="{$data->url_repo}">{@booster~main.repository@}</a>
                {/if}
            </li>
        </ul>
    </div>
    <div class="booster_itembody">
        {if $item_not_moderated}
        <div id="item_not_moderated">
            <h4>{@booster~main.item_not_moderated@}</h4>
            <div>{@booster~main.your.item.is.not.moderated.yet@}</div>
        </div>
        {literal}
        <script type="text/javascript">
        //<![CDATA[
        $(document).ready(function(){
            $("#item_not_moderated").fadeOut(20000);
            return false;
        });
        //]]>
        </script>
        {/literal}
        {/if}
        <h4>{@booster~main.short_desc@} </h4>
        <div class="booster_short_desc">{$data->short_desc|wiki:'wr3_to_xhtml'}</div>
        {zone 'booster~tagsitem',array('id'=>$data->id)}
    </div>
    <div class="booster_itemaction">&nbsp;
        {assign $canEditVersion = false}
        {if $data->item_by == $current_user}
            {assign $canEditVersion = true}
        <a href="{jurl 'booster~editItem',array('id'=>$data->id,'name'=>$data->name)}">{@booster~main.edit.item@}</a>
        {else}
            {ifacl2 'booster.edit.item'}
        <a href="{jurl 'booster~editItem',array('id'=>$data->id,'name'=>$data->name)}">{@booster~main.edit.item@}</a>
            {/ifacl2}
        {/if}
        {if $data->item_by == $current_user}
        <a href="{jurl 'booster~addVersion',array('id'=>$data->id,'name'=>$data->name)}">{@booster~main.add.a.version@}</a>
        {else}
            {ifacl2 'booster.edit.version'}
        <a href="{jurl 'booster~addVersion',array('id'=>$data->id,'name'=>$data->name)}">{@booster~main.add.a.version@}</a>
            {/ifacl2}
        {/if}
    </div>
    {zone "booster~versions",array('id'=>$data->id, 'canEditVersion' => $canEditVersion)}
</div>
<div class="booster_itemfoot">&nbsp;</div>
