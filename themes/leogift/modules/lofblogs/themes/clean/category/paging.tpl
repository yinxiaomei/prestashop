<div id="pagination" class="pagination">
	{if $n < $nb_products}
		<ul class="pagination">
		{if $p != 1}
			{assign var='p_previous' value=$p-1}
			<li id="pagination_previous"><a href="{$link_paging}{$lof_pathway}p={$p_previous}&n={$n}">
			&laquo;&nbsp;{l s='Previous' mod='loyalty'}</a></li>
		{else}
			<li id="pagination_previous" class="disabled"><span>&laquo;&nbsp;{l s='Previous' mod='loyalty'}</span></li>
		{/if}
		{if $p > 2}
			<li><a href="{$link_paging}{$lof_pathway}p=1&n={$n}">1</a></li>
			{if $p > 3}
				<li class="truncate">...</li>
			{/if}
		{/if}
		{section name=pagination start=$p-1 loop=$p+2 step=1}
			{if $p == $smarty.section.pagination.index}
				<li class="current"><span>{$p|escape:'htmlall':'UTF-8'}</span></li>
			{elseif $smarty.section.pagination.index > 0 && $nb_products+$n > ($smarty.section.pagination.index)*($n)}
				<li><a href="{$link_paging}{$lof_pathway}p={$smarty.section.pagination.index}&n={$n}">{$smarty.section.pagination.index|escape:'htmlall':'UTF-8'}</a></li>
			{/if}
		{/section}
		{if $pages_nb-$p > 1}
			{if $pages_nb-$p > 2}
				<li class="truncate">...</li>
			{/if}
			<li><a href="{$link_paging}{$lof_pathway}p={$pages_nb}&n={$n}">{$pages_nb}</a></li>
		{/if}
		{if $nb_products > $p * $n}
			{assign var='p_next' value=$p+1}
			<li id="pagination_next"><a href="{$link_paging}{$lof_pathway}p={$p_next}&n={$n}">{l s='Next' mod='loyalty'}&nbsp;&raquo;</a></li>
		{else}
			<li id="pagination_next" class="disabled"><span>{l s='Next' mod='loyalty'}&nbsp;&raquo;</span></li>
		{/if}
		</ul>
	{/if}
	{if $nb_products > 10}
		<form action="{$pagination_link}" method="get" class="pagination">
			<p>
				<input type="submit" class="button_mini" value="{l s='OK'}" />
				<label for="nb_item">{l s='items:' mod='loyalty'}</label>
				<select name="n" id="nb_item">
				{foreach from=$nArray item=nValue}
					{if $nValue <= $nb_products}
						<option value="{$nValue|escape:'htmlall':'UTF-8'}" {if $n == $nValue}selected="selected"{/if}>{$nValue|escape:'htmlall':'UTF-8'}</option>
					{/if}
				{/foreach}
				</select>
				<input type="hidden" name="p" value="1" />
			</p>
		</form>
	{/if}
</div>