<?php /* Smarty version Smarty-3.1.14, created on 2013-12-22 21:02:57
         compiled from "D:\xampp\htdocs\prestashop\adminkk\themes\default\template\helpers\list\list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3055552b6b8d189cab1-09444275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6161374111496b3fa7a0eb5e2db6ee5a53b5a17' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\adminkk\\themes\\default\\template\\helpers\\list\\list_action_edit.tpl',
      1 => 1384762196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3055552b6b8d189cab1-09444275',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b6b8d18fe554_95829491',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b6b8d18fe554_95829491')) {function content_52b6b8d18fe554_95829491($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="edit" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/edit.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>