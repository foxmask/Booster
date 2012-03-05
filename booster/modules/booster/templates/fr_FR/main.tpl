{meta_html csstheme 'css/reset.css'}
{meta_html csstheme 'css/text.css'}
{meta_html csstheme 'css/booster.css'}
{meta_html cssthemeie 'css/ie.css'}
{meta_html cssthemeltie7 'css/ie6.css'}

{meta_html js $j_jelixwww.'jquery/jquery.js'}
{meta_html js $j_basepath.'booster/js/booster.js'}
{meta_html js $j_basepath.'booster/js/charCount.js'}

<div id="top-box">
    <div class="top-container">
        <div id="accessibility">Raccourcis :
            <a href="#content">Contenu</a> -
            <a href="#topmenubar">rubriques</a> -
            <a href="#submenubar">sous rubriques</a>
        </div>       
        {zone 'jcommunity~status'}
        <div id="lang-box">
          <a href="{jurl 'booster~default:index', array('lang'=>'en_EN')}" hreflang="en" title="english">en</a>
          <strong>fr</strong>
        </div>
    </div>
</div>

 
<div id="header">
    <div class="top-container">
        <h1 id="logo">
            <a href="/" title="Page d'accueil du site"><img src="/images/logo_jelix_moyen4.png" alt="Jelix" /></a>
        </h1>
        <div id="topmenubar">
            <p>
                <a href="{jurl 'booster~default:index'}">Jelix BOOSTER</a>, le portail des ressources produites par la communauté
            </p>
            <ul>
                {*<li {if $tout}class="selected"{/if}><a href="{jurl 'booster~default:index'}">Tout</a></li>*}
                <li {if $applis}class="selected"{/if}><a href="{jurl 'booster~default:applis'}">Applications</a></li>
                <li {if $modules}class="selected"{/if}><a href="{jurl 'booster~default:modules'}">Modules</a></li>
                <li {if $plugins}class="selected"{/if}><a href="{jurl 'booster~default:plugins'}">Plugins</a></li>
                <li {if $packlang}class="selected"{/if}><a href="{jurl 'booster~default:packlang'}">Pack de Langues</a></li>
                {ifuserconnected}
                    <li {if $your_ressources}class="selected"{/if}><a href="{jurl 'booster~default:yourressources'}">{@booster~main.your.ressources@}</a></li>
                {/ifuserconnected}
            </ul>

        </div>
    </div>
</div>

<div id="main-content">
    <div class="top-container">
        <div id="content-header">
            <div id="submenubar" {ifuserconnected}class="no-center"{/ifuserconnected}>
                {$SEARCH}
                {ifuserconnected}
                    <a class="jforms-submit" href="{jurl 'booster~default:_add'}">{@booster~main.add.an.item@}</a>
                {/ifuserconnected}
            </div>
        </div>

        {ifuserconnected}
            {ifacl2 'booster.admin.index'}
                {zone 'boosteradmin~tasktodo'}
            {/ifacl2}
        {/ifuserconnected}

        <div id="content">
            {jmessage}
    
            {$MAIN}

        </div>
    </div>
</div>

<div id="footer">
    <div class="top-container">

        <div class="footer-box">
            <p><img alt="Jelix" src="/images/logo_jelix_moyen5.png"><br>
                est sponsorisé par <a href="http://innophi.com">Innophi</a>.</p>
            <p>Jelix est publié sous <br>la licence LGPL</p>
        </div>

        <div class="footer-box">
             <p>
                <span style="color:red">version BETA</span> - <a href="https://github.com/foxmask/Booster/issues/new">Un problème d'utilisation ? faites nous en part</a> - <a href="{jurl 'booster~default:credits'}">Crédits</a>
            </p>
        </div>

        <p id="footer-legend">
            Copyright 2006-2012 Jelix team. <br/>
            Design par Laurentj. <br/>
            <img alt="page générée par une application Jelix" src="{$j_jelixwww}design/images/jelix_powered.png">
        </p>
    </div>
</div>
