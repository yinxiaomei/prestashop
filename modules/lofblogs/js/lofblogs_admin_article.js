
$.fn.dvcSimpleSwither = function() {   
    return this.each(function(i,item) { 
        if(i==0) {
            viewGroup($(item));
        }
        $(item).click(function(){
            viewGroup($(item));
        })
    });
    
};
function viewGroup(elem) {
    var current = $('#view_'+elem.attr('id')); 
    if(current != null) {
        var views = $('.dvc_simple_switcher');
        elem.siblings().removeClass('selected_view');
        elem.addClass('selected_view');
        views.hide(0);
        current.fadeIn('medium');    
    } else {
        alert('View view_'+elem.attr('id')+' does not exits');
    }
}
function addFileInput() {
    var fileIndex = parseInt($('#count_files').val())+1;
    var listElement = $('#upload_list');
    var inputFileHtml = '<li><input class="gallery_upload_field" type="file" name="ga_upload_field_'+fileIndex+'" value="" /> </li>';
    $('#count_files').val(fileIndex);
    listElement.append(inputFileHtml);
}
function selectImage(elem) {
    var myParent = $(elem).parent('span'); 
    $(myParent).parent('li').toggleClass('image_for_remove'); 
}

function reportFilesSelected(){
    var input = document.getElementById("ga_upload_field");
    var ul = document.getElementById("upload_list");
    while (ul.hasChildNodes()) {
        ul.removeChild(ul.firstChild);
    }
    for (var i = 0; i < input.files.length; i++) {
        var li = document.createElement("li");
        li.innerHTML = '<span> '+input.files[i].name+'</span>';
        ul.appendChild(li);
    }
    if(!ul.hasChildNodes()) {
        var li = document.createElement("li");
        li.innerHTML = 'No Files Selected';
        ul.appendChild(li);
    }    
}

function getProducts(category) {
    $('#view_container').addClass('product-loading');
    var url = $('#root_uri').attr('value')+'?fc=module&module=lofblogs&controller=articles';
    var catid = $(category).val();
    var view = $('#product_listview');
   
    $.ajax({
        async: false,
        type: "POST",
        url: url,
        data: "view=ajax&catid=" + catid,
        success: function(page){
            $('#view_container').removeClass('product-loading');
            view.html(page);
        }
    });
}

function addRelatedProduct(container) {

    var product_id = parseInt($(container).attr('id').replace("related_", ""));
    if(jQuery.inArray(product_id, products) == -1) {
        products.push(product_id);
        var data = '<input class="rlt_product_data" type="hidden" name="products[]" value="'+product_id+'" />';
        var img = $(container).children('img').get(0);
        var image = '<img src="'+$(img).attr('src')+'" />';
        var title = '<p>'+$(img).attr('alt')+'</p>';
        var button = '<div class="deleted_img_label">Remove</div>';
    
        var listElement = $('#related_products');
        var inputFileHtml = '<li onClick="removeMe(this);" id="selected_'+product_id+'" class="product_item">'+title+image+button+data+'</li>';
        listElement.append(inputFileHtml);        
    } else {
        alert('This product already added to list !');
    }

}

function removeMe(container) {
    var product_id = $(container).attr('id').replace("selected_", "");
    
    //remove id from products variable :
    products = jQuery.grep(products, function(value) {
        return value != product_id;
    });

    //remove display element :
    $(container).remove();
}

function getThemePositions(themename, value) {
    $('#template').addClass('theme-loading');
    var params = {
        theme: themename,
        value: value
    };         
    var url = $('#root_uri').val()+'?fc=module&module=lofblogs&controller=articles&view=loadposition&'+jQuery.param(params); 
    $.ajax({
        async: false,
        type: "POST",
        url: url,        
        success: function(list){ 
            $('#position_view').html(list);
            $('#template').removeClass('theme-loading');
        }
    });    
}

article_fc = new function(){
	var self = this;
	this.initAccessoriesAutocomplete = function (){
		$('#product_autocomplete_input')
			.autocomplete('ajax_products_list.php', {
				minChars: 1,
				autoFill: true,
				max:20,
				matchContains: true,
				mustMatch:true,
				scroll:false,
				cacheLength:0,
				formatItem: function(item) {
					return item[1]+' - '+item[0];
				}
			}).result(self.addAccessory);

		$('#product_autocomplete_input').setOptions({
			extraParams: {
				excludeIds : self.getAccessoriesIds()
			}
		});
	};

	this.getAccessoriesIds = function()
	{
		if ($('#inputAccessories').val() === undefined)
			return '';
		var ids = '0,';
		ids += $('#inputAccessories').val().replace(/\\-/g,',').replace(/\\,$/,'');
		ids = ids.replace(/\,$/,'');

		return ids;
	}

	this.addAccessory = function(event, data, formatted)
	{
		if (data == null)
			return false;
		var productId = data[1];
		var productName = data[0];

		var $divAccessories = $('#divAccessories');
		var $inputAccessories = $('#inputAccessories');
		var $nameAccessories = $('#nameAccessories');

		/* delete product from select + add product line to the div, input_name, input_ids elements */
		$divAccessories.html($divAccessories.html() + productName + ' <span class="delAccessory" name="' + productId + '" style="cursor: pointer;"><img src="../img/admin/delete.gif" /></span><br />');
		$nameAccessories.val($nameAccessories.val() + productName + '¤');
		$inputAccessories.val($inputAccessories.val() + productId + '-');
		$('#product_autocomplete_input').val('');
		$('#product_autocomplete_input').setOptions({
			extraParams: {excludeIds : self.getAccessoriesIds()}
		});
	};

	this.delAccessory = function(id)
	{
		var div = getE('divAccessories');
		var input = getE('inputAccessories');
		var name = getE('nameAccessories');

		// Cut hidden fields in array
		var inputCut = input.value.split('-');
		var nameCut = name.value.split('¤');
		if (inputCut.length != nameCut.length)
			return jAlert('Bad size');

		// Reset all hidden fields
		input.value = '';
		name.value = '';
		div.innerHTML = '';
		for (i in inputCut)
		{
			// If empty, error, next
			if (!inputCut[i] || !nameCut[i])
				continue ;

			// Add to hidden fields no selected products OR add to select field selected product
			if (inputCut[i] != id)
			{
				input.value += inputCut[i] + '-';
				name.value += nameCut[i] + '¤';
				div.innerHTML += nameCut[i] + ' <span class="delAccessory" name="' + inputCut[i] + '" style="cursor: pointer;"><img src="../img/admin/delete.gif" /></span><br />';
			}
			else
				$('#selectAccessories').append('<option selected="selected" value="' + inputCut[i] + '-' + nameCut[i] + '">' + inputCut[i] + ' - ' + nameCut[i] + '</option>');
		}

		$('#product_autocomplete_input').setOptions({
			extraParams: {excludeIds : self.getAccessoriesIds()}
		});
	};

	this.onReady = function(){
		self.initAccessoriesAutocomplete();
		$('#divAccessories').delegate('.delAccessory', 'click', function(){
			self.delAccessory($(this).attr('name'));
		});
	};
}