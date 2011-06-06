<ul id="boosteradmin-tasktodo">
{if count($tasks) == 0}
<li>{@boosteradmin~admin.task.none@}</li>
{/if}
{for $i = 0 ; $i < count($tasks) ; $i++}
<li>{$tasks[$i]}</li>
{/for}
</ul>
