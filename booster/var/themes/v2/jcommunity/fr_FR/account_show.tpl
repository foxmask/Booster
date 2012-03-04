{meta_html css '/jelix/design/records_list.css'}
<div class="jcommunity-box jcommunity-account">
<h1>Profil de {$user->login|eschtml}</h1>

<table class="records-list">
    <tbody>
        <tr class="odd">
            <td>Login</td> <td>{$user->login|eschtml}</td>
        </tr>
        <tr class="even">
            <td>Nom affiché</td> <td>{$user->nickname|eschtml}</td>
        </tr>
{ifuserconnected}
        <tr class="odd">
            <td>Email</td> <td>{$user->email|eschtml}</td>
        </tr>
{/ifuserconnected}
{foreach $otherInfos as $label=>$value}
        <tr class="{cycle 'even,odd'}">
            <td>{$label|eschtml}</td> <td>{$value|eschtml}</td>
        </tr>
{/foreach}
    </tbody>
</table>
{$additionnalContent}

{if $himself}
<ul>
    <li><a href="{jurl 'jcommunity~account:prepareedit', array('user'=>$user->login)}">Editer votre profil</a></li>
    <li><a href="{jurl 'jcommunity~account:destroy', array('user'=>$user->login)}">Effacer votre profil</a></li>
    {foreach $otherPrivateActions as $link=>$label}
    <li><a href="{$link}">{$label|eschtml}</a></li>
    {/foreach}
</ul>
{/if}
</div>
