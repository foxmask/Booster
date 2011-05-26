<ul id="login-status">
{ifuserconnected}
    <li id="connected">{$login}, vous êtes connecté.</li>
    <li>(<a href="{jurl 'jcommunity~login:out'}">déconnexion</a>,</li>
    <li><a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">votre compte</a>)</li>
{else}
    <li id="connected">Non connecté.</li>
    <li><a href="{jurl 'jcommunity~login:index'}">Login</a>,</li>
    <li><a href="{jurl 'jcommunity~registration:index'}">S'inscrire</a>,</li>
    <li><a href="{jurl 'jcommunity~password:index'}">Mot de passe oublié</a></li>
{/ifuserconnected}
</ul>
