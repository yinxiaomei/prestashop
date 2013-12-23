<!--Start Module-->
<div id="lofminigallery_{$moduleId}" class="lof_thumbnail_container thumb_{$thumbTheme}" style="width: {$moduleWidth}px;">
    {if $showTitle}
        <h4>{$moduleTitle}</h4>
    {/if}
    <ul class="lof_thumblist">
        {foreach from=$miniproducts item=row}
            {if $row.mainImge != '' && $row.thumbImge != ''}
                <li>
                    <a title="{$row.name}" rel="gallery[{$moduleId}]" href="{$row.mainImge}">
                        <img width="{$thumbnailWidth}" height="{$thumbnailHeight}" alt="{$row.name}" src="{$row.thumbImge}" />
                    </a>
                </li>
            {/if}
        {/foreach}
    </ul>
</div>

<!--End Module-->