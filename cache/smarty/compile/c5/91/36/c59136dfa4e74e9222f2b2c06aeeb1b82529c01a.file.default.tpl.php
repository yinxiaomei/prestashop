<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 00:40:40
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\modules\leocustomhtml2\tmpl\default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2215552b2f758e39ec5-13642690%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c59136dfa4e74e9222f2b2c06aeeb1b82529c01a' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\leocustomhtml2\\tmpl\\default.tpl',
      1 => 1387460355,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2215552b2f758e39ec5-13642690',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'class_prefix' => 0,
    'pos' => 0,
    'show_title' => 0,
    'module_title' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f758e84258_10008012',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f758e84258_10008012')) {function content_52b2f758e84258_10008012($_smarty_tpl) {?><div class="customhtml customhtml2 <?php echo $_smarty_tpl->tpl_vars['class_prefix']->value;?>
" id="leo-customhtml-<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
">
	<?php if ($_smarty_tpl->tpl_vars['show_title']->value){?>
		<h3 class="title_block"><?php echo $_smarty_tpl->tpl_vars['module_title']->value;?>
</h3>
	<?php }?>
	<div class="block_content">
		<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

	</div>
</div><?php }} ?>