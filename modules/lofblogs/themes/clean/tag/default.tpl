<div class="lofcontent_category">
    <h2>{$pagetitle}</h2>
    {foreach from=$LBObject item=article}
        <div class="lofcontent_category_item"> 
            <p class="lof_link_title" >
                <a href="{$article.link}" title="{$article.title}" >{$article.title}</a>
            </p>            
            {if $article.image}
                <div class="lof_item_thumb">
                    <img src="{$imgPrimaryUri}{$article.image}" alt="{$article.title}" />
                </div>
            {/if}
            <div class="lof_item_desc">
                <p class="lof_description">{$article.introtext}</p>
            </div>

        </div>
    {/foreach}
	{if $LOFSYSTEM_PAGINATION}{$LOFSYSTEM_PAGINATION}{/if}
</div>