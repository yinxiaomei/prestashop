$(document).ready(function() {
    $('.select-option').each(function() {		
        name = $(this).attr("name");		
        elemens = $.find('input[name="'+name+'"]');		
        for(i =0; i< elemens.length; i++){			
            if(!$(elemens[i]).attr("checked")){				
                $('.' + name + '-' +$(elemens[i]).val()).hide();
            }					
			
            $(elemens[i]).click(function() {
                subNameb   = $(this).attr("name");
                subElemens = $.find('input[name="'+subNameb+'"]');
                for(j =0; j< subElemens.length; j++){					
                    if(!$(subElemens[j]).attr("checked")){						
                        $('.' + $(subElemens[j]).attr("name") + '-' +$(subElemens[j]).val()).hide();
                    }else{						
                        $('.' + $(subElemens[j]).attr("name") + '-' +$(subElemens[j]).val()).show();
                    }
                }				
            });
        }			
    });	
		
	
    $('.select-group').each(function() {
        currentValue = $(this).val();
        name = $(this).attr("name");		
        $(this).find("option").each(function(index,Element) {		
            if($(Element).val() == currentValue){		    	
                $('.' + name + '-' + $(Element).val()).show();
            }else{		    	
                $('.' + name + '-' + $(Element).val()).hide();
            }
        });
    });	
	
    $('.select-group').change(function() {	   
        currentValue = $(this).val();
        name = $(this).attr("name");        		
        $(this).find("option").each(function(index,Element) {		
            if($(Element).val() == currentValue){		          
                $('.' + name + '-' + $(Element).val()).show();
            }else{
                $('.' + name + '-' + $(Element).val()).hide();
            }
        });		
    });
});
function lofSelectAll(obj){	
    $(obj).find("option").each(function(index,Element) {
        $(Element).attr("selected","selected");
    });	
}

function openPopup(id){
    $('#overlay_back_office').css('display', 'block');
    $(id).css('display', 'block');
}
function closePopup(id) {
    $('#overlay_back_office').css('display', 'none');
    $(id).css('display', 'none');
}
function getInfo(id) {
    var path = $('#path_info').text().trim(); 
    if(path!='') { $(id).val(path); }    
    closePopup('#popup_container');
}
function addFileInput() {
    var fileIndex = parseInt($('#count_files').val())+1;
    var listElement = $('#upload_list');
    var inputFileHtml = '<li><span>File '+fileIndex+' : </span><input type="file" name="upload_image_gfi_'+fileIndex+'" value="" /> </li>';
    $('#count_files').val(fileIndex);
    listElement.append(inputFileHtml);
}