
<div class="lofcontentmenu-wrapper block">
    {if $params.showTitle}
        <h4 class="title_block"><a href="index.php?view=category&id=0&fc=module&module=lofblogs&controller=articles" title="{l s='All article' mod='lofblogscategory'}">{$params.title}</a></h4>
    {/if}    
    <div class="block_content">
    <ul>
        {foreach from=$items item=item}
            {include file="$branche_tpl_path" node=$item last='true'}
        {/foreach}    
    </ul>
    </div>
</div>