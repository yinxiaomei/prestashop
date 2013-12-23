<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 01:47:07
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\modules\blockleorelatedproducts\blockleorelatedproducts.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13952b306eb4a4d30-59582226%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04acfee29d6e605308a9287541feea2e9da953b0' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\blockleorelatedproducts\\blockleorelatedproducts.tpl',
      1 => 1387460353,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13952b306eb4a4d30-59582226',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'product_tpl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b306eb57f960_31793862',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b306eb57f960_31793862')) {function content_52b306eb57f960_31793862($_smarty_tpl) {?>

<!-- MODULE Block specials -->
<div id="relatedproducts" class="block_box_center products_block exclusive blockleorelatedproducts">
	<ul class=" idTabs clearfix">
		<li><a href="#" class="selected"><?php echo smartyTranslate(array('s'=>'Related products','mod'=>'blockleorelatedproducts'),$_smarty_tpl);?>
</a></li>
	</ul>
	<div class="block_content">	
		<?php if (!empty($_smarty_tpl->tpl_vars['products']->value)){?>
			<?php $_smarty_tpl->tpl_vars['tabname'] = new Smarty_variable("leorelatedcarousel", null, 0);?>
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['product_tpl']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
 
		<?php }?>
	</div>
</div>
<!-- /MODULE Block specials -->
<script>
$(document).ready(function() {
    $('.blockleorelatedproducts').each(function(){
        $(this).carousel({
            pause: true,
            interval: false
        });
    });
	 
});
</script>
 <?php }} ?>