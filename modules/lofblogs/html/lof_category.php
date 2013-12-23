<?php
/**
 * Category manager layout ! 
 * @author LandOfcoder
 * @project Lof Content
 * 
 */
?>
<script type="text/javascript">    
    id_language = Number(<?php echo $defaultLanguage; ?>);
    jQuery(document).ready(function(){
        $('#lofcontent_cpanel > ul > li').dvcSimpleSwither();
    });    
    var iso = '<?php echo $isoTinyMCE; ?>' ;
    var pathCSS = '<?php echo _THEME_CSS_DIR_; ?>' ;
    var ad = '<?php echo dirname($_SERVER["PHP_SELF"]); ?>' ;    
        
</script>
<form action="<?php echo $formAction; ?>" method="post" enctype="multipart/form-data" name="<?php echo $this->table; ?>_form" id="<?php echo $this->table; ?>_form" >
    <div class="lof-back-office-content"> 
        <div class="clearfix"></div>
        <fieldset>
            <div id="lofcontent_panel">
                <div id="lofcontent_cpanel">                    
                    <ul>
                        <li id="lofc_global"><?php echo $lofAdminHtml->l('Global'); ?></li>
                        <li id="lofc_image"><?php echo $lofAdminHtml->l('Image'); ?></li>
                        <li id="lofc_metadata"><?php echo $lofAdminHtml->l('Metadata'); ?></li>
                    </ul>                    
                </div>

            </div> 

            <div class="lofcontent_mainview">

                <?php if ($obj) : ?>
                    <input type="hidden" name="id_<?php echo $this->table; ?>" value="<?php echo $obj->id; ?>" />
                <?php endif; ?>
                <div id="view_lofc_global" class="dvc_simple_switcher">
                    <h3 class="option_group_header"><?php echo $lofAdminHtml->l('Global Option'); ?></h3>

                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('input[type="text" class="lofCopy2friendlyURLByName"]', 'name', $lofAdminHtml->l('Name')); ?> 
                    </div>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('input[type="text"]', 'link_rewrite', $lofAdminHtml->l('Alias')); ?> 
                    </div>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('theme', 'template', $lofAdminHtml->l('Theme'), false); ?> 
                    </div>   
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('published', 'active', $lofAdminHtml->l('Published'), false); ?> 
                    </div>                    
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('categories_list', 'id_parent', $lofAdminHtml->l('Parent'), false); ?>
                    </div>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('textarea[class="mceNoEditor"]', 'short_desc', $lofAdminHtml->l('Short Description')); ?>
                    </div>                      
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('textarea[class="rte"]', 'description', $lofAdminHtml->l('Description')); ?>
                    </div>                  
                </div> 

                <div id="view_lofc_image" class="dvc_simple_switcher">
                    <h3 class="option_group_header"><?php echo $lofAdminHtml->l('Primary Image'); ?></h3>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('custom['.$imageField.']', '', $lofAdminHtml->l('Primary Image'), false); ?>
                        <?php echo $lofAdminHtml->getHtml('input[type="file"]', 'image', '', false); ?>
                    </div>  
                </div>

                <div id="view_lofc_metadata" class="dvc_simple_switcher">
                    <h3 class="option_group_header"><?php echo $lofAdminHtml->l('SEO Metadata'); ?></h3>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('input[type="text"]', 'meta_title', $lofAdminHtml->l('Meta title')); ?> 
                    </div>                    
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('textarea[class="mceNoEditor"]', 'meta_description', $lofAdminHtml->l('Meta Description')); ?>
                    </div>                
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('textarea[class="mceNoEditor"]', 'meta_keywords', $lofAdminHtml->l('Meta keywords')); ?>
                    </div>  
                </div>
            </div>
        </fieldset>    
    </div>
    <input type="submit" id="<?php echo $this->table; ?>_form_submit_btn" name="<?php echo $this->table; ?>_form_submit_btn" value="Save" />
</form>
<?php 
$lofAdminHtml->addScript($tinymceFile); 
$lofAdminHtml->addScript($tinymceInit); 
?>
<script type="text/javascript"> tinySetup(); </script>