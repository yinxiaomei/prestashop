<?php
/**
 * Article manager layout ! 
 * @author LandOfcoder
 * @project Lof Content
 * 
 */

?>
<script type="text/javascript">    
    id_language = Number(<?php echo $defaultLanguage; ?>); 
    var iso = '<?php echo $isoTinyMCE; ?>' ;
    var pathCSS = '<?php echo __PS_BASE_URI__; ?>themes/prestashop/css/' ;
    var ad = '<?php echo __PS_BASE_URI__; ?>' ;    
    $(document).ready(function(){
        var themeSwitcher = $('#template');
        
        getThemePositions($(this).val(), '<?php echo $obj->position; ?>');
        themeSwitcher.change(function(){
            getThemePositions(themeSwitcher.val(), '');
        });
        
        
    });
</script>
<form action="<?php echo $formAction; ?>" method="post" enctype="multipart/form-data" name="<?php echo $this->table; ?>_form" id="<?php echo $this->table; ?>_form" >
    <div class="lof-back-office-content">         
        <div class="clearfix"></div>
        <fieldset>
            <div class="lofcontent_mainview" id="lofcontent_blockmanger">
                <div id="view_lofc_global" class="dvc_simple_switcher">
                    <h3 class="option_group_header"><?php echo $lofAdminHtml->l('Custom Html Block'); ?></h3>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('input[type="text"]', 'title', $lofAdminHtml->l('title')); ?> 
                    </div>                      
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('published', 'published', $lofAdminHtml->l('Published'), false); ?> 
                    </div>                    
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('theme[id="template"]', 'template', $lofAdminHtml->l('Theme'), false); ?> 
                    </div>  
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('custom[<div id="position_view"></div>]', '', $lofAdminHtml->l('Blocks Position'), false); ?>                        
                    </div>                    
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('textarea[class="rte"]', 'content', $lofAdminHtml->l('Content')); ?>
                    </div>  
                    <input type="hidden" name="root_uri" id="root_uri" value="<?php echo __PS_BASE_URI__; ?>" />
                </div>
            </div>          
        </fieldset>   
    </div>
    <?php if (is_object($obj) && $obj->id) : ?>
        <input type="hidden" name="id" value="<?php echo $obj->id; ?>" />
    <?php endif; ?>
        <input type="hidden" name="imageUri" id="imageUri" value="<?php echo LOFCONTENT_IMAGES_ADMIN_URI; ?>" />
        <input type="submit" id="<?php echo $this->table; ?>_form_submit_btn" name="<?php echo $this->table; ?>_form_submit_btn" value="Save" /> 
</form>
<?php 
$lofAdminHtml->addScript($tinymceFile); 
$lofAdminHtml->addScript($tinymceInit); 
?>
<script type="text/javascript"> tinySetup(); </script>