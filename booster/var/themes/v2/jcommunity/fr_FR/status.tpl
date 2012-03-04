<div id="login-box">
{ifuserconnected}
    {$login} -
    <a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">votre compte</a>
    -
    <a href="{jurl 'jcommunity~login:out'}">déconnexion</a>
{else}
    <a href="{jurl 'jcommunity~login:index'}">connexion</a>
    -
    <a href="{jurl 'jcommunity~registration:index'}">s'inscrire</a>
{/ifuserconnected}
</div>
