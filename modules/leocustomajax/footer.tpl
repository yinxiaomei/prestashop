{if $leo_customajax_pn || $leo_customajax_rt}
{literal}
<script type="text/javascript">
    $(document).ready(function(){
	leoData = "";
{/literal}
        
        {if $leo_customajax_pn}
        {literal}    
        //get category id
	var leoCatList = "";
	$("#categories_block_left .leo-qty").each(function(){
	     if (leoCatList) leoCatList += ","+$(this).attr("id");
	     else leoCatList = $(this).attr("id");
	});
        
	leoCatList = leoCatList.replace(/leo-cat-/g,"");
        if(leoCatList) leoData = 'cat_list=' + leoCatList;
        {/literal}
        {/if}
        {if $leo_customajax_rt}     
        {literal}
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
        {/literal}
        {/if}    
{literal}            
	
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
{/literal}
{/if}