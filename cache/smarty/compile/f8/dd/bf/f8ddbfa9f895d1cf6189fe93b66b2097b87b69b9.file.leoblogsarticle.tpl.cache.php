<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 00:40:35
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\modules\leoblogsarticle\leoblogsarticle.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1641952b2f75397dcc4-94266415%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f8ddbfa9f895d1cf6189fe93b66b2097b87b69b9' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\leoblogsarticle\\leoblogsarticle.tpl',
      1 => 1387460355,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1641952b2f75397dcc4-94266415',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'itemsperpage' => 0,
    'mitems' => 0,
    'columnspage' => 0,
    'scolumn' => 0,
    'item' => 0,
    'thumbUri' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f753bf6a57_19071613',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f753bf6a57_19071613')) {function content_52b2f753bf6a57_19071613($_smarty_tpl) {?>
<!-- MODULE leo blogs article -->
<div id="leoblogsarticle" class="block_box_center exclusive leoblogsarticle">
	
	<div class="block_content">	
		<?php if (!empty($_smarty_tpl->tpl_vars['items']->value)){?>
                <div class="carousel slide" id="leoblogsarticletab">
                        <?php if (count($_smarty_tpl->tpl_vars['items']->value)>$_smarty_tpl->tpl_vars['itemsperpage']->value){?>	
                        <div class="carousel-button">
                            <a class="carousel-control left" href="#leoblogsarticletab"   data-slide="prev"><i class="icon-angle-up"></i></a>
                            <a class="carousel-control right" href="#leoblogsarticletab"  data-slide="next"><i class="icon-angle-down"></i></a>
                        </div>
                        <?php }?>
                        <div class="carousel-inner">
                        <?php $_smarty_tpl->tpl_vars['mitems'] = new Smarty_variable(array_chunk($_smarty_tpl->tpl_vars['items']->value,$_smarty_tpl->tpl_vars['itemsperpage']->value), null, 0);?>
                        <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mitems']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['items']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['items']->index++;
 $_smarty_tpl->tpl_vars['items']->first = $_smarty_tpl->tpl_vars['items']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['mypLoop']['first'] = $_smarty_tpl->tpl_vars['items']->first;
?>
                                <div class="item <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['mypLoop']['first']){?>active<?php }?>">
                                                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['item']->iteration++;
 $_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration === $_smarty_tpl->tpl_vars['item']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['last'] = $_smarty_tpl->tpl_vars['item']->last;
?>
                                                <?php if ($_smarty_tpl->tpl_vars['item']->iteration%$_smarty_tpl->tpl_vars['columnspage']->value==1&&$_smarty_tpl->tpl_vars['columnspage']->value>1){?>
                                                  <div class="row-fluid">
                                                <?php }?>
                                                <div class="item-container span<?php echo $_smarty_tpl->tpl_vars['scolumn']->value;?>
">
                                                    <div class="blog-title">
                                                    	<a class="itemTitle s_title_block" href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" ><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a>
                                                        
                                                    </div>
                                                    <div class="blog-image">
                                                        <div class="mask"></div>
                                                        <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" >
                                                            <img class="item_thumb"  src="<?php echo $_smarty_tpl->tpl_vars['thumbUri']->value;?>
<?php echo $_smarty_tpl->tpl_vars['item']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" />    
                                                        </a>  
                                                    </div>
                                                    <div class="blog-descrition thumbnails">
                                                    	<div class="item_descrition">
                                                        	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate(strip_tags($_smarty_tpl->tpl_vars['item']->value['short_desc']),60,'...');?>

                                                    	</div> 
                                                    </div>                   
                                                    
                                                    <div class="clearfix"></div>
                                                </div>

                                                <?php if (($_smarty_tpl->tpl_vars['item']->iteration%$_smarty_tpl->tpl_vars['columnspage']->value==0||$_smarty_tpl->getVariable('smarty')->value['foreach']['items']['last'])&&$_smarty_tpl->tpl_vars['columnspage']->value>1){?>
                                                        </div>
                                                <?php }?>

                                                <?php } ?>
                                </div>		
                        <?php } ?>
                        </div>
                </div>
                <?php }?>
	</div>
</div>
 
 <?php }} ?>