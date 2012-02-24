{assign $count = 0}
<div class="booster_versions">
{foreach $versions as $version}

    {if $count == 1}
        {assign $count = -1}
        <p id="booter_old_version">{@booster~main.old.versions@} : </p>
    {/if}

    <div class="booster_version {if $count == 0}last-version {assign $count= 1}{/if}">
        <h4>{$version->version_name} ({$version->stability})</h4>
        <div class="body">
            <div class="wrapper">
                <ul class="version-infos">
                    <li class="booster_created">
                        {@booster~main.created@} {$version->created|date_format:'%d/%m/%y %H:%M'}
                    </li>
                    
                    <li class="compatibility">
                        {@booster~main.compatible.with@} <span class="jelix-version">{$version->version}</span>
                    </li>
                        {if $canEditVersion}
                            <li>(<a href="{jurl 'booster~editVersion',array('id'=>$version->id)}">{@booster~main.edit@}</a>)</li>
                        {else}
                            {ifacl2 'booster.edit.version'}
                                <li>(<a href="{jurl 'booster~editVersion',array('id'=>$version->id)}">{@booster~main.edit@}</a>)</li>
                            {/ifacl2}
                        {/if}
                        
                    </ul>
                    
                <div class="booster_postbody">
                    <h5>{@booster~main.last_changes@}</h5>
                    <blockquote>{$version->last_changes|wiki:'wr3_to_xhtml'}</blockquote>
                </div>
            </div>
            <div class="booster_downloads">
                {@booster~main.download@}: <a href="{$version->download_url}">{$version->filename}</a>
            </div>
        </div>
    </div>

{/foreach}

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
</div>
