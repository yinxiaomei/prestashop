<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="themeinfo">
    <div class="loading_overlay"></div>
    <?php echo $list; ?>
    <?php if (isset($themeinfo['blockmap']) && $themeinfo['blockmap']) : ?>
        <a class="blockmap_popup" rel="lightbox" title="<?php echo $themeinfo['blockdesc']; ?>" href="<?php echo $themeUri . $themeinfo['blockmap']; ?>" >View blocks map</a>      
    <?php endif; ?>
</div>
