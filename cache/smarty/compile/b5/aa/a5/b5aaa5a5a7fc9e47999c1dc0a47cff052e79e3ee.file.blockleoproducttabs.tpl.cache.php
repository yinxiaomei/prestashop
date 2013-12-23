<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 00:40:36
         compiled from "D:\xampp\htdocs\prestashop\themes\leogift\modules\blockleoproducttabs\blockleoproducttabs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2940152b2f754841993-44092543%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5aaa5a5a7fc9e47999c1dc0a47cff052e79e3ee' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\themes\\leogift\\modules\\blockleoproducttabs\\blockleoproducttabs.tpl',
      1 => 1387460353,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2940152b2f754841993-44092543',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'featured' => 0,
    'newproducts' => 0,
    'special' => 0,
    'bestseller' => 0,
    'product_tpl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f754a0aa72_17579346',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f754a0aa72_17579346')) {function content_52b2f754a0aa72_17579346($_smarty_tpl) {?>

<!-- MODULE Block specials -->
<div class="span8">
<div id="leoproducttabs" class="block_box_center products_block exclusive blockleoproducttabs">
	<div class="block_content">			            
			<ul id="productTabs" class="nav nav-tabs idTabs">
			  <?php if ($_smarty_tpl->tpl_vars['featured']->value){?>	
              <li><a href="#tabfeaturedproducts" data-toggle="tab"><span></span><?php echo smartyTranslate(array('s'=>'Featured Products','mod'=>'blockleoproducttabs'),$_smarty_tpl);?>
</a></li>
			  <?php }?>
              <?php if ($_smarty_tpl->tpl_vars['newproducts']->value){?>	
              <li><a href="#tabnewproducts" data-toggle="tab"><span></span><?php echo smartyTranslate(array('s'=>'New Arrivals','mod'=>'blockleoproducttabs'),$_smarty_tpl);?>
</a></li>
			  <?php }?>
			  <?php if ($_smarty_tpl->tpl_vars['special']->value){?>	
              <li><a href="#tabspecial" data-toggle="tab"><?php echo smartyTranslate(array('s'=>'Special','mod'=>'blockleoproducttabs'),$_smarty_tpl);?>
</a></li>
			  <?php }?>
			  <?php if ($_smarty_tpl->tpl_vars['bestseller']->value){?>	
              <li><a href="#tabbestseller" data-toggle="tab"><span></span><?php echo smartyTranslate(array('s'=>'Best Seller','mod'=>'blockleoproducttabs'),$_smarty_tpl);?>
</a></li>
			  <?php }?>
            </ul>
			
            <div id="productTabsContent" class="tab-content">
			<?php if ($_smarty_tpl->tpl_vars['featured']->value){?>		  
              <div class="tab-pane " id="tabfeaturedproducts">
					<?php $_smarty_tpl->tpl_vars['products'] = new Smarty_variable($_smarty_tpl->tpl_vars['featured']->value, null, 0);?> <?php $_smarty_tpl->tpl_vars['tabname'] = new Smarty_variable('tabfeaturedproducts-carousel', null, 0);?>
					<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['product_tpl']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

              </div>   
			 <?php }?>	
			  <?php if ($_smarty_tpl->tpl_vars['newproducts']->value){?>		  
              <div class="tab-pane " id="tabnewproducts">
					<?php $_smarty_tpl->tpl_vars['products'] = new Smarty_variable($_smarty_tpl->tpl_vars['newproducts']->value, null, 0);?> <?php $_smarty_tpl->tpl_vars['tabname'] = new Smarty_variable('tabnewproducts-carousel', null, 0);?>
					<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['product_tpl']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

              </div>   
				 <?php }?>	
			   <?php if ($_smarty_tpl->tpl_vars['special']->value){?>	
					<div class="tab-pane" id="tabspecial">
					<?php $_smarty_tpl->tpl_vars['products'] = new Smarty_variable($_smarty_tpl->tpl_vars['special']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['tabname'] = new Smarty_variable('tabspecialcarousel', null, 0);?>
					<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['product_tpl']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

	              </div>
			   <?php }?>
			 <?php if ($_smarty_tpl->tpl_vars['bestseller']->value){?>		  
              <div class="tab-pane " id="tabbestseller">
					<?php $_smarty_tpl->tpl_vars['products'] = new Smarty_variable($_smarty_tpl->tpl_vars['bestseller']->value, null, 0);?> <?php $_smarty_tpl->tpl_vars['tabname'] = new Smarty_variable('tabbestseller-carousel', null, 0);?>
					<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['product_tpl']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

              </div>   
			 <?php }?>	
			 
			</div>
        
		
	</div>
</div>
</div>
<!-- /MODULE Block specials -->
<script>
$(document).ready(function() {
    $('.blockleoproducttabs').each(function(){
        $(this).carousel({
            pause: true,
            interval: false
        });
    });
	$(".blockleoproducttabs").each( function(){
		$(".nav-tabs li", this).first().addClass("active");
		$(".tab-content .tab-pane", this).first().addClass("active");
	} );
});
</script>
 <?php }} ?>