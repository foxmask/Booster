<ul id="login-status">
{ifuserconnected}
{meta_html js $j_basepath .'booster/js/booster.js'}
    <li id="my-status">
        <span>Bonjour <a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">{$login}</a></span>
        <ul class="dropdown">
            <li><a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">Votre compte</a></li>
            <li><a href="{jurl 'jcommunity~login:out'}">déconnexion</a></li>
        </ul>
    </li>
{else}
    <li id="my-status">
        <span><a href="{jurl 'jcommunity~login:index'}">Connexion</a></span>
        <ul class="dropdown">
            <li><a href="{jurl 'jcommunity~login:index'}">Connexion</a></li>
            <li><a href="{jurl 'jcommunity~registration:index'}">S'inscrire</a></li>
            <li><a href="{jurl 'jcommunity~password:index'}">Mot de passe oublié</a></li>
        </ul>
    </li>
{/ifuserconnected}
</ul>
