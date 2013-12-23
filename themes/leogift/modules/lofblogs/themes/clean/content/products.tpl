<div id="lofcontent_related_product" class="lofcontent_block">
    <h3 class="article_subheader">{l s='Related products' mod='lofblogs'}</h3>
    <ul>
        {foreach from=$lof_products item=product}
            <li>                
                <img src="{$product.image}" alt="{$product.name}" />
                <a href="{$product.link}" title="{$product.name}" >{$product.name}</a>
            </li>
        {/foreach}
    </ul>
</div>