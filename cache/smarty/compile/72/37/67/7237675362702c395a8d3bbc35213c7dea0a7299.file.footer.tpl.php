<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 00:40:42
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\layout\default\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2059752b2f75a9d9369-93020875%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7237675362702c395a8d3bbc35213c7dea0a7299' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\layout\\default\\footer.tpl',
      1 => 1387460352,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2059752b2f75a9d9369-93020875',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOOK_CONTENTBOTTOM' => 0,
    'page_name' => 0,
    'LAYOUT_COLUMN_SPANS' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f75aa5e087_96937121',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f75aa5e087_96937121')) {function content_52b2f75aa5e087_96937121($_smarty_tpl) {?>	</div>
	<!-- end div block_home -->
<?php if ($_smarty_tpl->tpl_vars['HOOK_CONTENTBOTTOM']->value&&in_array($_smarty_tpl->tpl_vars['page_name']->value,array('index'))){?>
	<div id="contentbottom">
	<?php echo $_smarty_tpl->tpl_vars['HOOK_CONTENTBOTTOM']->value;?>

	</div>
<?php }?>
</section>
<?php if (isset($_smarty_tpl->tpl_vars['LAYOUT_COLUMN_SPANS']->value[2])&&$_smarty_tpl->tpl_vars['LAYOUT_COLUMN_SPANS']->value[2]){?> 
<!-- Right -->
<section id="right_column" class="column span<?php echo $_smarty_tpl->tpl_vars['LAYOUT_COLUMN_SPANS']->value[2];?>
 sidebar">
	<?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>

</section>
<?php }?><?php }} ?>