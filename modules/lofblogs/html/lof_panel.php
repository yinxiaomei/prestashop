<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$last = count($subTabs) - 1;
?>
<?php if($newRelease) : ?>
<div class="update_notice">
    New Release Version <span><?php echo $newRelease['release']; ?></span> is now available
    <a href="<?php echo $newRelease['download']; ?>" title="Lof Blog Update" >Download Now</a>
</div>
<?php endif; ?>
<h2 class="pageTitleHome">Lof Blogs Dashboard</h2>
<div class="lofcontent_panel">
    <h3>Control Panel</h3>
    <ul class="panel_tabs_list">
        <?php foreach ($subTabs as $k =>$tab) : 
            if($k == 0) {
                $class = 'class="first"';
            } elseif($k == $last) {
                $class = 'class="last"';
            } else {
                $class = '';
            }
         ?>
            <li <?php echo $class; ?> >                
                <a href="<?php echo $tab['link']; ?>" title="<?php echo $tab['title']; ?>" >
                    <img src="<?php echo $tab['image']; ?>" />
                    <div class="clearfix"></div>
                    <span><?php echo $tab['title']; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="lofcontent_copyright">Lof Blogs manager 1.1 &copy; <a href="http://landofcoder.com/" title="joomla, prestashop extentsion and template">LandOfcoder</a> all rights reserved</div>
<div class="clearfix"></div>