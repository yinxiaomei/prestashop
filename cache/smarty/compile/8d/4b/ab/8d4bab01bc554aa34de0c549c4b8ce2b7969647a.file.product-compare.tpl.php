<?php /* Smarty version Smarty-3.1.14, created on 2013-12-23 00:30:06
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\product-compare.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1982052b6e95ea693c7-46192421%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d4bab01bc554aa34de0c549c4b8ce2b7969647a' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\product-compare.tpl',
      1 => 1387460356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1982052b6e95ea693c7-46192421',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'comparator_max_item' => 0,
    'paginationId' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b6e95eb53a05_12106338',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b6e95eb53a05_12106338')) {function content_52b6e95eb53a05_12106338($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['comparator_max_item']->value){?>
<?php if (!isset($_smarty_tpl->tpl_vars['paginationId']->value)||$_smarty_tpl->tpl_vars['paginationId']->value==''){?>
<script type="text/javascript">
// <![CDATA[
	var min_item = '<?php echo smartyTranslate(array('s'=>'Please select at least one product','js'=>1),$_smarty_tpl);?>
';
	var max_item = "<?php echo smartyTranslate(array('s'=>'You cannot add more than %d product(s) to the product comparison','sprintf'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value,'js'=>1),$_smarty_tpl);?>
";
	var add_compare = '<?php echo smartyTranslate(array('s'=>'This product was added to comparison list','js'=>1),$_smarty_tpl);?>
';
	var remove_compare = '<?php echo smartyTranslate(array('s'=>'This product was removed from comparison list','js'=>1),$_smarty_tpl);?>
';
	var err_remove_compare = '<?php echo smartyTranslate(array('s'=>'Can not remove from comparison list','js'=>1),$_smarty_tpl);?>
';
//]]>
</script>
<?php }?>
	<form method="post" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('products-comparison'), ENT_QUOTES, 'UTF-8', true);?>
" onsubmit="true">
		<p>
		<input type="submit" id="bt_compare<?php if (isset($_smarty_tpl->tpl_vars['paginationId']->value)){?>_<?php echo $_smarty_tpl->tpl_vars['paginationId']->value;?>
<?php }?>" class="button bt_compare" value="<?php echo smartyTranslate(array('s'=>'Compare'),$_smarty_tpl);?>
" />
		<input type="hidden" name="compare_product_list" class="compare_product_list" value="" />
		</p>
	</form>
<?php }?>

<?php }} ?>