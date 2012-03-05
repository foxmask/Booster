{assign $count = 0}
<div class="booster-versions">

{if $versions->rowCount() >= 1}

    <h4>{@booster~main.versions.last@}</h4>

    {foreach $versions as $version}

        {if $count == 1}
            {assign $count = -1}
            <h4 id="booter_old_version">{@booster~main.old.versions@}</h4>
        {/if}

        <div class="booster-version section {if $count == 0}last-version {assign $count= 1}{/if}">
            <h5 class="booster-version-title">{$version->version_name} <small>({$version->stability})</small></h5>
            <ul class="inline-list">
                <li>
                    <img src="{$j_themepath}icons/date.png" alt=""/>
                    {@booster~main.created@} {$version->created|date_format:'%d/%m/%y %H:%M'}
                </li>
                
                <li class="compatibility">
                    <img src="{$j_themepath}icons/wrench_orange.png" alt=""/>
                    {@booster~main.compatible@} <span class="jelix-version">{$version->version}</span>
                </li>

                <li>
                    <img src="{$j_themepath}icons/disk.png" alt=""/>
                    {@booster~main.download@} : <a href="{$version->download_url}">{$version->filename}</a>
                </li>

                {if $canEditVersion}
                    <li>
                        <img src="{$j_themepath}icons/version_edit.png" alt=""/>
                        <a href="{jurl 'booster~editVersion',array('id'=>$version->id)}">{@booster~main.edit@}</a>
                    </li>
                {else}
                    {ifacl2 'booster.edit.version'}
                        <li>
                            <img src="{$j_themepath}icons/version_edit.png" alt=""/>
                            <a href="{jurl 'booster~editVersion',array('id'=>$version->id)}">{@booster~main.edit@}</a>
                        </li>
                    {/ifacl2}
                {/if}
                   
            </ul>

            <div class="booster-version-body">
                <h6>{@booster~main.version.changelog@}</h6>
                <blockquote class="desc">{$version->last_changes|wiki:'wr3_to_xhtml'}</blockquote>
            </div>
        </div>

    {/foreach}

{*
    {if $versions->rowCount() >= 1}
        <script type="text/javascript">
        {literal}
    //<![CDATA[
            $(document).ready(function(){
                $otherVersions = $('.booster_version:not(.last-version)');
                $otherVersions.find('.body').hide();

                $otherVersions.find('h4').bind('click keypress', function(event){
                    if(event.type == 'click' || (event.type == 'keypress' && event.which == 13)){
                        $(this).next('.body').slideToggle();
                    }
                })
                .attr('tabindex', 0);
            });
    //]]>
        {/literal}
        </script>
    {/if}
*}
{/if}
</div>
