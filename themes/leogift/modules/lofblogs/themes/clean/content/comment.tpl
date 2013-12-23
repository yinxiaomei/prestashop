{$editor_config}
<div id="lofcontent_comments" class="lofcontent_block">
    <div id="display_errors"></div>    
    <h3 class="article_subheader"><span>{l s='Comments' mod='lofblogs'}</span></h3>
    <div id="view_comment_list" >        
    {if $comments_list}{$comments_list}{/if}    
    </div>
<div class="item_comment_form">
    <div class="loading_overlay"></div>
    <h3 class="article_subheader" ><span>{l s='Leave a comment' mod='lofblogs'}</span></h3>
    <form action="" method="post" name="submit_comment" >
        <div class="lofcontent_line">
            
            <div class="lofcontent_right_col">
                <div class="form_error_tip">{l s='Enter your name' mod='lofblogs'}</div>
                <input id="cm_name" class="validate_required" name="name" type="text" value="{$customer.fullname}" />
                <span class="commentFormInputDesc">{l s='Fill up your name' mod='lofblogs'}</span>
            </div>

        </div>
        <div class="lofcontent_line">            
            <div class="lofcontent_right_col">
                <input id="cm_email" name="email" type="text" value="{$customer.email}" />
                <span class="commentFormInputDesc">{l s='Fill up your email, we\'ll never public your email.' mod='lofblogs'}</span>
            </div>
        </div>
        <div class="lofcontent_line">
            
            <div class="lofcontent_right_col">
                <input id="cm_website" name="website" type="text" value="" />     
                <span class="commentFormInputDesc">{l s='Fill up your website' mod='lofblogs'}</span>
            </div>
        </div>        
        <div class="lofcontent_line">
            
            <div class="lofcontent_right_col" id="comment_area_col">
                <div class="form_error_tip">{l s='Enter your comment' mod='lofblogs'}</div>
                <textarea id="cm_content" class="rte" name="content" cols="40" rows="10" ></textarea>                
            </div>
        </div>
        {if $config.showCaptcha}
        <div class="lofcontent_line">
            
            <div class="lofcontent_right_col" id="captcha_container">
                <img src="{$captchar_uri}get_captcha.php" alt="" id="captcha" />       
                <img src="{$captchar_uri}refresh.png" alt="" id="refresh_captcha" onClick="change_captcha();" />   
            </div>
        </div> 
        <div class="lofcontent_line">            
            <div class="lofcontent_right_col">
                <div class="form_error_tip">{l s='Enter captcha code above' mod='lofblogs'}</div>
                <input id="cm_captcha_validate" class="validate_required" name="captcha_validate" type="text" value="" />   
            </div>
        </div>  
        <input type="hidden" name="captcha_uri" id="captcha_uri" value="{$captchar_uri}get_captcha.php" />
        {/if}
        <div class="lofcontent_line" id="button_container" >
            <a href="javascript:void(0)" onClick="updateComments('{$LBObject->id}')" >{l s='Send' mod='lofblogs'}</a>
        </div>                    
        
    </form>
</div>
</div>
