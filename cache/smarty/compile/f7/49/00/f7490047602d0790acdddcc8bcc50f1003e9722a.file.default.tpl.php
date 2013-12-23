<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 00:40:41
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\modules\lofminigallery\tmpl\basic\default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2058352b2f759495410-97172888%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7490047602d0790acdddcc8bcc50f1003e9722a' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\lofminigallery\\tmpl\\basic\\default.tpl',
      1 => 1387460355,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2058352b2f759495410-97172888',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'moduleId' => 0,
    'thumbTheme' => 0,
    'moduleWidth' => 0,
    'showTitle' => 0,
    'moduleTitle' => 0,
    'miniproducts' => 0,
    'row' => 0,
    'thumbnailWidth' => 0,
    'thumbnailHeight' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f75959ee54_54967019',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f75959ee54_54967019')) {function content_52b2f75959ee54_54967019($_smarty_tpl) {?><!--Start Module-->
<div id="lofminigallery_<?php echo $_smarty_tpl->tpl_vars['moduleId']->value;?>
" class="lof_thumbnail_container thumb_<?php echo $_smarty_tpl->tpl_vars['thumbTheme']->value;?>
" style="width: <?php echo $_smarty_tpl->tpl_vars['moduleWidth']->value;?>
px;">
    <?php if ($_smarty_tpl->tpl_vars['showTitle']->value){?>
        <h4><?php echo $_smarty_tpl->tpl_vars['moduleTitle']->value;?>
</h4>
    <?php }?>
    <ul class="lof_thumblist">
        <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['miniproducts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['mainImge']!=''&&$_smarty_tpl->tpl_vars['row']->value['thumbImge']!=''){?>
                <li>
                    <a title="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" rel="gallery[<?php echo $_smarty_tpl->tpl_vars['moduleId']->value;?>
]" href="<?php echo $_smarty_tpl->tpl_vars['row']->value['mainImge'];?>
">
                        <img width="<?php echo $_smarty_tpl->tpl_vars['thumbnailWidth']->value;?>
" height="<?php echo $_smarty_tpl->tpl_vars['thumbnailHeight']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['row']->value['thumbImge'];?>
" />
                    </a>
                </li>
            <?php }?>
        <?php } ?>
    </ul>
</div>

<!--End Module--><?php }} ?>