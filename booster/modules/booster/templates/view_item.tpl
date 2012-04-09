{meta_html js $j_jelixwww.'jquery/jquery.js'}
{meta_html js $j_jelixwww.'jquery/ui/jquery.ui.widget.min.js'}
{meta_html js $j_jelixwww.'jquery/ui/jquery.ui.core.min.js'}
{meta_html js $j_jelixwww.'jquery/ui/jquery.ui.tabs.min.js'}



{assign $github = strpos($data->url_repo , '//github.com') !== false}
{assign $bitbucket = strpos($data->url_repo , '//bitbucket.org') !== false}



<div class="booster-item">

{literal}

<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
    $(".booster-item-desc").tabs();
});
//]]>
</script>

{/literal}

<h3>
    {$data->type_name} <a class="booster-item-name" href="{jurl 'booster~viewItem',array('name'=>$data->name,'id'=>$data->id)}">{$data->name}</a> 
    {if $data->status == 0 || !empty($item_not_moderated)}
        <small>({@booster~main.not.moderated@})</small>
    {/if}
    {if $data->recommendation}
        <small><img src="{$j_themepath}icons/reco.png" height="12" width="12" alt="{@booster~main.is.reco@}" title="{@booster~main.reco.help@}"/></small>
    {/if}
    
</h3>

    {if !empty($item_not_moderated)}
        <div class="section" id="item-not-moderated">
            <h4><img src="{$j_themepath}icons/exclamation.png" alt=""/>
                {@booster~main.item_not_moderated@}
            </h4>
            {if $current_user == $data->item_by}
                <div>{@booster~main.your.item.is.not.moderated.yet@}</div>
            {/if}
        </div>
    {/if}

    <div class="wrapper-section">

        <div class="booster-item-image">
            {zone 'booster~itemimage', array('id'=>$data->id)}
        </div>

        {zone 'booster~tagsitem',array('id'=>$data->id)}

        <div class="booster-item-desc section">
            {if $data->short_desc != '' and $data->short_desc_fr != ''}
                <ul class="tabs-lang">
                    <li><a href="#short_desc_en_{$data->id}" title="View the english description">{image $j_basepath.'booster/images/flags/gb.gif',array('alt'=>'View the english description')}</a></li>
                    <li><a href="#short_desc_fr_{$data->id}" title="Voir la description française">{image $j_basepath.'booster/images/flags/fr.gif',array('alt'=>'Voir la description française')}</a></li>
                </ul>
                <div id="short_desc_en_{$data->id}" class="desc lang">
                    <h4>Description</h4>
                    {$data->short_desc|wiki:'wr3_to_xhtml'}
                </div>
                <div id="short_desc_fr_{$data->id}" class="desc lang">
                    <h4>Description</h4>
                    {$data->short_desc_fr|wiki:'wr3_to_xhtml'}
                </div>
            {elseif $data->short_desc != ''}
                <div id="short_desc_{$data->id}" class="desc">
                    <h4>Description</h4>
                    {$data->short_desc|wiki:'wr3_to_xhtml'}
                </div>
            {else}
                <div id="short_desc_fr_{$data->id}" class="desc">
                    <h4>Description</h4>
                    {$data->short_desc_fr|wiki:'wr3_to_xhtml'}
                </div>
            {/if}
        </div>
    </div>   

     <div class="booster-item-infos section">
            <ul class="inline-list">
                <li>
                    <img src="{$j_themepath}icons/user_edit.png" alt=""/>
                    {@booster~main.author@} {$data->author}
                </li>
                <li>
                    <img src="{$j_themepath}icons/user_gray.png" alt=""/>
                    {@booster~main.item_by@} {zone 'booster~author', array('id'=>$data->item_by)}
                </li>

                
                {if $data->url_website != null}
                    <li class="booster_url">
                        <img src="{$j_themepath}icons/world.png" alt=""/>
                        <a href="{$data->url_website}">{@booster~main.website@}</a>
                    </li>
                {/if}
                {if $data->url_repo != null }
                    <li>
                        {if $github}
                            <img src="{$j_themepath}icons/github.png" alt=""/>
                        {elseif $bitbucket}
                            <img src="{$j_themepath}icons/bitbucket.png" alt=""/>
                        {/if}
                        <a href="{$data->url_repo}">{@booster~main.repository@}</a>
                    </li>
                {/if}

            </ul>
    </div>
    {if $github}
        {zone 'booster~item_github', array('url_repo'=>$data->url_repo)}
    {/if}




    {assign $canEditVersion = false}
    {assign $editRight = false}
    {assign $recommendation = false}

    {if empty($item_not_moderated) && $data->item_by == $current_user}
        {assign $canEditVersion = true}
    {/if}

    {ifacl2 'booster.edit.item'}
        {assign $editRight = true}
    {/ifacl2}

    {ifacl2 'booster.recommendation'}
        {assign $recommendation = true}
    {/ifacl2}

    {if $canEditVersion || $editRight || $recommendation}
        <div class="booster-item-action section admin">
            <ul class="inline-list">


                {if $canEditVersion || $editRight}
                    <li>
                        <img src="{$j_themepath}icons/item_edit.png" alt=""/>
                        <a href="{jurl 'booster~default:editItem',array('id'=>$data->id,'name'=>$data->name)}">{@booster~main.edit.item@}</a>
                    </li>
                    <li>
                        <img src="{$j_themepath}icons/version_add.png" alt=""/>
                        <a href="{jurl 'booster~default:_addVersion',array('id'=>$data->id,'name'=>$data->name)}">{@booster~main.add.a.version@}</a>
                    </li>
                {/if}

                {if $recommendation}
                    <li>
                        <form action="{formurl 'booster~default:recommendation'}" method="POST">
                            <div>
                                 <img src="{$j_themepath}icons/reco.png" alt=""/>
                                {formurlparam}
                                <input type="hidden" name="id" value="{$data->id}"/>
                                <input type="hidden" name="name" value="{$data->name}"/>
                                {if $data->recommendation}
                                    <input type="hidden" name="state" value="0"/>
                                    <input type="submit" class="link" value="{@booster~main.reco.item.cancel@}"/>
                                {else}
                                    <input type="hidden" name="state" value="1"/>
                                    <input type="submit" class="link" value="{@booster~main.reco.item@}"/>
                                {/if}
                            </div>
                        </form>
                    </li>
                {/if}

            </ul>
        </div>
    {/if}


    {zone "booster~versions",array('id'=>$data->id, 'canEditVersion' => $canEditVersion)}

</div>