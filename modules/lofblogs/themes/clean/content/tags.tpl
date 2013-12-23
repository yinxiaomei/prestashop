<div id="lofcontent_tags" class="lofcontent_block">
    <h3>{l s='Tags : ' mod='lofblogs'}</h3>
    <ul>
        {foreach from=$lofcontent_tags item=tag}
            <li>                
                <a href="{$tag.link}" title="{$tag.text}" >{$tag.text}</a>
            </li>
        {/foreach}
    </ul>
</div>