{foreach $versions as $version}
    <div class="booster_version">
        <h3>{$version->version_name} ({$version->stability})</h3>
        <div class="booster_created">{@booster~main.created@} {$version->created|jdatetime:'db_datetime','lang_datetime'}</div>
        <div class="booster_postbody">
            <h4>{@booster~main.last_changes@}</h4>
            <blockquote>{$version->last_changes|wiki:'wr3_to_xhtml'}</blockquote>
        </div>
        <div class="booster_downloads">
            {@booster~main.download@}: <a href="{$version->download_url}">{$version->filename}</a>
        </div>
    </div>
{/foreach}
