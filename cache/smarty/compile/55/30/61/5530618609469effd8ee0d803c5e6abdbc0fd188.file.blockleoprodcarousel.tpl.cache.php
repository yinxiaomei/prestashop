<?php /* Smarty version Smarty-3.1.14, created on 2013-12-21 23:17:28
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\modules\blockleoprodcarousel\blockleoprodcarousel.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2355752b2f7588139d7-88263422%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5530618609469effd8ee0d803c5e6abdbc0fd188' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\blockleoprodcarousel\\blockleoprodcarousel.tpl',
      1 => 1387628244,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2355752b2f7588139d7-88263422',
  'function' => 
  array (
  ),
  'cache_lifetime' => 31536000,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f7588715e0_16294928',
  'variables' => 
  array (
    'products' => 0,
    'product_tpl' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f7588715e0_16294928')) {function content_52b2f7588715e0_16294928($_smarty_tpl) {?>

<!-- MODULE Block specials -->
<div id="categoriesprodtabs" class="block_box_center products_block exclusive blockleoprodcarousel span9">
	<h1 style="text-transform:text-transform:uppercase;"><?php echo smartyTranslate(array('s'=>'Top Seller','mod'=>'blockleoprodcarousel'),$_smarty_tpl);?>
</h1>
	<h3 style="text-transform:text-transform:uppercase;text-align:center"><?php echo smartyTranslate(array('s'=>'You can see more detail in the shop'),$_smarty_tpl);?>
</h3>
	<div class="block_content">	
		<?php if (!empty($_smarty_tpl->tpl_vars['products']->value)){?>
			<?php $_smarty_tpl->tpl_vars['tabname'] = new Smarty_variable("leoproductcarousel", null, 0);?>
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['product_tpl']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
 
		<?php }?>
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
 <?php }} ?>