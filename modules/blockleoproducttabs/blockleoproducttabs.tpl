{*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- MODULE Block specials -->
<div class="span8">
<div id="leoproducttabs" class="block_box_center products_block exclusive blockleoproducttabs">
	<div class="block_content">			            
			<ul id="productTabs" class="nav nav-tabs idTabs">
			  {if $featured}	
              <li><a href="#tabfeaturedproducts" data-toggle="tab"><span></span>{l s='Featured Products' mod='blockleoproducttabs'}</a></li>
			  {/if}
              {if $newproducts}	
              <li><a href="#tabnewproducts" data-toggle="tab"><span></span>{l s='New Arrivals' mod='blockleoproducttabs'}</a></li>
			  {/if}
			  {if $special}	
              <li><a href="#tabspecial" data-toggle="tab">{l s='Special' mod='blockleoproducttabs'}</a></li>
			  {/if}
			  {if $bestseller}	
              <li><a href="#tabbestseller" data-toggle="tab"><span></span>{l s='Best Seller' mod='blockleoproducttabs'}</a></li>
			  {/if}
            </ul>
			
            <div id="productTabsContent" class="tab-content">
			{if $featured}		  
              <div class="tab-pane " id="tabfeaturedproducts">
					{$products=$featured} {$tabname='tabfeaturedproducts-carousel'}
					{include file="{$product_tpl}"}
              </div>   
			 {/if}	
			  {if $newproducts}		  
              <div class="tab-pane " id="tabnewproducts">
					{$products=$newproducts} {$tabname='tabnewproducts-carousel'}
					{include file="{$product_tpl}"}
              </div>   
				 {/if}	
			   {if $special}	
					<div class="tab-pane" id="tabspecial">
					{$products=$special}{$tabname='tabspecialcarousel'}
					{include file="{$product_tpl}"}
	              </div>
			   {/if}
			 {if $bestseller}		  
              <div class="tab-pane " id="tabbestseller">
					{$products=$bestseller} {$tabname='tabbestseller-carousel'}
					{include file="{$product_tpl}"}
              </div>   
			 {/if}	
			 
			</div>
        
		
	</div>
</div>
</div>
<!-- /MODULE Block specials -->
<script>
$(document).ready(function() {
    $('.carousel').each(function(){
        $(this).carousel({
            pause: true,
            interval: false
        });
    });
	$(".blockleoproducttabs").each( function(){
		$(".nav-tabs li", this).first().addClass("active");
		$(".tab-content .tab-pane", this).first().addClass("active");
	} );
});
</script>
 