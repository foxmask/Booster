{meta_html js $j_jelixwww.'jquery/jquery.js'}
{assign $count = 0}

{foreach $versions as $version}

    {if $count == 1}
        {assign $count = -1}
        <p>{@booster~main.old.versions@} : </p>
    {/if}

    <div class="booster_version {if $count == 0}last-version {assign $count= 1}{/if}">
        <h3>{$version->version_name} ({$version->stability})</h3>
        <div class="body">
            <div class="booster_created">
                {@booster~main.created@} {$version->created|jdatetime:'db_datetime','lang_datetime'}

                {if $canEditVersion}
                    - (<a href="{jurl 'booster~editVersion',array('id'=>$version->id)}">{@booster~main.edit@}</a>)
                {else}
                    {ifacl2 'booster.edit.version'}
                        - (<a href="{jurl 'booster~editVersion',array('id'=>$version->id)}">{@booster~main.edit@}</a>)
                    {/ifacl2}
                {/if}
            </div>
            <div class="booster_postbody">
                <h4>{@booster~main.last_changes@}</h4>
                <blockquote>{$version->last_changes|wiki:'wr3_to_xhtml'}</blockquote>
            </div>
            <div class="booster_downloads">
                {@booster~main.download@}: <a href="{$version->download_url}">{$version->filename}</a>
            </div>
        </div>
    </div>

{/foreach}

{if count($versions) >= 1}
    <script type="text/javascript">
    {literal}
//<![CDATA[
        $(document).ready(function(){
            $otherVersions = $('.booster_version:not(.last-version)');
            $otherVersions.find('.body').hide();

            $otherVersions.find('h3').bind('click keypress', function(event){
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
