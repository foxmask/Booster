<ul id="login-status">
{ifuserconnected}
    <li id="connected">Hello {$login}</li>
    <li><a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">Your account</a></li>
    <li><a href="{jurl 'jcommunity~login:out'}">Logout</a></li>
{else}
    <li id="connected"><a href="{jurl 'jcommunity~login:index'}">Login</a></li>
    <li><a href="{jurl 'jcommunity~registration:index'}">Register</a></li>
    <li><a href="{jurl 'jcommunity~password:index'}">Forgotten password</a></li>
{/ifuserconnected}
</ul>
