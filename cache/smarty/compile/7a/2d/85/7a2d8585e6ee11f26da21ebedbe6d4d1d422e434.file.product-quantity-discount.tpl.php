<?php /* Smarty version Smarty-3.1.14, created on 2013-12-19 14:23:30
         compiled from "D:\xampp\htdocs\prestashop\themes\default\mobile\product-quantity-discount.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1122052b2f352499471-03642023%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a2d8585e6ee11f26da21ebedbe6d4d1d422e434' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\default\\mobile\\product-quantity-discount.tpl',
      1 => 1384762196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1122052b2f352499471-03642023',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'quantity_discounts' => 0,
    'quantity_discount' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f3526a8a77_81318829',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f3526a8a77_81318829')) {function content_52b2f3526a8a77_81318829($_smarty_tpl) {?>

<?php if ((isset($_smarty_tpl->tpl_vars['quantity_discounts']->value)&&count($_smarty_tpl->tpl_vars['quantity_discounts']->value)>0)){?>
<!-- quantity discount -->
<ul class="idTabs clearfix">
	<li><a href="#discount" style="cursor: pointer" class="selected" data-ajax="false"><?php echo smartyTranslate(array('s'=>'Sliding scale pricing'),$_smarty_tpl);?>
</a></li>
</ul>
<div id="quantityDiscount">
	<table class="std">
		<thead>
			<tr>
				<th><?php echo smartyTranslate(array('s'=>'product'),$_smarty_tpl);?>
</th>
				<th><?php echo smartyTranslate(array('s'=>'from (qty)'),$_smarty_tpl);?>
</th>
				<th><?php echo smartyTranslate(array('s'=>'discount'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
		<tbody>
			<tr id="noQuantityDiscount">
				<td colspan='3'><?php echo smartyTranslate(array('s'=>'There is no quantity discount for this product.'),$_smarty_tpl);?>
</td>
			</tr>
			<?php  $_smarty_tpl->tpl_vars['quantity_discount'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['quantity_discount']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['quantity_discounts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['quantity_discount']->key => $_smarty_tpl->tpl_vars['quantity_discount']->value){
$_smarty_tpl->tpl_vars['quantity_discount']->_loop = true;
?>
			<tr id="quantityDiscount_<?php echo $_smarty_tpl->tpl_vars['quantity_discount']->value['id_product_attribute'];?>
">
				<td>
					<?php if ((isset($_smarty_tpl->tpl_vars['quantity_discount']->value['attributes'])&&($_smarty_tpl->tpl_vars['quantity_discount']->value['attributes']))){?>
						<?php echo $_smarty_tpl->tpl_vars['product']->value->getProductName($_smarty_tpl->tpl_vars['quantity_discount']->value['id_product'],$_smarty_tpl->tpl_vars['quantity_discount']->value['id_product_attribute']);?>

					<?php }else{ ?>
						<?php echo $_smarty_tpl->tpl_vars['product']->value->getProductName($_smarty_tpl->tpl_vars['quantity_discount']->value['id_product']);?>

					<?php }?>
				</td>
				<td><?php echo intval($_smarty_tpl->tpl_vars['quantity_discount']->value['quantity']);?>
</td>
				<td>
					<?php if ($_smarty_tpl->tpl_vars['quantity_discount']->value['price']!=0||$_smarty_tpl->tpl_vars['quantity_discount']->value['reduction_type']=='amount'){?>
						-<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>floatval($_smarty_tpl->tpl_vars['quantity_discount']->value['real_value'])),$_smarty_tpl);?>

					<?php }else{ ?>
						-<?php echo floatval($_smarty_tpl->tpl_vars['quantity_discount']->value['real_value']);?>
%
					<?php }?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php }?>
<?php }} ?>