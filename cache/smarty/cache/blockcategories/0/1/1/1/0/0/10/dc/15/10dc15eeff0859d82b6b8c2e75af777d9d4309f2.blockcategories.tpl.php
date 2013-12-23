<?php /*%%SmartyHeaderCode:2549352b2f75568c4b9-75427353%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10dc15eeff0859d82b6b8c2e75af777d9d4309f2' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\blockcategories\\blockcategories.tpl',
      1 => 1387811029,
      2 => 'file',
    ),
    '3cf91a7c130ee1514d7de031afb3af92c6f1536d' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\blockcategories\\category-tree-branch.tpl',
      1 => 1387720810,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2549352b2f75568c4b9-75427353',
  'cache_lifetime' => 31536000,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b850e37502e3_64178243',
  'variables' => 
  array (
    'isDhtml' => 0,
    'blockCategTree' => 0,
    'child' => 0,
  ),
  'has_nocache_code' => false,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b850e37502e3_64178243')) {function content_52b850e37502e3_64178243($_smarty_tpl) {?>
<!-- Block categories module -->
<div id="categories_block_left" class="block highlight">
	<!--  p class="title_block">Categories</p>-->
	<div class="block_content">
		<ul class="tree dhtml">
									
<li class="item ">
	<h2></h2>
	<a href="http://localhost/prestashop/index.php?id_category=4&amp;controller=category"  title="&lt;p&gt;Wonderful accessories for your iPod&lt;/p&gt;">Christmas Banner</a>
	</li>

												
<li class="item ">
	<h2></h2>
	<a href="http://localhost/prestashop/index.php?id_category=3&amp;controller=category"  title="&lt;p&gt;Now that you can buy movies from the iTunes Store and sync them to your iPod, the whole world is your theater.&lt;/p&gt;">Birth Banner</a>
	</li>

												
<li class="item ">
	<h2></h2>
	<a href="http://localhost/prestashop/index.php?id_category=6&amp;controller=category"  title="">Wedding Banner</a>
	</li>

												
<li class="item ">
	<h2></h2>
	<a href="http://localhost/prestashop/index.php?id_category=7&amp;controller=category"  title="">Anniversery Banner</a>
	</li>

												
<li class="item last">
	<h2></h2>
	<a href="http://localhost/prestashop/index.php?id_category=5&amp;controller=category"  title="The latest Intel processor, a bigger hard drive, plenty of memory, and even more new features all fit inside just one liberating inch. The new Mac laptops have the performance, power, and connectivity of a desktop computer. Without the desk part.">Laptops</a>
	</li>

							</ul>
		
		<script type="text/javascript">
		// <![CDATA[
			// we hide the tree only if JavaScript is activated
			$('div#categories_block_left ul.dhtml').hide();
		// ]]>
		</script>
	</div>
</div>
<!-- /Block categories module -->
<?php }} ?>