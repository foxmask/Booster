<ul id="login-status">
{ifuserconnected}
{meta_html js $j_basepath .'booster/js/booster.js'}
    <li id="my-status">
    <span>Hello, <a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">{$login}</a></span>
        <ul class="dropdown">
            <li><a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">Your account</a></li>
            <li><a href="{jurl 'jcommunity~login:out'}">Logout</a></li>
        </ul>
    </li>
{else}
    <li id="my-status">
        <span><a href="{jurl 'jcommunity~login:index'}">Login</a></span>
        <ul class="dropdown">
            <li><a href="{jurl 'jcommunity~login:index'}">Login</a></li>
            <li><a href="{jurl 'jcommunity~registration:index'}">Register</a></li>
            <li><a href="{jurl 'jcommunity~password:index'}">Forgotten password</a></li>
        </ul>
    </li>
{/ifuserconnected}
</ul>
