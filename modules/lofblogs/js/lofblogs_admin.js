if (!id_language)
	var id_language = Number(1);
var PS_ALLOW_ACCENTED_CHARS_URL = 0;

function lofCopy2friendlyURLByTitle()
{
	$('#input_link_rewrite_' + id_language).val(str2url($('#input_title_' + id_language).val().replace(/^[0-9]+\./, ''), 'UTF-8').replace('%', ''));
	if ($('#friendly-url'))
		$('#friendly-url').html($('#input_link_rewrite_' + id_language).val());
	// trigger onchange event to use anything binded there
	$('#input_link_rewrite_' + id_language).change(); 
	
	return;
}
function lofCopy2friendlyURLByName()
{
	$('#input_link_rewrite_' + id_language).val(str2url($('#input_name_' + id_language).val().replace(/^[0-9]+\./, ''), 'UTF-8').replace('%', ''));
	if ($('#friendly-url'))
		$('#friendly-url').html($('#input_link_rewrite_' + id_language).val());
	// trigger onchange event to use anything binded there
	$('#input_link_rewrite_' + id_language).change(); 

	return;
}
$(document).ready(function()
{
	$(".lofcopy2friendlyUrlByTitle").live('keyup change',function(e){
		if(!isArrowKey(e))
			return lofCopy2friendlyURLByTitle();
	});
	
	$(".lofCopy2friendlyURLByName").live('keyup change',function(e){
		if(!isArrowKey(e))
			return lofCopy2friendlyURLByName();
	});
});
