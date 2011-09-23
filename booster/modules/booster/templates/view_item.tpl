{meta_html js $j_jelixwww.'jquery/jquery.js'}
{meta_html js $j_jelixwww.'jquery/ui/jquery.ui.widget.min.js'}
{meta_html js $j_jelixwww.'jquery/ui/jquery.ui.core.min.js'}
{meta_html js $j_jelixwww.'jquery/ui/jquery.ui.tabs.min.js'}
{literal}
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
    $(".tabs_desc").tabs();
});
//]]>
</script>
{/literal}

<h3>{$data->type_name}: <a href="{jurl 'booster~viewItem',array('name'=>$data->name,'id'=>$data->id)}">{$data->name}</a> {if $item_not_moderated || $data->status == 0}(Non validé){/if}</h3>
<div class="booster_item">
    <div class="booster_itemauthor">
        <ul class="member-ident">
            <li class="user-name user-image">{@booster~main.author@} {$data->author}</li>
            <li class="user-rank user-image">{@booster~main.item_by@} {zone 'booster~author', array('id'=>$data->item_by)}</li>
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
                {if $current_user == $data->item_by}
                    <div>{@booster~main.your.item.is.not.moderated.yet@}</div>
                {/if}
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

        {if $data->short_desc != '' and $data->short_desc_fr != ''}
        <div class="tabs_desc">
            <ul>
                <li><a href="#short_desc_en_{$data->id}" title="View the english description">{image $j_basepath.'booster/images/flags/gb.gif',array('alt'=>'View the english description')}</a></li>
                <li><a href="#short_desc_fr_{$data->id}" title="Voir la description française">{image $j_basepath.'booster/images/flags/fr.gif',array('alt'=>'Voir la description française')}</a></li>
            </ul>
            <div id="short_desc_en_{$data->id}">
                {$data->short_desc|wiki:'wr3_to_xhtml'}
            </div>
            <div id="short_desc_fr_{$data->id}">
                {$data->short_desc_fr|wiki:'wr3_to_xhtml'}
            </div>
        </div>
        {elseif $data->short_desc != ''}
            <div id="short_desc_{$data->id}">
                {$data->short_desc|wiki:'wr3_to_xhtml'}
            </div>
        {else}
            <div id="short_desc_fr_{$data->id}">
                {$data->short_desc_fr|wiki:'wr3_to_xhtml'}
            </div>
        {/if}
        {zone 'booster~tagsitem',array('id'=>$data->id)}

    </div>
    <div class="booster_itemaction">&nbsp;
        {assign $canEditVersion = false}

        {if !$item_not_moderated}
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
        {/if}
    </div>
    {zone "booster~versions",array('id'=>$data->id, 'canEditVersion' => $canEditVersion)}
</div>
<div class="booster_itemfoot">&nbsp;</div>
