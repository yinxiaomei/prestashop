<?php /* Smarty version Smarty-3.1.14, created on 2013-12-19 14:23:27
         compiled from "D:\xampp\htdocs\prestashop\themes\default\mobile\page-title.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27052b2f34f413c98-50698433%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '852da5230ee3b1522d76006aaae3d55f8aa9a18b' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\default\\mobile\\page-title.tpl',
      1 => 1384762196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27052b2f34f413c98-50698433',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_title' => 0,
    'meta_title' => 0,
    'shop_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f34f4c3949_42191522',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f34f4c3949_42191522')) {function content_52b2f34f4c3949_42191522($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'D:\\xampp\\htdocs\\prestashop\\tools\\smarty\\plugins\\modifier.escape.php';
?><?php if (!isset($_smarty_tpl->tpl_vars['page_title']->value)&&isset($_smarty_tpl->tpl_vars['meta_title']->value)&&$_smarty_tpl->tpl_vars['meta_title']->value!=$_smarty_tpl->tpl_vars['shop_name']->value){?>
	<?php $_smarty_tpl->tpl_vars['page_title'] = new Smarty_variable(smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_title']->value, 'htmlall', 'UTF-8'), null, 0);?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['page_title']->value)){?>
	<div data-role="header" class="clearfix navbartop" data-position="inline">
		<h1><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</h1>
	</div><!-- /navbartop -->
<?php }?><?php }} ?>