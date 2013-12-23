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
    products = new Array(<?php echo $obj->id_products; ?>);
    jQuery(document).ready(function(){       
        $('#lofcontent_cpanel > ul > li').dvcSimpleSwither();
        
        var categorySelector = $('#select_category');
        getProducts(categorySelector);
        categorySelector.change(function(){
            getProducts(this);           
        });
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
                        <li id="lofc_global"><?php echo $lofAdminHtml->l('Global') ?></li>
                        <li id="lofc_gallery"><?php echo $lofAdminHtml->l('Image & Gallery') ?></li>                        
                        <li id="lofc_product"><?php echo $lofAdminHtml->l('Related Product'); ?></li>
                        <li id="lofc_metadata"><?php echo $lofAdminHtml->l('Metadata'); ?></li>
                    </ul>                    
                </div>

                <?php if (is_object($obj) && $obj->id) : ?>
                    <div id="lof_article_info">                        
                        <ul>
                            <li><?php echo $lofAdminHtml->l('Created Date : ') . $obj->date_add; ?></li>
                            <li><?php echo $lofAdminHtml->l('Last Update : ') . $obj->date_upd; ?></li>
                            <li><?php echo $lofAdminHtml->l('Author : ') . $obj->authorname ?></li>
                        </ul>
                    </div>
                    <input type="hidden" name="id_<?php echo $this->table; ?>" value="<?php echo $obj->id; ?>" />
                <?php endif; ?>
            </div> 
            <div class="lofcontent_mainview">
                <div id="view_lofc_global" class="dvc_simple_switcher">
                    <h3 class="option_group_header"><?php echo $lofAdminHtml->l('Global options'); ?></h3>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('input[type="text" class="lofcopy2friendlyUrlByTitle"]', 'title', $lofAdminHtml->l('title')); ?> 
                    </div>                      
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('input[type="text"]', 'link_rewrite', $lofAdminHtml->l('Alias')); ?> 
                    </div>  
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('feature[type="checkbox"]', 'featured', $lofAdminHtml->l('is Featured'), false); ?> 
                    </div>                    
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('categories_list', 'id_lofblogs_category', $lofAdminHtml->l('Category'), false); ?>
                    </div>                    
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('status', 'status', $lofAdminHtml->l('Status'), false); ?> 
                    </div>  
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('access[multiple="1"]', 'access', $lofAdminHtml->l('Access'), false); ?> 
                    </div>                    
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('textarea[class="noEditor"]', 'short_desc', $lofAdminHtml->l('Short Description')); ?>
                    </div>                      
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('textarea[class="rte"]', 'content', $lofAdminHtml->l('Content')); ?>
                    </div>  
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('input[type="text"]', 'tags', $lofAdminHtml->l('Tags')); ?>
                    </div>                     
                </div>

                <div id="view_lofc_gallery" class="dvc_simple_switcher">
                    <h3 class="option_group_header"><?php echo $lofAdminHtml->l('Primary Images'); ?></h3>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('custom['.$imageField.']', '', '', false); ?>
                        <?php echo $lofAdminHtml->getHtml('input[type="file"]', 'image', '', false); ?>
                    </div>  

                    <h3 class="option_group_header"><?php echo $lofAdminHtml->l('Gallery Images'); ?></h3>
                    <?php if (is_object($obj) && $obj->id) : ?>                       
                        <div class="lofcontent-backoffice-line">                                   
                            <?php echo $lofAdminHtml->getHtml('custom[' . $obj->getGallery() . ']', '', '', false); ?>
                        </div>  
                        <div class="lofcontent-backoffice-line">                                   
                            <?php echo $lofAdminHtml->getHtml('custom[<input type="submit" value="' . $lofAdminHtml->l('Update') . '" name="submitAdd' . $this->table . '" class="lofcontent_button" />]', '', '', false); ?>
                        </div>                        
                        <div class="lofcontent-backoffice-line">  
                            <label></label>
                            <div class="lofcontent-right-column">
                                <input class="gallery_upload_field" onChange="reportFilesSelected()" type="file" name="ga_upload_field[]" id="ga_upload_field" multiple="" />                            
                                <fieldset>
                                    <legend>Files Selected</legend>
                                    <ul id="upload_list"><li><span>Please select some image ("Ctrl + left click" on image to select multiple image)</span></li></ul>    
                                </fieldset>                                
                            </div>                            
                        </div>    
                    <?php else: ?>
                        <?php echo $lofAdminHtml->getHtml('custom[<div class="lofnote">' . $lofAdminHtml->l('Please save article first then you can upload gallery') . '</div>]', '', '', false); ?>
                    <?php endif; ?>
                </div>
                <div id="view_lofc_metadata" class="dvc_simple_switcher">
                    <h3 class="option_group_header"><?php echo $lofAdminHtml->l('SEO Metadata'); ?></h3>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('input[type="text"]', 'meta_title', $lofAdminHtml->l('Meta title')); ?> 
                    </div>                    
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('textarea[class="noEditor"]', 'meta_description', $lofAdminHtml->l('Meta Description')); ?>
                    </div>                
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('textarea[class="noEditor"]', 'meta_keywords', $lofAdminHtml->l('Meta keywords')); ?>
                    </div>  
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('textarea[class="noEditor"]', 'excerpt', $lofAdminHtml->l('Excerpt SEO description')); ?>
                    </div>                    
                </div>   
                <div id="view_lofc_product" class="dvc_simple_switcher">
                    <h3 class="option_group_header"><?php echo $lofAdminHtml->l('Related Product'); ?></h3>
                    <div class="lofcontent-backoffice-line">
                        
                        <label></label>
                        <div class="lofcontent-right-column">
                            <?php
                            $inputAccessories = '';
                            $nameAccessories = '';
                            foreach($relate_products as $product){ 
                                $inputAccessories .= $product['id_product'].'-';
                                $nameAccessories .= htmlentities($product['name'], ENT_COMPAT, 'UTF-8').'¤';
                            } 
                            ?>
                            <input type="hidden" name="inputAccessories" id="inputAccessories" value="<?php echo $inputAccessories;?>" />
                            <input type="hidden" name="nameAccessories" id="nameAccessories" value="<?php echo $nameAccessories;?>" />

                            <div id="ajax_choose_product">
                                <p style="clear:both;margin-top:0;">
                                    <input type="text" value="" id="product_autocomplete_input" />
                                    <?php echo $lofAdminHtml->l('Begin typing the first letters of the product name, then select the product from the drop-down list.'); ?>
                                </p>
                                <p class="preference_description"><?php echo $lofAdminHtml->l('(Do not forget to save the product afterward)');?></p>
                                <!--<img onclick="$(this).prev().search();" style="cursor: pointer;" src="../img/admin/add.gif" alt="<?php echo $lofAdminHtml->l('Add an accessory');?>" title="<?php echo $lofAdminHtml->l('Add an accessory');?>" />-->
                            </div>
                            <div id="divAccessories">
                                <?php
                                foreach($relate_products as $product){ 
                                    echo htmlentities($product['name'], ENT_COMPAT, 'UTF-8');
                                    if(!empty($product['reference'])) {
                                        echo $product['reference'];
                                    }
                                    ?>
                                    <span class="delAccessory" name="<?php echo $product['id_product'];?>" style="cursor: pointer;">
                                        <img src="../img/admin/delete.gif" class="middle" alt="" />
                                    </span><br />
                                <?php } ?>
                            </div>

                        </div>

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
<script type="text/javascript"> 
    tinySetup(); 
    article_fc.onReady();
    jQuery(document).ready(function(){
        $("#<?php echo $this->table; ?>_form").delegate('input', 'keypress', function(e){
            var code = null;
            code = (e.keyCode ? e.keyCode : e.which);
            return (code == 13) ? false : true;
        });
    });
</script>
