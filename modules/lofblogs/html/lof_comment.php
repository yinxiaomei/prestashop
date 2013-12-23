<?php 
/**
 * Comments manager layout ! 
 * @author LandOfcoder
 * @project Lof Content
 * 
 */

?>
<form action="<?php echo $formAction; ?>" method="post" enctype="multipart/form-data" name="<?php echo $this->table; ?>_form" id="<?php echo $this->table; ?>_form" >
    <div class="lof-back-office-content">
        <div class="clearfix"></div>
        <fieldset>
            <div class="lofcontent_mainview">
                <?php if ($obj) : ?>
                    <input type="hidden" name="id" value="<?php echo $obj->id; ?>" />
                <?php endif; ?>
                <div id="view_lofc_global" class="dvc_simple_switcher">                    
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('published', 'published', $lofAdminHtml->l('Published'), false); ?> 
                    </div> 
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('custom['.$obj->name.']', '', $lofAdminHtml->l('Author name '), false); ?>
                    </div>   
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('custom['.$obj->email.']', '', $lofAdminHtml->l('Author email '), false); ?>
                    </div>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('custom['.$obj->website.']', '', $lofAdminHtml->l('Author website '), false); ?>
                    </div>
                    <div class="lofcontent-backoffice-line">
                        <?php echo $lofAdminHtml->getHtml('custom['.$obj->content.']', '', $lofAdminHtml->l('Comment content '), false); ?>
                    </div>                    
                </div> 
            </div>
        </fieldset>    
    </div>
    <input type="submit" id="<?php echo $this->table; ?>_form_submit_btn" name="<?php echo $this->table; ?>_form_submit_btn" value="Save" />
</form>