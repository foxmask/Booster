{meta_html csstheme 'css/grid.css'}
{meta_html csstheme 'css/layout.css'}
{meta_html csstheme 'css/booster.css'}
{meta_html csstheme 'css/nav.css'}
{meta_html cssthemeie 'css/ie.css'}
{meta_html cssthemeltie7 'css/ie6.css'}

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
        <a href="{jurl 'booster~default:index'}">Jelix BOOSTER</a>
    </div>
    <ul id="submenubar">
       <li><a href="">Liste Complete</a></li>
       <li><a href="">Derniers ajouts</a></li>
    </ul>
</div>

<div class="container_16" id="main">
    {if $is_home}
        <div class="grid_16">
            <h1>Booster : Qu'est-ce ?</h1>
            <p id="booster_description">
                Booster est le portail qui vous fourni l'ensemble des ressources Jelix existantes produites par la communauté :
                Applications, Modules, Plugins, Paquets de langage. <a href="{jurl 'booster~default:add'}">Vous pouvez, à votre tour, déposer vos propres créations</a> sur <em>Booster</em>
            </p>
        </div>
    {/if}
    <div class="clear"></div>
    <div class="grid_13">
         {if $is_home}<h2>Bienvenue sur Booster.</h2>{/if}
        {jmessage}
        {$MAIN}
    </div>
    <div class="grid_3">
        {$MENU}
        <br/>
        {zone "jtags~tagscloud", array('destination'=>'booster~default:cloud', 'maxcount'=>20)}
    </div>
    <div class="clear"></div>
</div>

<div id="footer" class="full">
    <a href="/articles/fr/credits">Contacts &amp; Crédits</a> - Copyright 2006-2011 Jelix team.<br/>
    <img src="/btn_jelix_powered.png" alt="page générée par Jelix" />
</div>
