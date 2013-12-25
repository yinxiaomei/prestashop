{assign var='request' value=$smarty.server.SCRIPT_NAME|escape:'htmlall':'UTF-8'}

<div class="carousel searchmenu">


<div class="row">
	<div id="hidden" style="display:none;"></div>
		
	<script type="text/javascript">
	var timeout         = 500;
	var closetimer		= 0;
	var ddmenuitem      = 0;
	
	function jsddm_open()
	{	
		jsddm_canceltimer();
		jsddm_close();
		$(this).parent('li').find('div.lab label').text("");
		ddmenuitem = $(this).parent('li').find('ul').css('visibility', 'visible');
	}
	
	function jsddm_close()
	{	
		if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');
	}
	
	function jsddm_timer()
	{	
		closetimer = window.setTimeout(jsddm_close, timeout);
	}
	
	function jsddm_canceltimer()
	{	
		if(closetimer)
		{	
			window.clearTimeout(closetimer);
			closetimer = null;
		}
	}
	
	function itemClick(attr_name, attr_val)
	{
		var id = "selectproducts";
		var attributeName = attr_name;
		var attributeVal = attr_val;
		
		$("label.val_"+attributeName).text(attributeVal);
		
		var hidtext = $("#hidden").text();
		if(hidtext != "")
		{
			if(hidtext.indexOf(attributeName+"=")>=0){
				var hidarr = hidtext.split("&");
				hidtext = "";
				for(var i=0;i<hidarr.length;i++){
					if(hidarr[i].indexOf(attributeName+"=")>=0){
						hidarr[i] = attributeName+"="+attributeVal;
					}
					if(hidtext == "") hidtext = hidarr[i];
					else hidtext += "&"+hidarr[i];
				}
			}
			else hidtext += "&"+attributeName+"="+attributeVal;
		}
		else hidtext = attributeName+"="+attributeVal;
		$.ajax({
			type: 'GET',
			async: true,
			url: baseDir + 'modules/wdproductsearch/manageproducts.php',
			data: hidtext+'&id_lang='+{$id_lang},
			cache: false,
			success: function(data)
			{
				$('#'+id).hide();
				document.getElementById(id).innerHTML = data;
				myPagination();
				$('#'+id).fadeIn('fast');
				if (window.ajaxCart != undefined)
				{	
				    //reset the onlick events in relation to the cart block (it allow to bind the onclick event to the new 'delete' buttons added)
				    ajaxCart.overrideButtonsInThePage(); 
				    ajaxCart.refresh();
				}
			}
		});
		$("#hidden").text(hidtext);
	}
	
	$(document).ready(function()
	{	$('#jsddm > li > label').bind('mouseover', jsddm_open);
		$('#jsddm > li').bind('mouseleave',  jsddm_timer);
		$('#jsddm > li').click(function(e){
			var attrName = $(this).find("label.attr_name").text();
			//alert(attrName);
			var attrVal = e.target.id;
			//alert(attrVal);
			itemClick(attrName, attrVal);
			jsddm_close();
		});
	});
	
	//document.onclick = jsddm_close;
	</script>
	
	<ul id="jsddm" class="nav">
		<li>
			<label class="attr_name">COLOUR</label>
			<div class="lab"><label class="val_COLOUR"></label></div>
			<ul class="COLOUR" >
				{foreach from=$COLOUR item=type_name}
				<li>
					<div class="{$type_name}" >
					<a href="javascript:void(0);"  id="{$type_name}" >{$type_name}</a>
					</div>
				</li>
				{/foreach}
				
			</ul>
		</li>
		<li>
			<label class="attr_name">STYLE</label>
			<div class="lab"><label class="val_STYLE"></label></div>
			<ul class="STYLE">
				{foreach from=$STYLE item=type_name}
				<li>
					<div class="{$type_name}" >
					<a href="javascript:void(0);"  id="{$type_name}" >{$type_name}</a>
					</div>
				</li>
				{/foreach}
			</ul>
		</li>
		<li>
			<label class="attr_name">ORIENTATION</label>
			<div class="lab"><label class="val_SHAPE"></label></div>
			<ul class="SHAPE">
				{foreach from=$SHAPE item=type_name}
				<li>
					<div class="{$type_name}" >
					<a href="javascript:void(0);"  id="{$type_name}" >{$type_name}</a>
					</div>
				</li>
				{/foreach}
			</ul>
		</li>
		<li>
			<label class="attr_name">PURPOSE</label>
			<div class="lab"><label class="val_PURPOSE"></label></div>
			<ul class="PURPOSE">
				{foreach from=$POPULAR item=type_name}
				<li>
					<div class="{$type_name}" >
					<a href="javascript:void(0);"  id="{$type_name}" >{$type_name}</a>
					</div>
				</li>
				{/foreach}
			</ul>
		</li>
		<li>
			<label class="attr_name">SEASONAL</label>
			<div class="lab"><label class="val_SEASONAL"></label></div>
			<ul class="SEASONAL">
				{foreach from=$INDUSTRY item=type_name}
				<li>
					<div class="{$type_name}" >
					<a href="javascript:void(0);"  id="{$type_name}" >{$type_name}</a>
					</div>
				</li>
				{/foreach}
			</ul>
		</li>
	</ul>
</div>
</div>

<div id="selectproducts" class="selectproducts">
{if $products != false}
                    {assign var='liHeight' value=250}
			{assign var='nbItemsPerLine' value=4}
			{assign var='nbLi' value=$products|@count}
			{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
			{math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight}
                        <ul class="products-grid row">
                      {foreach from=$products item=product name=myLoop} 
                            	{math equation="(total%perLine)" total=$smarty.foreach.myLoop.total perLine=$nbItemsPerLine assign=totModulo}
				{if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
				<li class="ajax_block_product {if $smarty.foreach.myLoop.first}item first{elseif $smarty.foreach.myLoop.last}{else}item{/if} {if $smarty.foreach.myLoop.iteration%$nbItemsPerLine == 0}last_item_of_line{elseif $smarty.foreach.myLoop.iteration%$nbItemsPerLine == 1} {/if} {if $smarty.foreach.myLoop.iteration > ($nbItemsPerLine*$totModulo)}last_line{/if} span3">
                                <div class="products-box">
                                      {if isset($product.new) && $product.new == 1}<div class="products-new">{l s='New' mod='wdproductsearch'}</div>{/if}
                                    <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product-image product_img_link"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"  alt="{$product.name|escape:html:'UTF-8'}" /> </a>
                                    <div class="pro-info">
                                       <!-- <div class="ratings">
                                            <div class="rating-box">
                                                <div class="rating" style="width:73%"></div>
                                            </div>
                                            <span class="amount"><a href="#" onclick="var t = opener ? opener.window : window; t.location.href=''; return false;">3 Review(s)</a></span>
                                        </div>-->
                                        <h2 class="product-name"><a href="{$product.link}" title="{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h2>
                                    </div>
                                    <div class="actions">
                                        <div class="price-box">
                                            <span class="regular-price" id="product-price-44">
                                                
                                                {if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE} <span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span>{else} <span class="price"></span> {/if}
                                                
                                            </span>

                                        </div>
                                        {if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}
                                               {if ($product.quantity > 0 OR $product.allow_oosp)}
                                                   <button  type="button" title="{l s='Add to Cart' mod='wdproductsearch'}" rel="ajax_id_product_{$product.id_product}" class="button btn-cart add-to-cart exclusive ajax_add_to_cart_button" onclick="setPLocation('{$link->getPageLink('cart.php')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add')">
                                                    <span>
                                                    <div class='add-to-links'>        
                                                         <!--img class ='shopcart' src ='img/shopcarts.png'  data-original-title='mx' /-->
                                                     </div>
                                                    </span>
                                                   </button>
                                                 
                                               {else}
                                                   <a class="btn-cart" rel="tooltip"  href="#" title="{l s='Out of stock'}"><span>&nbsp;</span></a>
                                               {/if}
                                       {else}
                                                <a class="btn-cart" rel="tooltip"  href="#" title="{l s='Out of stock'}"><span>&nbsp;</span></a>
                                       {/if}
                                        
                                        <ul class="add-to-links">
                                           <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
                  <li><a href="#" onclick="WishlistCart('wishlist_block_list', 'add', '{$product.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;"  rel="tooltip" class="link-wishlist" title="{l s='Add to Wishlist' mod='wdproductsearch'} ">&nbsp;</a></li>
                <li><span class="separator">|</span> 
                     <a href="#" rel="tooltip" title="{l s='Customise Me' mod='wdproductsearch'}" class="new_comparator link-compare"  id="comparator_item_{$product.id_product}">
                     <!--img class ='handpng new_comparator' src ='img/smallhand.png'  data-original-title='' /-->
                     </a>
                </li>
                                        </ul>
                                            
                                    </div><div class="clear"></div>
                                </div>
                            </li>
                       {/foreach}
                        </ul>
{else}
<p>{l s='No products at this time' mod='wdproductsearch'}</p>
{/if}

<script type="text/javascript">
	myPagination();	
        
        $(function (){
            /*
            var node;
              $("li").mouseover(function(){
              //$("li").click(function(){
               // $("li:has(.link-compare)") return prior parent, no direct parent.
                //children[1] is a node
                children = $(this).children();
                if ($(children[1]).attr('data-original-title') !='Customise Me')
                    return;
                
                //add new element.
                if ($("#handpng").length==0){
                    $(this).append("<img id ='handpng' src ='img/smallhand.png'  data-original-title='Customise Me'/>");
                    //copy the node should delete for later use.
                    node = children[1];
                    $(children[1]).remove();
              
                }
            })
            
             $("li").mouseout(function(){
             //$("li").dblclick(function(){
                //prove has a li node contains #handpng, but maybe the prior parent node.
                if (!($("li:has(#handpng)")))
                     return;
               // children = $(this).children();
               parentnode =$("#handpng").parent();
               //re append delted node.
               $("#handpng").parent().append(node);
               if ($("#handpng").length==1)
                    $("#handpng").remove();
                
               //children = parentnode.children();
               //$(children[1]).attr('data-original-title','');
              })
             */
          $(".handpng").mouseover(function (){
            $(this).attr('src','img/smallhandd.png');
            $(this).attr('data-original-title','Customise Me');
            //$(this).attr('data-original-title','Customise Me');
            
            
          })
          
          $(".handpng").mouseout(function (){
            $(this).attr('src','img/smallhand.png');
            $(this).attr('data-original-title','');
            //$(this).attr('data-original-title','Customise Me');
            
            
          })
          //add mouseover event in outer layer.
          $(".add-to-cart").mouseover(function (){
            //$("this :firstchild:firstchild:firstchild").attr('src', 'img/shopcartsd.png');
            //aa = $("this :first-child:first-child:first-child");
             //  children = $(this).children();
                //alert(children.length);
                //second node.
              //  node = children[0];
            //alert($(this).find(".shopcart").length);  
            $(this).find(".shopcart").attr('src','img/shopcartsd.png');
            //$(this).find(".handpng").attr('src','img/shopcartsd.png');
            //alert(($(this).children())[0].length);
            //alert($(aa).attr('data-original-title'));
            
            //alert('effect');
            
          }) 
          //add mouseover event in inner layer.
          $(".add-to-cart").mouseout(function (){
            $(this).find(".shopcart").attr('src','img/shopcarts.png');
            })
          /*  
          $(".shopcart").mouseover(function (){
            //alert('mouse over');
          //$(".shopcart").click(function (){
            $(this).attr('src','img/shopcartsd.png');
            $(this).attr('data-original-title','Customise Me');
            //$(this).attr('data-original-title','Customise Me');
            
            
          })
          
          $(".shopcart").mouseout(function (){
            $(this).attr('src','img/shopcarts.png');
            $(this).attr('data-original-title','');
            //$(this).attr('data-original-title','Customise Me');
            
            
          })
          */
        })
  
</script>

</div>



{*<div class="carousel">
	<div class="search_page">
		<span class="spanFirst" id="spanFirst">{l s='first'}</span>
		<span class="spanPre" id="spanPre">{l s='preview'}</span>
		<span class="spanNext" id="spanNext">{l s='next'}</span>
		<span class="spanLast" id="spanLast">{l s='last'}</span>
		{l s='page'}&nbsp;<span class="spanPageNum" id="spanPageNum"></span>{l s='of'}&nbsp;
		<span class="spanTotalPage" id="spanTotalPage"></span>
	</div>
</div>
<div class="carousel">
	<div class="search_page">
		<a href="javascript:void(0);" id="btnFirst">{l s='first'}</a>
		<a href="javascript:void(0);" id="btnPre">{l s='preview'}</a>
		<a href="javascript:void(0);" id="btnNext">{l s='next'}</a>
		<a href="javascript:void(0);" id="btnLast">{l s='last'}</a>
		{l s='page'}&nbsp;<span class="spanPageNum" id="spanPageNum"></span>{l s='of'}&nbsp;
		<span class="spanTotalPage" id="spanTotalPage"></span>
	</div>
	<script type="text/javascript">
	$(document).ready( function() {
		var total = Math.ceil($("#selectproducts ul li").length / 8);
	    var current = 1;
	}
	
	</script>
	
</div>*}
