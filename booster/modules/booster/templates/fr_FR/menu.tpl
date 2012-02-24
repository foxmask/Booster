    <h2>Booster : Qu'est-ce ?</h2>
    <p id="booster_description">
        Booster est le portail qui vous fourni l'ensemble des ressources Jelix existantes produites par la communauté :
        Applications, Modules, Plugins, Paquets de langage. <a href="{jurl 'booster~default:add'}">Vous pouvez, à votre tour, déposer vos propres créations</a> sur <em>Booster</em>
    </p>
    
{ifuserconnected}
<h2>{@main.item@}</h2>
<a class="jforms-submit" href="{jurl 'booster~add'}">{@main.add.an.item@}</a>
{ifacl2 'booster.admin.index'}
<div class="booster_tasktodo">
<span>{@main.waiting.your.validation@} : </span>
{zone 'boosteradmin~tasktodo'}
</div>
{/ifacl2}
{/ifuserconnected}
{zone "jtags~tagscloud", array('destination'=>'booster~default:cloud', 'maxcount'=>20)}
