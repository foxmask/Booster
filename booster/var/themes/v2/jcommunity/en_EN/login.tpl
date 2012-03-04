<div class="jcommunity-box jcommunity-login">
<h1>Authentification</h1>
{ifuserconnected}

    {$login}, you are connected.
    <div class="loginbox-links">
        (<a href="{jurl 'jcommunity~login:out'}">Logout</a>,
        <a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">Your account</a>)
    </div>

{else}
<p>If you already own an account on <a href="http://jelix.org/forums/">the forum</a>, then you can use it to connect here</p>
{form $form, 'jcommunity~login:in'}
    <p> {ctrl_label 'auth_login'} {ctrl_control 'auth_login'}
     - {ctrl_label 'auth_password'} {ctrl_control 'auth_password'}
{if $persistance_ok}
    - {ctrl_label 'auth_remember_me'} {ctrl_control 'auth_remember_me'}
{/if}
    {if $url_return}
    <input type="hidden" name="auth_url_return" value="{$url_return|eschtml}" />
    {/if}
    {formsubmit}
    </p>
{/form}

<div class="loginbox-links">
  (<a href="{jurl 'jcommunity~registration:index'}">Register</a>,
  <a href="{jurl 'jcommunity~password:index'}">Forgotten password</a>)
</div>

{/ifuserconnected}
</div>
