<?php /*%%SmartyHeaderCode:1998852b2f7595e91e1-83600502%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87b1c08243742f05a210f259a512091bae612d79' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\blockmyaccountfooter\\blockmyaccountfooter.tpl',
      1 => 1387460353,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1998852b2f7595e91e1-83600502',
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b6e94973fcf8_01688173',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b6e94973fcf8_01688173')) {function content_52b6e94973fcf8_01688173($_smarty_tpl) {?>
<!-- Block myaccount module -->
<div class="block myaccount">
	<p class="title_block"><a href="http://localhost/prestashop/index.php?controller=my-account" title="Manage your customer account" rel="nofollow">My account</a></p>
	<div class="block_content">
		<ul class="bullet">
			<li class="item"><a href="http://localhost/prestashop/index.php?controller=history" title="My orders" rel="nofollow">My orders</a></li>
						<li class="item"><a href="http://localhost/prestashop/index.php?controller=order-slip" title="My credit slips" rel="nofollow">My credit slips</a></li>
			<li class="item"><a href="http://localhost/prestashop/index.php?controller=addresses" title="My addresses" rel="nofollow">My addresses</a></li>
			<li class="item"><a href="http://localhost/prestashop/index.php?controller=identity" title="Manage your personal information" rel="nofollow">My personal info</a></li>
						
		</ul>
		<p class="logout"><a href="http://localhost/prestashop/index.php?mylogout" title="Sign out" rel="nofollow">Sign out</a></p>
	</div>
</div>
<!-- /Block myaccount module -->
<?php }} ?>