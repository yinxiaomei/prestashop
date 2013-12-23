<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 02:26:16
         compiled from "D:\xampp\htdocs\prestashop\modules\leotempcp\views\templates\admin\leotempcp_panel\panel.tpl" */ ?>
<?php /*%%SmartyHeaderCode:523252b310188d4969-20222512%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad18ac696deb634e4dfe9c3d9bf83758a6e76a28' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\modules\\leotempcp\\views\\templates\\admin\\leotempcp_panel\\panel.tpl',
      1 => 1387460383,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '523252b310188d4969-20222512',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'showed' => 0,
    'toolbar' => 0,
    'modules' => 0,
    'module' => 0,
    'URI' => 0,
    'hookModules' => 0,
    'currentURL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b3101973aa18_20457566',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b3101973aa18_20457566')) {function content_52b3101973aa18_20457566($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['showed']->value==true){?>
 <?php echo $_smarty_tpl->tpl_vars['toolbar']->value;?>
 
<div id="leo-page" class="clearfix">
	
	<div class="note">

		<p>+ <?php echo smartyTranslate(array('s'=>'Drop modules from hooks layouts to "<b>UnHook Modules</b>" Panel to unhook them','mod'=>'leotempcp'),$_smarty_tpl);?>
. <?php echo smartyTranslate(array('s'=>'Drag and drop modules from hooks layouts to update theirs order and hook position','mod'=>'leotempcp'),$_smarty_tpl);?>
</p>
		<p>+  <?php echo smartyTranslate(array('s'=>'Override hook feature only applies for <b>HOOK_HEADERRIGHT, HOOK_SLIDESHOW, HOOK_TOPNAVIATION, HOOK_SLIDESHOW, HOOK_PROMOTETOP, HOOK_CONTENTBOTTOM, HOOK_BOTTOM</b>','mod'=>'leotempcp'),$_smarty_tpl);?>
</p>
		<p>+ <?php echo smartyTranslate(array('s'=>'Here only shows all of installed modules having hooks supportting for LeoTheme Layout.','mod'=>'leotemcp'),$_smarty_tpl);?>

	</div>	
	<div class="leo-container holdposition" id="noposition">
		<div class="pos"><?php echo smartyTranslate(array('s'=>'UnHook Modules','mod'=>'leotempcp'),$_smarty_tpl);?>
 </div>
		 <?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['modules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
?>
			<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value->id;?>
">
				<div class="leo-editmodule" rel="<?php echo $_smarty_tpl->tpl_vars['module']->value->author;?>
">
				<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value->name;?>
/logo.png"/>
				<?php echo $_smarty_tpl->tpl_vars['module']->value->displayName;?>

				</div>
			
			</div>
		 <?php } ?>
	</div>

	<br>
	<div class="leotheme-layout">
		<div id="leo-header" >
			<div class="topbar leo-container" data-position="displayTop">
				<div class="pos">HOOK_TOP</div>
				<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displayTop'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displayTop']['module_count']>0){?>
				<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displayTop']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
				<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
				<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
					<div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
						<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

					</div>
				</div>
				<?php }?>
				<?php } ?>
				<?php }?>
			</div>
			<div class="leoheader clearfix">
				<div id="leologo"><div class="pos">LOGO</div></div>
				<div id="leo-hheaderright" class="leo-container overridehook" data-position="displayHeaderRight"><div class="pos">HOOK_HEADERRIGHT</div>
					<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displayHeaderRight'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displayHeaderRight']['module_count']>0){?>
					<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displayHeaderRight']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
					<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
					<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
						<div class="edithook"></div>
						<div class="leo-editmodule">
							<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
							<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

						</div>
					</div>
					<?php }?>
					<?php } ?>
					<?php }?>
				</div>
			</div>
		</div>
		
		
		<div id="leo-menu" class="leo-container overridehook" data-position="topNavigation"><div class="pos">HOOK_TOPNAVIATION</div>
			<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['topNavigation'])&&$_smarty_tpl->tpl_vars['hookModules']->value['topNavigation']['module_count']>0){?>
			<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['topNavigation']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?> 
			<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
			<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
				<div class="edithook"></div>
				<div class="leo-editmodule">
					<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
					<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

				</div>
			</div>
			<?php }?>
			<?php } ?>
			<?php }?>
		</div>
		
		
		<div id="leo-slideshow" class="leo-container overridehook" data-position="displaySlideshow"><div class="pos">HOOK_SLIDESHOW</div>
				<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displaySlideshow'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displaySlideshow']['module_count']>0){?>
				<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displaySlideshow']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
				<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
				<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
					<div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
						<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

					</div>
				</div>
				<?php }?>
				<?php } ?>
				<?php }?>
		</div>
		<div id="leo-promotetop"  class="leo-container overridehook" data-position="displayPromoteTop"><div class="pos">HOOK_PROMOTETOP</div>
			<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displayPromoteTop'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displayPromoteTop']['module_count']>0){?>
			<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displayPromoteTop']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
			<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
			<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
				<div class="edithook"></div>
				<div class="leo-editmodule">
					<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
					<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

				</div>
			</div>
			<?php }?>
			<?php } ?>
			<?php }?>
		</div>

		<div id="leo-content" class="clearfix"  >
			<div id="leo-left" class="leo-container" data-position="displayLeftColumn"><div class="pos">HOOK_LEFT</div>
				<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displayLeftColumn'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displayLeftColumn']['module_count']>0){?>
				<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displayLeftColumn']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?> 
				<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
				<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
					<div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
						<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

					</div>
				</div>
				<?php }?>
				<?php } ?>
				<?php }?>
				<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['leftcolumn'])&&$_smarty_tpl->tpl_vars['hookModules']->value['leftcolumn']['module_count']>0){?>
				<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['leftcolumn']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?> 
				<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
				<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
					<div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
						<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

					</div>
				</div>
				<?php }?>
				<?php } ?>
				<?php }?>
			</div>
			<div id="leo-center">
				<div  class="leo-container inner" data-position="displayHome" style="min-height:250px"><div class="pos">HOOK_HOME</div>
				<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displayHome'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displayHome']['module_count']>0){?>
				<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displayHome']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
				<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
				<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
					<div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
						<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

					</div>
				</div>
				<?php }?>
				<?php } ?>
				<?php }?>
				</div>
				
				<div  class="leo-container overridehook inner" data-position="displayContentBottom" style="min-height:50px">
					<div class="pos">HOOK_CONTENTBOTTOM</div>
					<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displayContentBottom'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displayContentBottom']['module_count']>0){?>
					<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displayContentBottom']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
					<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
						<div class="edithook"></div>
						<div class="leo-editmodule">
							<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
							<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

						</div>
					</div>
					<?php } ?>
					<?php }?>
				</div>
			</div>
			
			
			<div id="leo-right" class="leo-container" data-position="displayRightColumn"><div class="pos">HOOK_RIGHT</div>
				<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displayRightColumn'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displayRightColumn']['module_count']>0){?>
				<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displayRightColumn']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
				<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
				<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
					<div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
						<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

					</div>
				</div>
				<?php }?>
				<?php } ?>
				<?php }?>
				
				<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['rightcolumn'])&&$_smarty_tpl->tpl_vars['hookModules']->value['rightcolumn']['module_count']>0){?>
				<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['rightcolumn']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?> 
				<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
				<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
					<div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
						<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

					</div>
				</div>
				<?php }?>
				<?php } ?>
				<?php }?>
				
			</div>
		</div>
		<div id="leo-bottom" class="leo-container overridehook clearfix" data-position="displayBottom">
				<div class="pos">HOOK_BOTTOM</div>
				<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displayBottom'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displayBottom']['module_count']>0){?>
				<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displayBottom']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
				<?php if (isset($_smarty_tpl->tpl_vars['module']->value['instance'])){?>
				<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
					<div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
						<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

					</div>
				</div>
				<?php }?>
				<?php } ?>
				<?php }?>
				
		</div>
		<div id="leo-footer" class="clearfix">
			<div id="leo-hfooter" class="leo-container clearfix" data-position="displayFooter">
				<div class="pos">HOOK_FOOTER</div>
				<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displayFooter'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displayFooter']['module_count']>0){?>
				<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displayFooter']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
				<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
					<div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
						<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

					</div>
				</div>
				<?php } ?>
				<?php }?>
			</div>
		</div>
		
		<div class="clearfix"  id="page-footer">
				<div id="leo-copyright" class="clearfix"><div class="pos">HOOK_COPYRIGHT</div></div>
		
				<div id="leo-footnav" class="leo-container overridehook clearfix" data-position="displayFootNav">				
					<div class="pos">HOOK_FOOTNAV</div>
						<?php if (isset($_smarty_tpl->tpl_vars['hookModules']->value['displayFootNav'])&&$_smarty_tpl->tpl_vars['hookModules']->value['displayFootNav']['module_count']>0){?>
						<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hookModules']->value['displayFootNav']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['position']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
						<div class="module-pos" id="module-<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->id;?>
" data-position="<?php echo $_smarty_tpl->tpl_vars['module']->value['id_hook'];?>
">
							<div class="edithook"></div>
							<div class="leo-editmodule">
								<img src="<?php echo $_smarty_tpl->tpl_vars['URI']->value;?>
<?php echo $_smarty_tpl->tpl_vars['module']->value['name'];?>
/logo.png"/>
								<?php echo $_smarty_tpl->tpl_vars['module']->value['instance']->displayName;?>

							</div>
						</div>
						<?php } ?>
						<?php }?>				
					</div>
				</div>
			
		
	</div>
</div>
<div id="overidehook" style="display:none">
	<div id="oh-close">Close</div>
	<form action="<?php echo $_smarty_tpl->tpl_vars['currentURL']->value;?>
&action=overridehook" method="post">
	<p class="clearfix"><label><?php echo smartyTranslate(array('s'=>"Select override hook"),$_smarty_tpl);?>
</lable><br>
	<select  name="name_hook">
		<option value="0"><?php echo smartyTranslate(array('s'=>'--- Use Self Hook ---','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>

	</select>
	
	
	<input type="hidden" name="hdidmodule" id="hdidmodule" value=""/>
	<input type="submit" value="<?php echo smartyTranslate(array('s'=>'Save'),$_smarty_tpl);?>
" name="submit" />
	</p>
	</form>
</div>	
<script type="text/javascript">
$("#noposition").css("height",$(".leotheme-layout").height() );
$('#leo-page .leo-container').sortable( {
			connectWith: '#leo-page .leo-container',
			containment: '#leo-page',
			forceHelperSize: true,
			forcePlaceholderSize: true,
			placeholder: 'placeholder',
			handle:".leo-editmodule"
		});
$(document).ready( function(){
	$("#desc-leohook-save").click( function(){
			var string = 'rand='+Math.random();
			var hook = '';
			$(".ui-sortable").each( function(){
				if( $(this).attr("data-position") && $(".module-pos",this).length>0) {
					string +="&position[]="+$(this).attr("data-position")+"|";
				 	hook += "&"+$(this).attr("data-position")+"=";
					$(".module-pos",this).each( function(){
						if( $(this).attr("id") != "" ){
							string += $(this).attr("id").replace("module-","")+",";
							hook += $(this).attr("data-position")+",";
						}				
					} );
					string = string.replace(/\,$/,"");
					hook = hook.replace(/\,$/,"");
				}	
			} );
			var unhook = '';
			$("#noposition .module-pos").each( function(){
				if( $(this).attr("data-position") ) {
					unhook += '&unhook['+$(this).attr("id").replace("module-","")+']='+$(this).attr("data-position");
				}
			} );
			
			if($("#ajax_running").length) $("#ajax_running").slideDown('fast');
			$.ajax({
			  type: 'POST',
			  url: $(this).attr("href"),
			  data: string+"&"+hook+unhook,
			  success: function(){
			  		if($("#ajax_running").length) $("#ajax_running").slideUp('fast');
					window.location.reload(true);
			  }
			});
		return false; 
	} );
	
	$(".module-pos .edithook").bind("click", function(){
		var parent = $(this).parent(".module-pos");
	 
		$("#overidehook").css({
			"top":$(parent).offset().top-$("#overidehook").height()-$(parent).height(),
			"left":$(parent).offset().left 
		});
		var id = $(parent).attr("id").replace("module-","");
		$("#overidehook #hdidmodule").val( id );
	  	 $.ajax({ type:'POST',
				  url:'<?php echo $_smarty_tpl->tpl_vars['currentURL']->value;?>
&action=modulehook',
				  data:'id='+id,
				  success: function( data ){
					if( data.hooks ){
						var hooks = data.hooks.split("|");
						$("#overidehook select option").each( function(){
							if(  $(this).val() == 0 || $(this).val() == 1 ){}else{ $(this).remove(); }
						});
						for (i =0; i<hooks.length; i++){
						 $("#overidehook select").append('<option value="'+hooks[i]+'">'+hooks[i]+'</option>')
						}
					}
					if( !data.hasError) {
						$("#overidehook select option").each( function(){
							if( $(this).val() == data.hook ){ 
								$(this).attr("selected","selected" );
							}
						} );
					}
					$("#overidehook").show();
				  },
				  dataType:'json'
		 });
	} );
	$("#overidehook #oh-close").click( function() { $("#overidehook").hide(); } );
	$("#overidehook form").submit( function(){
		var string  =  $("#overidehook form").serialize();
		if( $("#overidehook #hdidmodule").val() ){
			$.ajax({ type:'POST',
					  url:$(this).attr("action"),
					  data:string,
					  success: function( data ){
						$("#overidehook").hide();
					  } 
			 });
		 }
		 return false; 
	} );
} );	
</script>
<?php }?>
 
<div style="font-size:10px;">Prestashop Theme Powerby <a href="http://www.leotheme.com" title="LeoTheme">LeoTheme.Com</a></div><?php }} ?>