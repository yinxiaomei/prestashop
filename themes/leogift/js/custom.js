$(document).ready( function(){

	$("#productsview a").click( function(){
		if( $(this).attr("rel") == "view-grid" ){
			$("#product_list").addClass("view-grid").removeClass("view-list");
			$(".icon-th-large").addClass("active");
			$(".icon-list-ul").removeClass("active");
		} else {
			$("#product_list").addClass("view-list").removeClass("view-grid");
			$(".icon-list-ul").addClass("active");
			$(".icon-th-large").removeClass("active");
		}
		return false;
	} );  
} );

function LeoWishlistCart(id, action, id_product, id_product_attribute, quantity)
{ 
	$.ajax({
		type: 'GET',
		url:	baseDir + 'modules/blockwishlist/cart.php',
		async: true,
		cache: false,
		data: 'action=' + action + '&id_product=' + id_product + '&quantity=' + quantity + '&token=' + static_token + '&id_product_attribute=' + id_product_attribute,
		success: function(data)
		{ 
			if (action == 'add') {
				var html = '<div id="page_notification" class="notification alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="not-content">' + data + '</div></div>';
				if (!$("#page_notification").length) $("body").append( html );
				else $("#page_notification .not-content").html(data);
				
				$(".notification").show().delay(2000).fadeOut(600);				
   			}
		
			if($('#' + id).length != 0)
			{ 
				$('#' + id).slideUp('normal');
				document.getElementById(id).innerHTML = data;
				$('#' + id).slideDown('normal');
			}
		}
	});
}

//Detail-product

// Change the current product images regarding the combination selected
function refreshProductImages(id_product_attribute)
{
	$('#thumbs_list_frame').scrollTo('li:eq(0)', 700, {axis:'x'});
	$('#thumbs_list li').hide();
	id_product_attribute = parseInt(id_product_attribute);

	if (typeof(combinationImages) != 'undefined' && typeof(combinationImages[id_product_attribute]) != 'undefined')
	{
		for (var i = 0; i < combinationImages[id_product_attribute].length; i++)
			$('#thumbnail_' + parseInt(combinationImages[id_product_attribute][i])).show();
		if (parseInt($('#thumbs_list_frame >li:visible').length) < parseInt($('#thumbs_list_frame >li').length))
			$('#wrapResetImages').show('slow');
		else
			$('#wrapResetImages').hide('slow');
	}
	if (i > 0)
	{
		var thumb_height = $('#thumbs_list_frame >li').height()+parseInt($('#thumbs_list_frame >li').css('marginTop'));
		$('#thumbs_list_frame').height((parseInt((thumb_height)* i) + 3) + 'px'); //  Bug IE6, needs 3 pixels more ?
	}
	else
	{
		$('#thumbnail_' + idDefaultImage).show();
		displayImage($('#thumbnail_'+ idDefaultImage +' a'));
		if (parseInt($('#thumbs_list_frame >li').length) == parseInt($('#thumbs_list_frame >li:visible').length))
			$('#wrapResetImages').hide('slow');
	}
	$('#thumbs_list').trigger('goto', 0);
	serialScrollFixLock('', '', '', '', 0);// SerialScroll Bug on goto 0 ?
}
//To do after loading HTML
 

/*bootstrap menu*/
$(window).ready( function(){
 $(document.body).on('click', '[data-toggle="dropdown"]' ,function(){
  if(!$(this).parent().hasClass('open') && this.href && this.href != '#'){
   window.location.href = this.href;
  }
 }); 



 $("#topnavigation .dropdown .caret").click( function() {
  $(this).parent().toggleClass('iopen'); 
 } );
//  $("#topnavigation .nav-collapse").OffCanvasMenu();
} );


// JS CAVANS MENU 

(function($) {
	$.fn.OffCavasmenu = function(opts) {
		// default configuration
		var config = $.extend({}, {
			opt1: null,
			text_warning_select:'Please select One to remove?',
			text_confirm_remove:'Are you sure to remove footer row?',
			JSON:null
		}, opts);
		// main function
	

		// initialize every element
		this.each(function() {  
			var $btn = $('#topnavigation .btn-navbar');
			var	$nav = null;
			 

			if (!$btn.length) return;
	 	 	var $nav = $('<section id="off-canvas-nav"><nav class="offcanvas-mainnav" ><div id="off-canvas-button"><span class="off-canvas-nav"></span>Close</div></nav></sections>'); 
	 	 	var $menucontent = $($btn.data('target')).find('.megamenu').clone();
			$("body").append( $nav );
	 	 	$("#off-canvas-nav .offcanvas-mainnav").append( $menucontent );
		 
		
 			$('html').addClass ('off-canvas');
			$("#off-canvas-button").click( function(){
				$btn.click();	
			} ); 
			$btn.toggle( function(){
				$("body").removeClass("off-canvas-inactive").addClass("off-canvas-active");
			}, function(){
				$("body").removeClass("off-canvas-active").addClass("off-canvas-inactive");
		 
			} );

		});
		return this;
	}
	
})(jQuery);

$(document).ready( function(){
	
		/* off Canvasmenu */
	jQuery("#topnavigation").OffCavasmenu();
	 $('#topnavigation .btn-navbar').click(function () {
     $('body,html').animate({
      scrollTop: 0
     }, 0);
    return false;
   });
	


} );
 