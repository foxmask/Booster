{meta_html csstheme 'css/reset.css'}
{meta_html csstheme 'css/text.css'}
{meta_html csstheme 'css/booster.css'}
{meta_html cssthemeie 'css/ie.css'}
{meta_html cssthemeltie7 'css/ie6.css'}

{meta_html js $j_jelixwww.'jquery/jquery.js'}
{meta_html js $j_basepath.'booster/js/charCount.js'}

<div id="top-box">
    <div id="accessibility">Raccourcis :
        <a href="#content">Contenu</a> -
        <a href="#topmenubar">rubriques</a> -
        <a href="#submenubar">sous rubriques</a>
    </div>
    <div id="lang-box">
      <a href="{jurl 'booster~default:index', array('lang'=>'en_EN')}" hreflang="en" title="english">en</a>
      <strong>fr</strong>
    </div>
</div>

  <h1 id="logo"><a href="/" title="Page d'accueil du site"><img src="/logo_jelix_moyen2.png" alt="Jelix" /></a><br/>
  Framework PHP5
  </h1>

<div id="header">
    <div id="topmenubar">
        <a href="{jurl 'booster~default:index'}">Jelix BOOSTER</a>, le portail des ressources produites par la communauté
    </div>
    <div id="submenubar">
        <ul id="booster_action">
            <li {if $tout}class="selected"{/if}><a href="{jurl 'booster~default:index'}">Tout</a></li>
            <li {if $applis}class="selected"{/if}><a href="{jurl 'booster~default:applis'}">Applications</a></li>
            <li {if $modules}class="selected"{/if}><a href="{jurl 'booster~default:modules'}">Modules</a></li>
            <li {if $plugins}class="selected"{/if}><a href="{jurl 'booster~default:plugins'}">Plugins</a></li>
            <li {if $packlang}class="selected"{/if}><a href="{jurl 'booster~default:packlang'}">Pack de Langues</a></li>

        {ifuserconnected}
            {zone 'booster~reported', array('selected' => $your_ressources)}
        {/ifuserconnected}
        </ul>
        {zone 'jcommunity~status'}
    </div>
</div>

<div id="main">

    <div id="content-menu">
        {$MENU}
    </div>
    <div id="content">
        {jmessage}
        
        {zone 'booster~search'}
        
        {$MAIN}
    </div>
    <div class="clear"></div>
</div>

<div id="footer" class="full">
    <span style="color:red">version BETA</span> - <a href="https://github.com/foxmask/Booster/issues/new">Un problème d'utilisation ? faites nous en part</a> - <a href="{jurl 'booster~default:credits'}">Crédits</a> - Copyright 2006-2011 Jelix team.<br/>
    <img src="/btn_jelix_powered.png" alt="page générée par Jelix" />
</div>
