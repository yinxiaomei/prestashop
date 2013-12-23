/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {          
    $(function() {
        $( "#loftab" ).dvcTab({
            navCls: 'tabs-nav'
        });
    });	         
});

function changeToLanguage(id) {    
    var current_flag = '<img src="../img/l/' + id + '.jpg" class="pointer" id="language_current_' + id + '" onclick="toggleLanguageFlags(this);" alt="" />';
    
    $('.displayed_flag').html(current_flag);
    $('.language_flags').css('display', 'none');
    var target_id = 'lang_'+id; 
    $('.info_lang').css('display', 'none');
    $('.lang_'+id).css('display', 'block');
    
}