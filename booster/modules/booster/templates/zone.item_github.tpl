{if empty($not_ok)}
	<div class="section booster-item-github">
		<h4>{@booster~main.github.repo.details@}</h4>
		<ul class="inline-list">
			<li title="{jlocale 'booster~main.github.repo.activity.details.'.$activity}">
				<img src="{$j_themepath}icons/chart_curve.png" alt=""/>
				{@booster~main.github.repo.activity@} : <span class="activity">{jlocale 'booster~main.github.repo.activity.'.$activity}</span>
			</li>

			<li>
				<img src="{$j_themepath}icons/arrow_divide2.png" alt=""/>
				{$forks} {@booster~main.github.repo.forks@}
			</li>
			<li>
				<img src="{$j_themepath}icons/eye.png" alt=""/>
				{$watchers} {@booster~main.github.repo.watchers@}
			</li>

			<li>
				<img src="{$j_themepath}icons/hourglass.png" alt=""/>
				{@booster~main.github.repo.last.update@} : {$update|jdatetime:'iso8601':'lang_date'}
			</li>
		</ul>
	</div>
{/if}