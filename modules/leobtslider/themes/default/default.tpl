
<div id="leobttslider{$leobtslider_modid}" class="carousel slide leobttslider span9">
	<div class="box-shadow">
		<div class="carousel-inner">
			{foreach from=$leobtslider_slides item=slide name=slidename}
				<div class="item{if $smarty.foreach.slidename.index == 0} active{/if}">
					{if $slide.url}
						<a href="{$slide.url}"><img src="{$slide.mainimage}" alt="{$slide.title}" /></a>
					{else}
						<img src="{$slide.mainimage}" alt="{$slide.title}" />
					{/if}

					{if $slide.title  || $slide.description}
						<div class="mask"></div>
						<div class="slide-info">
							<h1>{$slide.title}</h1>
							<div class="desc">{$slide.description}</div>
						</div>
					{/if}
				</div>
			{/foreach}
		</div>
		{if count($leobtslider_slides) > 1}
		<a class="carousel-control left icon-leo-prev" href="#leobttslider{$leobtslider_modid}" data-slide="prev">&nbsp;</a>
		<a class="carousel-control right icon-leo-next" href="#leobttslider{$leobtslider_modid}" data-slide="next">&nbsp;</a>
		{/if}

		{if count($leobtslider_slides) > 1}
			{if $leobtslider.image_navigator}
				<ol class="carousel-indicators">
				{foreach from=$leobtslider_slides item=item name=itemname}
					<li data-target="#leobttslider{$leobtslider_modid}" data-slide-to="{$smarty.foreach.itemname.index}" class="{if $smarty.foreach.itemname.index == 0}active{/if}"></li>
				{/foreach}
				</ol> 
			{/if}
		{/if} 
	</div>
</div>
{if $leobtslider.auto}
<script type="text/javascript">
	{literal}
	jQuery(document).ready(function(){
		$('#leobttslider{/literal}{$leobtslider_modid}{literal}').carousel({
		  interval: {/literal}{$leobtslider.delay}{literal}
		});
	});
	{/literal}
</script>
{/if}
