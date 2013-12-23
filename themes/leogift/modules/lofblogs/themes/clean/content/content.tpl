
<div id="lofcontent_content" class="lofcontent_block">
    <h2>{$LBObject->title}</h2>
    <div class="lofcontent_content_main" >
        <div class="lofcontent_main_content" >
            {if $LBObject->image}
            <div class="primay_img img_align_{$config.imgAlign}">
                <img src="{$imageUri}{$LBObject->image}" alt="{$LBObject->title}" />
            </div>
            {/if}
            <div class="article_header">
            {if $config.showInfo}<p class="article_infor">{l s='written by ' mod='lofblogs'}<span class="lofcontent_authorname">{$LBObject->authorname}</span>{l s=' at ' mod='lofblogs'}{$LBObject->date_upd}</p>{/if}
            {if $config.showRating}
                <div class="lofcontent_rating_container" >
                    <div><span id="article_rating_total">{$LBObject->rating_num}</span><span>{l s='vote' mod='lofblogs'}</span></div>
                    <div id="article_rating" {$ratingClass} >
                        <a href="javascript:void(0)"  class="article_rate_buttons" id="article_rate_btn1" title="1" >1</a>
                        <a href="javascript:void(0)"  class="article_rate_buttons" id="article_rate_btn2" title="2" >2</a>
                        <a href="javascript:void(0)"  class="article_rate_buttons" id="article_rate_btn3" title="3" >3</a>
                        <a href="javascript:void(0)"  class="article_rate_buttons" id="article_rate_btn4" title="4" >4</a>
                        <a href="javascript:void(0)"  class="article_rate_buttons" id="article_rate_btn5" title="5" >5</a>
                    </div>                    
                    <div id="rating_status"><img id="loading_img" src="{$imgLoadingVote}" /><span id="aticle_rating_note">{l s='Thank you for vote this article' mod='lofblogs'}</span></div>
                </div>    
            {/if}
            </div>  
            <div class="clear"></div>
                  
            {$LBObject->content}
        </div>
    </div>
<input type="hidden" name="root_uri" id="root_uri" value="{$rootUri}" />
<input type="hidden" id="article_id" name="article_id" value="{$LBObject->id}" />
<input type="hidden" id="update_star" name="update_star" value="" />
</div> 