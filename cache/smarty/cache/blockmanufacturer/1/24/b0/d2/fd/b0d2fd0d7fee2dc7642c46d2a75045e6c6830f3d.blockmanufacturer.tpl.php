<?php /*%%SmartyHeaderCode:3180052b2f75695b4f5-97390491%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0d2fd0d7fee2dc7642c46d2a75045e6c6830f3d' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\blockmanufacturer\\blockmanufacturer.tpl',
      1 => 1387460353,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3180052b2f75695b4f5-97390491',
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b6e94823e439_70570173',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b6e94823e439_70570173')) {function content_52b6e94823e439_70570173($_smarty_tpl) {?>
<!-- Block manufacturers module -->
<div id="manufacturers_block_left" class="block blockmanufacturer">
	<p class="title_block"><a href="http://localhost/prestashop/index.php?controller=manufacturer" title="Manufacturers">Manufacturers</a></p>
	<div class="block_content">
		<ul class="bullet">
					<li class="first_item"><a href="http://localhost/prestashop/index.php?id_manufacturer=1&controller=manufacturer" title="Learn more about Apple Computer, Inc">Apple Computer, Inc</a></li>
							<li class="last_item"><a href="http://localhost/prestashop/index.php?id_manufacturer=2&controller=manufacturer" title="Learn more about Shure Incorporated">Shure Incorporated</a></li>
				</ul>
				<form action="/prestashop/index.php" method="get">
			<p>
				<select id="manufacturer_list" onchange="autoUrl('manufacturer_list', '');">
					<option value="0">All manufacturers</option>
									<option value="http://localhost/prestashop/index.php?id_manufacturer=1&controller=manufacturer">Apple Computer, Inc</option>
									<option value="http://localhost/prestashop/index.php?id_manufacturer=2&controller=manufacturer">Shure Incorporated</option>
								</select>
			</p>
		</form>
		</div>
</div>
<!-- /Block manufacturers module -->
<?php }} ?>