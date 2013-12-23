<?php /*%%SmartyHeaderCode:3073952b2f7577e4839-30532610%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '59354f173040bcd651dfe9ed3ded2e80c3bd6a1d' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\blocksupplier\\blocksupplier.tpl',
      1 => 1387460354,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3073952b2f7577e4839-30532610',
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b6e9486d61c4_04648367',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b6e9486d61c4_04648367')) {function content_52b6e9486d61c4_04648367($_smarty_tpl) {?>
<!-- Block suppliers module -->
<div id="suppliers_block_left" class="block blocksupplier">
	<p class="title_block"><a href="http://localhost/prestashop/index.php?controller=supplier" title="Suppliers">Suppliers</a></p>
	<div class="block_content">
		<ul class="bullet">
					<li class="first_item">
			<a href="http://localhost/prestashop/index.php?id_supplier=1&controller=supplier" title="About AppleStore">AppleStore</a>
		</li>
							<li class="last_item">
			<a href="http://localhost/prestashop/index.php?id_supplier=2&controller=supplier" title="About Shure Online Store">Shure Online Store</a>
		</li>
				</ul>
				<form action="/prestashop/index.php" method="get">
			<p>
				<select id="supplier_list" onchange="autoUrl('supplier_list', '');">
					<option value="0">All suppliers</option>
									<option value="http://localhost/prestashop/index.php?id_supplier=1&controller=supplier">AppleStore</option>
									<option value="http://localhost/prestashop/index.php?id_supplier=2&controller=supplier">Shure Online Store</option>
								</select>
			</p>
		</form>
		</div>
</div>
<!-- /Block suppliers module -->
<?php }} ?>