<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 00:40:42
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1937252b2f75a8a0b18-46755929%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'be5627296973077adb639dfabbb23f5bf7bf83bc' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\footer.tpl',
      1 => 1387460351,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1937252b2f75a8a0b18-46755929',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'LEO_LAYOUT_DIRECTION' => 0,
    'HOOK_BOTTOM' => 0,
    'page_name' => 0,
    'HOOK_FOOTER' => 0,
    'PS_ALLOW_MOBILE_DEVICE' => 0,
    'link' => 0,
    'LEO_COPYRIGHT' => 0,
    'HOOK_FOOTNAV' => 0,
    'LEO_PANELTOOL' => 0,
    'LEO_PATTERN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f75a9b9f58_79841949',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f75a9b9f58_79841949')) {function content_52b2f75a9b9f58_79841949($_smarty_tpl) {?>

		<?php if (!$_smarty_tpl->tpl_vars['content_only']->value){?>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./layout/".((string)$_smarty_tpl->tpl_vars['LEO_LAYOUT_DIRECTION']->value)."/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</div></div></section>

<!-- Footer -->
			<?php if ($_smarty_tpl->tpl_vars['HOOK_BOTTOM']->value&&in_array($_smarty_tpl->tpl_vars['page_name']->value,array('index'))){?>
			<section id="bottom">
				<div class="container">
					<div class="row-fluid">
						 <?php echo $_smarty_tpl->tpl_vars['HOOK_BOTTOM']->value;?>

					</div>
				</div>
			</section>
			<?php }?>
			<footer id="footer" class="omega clearfix">
				<section class="footer">
					<div class="container"><div class="row-fluid">
					<?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>

					<?php if ($_smarty_tpl->tpl_vars['PS_ALLOW_MOBILE_DEVICE']->value){?>
						<p class="center clearBoth hidden-desktop"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true);?>
?mobile_theme_ok"><?php echo smartyTranslate(array('s'=>'Browse the mobile site'),$_smarty_tpl);?>
</a></p>
					<?php }?>
					</div></div>
				</section>	
				<section id="footer-bottom">
					<div class="container"><div class="row-fluid">
						<div class="span8">
							<div class="copyright">
								<p class="fs12"><?php echo $_smarty_tpl->tpl_vars['LEO_COPYRIGHT']->value;?>
</p>
							</div>
						</div>
						<?php if ($_smarty_tpl->tpl_vars['HOOK_FOOTNAV']->value){?>
						<div class="span4"><div class="footnav"><?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTNAV']->value;?>
</div></div>		
						<?php }?>
					</div></div>	
				</section>
				
			</footer>
		</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['LEO_PANELTOOL']->value){?>
    	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./info/paneltool.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php }?>

		<script type="text/javascript">
			var classBody = "<?php echo $_smarty_tpl->tpl_vars['LEO_PATTERN']->value;?>
";
			$("body").addClass( classBody.replace(/\.\w+$/,"")  );
			
		</script>
	</body>
</html>
<?php }} ?>