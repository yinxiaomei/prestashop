<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<script type="text/javascript">
    $(document).ready(function() {          
        $(function() {
            try { changeToLanguage("<?php echo $this->defaultLang; ?>");}
            catch(err){
                //do nothing
            } 
        });	         
    });   
</script>
<form action="<?php echo $_SERVER['REQUEST_URI'] . '&rand=' . rand(); ?>" enctype="multipart/form-data" method="post" id="lofparams_form">
    <div id="config_form_<?php echo $this->module; ?>" class="lofparams">
        <div id="lofparams_panel">
            <input type="submit" name="submit" value="<?php echo $this->moduleObj->l('Update', 'form'); ?>" class="button" />            
        </div>
        <div class="lofparams_main_view">
            <?php echo $this->callHook($this->beforeDisplayForm); ?>
            <div id="loftab">       
                <ul>
                    <?php foreach ($fieldsets as $k => $fieldset) : ?>
                        <li><a href="#tab-<?php echo $k; ?>" ><?php echo $this->moduleObj->l($fieldset['label'], 'params_lang'); ?></a></li>
                    <?php endforeach; ?>
                </ul>

                <?php foreach ($fieldsets as $k => $fieldset) : ?>
                    <div id="tab-<?php echo $k; ?>" >
                        <?php foreach ($fieldset['fields'] as $field) : ?>
                            <div class="lofparams_line">
                                <?php echo $this->toHtml($field); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>            
            </div>
            <?php echo $this->callHook($this->afterDisplayForm); ?>
        </div>
    </div>
    <input type="hidden" name="start_tab_index" id="start_tab_index" value="0" />
</form>