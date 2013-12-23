<div id="lofcontent_gallery" class="lofcontent_block">
    <ul id="articleGallery">
        {foreach from=$images item=img}
            <li>                
                <a class="article_gallery" href="{$galleryUri}{$img}" title="{$LBObject->title}" rel="gallery[{$LBObject->id}]" >
                    <img src="{$thumbUri}{$img}" alt="{$LBObject->title}" />
                </a>
            </li>           
        {/foreach}
    </ul>
</div>