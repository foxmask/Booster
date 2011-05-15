{meta_html csstheme 'css/grid.css'}
{meta_html csstheme 'css/layout.css'}
{meta_html csstheme 'css/booster.css'}
{meta_html csstheme 'css/nav.css'}
{meta_html cssthemeie 'css/ie.css'}
{meta_html cssthemeltie7 'css/ie6.css'}
<div id="top-box">
    <div id="accessibility">Quick links:
        <a href="#content">Content</a> -
        <a href="#topmenubar">sections</a> -
        <a href="#submenubar">sub sections</a>
    </div>
    <div id="lang-box">
      <strong>EN</strong>
      <a href="{jurl 'booster~default:index', array('lang'=>'fr_FR')}" hreflang="fr" title="français">fr</a>
    </div>
</div>

  <h1 id="logo"><a href="/" title="Return to homepage"><img src="/logo_jelix_moyen2.png" alt="Jelix" /></a><br/>
  PHP5 Framework
  </h1>

<div id="header">
    <div id="topmenubar">
        <a href="{jurl 'booster~default:index'}">Jelix BOOSTER</a>
    </div>
    <ul id="submenubar">
       <li><a href="">List All</a></li>
       <li><a href="">Last adding</a></li>
    </ul>
</div>

<div class="container_16" id="main">
    <div class="grid_16">
        <h1>Booster : What's that ?</h1>
        <p id="booster_description">
            Booster is the portal that provides all the existing Jelix ressources provided by the community :
            Applications, Modules, Plugins, and Language Packs. <a href="{jurl 'booster~default:add'}">You can now add your own work</a> on <em>Booster</em>.
        </p>
    </div>
    <div class="clear"></div>
    <div class="grid_13">
        <h2>Welcome to Booster.</h2>
        {jmessage}
        {$MAIN}
    </div>
    <div class="grid_3">
        {$MENU}
        <br/>
        {zone 'jtags~tagscloud'}
    </div>
    <div class="clear"></div>
</div>

<div id="footer" class="full">
    <a href="/articles/fr/credits">Contacts &amp; Crédits</a> - Copyright 2006-2011 Jelix team.<br/>
    <img src="/btn_jelix_powered.png" alt="page générée par Jelix" />
</div>
