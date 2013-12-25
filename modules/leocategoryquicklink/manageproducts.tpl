{if $products != false}
                    {assign var='liHeight' value=250}
			{assign var='nbItemsPerLine' value=4}
			{assign var='nbLi' value=$products|@count}
			{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
			{math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight}
                        <ul class="products-grid row">
                      {foreach from=$products item=product name=myLoop} 
                            	{math equation="(total%perLine)" total=$smarty.foreach.myLoop.total perLine=$nbItemsPerLine assign=totModulo}
				{if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
				<li class="ajax_block_product {if $smarty.foreach.myLoop.first}item first{elseif $smarty.foreach.myLoop.last}{else}item{/if} {if $smarty.foreach.myLoop.iteration%$nbItemsPerLine == 0}last_item_of_line{elseif $smarty.foreach.myLoop.iteration%$nbItemsPerLine == 1} {/if} {if $smarty.foreach.myLoop.iteration > ($smarty.foreach.myLoop.total - $totModulo)}last_line{/if} span3">
                                <div class="products-box">
                                      {if isset($product.new) && $product.new == 1}<div class="products-new">{l s='New' mod='wdproductsearch'}</div>{/if}
                                    <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product-image product_img_link"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"  alt="{$product.name|escape:html:'UTF-8'}" /> </a>
                                    <div class="pro-info">
                                       <!-- <div class="ratings">
                                            <div class="rating-box">
                                                <div class="rating" style="width:73%"></div>
                                            </div>
                                            <span class="amount"><a href="#" onclick="var t = opener ? opener.window : window; t.location.href=''; return false;">3 Review(s)</a></span>
                                        </div>-->
                                        <h2 class="product-name"><a href="{$product.link}" title="{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h2>
                                    </div>
                                    <div class="actions">
                                        <div class="price-box">
                                            <span class="regular-price" id="product-price-44">
                                                
                                                {if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE} <span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span>{else} <span class="price"></span> {/if}
                                                
                                            </span>

                                        </div>
                                        {if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}
                                               {if ($product.quantity > 0 OR $product.allow_oosp)}
                                               <button  type="button" title="{l s='Add to Cart' mod='wdproductsearch'}" rel="ajax_id_product_{$product.id_product}" class="button btn-cart add-to-cart exclusive ajax_add_to_cart_button" onclick="setPLocation('{$link->getPageLink('cart.php')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add')">
                                                    
                                                   <span>
                                                    <div class='add-to-links'>        
                                                         <!--img class ='shopcart' src ='img/shopcarts.png'  data-original-title='mx' /-->
                                                     </div>
                                                    </span>
                                                   </button>
                                               {else}
                                                   <a class="btn-cart" rel="tooltip"  href="#" title="{l s='Out of stock'}"><span>&nbsp;</span></a>
                                               {/if}
                                       {else}
                                                <a class="btn-cart" rel="tooltip"  href="#" title="{l s='Out of stock'}"><span>&nbsp;</span></a>
                                       {/if}
                                        
                                        <ul class="add-to-links">
                                           <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
                  <li><a href="#" onclick="WishlistCart('wishlist_block_list', 'add', '{$product.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;"  rel="tooltip" class="link-wishlist" title="{l s='Add to Wishlist' mod='wdproductsearch'} ">&nbsp;</a></li>
                <li><span class="separator">|</span> 
                    <!--<a href="#" rel="tooltip" title="{l s='Add to Compare' mod='wdproductsearch'}" class="new_comparator link-compare"  id="comparator_item_{$product.id_product}">&nbsp;</a>-->
                    {if isset($product) && $product.customizable}
                     <a href="http://www.salessign.com.au/modules/wdproductcustomise/productcustomise.php?id_product={$product.id_product}" rel="tooltip" title="{l s='Customise Me' mod='wdproductsearch'}" class="new_comparator link-compare"  id="comparator_item_{$product.id_product}"></a>
                     <!--img class ='handpng new_comparator' src ='img/smallhand.png'  data-original-title='' /-->
                     {else}
                         {/if}
                </li>
                                        </ul>
                                            
                                    </div><div class="clear"></div>
                                </div>
                            </li>
                       {/foreach}
                        </ul>
{else}
<p>{l s='No products at this time' mod='wdproductsearch'}</p>
{/if}
