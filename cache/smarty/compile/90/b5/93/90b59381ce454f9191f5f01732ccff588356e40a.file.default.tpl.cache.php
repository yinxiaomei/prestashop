<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 00:40:40
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\modules\lofblogscategory\themes\default\default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:62352b2f7585f49d2-90833899%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90b59381ce454f9191f5f01732ccff588356e40a' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\lofblogscategory\\themes\\default\\default.tpl',
      1 => 1387460355,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '62352b2f7585f49d2-90833899',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'params' => 0,
    'items' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f758665e62_39303552',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f758665e62_39303552')) {function content_52b2f758665e62_39303552($_smarty_tpl) {?>
<div class="lofcontentmenu-wrapper block">
    <?php if ($_smarty_tpl->tpl_vars['params']->value['showTitle']){?>
        <h4 class="title_block"><a href="index.php?view=category&id=0&fc=module&module=lofblogs&controller=articles" title="<?php echo smartyTranslate(array('s'=>'All article','mod'=>'lofblogscategory'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['params']->value['title'];?>
</a></h4>
    <?php }?>    
    <div class="block_content">
    <ul>
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['branche_tpl_path']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('node'=>$_smarty_tpl->tpl_vars['item']->value,'last'=>'true'), 0);?>

        <?php } ?>    
    </ul>
    </div>
</div><?php }} ?>