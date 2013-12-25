function myPagination(){
	
	var pageNum = 20;
	var listNum = $("ul.products-grid li.ajax_block_product").length;
	var totalNumberOfPages;
	if(listNum > pageNum)
	{
		totalNumberOfPages = Math.ceil(listNum / pageNum) - 1;
		
		$("ul.products-grid li.ajax_block_product:gt(" + (pageNum - 1) + ")").hide();
		$(window).paged_scroll({
			handleScroll : function(page, container, doneCallback) {
				setTimeout(function() {
					console.log("Page is:", page);
					$("ul.products-grid li.ajax_block_product").show();
					$("ul.products-grid li.ajax_block_product:gt("+ (pageNum * (page + 1) - 1) + ")").hide();
				}, 1000);
				return true;
			},
			triggerFromBottom : '5%',
			loader : '<div class="loader"></div>',
			pagesToScroll : 1,
			targetElement : $('#selectproducts ul.products-grid'),
			debug : true
		});
	}
	
}