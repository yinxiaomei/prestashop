<?php /* Smarty version Smarty-3.1.14, created on 2013-12-23 00:30:06
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:556652b6e95e539092-46363133%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e12703be7d401a2e52e10ce831bab6d7ceac33b5' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\category-count.tpl',
      1 => 1387460350,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '556652b6e95e539092-46363133',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'nb_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b6e95e5cd7b3_10078300',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b6e95e5cd7b3_10078300')) {function content_52b6e95e5cd7b3_10078300($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<?php echo smartyTranslate(array('s'=>'There are no products in  this category'),$_smarty_tpl);?>

<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?><?php }} ?>