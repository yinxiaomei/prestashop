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
<div class="span12">
<div id="categoriesprodtabs" class="block_box_center products_block exclusive blockleoprodcarousel span9">
	<h1 style="text-transform:text-transform:uppercase;">{l s='Top Seller' mod='blockleoprodcarousel'}</h1>
	<h3 style="text-transform:text-transform:uppercase;text-align:center">{l s = 'You can see more detail in the shop'}</h3>
	<div class="block_content">	
		{if !empty($products )}
			{$tabname="leoproductcarousel"}
			{include file="{$product_tpl}"} 
		{/if}
	</div>
</div>
<!--div id="clipart" class="customhtml  leo-customhtml-slideshow span3">
	<img id="hideclipart" src='/prestashop/modules/blockleoprodcarousel/img/delete.gif' style="position:relative;float:right"></img>
	<div class="block_content">
		<p>
			<a class="box-shadow" href="#">
				<img src="/prestashop/cache/cachefs/leobtslidermini/350_690_sample-2.jpg"></img>
			</a>
		</p>
	</div>
</div>   -->
<!-- /MODULE Block specials -->
<script>
$(document).ready(function() {
    $('.blockleoprodcarousel').each(function(){
        $(this).carousel({
            pause: true,
            interval: false
        });
    });
    
    $('#hideclipart').bind('click',showAll);
});
function showAll(){
	var categoriesprodtabs = $('#categoriesprodtabs');
	var clipart = $('#clipart');
	$("#clipart").css('display','none');
	categoriesprodtabs.removeClass('span9');
	categoriesprodtabs.addClass('span12');
	
	//修改每行产品：更改每个长度及显示最后一个产品图片
	var productsFirstLine = $('#categoriesprodtabs .span4');
	var lengthFirst = productsFirstLine.length;
	for(var i = 0 ; i < lengthFirst; i++) {
		var $product = $(productsFirstLine[i]);
		$product.removeClass('span4');
		$product.addClass('span3');
	}
	
	var productsSecondLine = $('#categoriesprodtabs .span6');
	var lengthSecond = productsSecondLine.length;
	for(var i = 0 ; i < lengthSecond; i++) {
		var $product = $(productsSecondLine[i]);
		$product.removeClass('span6');
		$product.addClass('span4');
	}
	
	var productHideone = $('.hideone');
	var lengthHide = productHideone.length;
	for(var i = 0 ; i < lengthHide; i++) {
		var $product = $(productHideone[i]);
		$product.removeClass('hideone');
		if( i == 0) {
			$product.addClass('span3');
		}else {
			$product.addClass('span4');
		}
		
		
	}
	
}
</script>
 