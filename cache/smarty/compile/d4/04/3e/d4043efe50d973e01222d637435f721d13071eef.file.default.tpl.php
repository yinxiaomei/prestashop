<?php /* Smarty version Smarty-3.1.14, created on 2013-12-24 02:07:20
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\modules\leocustomhtml1\tmpl\default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2198152b2f75375ae46-37283358%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd4043efe50d973e01222d637435f721d13071eef' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\leocustomhtml1\\tmpl\\default.tpl',
      1 => 1387811191,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2198152b2f75375ae46-37283358',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f7537a51d7_84602318',
  'variables' => 
  array (
    'class_prefix' => 0,
    'pos' => 0,
    'show_title' => 0,
    'module_title' => 0,
    'src' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f7537a51d7_84602318')) {function content_52b2f7537a51d7_84602318($_smarty_tpl) {?><div id="clipart" class="customhtml <?php echo $_smarty_tpl->tpl_vars['class_prefix']->value;?>
 leo-customhtml-<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
 span3">
	<?php if ($_smarty_tpl->tpl_vars['show_title']->value){?>
		<h3 class="title_block"><?php echo $_smarty_tpl->tpl_vars['module_title']->value;?>
</h3>
	<?php }?>
	<img id="hideclipart" src='<?php echo $_smarty_tpl->tpl_vars['src']->value;?>
' style="position:relative;float:right"></img>
	<div class="block_content">
		<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

	</div>
</div>
</div><?php }} ?>