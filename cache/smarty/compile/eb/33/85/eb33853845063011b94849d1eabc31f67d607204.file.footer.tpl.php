<?php /* Smarty version Smarty-3.1.14, created on 2013-12-20 00:40:41
         compiled from "D:\xampp\htdocs\prestashop\modules\leocustomajax\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1318552b2f7590ad320-45774415%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eb33853845063011b94849d1eabc31f67d607204' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\modules\\leocustomajax\\footer.tpl',
      1 => 1387460387,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1318552b2f7590ad320-45774415',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'leo_customajax_pn' => 0,
    'leo_customajax_rt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52b2f759112c45_58550858',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52b2f759112c45_58550858')) {function content_52b2f759112c45_58550858($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['leo_customajax_pn']->value||$_smarty_tpl->tpl_vars['leo_customajax_rt']->value){?>

<script type="text/javascript">
    $(document).ready(function(){
	leoData = "";

        
        <?php if ($_smarty_tpl->tpl_vars['leo_customajax_pn']->value){?>
            
        //get category id
	var leoCatList = "";
	$("#categories_block_left .leo-qty").each(function(){
	     if (leoCatList) leoCatList += ","+$(this).attr("id");
	     else leoCatList = $(this).attr("id");
	});
        
	leoCatList = leoCatList.replace(/leo-cat-/g,"");
        if(leoCatList) leoData = 'cat_list=' + leoCatList;
        
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['leo_customajax_rt']->value){?>     
        
        //get product id
	var leoProduct = "";
        var tmpPro = new Array();
	$("a.rating_box").each(function(i){
            myrel = $(this).attr("rel");
            if ($.inArray(myrel, leoProduct) == -1){
                tmpPro[i] = myrel;
                if (leoProduct) leoProduct += ","+myrel;
                else leoProduct = myrel;
            }
	});
        if(leoProduct) {
            if(leoData) leoData += "&";
            leoData += 'pro_list=' + leoProduct;
        }
        
        <?php }?>    
            
	
        $.ajax({
                type: 'POST',
                headers: { "cache-control": "no-cache" },
                url: baseDir + 'modules/leocustomajax/leoajax.php' + '?rand=' + new Date().getTime(),
                async: true,
                cache: false,
                dataType : "json",
                data: leoData + '&rand=' + new Date().getTime(),
                success: function(jsonData){
                    if(jsonData){
                        if(jsonData.cat){
                            for(i=0;i<jsonData.cat.length;i++){
                                $("#leo-cat-"+jsonData.cat[i].id_category).html(jsonData.cat[i].total);
                                $("#leo-cat-"+jsonData.cat[i].id_category).show();
                            }
                        }
                        if(jsonData.pro){
                            $("a.rating_box").show();
                            for(i=0;i<jsonData.pro.length;i++){
                                $(".leo-rating-"+jsonData.pro[i].id).show();
                                $(".leo-rating-"+jsonData.pro[i].id).each(function( index ) {
                                    $(this).find("i").each(function( index ) {
                                        if(index < jsonData.pro[i].rate){
                                            $(this).attr("class","icon-star");
                                        }
                                    });
                                });
                            }
                            
                        }
                    }
                },
                error: function() {}
        });
	
    });
</script>

<?php }?><?php }} ?>