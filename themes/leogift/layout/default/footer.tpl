	</div>
	<!-- end div block_home -->
{if $HOOK_CONTENTBOTTOM && in_array($page_name,array('index')) }
	<div id="contentbottom">
	{$HOOK_CONTENTBOTTOM}
	</div>
{/if}
</section>
{if isset($LAYOUT_COLUMN_SPANS[2])&&$LAYOUT_COLUMN_SPANS[2]} 
<!-- Right -->
<section id="right_column" class="column span{$LAYOUT_COLUMN_SPANS[2]} sidebar">
	{$HOOK_RIGHT_COLUMN}
</section>
{/if}