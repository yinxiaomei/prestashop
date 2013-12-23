<?php $gallery_makeup =
'<div class="pp_gallery">
    <a href="#" class="pp_arrow_previous">Previous</a>
    <div>
        <ul style="display:none;">
            {gallery}
        </ul>
    </div>
    <a href="#" class="pp_arrow_next">Next</a>
</div>    
';
?>
<script type="text/javascript">
    // <![CDATA[    
    $(window).load(function() {
        $('#lofminigallery_<?php echo $moduleId; ?> a').prettyPhoto({
            animation_speed:'<?php echo $params->get('a_speed', 'normal'); ?>',
            theme:'<?php echo $params->get("g_theme", "dark_rounded"); ?>',
            slideshow:<?php echo $params->get("slideshow", 3000); ?>, 
            autoplay_slideshow: <?php echo $params->get("autoplay", 'false'); ?>,
            social_tools: false,
            gallery_markup: '<?php echo str_replace(array("\r", "\n"), '', $gallery_makeup);?>'
        });
    });  
    // ]]>
</script>
