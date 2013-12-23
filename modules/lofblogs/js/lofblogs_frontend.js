/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    
    var view = $('#article_rating');
    var ratingButtons = $('.article_rate_buttons');
    var current_cls = view.attr('class');    
    
    if(ratingButtons) {
        ratingButtons.each(function(){      
            
            var rate = $(this).attr('title');      
            var star_cls = 'lofcontent_article_rate'+rate;
            $(this).hover(
                function(){
                    current_cls = view.attr('class');
                    view.attr('class', star_cls)
                }, 
                function(){  
                    var updateStar = $('#update_star').val();
                    var starClass = updateStar ? updateStar : current_cls;
                    view.attr('class', starClass);
                }
                );
            $(this).click(function(){
                articleRate(rate);
            });
       
        });
    }
});

function articleRate(rate) {
    //set status proccessing :
    $('#loading_img').css('display', 'inline');
        
        
    var params = {
        article_id: $('#article_id').val(),
        rate:rate
    };         
    var url = $('#root_uri').val()+'?fc=module&module=lofblogs&controller=articles&view=rating&'+jQuery.param(params); 
    $.ajax({
        async: false,
        type: "POST",
        url: url,        
        success: function(rate){ 
            var rating = jQuery.parseJSON(rate); 
            if(rating.error == 'NOTHING') {
                $('#article_rating_total').text(rating.total); 
                $('#article_rating').attr('class', 'lofcontent_article_rate'+rating.star);
                $('#update_star').val('lofcontent_article_rate'+rating.star);
                $('#aticle_rating_note').text(rating.note);
            } else { 
                $('#aticle_rating_note').text(rating.error);
            }
            $('#aticle_rating_note').css('display', 'block').delay(3000).fadeOut(1000);
            $('#loading_img').css('display', 'none');
        }
    });     
}

function updateComments(id) { 
    var editor = tinyMCE.get('cm_content');

    var clsLoading = 'loading_comments';
    var view = $('#view_comment_list');
    var container = $('#lofcontent_comments');
    var validForm = validateForm();

    if(validForm) {
        container.addClass(clsLoading);
        var params = {
            item_id: id,
            name:$('#cm_name').val(), 
            email:$('#cm_email').val(), 
            website:$('#cm_website').val(),
            content: tinyMCE.activeEditor.getContent(),
            captcha: $('#cm_captcha_validate').val()
        };   
        var url = $('#root_uri').val()+'?fc=module&module=lofblogs&controller=articles&view=comment&'+jQuery.param(params); 
        $.ajax({
            async: false,
            type: "POST",
            url: url,        
            success: function(page){              
                view.html(page);
                container.removeClass(clsLoading);
                $('html, body').animate({
                    scrollTop: $("#lofcomment_error").offset().top
                }, 600);
                change_captcha();
                tinyMCE.activeEditor.setContent('');
            }
        });        
    }    
}

function validateForm(){
    var requiredFields = $('.validate_required');
    var errors = 0;
    requiredFields.each(function(){
        var error_tip = $(this).prev();
        if($(this).val() == '') {
            error_tip.css('display', 'block');
            $(this).effect("highlight", {
                color: '#f59c9c'
            }, 3000);
            $(this).focus();
            errors++;
            return false;
        }
    });    
    if(errors > 0) {
        return false;
    } else return true;
}

function change_captcha()
{
    var captcha_uri = $('#captcha_uri').val();
    if(captcha_uri) {
        document.getElementById('captcha').src=captcha_uri+"?rnd=" + Math.random();
    }    
}

function commentVote(id, type) {
    var params = {
        comment_id: id,
        vote:type
    };         
    var url = $('#root_uri').val()+'?fc=module&module=lofblogs&controller=articles&view=vote&'+jQuery.param(params);
    $.ajax({
        async: false,
        type: "POST",
        url: url,        
        success: function(vote){              
            $('#vote_buttons'+id).html(vote);
        }
    });      
}

function insertAtCaret(areaId,text) {
    var txtarea = document.getElementById(areaId);
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? 
        "ff" : (document.selection ? "ie" : false ) );
    if (br == "ie") { 
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        strPos = range.text.length;
    }
    else if (br == "ff") strPos = txtarea.selectionStart;

    var front = (txtarea.value).substring(0,strPos);  
    var back = (txtarea.value).substring(strPos,txtarea.value.length); 
    txtarea.value=front+text+back;
    strPos = strPos + text.length;
    if (br == "ie") { 
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        range.moveStart ('character', strPos);
        range.moveEnd ('character', 0);
        range.select();
    }
    else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    }
    txtarea.scrollTop = scrollPos;
}

function toogleSmile(){
    var allToolbars = $('table.mceToolbar'); 
    allToolbars.each(function(idx, item){ 
        var toolbarId = $(item).attr('id') != '' ? $(item).attr('id').replace('cm_content_toolbar', '') : 0;
        var toolbarNo = parseInt(toolbarId, 0); 
        if( toolbarNo > 3) {
            $(item).toggle();
        }
    });
}