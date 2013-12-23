<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form action="<?php echo $formAction; ?>" method="post" enctype="multipart/form-data">
    <div class="lofcontent_themes_manager">        
        <div class="theme_installer">
            <h3 class="lofcontent_theme_item_header"><?php echo $lofAdminHtml->l('Install new theme'); ?></h3>
            <div class="lofcontent_theme_wrapper">
                <input type="file" name="file" value="" />
                <input type="submit" name="installTheme" value="Install" />
            </div>
        </div>

        <div class="theme_uninstaller">
            <h3 class="lofcontent_theme_item_header"><?php echo $lofAdminHtml->l('Installed themes'); ?></h3>
            <div class="lofcontent_theme_wrapper">
                <?php if (is_array($themesInfo) && count($themesInfo)) : ?>
                    <?php foreach ($themesInfo as $key => $theme) : ?>
                        <div class="lofcontent_theme_item">                            
                            <p class="theme_title"><?php echo $theme['info']['name']; ?>   <span><?php echo $lofAdminHtml->l('Version') . ' ' . $theme['info']['version']; ?></span></p>
                            <p class="theme_copyright"><?php echo $lofAdminHtml->l('Created by '); ?> <span><?php echo $theme['info']['author']; ?></span> <?php echo $lofAdminHtml->l('at') . ' ' . $theme['info']['date'] ?></p>
                            <p><?php echo $lofAdminHtml->l('Blocks position'); ?> : <?php echo implode(', ', $theme['blocks']); ?></p>
                            <p class="theme_desc"><?php echo $theme['info']['description'] ?></p>
                            <?php if (trim($key) != 'default') : ?>
                                <a class="lofcontent_theme_button" href="<?php echo $removeBaseLink.trim($key); ?>" >Delete</a>
                            <?php else: ?>
                                <div id="disable_button" class="lofcontent_theme_button"><?php echo $lofAdminHtml->l('Can not delete default theme'); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</form>