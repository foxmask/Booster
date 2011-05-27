<li id="my-items" {if $selected}class="selected"{/if}>
    <span><a href="{jurl 'booster~default:yourressources'}">{@main.your.ressources@}</a></span>

    <ul class="dropdown">
        {foreach $items as $item}
            <li>
                <a href="{jurl 'booster~default:viewItem', array('id' => $item->id, "name" => $item->name)}">
                    {$item->name}</a> {if $item->status == 0}({@main.status.not_validated@}){/if}
                </a>
            </li>
        {/foreach}
        {if $more}<li><a href="{jurl 'booster~default:yourressources'}">...</a></li>{/if}
    </ul>

</li>


<script type="text/javascript">
    {literal}
//<![CDATA[
        console.log('hello !');
        $(document).ready(function(){
            
            var $liste = $('#my-items').find('ul');
            var timeoutFadeIn;
            var timeoutFadeOut;
            
            $('#my-items').bind('mouseenter' , function(){
                clearTimeout(timeoutFadeIn);
                clearTimeout(timeoutFadeOut);
                timeoutFadeIn = setTimeout( function(){
                        $liste.fadeIn();
                    }, 200);
            });
            
            $('#my-items').bind('mouseleave' , function(){
                clearTimeout(timeoutFadeOut);
                timeoutFadeOut = setTimeout( function(){
                        $liste.fadeOut();
                    }, 500);
            });
            
        });
//]]>
    {/literal}
</script>