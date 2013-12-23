
<div class="lofcontentmenu-wrapper block">
    {if $params.showTitle}
        <h4>{$params.title}</h4>
    {/if}    
    <div class="block_content">
        <ul>
            {foreach from=$items item=item}
                <li>
                    <a href="{$item.link}" title="{$item.title}" >{$item.title}</a>
                </li>
            {/foreach}    
        </ul>
    </div>
</div>