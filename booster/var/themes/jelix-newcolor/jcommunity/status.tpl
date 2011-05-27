<ul id="login-status">
{ifuserconnected}
    <li id="connected">Bonjour <a href="{jurl 'jcommunity~account:show', array('user'=>$login)}" title="Cliquer pour modifier votre compte">{$login}</a> - (<a href="{jurl 'jcommunity~login:out'}">déconnexion</a>)</li>
{else}
    <li id="connected">Non connecté.</li>
    <li><a href="{jurl 'jcommunity~login:index'}">Connexion</a>,</li>
    <li><a href="{jurl 'jcommunity~registration:index'}">S'inscrire</a>,</li>
    <li><a href="{jurl 'jcommunity~password:index'}">Mot de passe oublié</a></li>
{/ifuserconnected}
</ul>
