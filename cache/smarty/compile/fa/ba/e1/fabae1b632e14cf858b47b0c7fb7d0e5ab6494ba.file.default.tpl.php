<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 00:40:35
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\modules\leobootstrapmenu\themes\default\default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:545852b2f7537fb0e7-67027256%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fabae1b632e14cf858b47b0c7fb7d0e5ab6494ba' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\leobootstrapmenu\\themes\\default\\default.tpl',
      1 => 1387460355,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '545852b2f7537fb0e7-67027256',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'leobootstrapmenu_menu_tree' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f7538127f0_99457276',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f7538127f0_99457276')) {function content_52b2f7538127f0_99457276($_smarty_tpl) {?><div class="navbar">
<div class="navbar-inner">
		<a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</a>
	<div class="nav-collapse collapse">
		<?php echo $_smarty_tpl->tpl_vars['leobootstrapmenu_menu_tree']->value;?>

	</div>
</div>
</div><?php }} ?>