<?php /* Smarty version Smarty-3.1.14, created on 2013-12-21 22:42:05
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\modules\leobtslider\leobtslider.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2603652b2f753497d21-12053184%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '209a68845a1cf0b16d2b3aadeb86505de39c691d' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\leobtslider\\leobtslider.tpl',
      1 => 1387626121,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2603652b2f753497d21-12053184',
  'function' => 
  array (
  ),
  'cache_lifetime' => 31536000,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f7536e5b22_93888292',
  'variables' => 
  array (
    'leobtslider_modid' => 0,
    'leobtslider_slides' => 0,
    'slide' => 0,
    'leobtslider' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f7536e5b22_93888292')) {function content_52b2f7536e5b22_93888292($_smarty_tpl) {?>
<div id="leobttslider<?php echo $_smarty_tpl->tpl_vars['leobtslider_modid']->value;?>
" class="carousel slide leobttslider span12" >
	<div class="box-shadow">
		<div class="carousel-inner">
			<?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slide']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['leobtslider_slides']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['slidename']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value){
$_smarty_tpl->tpl_vars['slide']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['slidename']['index']++;
?>
				<div class="item<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['slidename']['index']==0){?> active<?php }?>">
					<?php if ($_smarty_tpl->tpl_vars['slide']->value['url']){?>
						<a href="<?php echo $_smarty_tpl->tpl_vars['slide']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['slide']->value['mainimage'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['slide']->value['title'];?>
" /></a>
					<?php }else{ ?>
						<img src="<?php echo $_smarty_tpl->tpl_vars['slide']->value['mainimage'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['slide']->value['title'];?>
" />
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['slide']->value['title']||$_smarty_tpl->tpl_vars['slide']->value['description']){?>
						<div class="mask"></div>
						<div class="slide-info">
							<h1><?php echo $_smarty_tpl->tpl_vars['slide']->value['title'];?>
</h1>
							<div class="desc"><?php echo $_smarty_tpl->tpl_vars['slide']->value['description'];?>
</div>
						</div>
					<?php }?>
				</div>
			<?php } ?>
		</div>
		<?php if (count($_smarty_tpl->tpl_vars['leobtslider_slides']->value)>1){?>
		<a class="carousel-control left icon-leo-prev" href="#leobttslider<?php echo $_smarty_tpl->tpl_vars['leobtslider_modid']->value;?>
" data-slide="prev">&nbsp;</a>
		<a class="carousel-control right icon-leo-next" href="#leobttslider<?php echo $_smarty_tpl->tpl_vars['leobtslider_modid']->value;?>
" data-slide="next">&nbsp;</a>
		<?php }?>

		<?php if (count($_smarty_tpl->tpl_vars['leobtslider_slides']->value)>1){?>
			<?php if ($_smarty_tpl->tpl_vars['leobtslider']->value['image_navigator']){?>
				<ol class="carousel-indicators">
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['leobtslider_slides']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['itemname']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['itemname']['index']++;
?>
					<li data-target="#leobttslider<?php echo $_smarty_tpl->tpl_vars['leobtslider_modid']->value;?>
" data-slide-to="<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['itemname']['index'];?>
" class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['itemname']['index']==0){?>active<?php }?>"></li>
				<?php } ?>
				</ol> 
			<?php }?>
		<?php }?> 
	</div>
</div>
<?php if ($_smarty_tpl->tpl_vars['leobtslider']->value['auto']){?>
<script type="text/javascript">
	
	jQuery(document).ready(function(){
		$('#leobttslider<?php echo $_smarty_tpl->tpl_vars['leobtslider_modid']->value;?>
').carousel({
		  interval: <?php echo $_smarty_tpl->tpl_vars['leobtslider']->value['delay'];?>

		});
	});
	
</script>
<?php }?>
<?php }} ?>