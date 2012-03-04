<div id="login-box">
{ifuserconnected}
    {$login} -
    <a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">your account</a>
    -
    <a href="{jurl 'jcommunity~login:out'}">logout</a>
{else}
    <a href="{jurl 'jcommunity~login:index'}">login</a>
    -
    <a href="{jurl 'jcommunity~registration:index'}">register</a>
{/ifuserconnected}
</div>
