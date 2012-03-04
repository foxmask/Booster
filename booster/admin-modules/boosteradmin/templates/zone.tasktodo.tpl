{if count($tasks) > 0}
    <div id="tasktodo" class="submenubar">
        <span>{@boosteradmin~admin.waiting.your.validation@} : </span>
        <ul>
			{foreach $tasks as $t}
				<li>{$t}</li>
			{/foreach}
		</ul>
	</div>
{/if}