<?php
if (!defined('_CAN_LOAD_FILES_'))
    exit;
?>
<link rel="stylesheet" href="<?php echo __PS_BASE_URI__ . "modules/" . $this->name . "/assets/admin/form.css"; ?>" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?php echo __PS_BASE_URI__ . "modules/" . $this->name . "/assets/admin/jquery_file_tree.css"; ?>" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?php echo __PS_BASE_URI__ . "modules/" . $this->name . "/assets/admin/farbtastic/farbtastic.css"; ?>" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="<?php echo __PS_BASE_URI__ . "modules/" . $this->name . "/assets/admin/farbtastic/farbtastic.js"; ?>"></script>
<script type="text/javascript" src="<?php echo __PS_BASE_URI__ . "modules/" . $this->name . "/assets/admin/form.js"; ?>"></script>
<script type="text/javascript" src="<?php echo __PS_BASE_URI__ . "modules/" . $this->name . "/assets/admin/jquery.dvc.minitab.js"; ?>"></script>
<script type="text/javascript" src="<?php echo __PS_BASE_URI__ . "modules/" . $this->name . "/assets/admin/jquery_file_tree.js"; ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {          
        $(function() {
            $( "#tabs" ).dvcTab({
                navCls: 'tabs-nav'
            });
        });	
        $(function(){
            $('.lof_tab').dvcTab();
        });          
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {    
        var root = $('#lof_hidden_image_root').val();
        $('#lof_folder_mainview').fileTree({ 
            root: root, 
            script: '<?php echo __PS_BASE_URI__ . "modules/" . $this->name . "/assets/admin/connectors/jquery_file_tree.php"; ?>' }, function(file) { 
            alert(file);
        });        
        jQuery('.it-addrow-block .add').each( function( idx , item ){    	  
            jQuery(item).bind('click',function(e){
                var name        = $(item).attr('id').replace('btna-','');            
                var div         = $('<div class="row"></div>');
                var spantext    = $('<span class="spantext"></span>');
                var span        = $('<span class="remove"></span>');
                var input       = $('<input type="text" name="'+name+'[]" value=""/>');
                var parent = $(item).parent().parent();
                div.append(spantext);
                div.append(input);
                div.append(span);
                parent.append(div);
                number = parent.find('input').length;                  
                spantext.html(parent.find('input').length);			
                span.bind('click',function(){ 
                    if( span.parent().find('input').value ) {
                        if( confirm('Are you sure to remove this') ) {
                            span.parent().remove(); 
                        }
                    } else {
                        span.parent().remove(); 
                    }				
                } );				 			
            });
        });
        jQuery('.it-addrow-block .remove').bind('click',function(events){	    
            parent = $(this).parent();        
            if( parent.find('input').value ) {
                if( confirm('Are you sure to remove this') ) {
                    parent.remove();
                }
            }else {
                parent.remove();
            }		
        });      
    });
</script>
<?php
$yesNoLang = array("0" => $this->l('No'), "1" => $this->l('Yes'));
$fileLangArr = array(
    "is_ena" => $this->l('Is Enabled'),
    "global_set" => $this->l('Content'),
    "title" => $this->l('Title'),
    "link" => $this->l('Link'),
    "content" => $this->l('Content'),
    "path_img" => $this->l('Image'),
    "classicon" => $this->l('Type of Icon'),
    "price" => $this->l('Price'),
    "desc" => $this->l('Description')
);
$languages = Language::getLanguages(true);
$lang = array();
$lang['auto'] = 'Auto Language';
$arrOder = array(
    'p.date_add' => $this->l('Date Add'),
    'p.date_add DESC' => $this->l('Date Add DESC'),
    'name' => $this->l('Name'),
    'name DESC' => $this->l('Name DESC'),
    'quantity' => $this->l('Quantity'),
    'quantity DESC' => $this->l('Quantity DESC'),
    'p.price' => $this->l('Price'),
    'p.price DESC' => $this->l('Price DESC')
);
foreach ($languages AS $language) {
    $lang[$language['id_lang']] = $language['name'];
}

$fileOption = array(
    "enable" => $yesNoLang,
    "type" => array("none" => $this->l('No Type'), "new" => $this->l('New'), "sale" => $this->l('Sale'), "feature" => $this->l('feature'))
);
?>

<div class="lof-back-office">
    <h3><?php echo $this->l('Lof Mini Gallery Configuration'); ?></h3>
    <form action="<?php echo $_SERVER['REQUEST_URI'] . '&rand=' . rand(); ?>" enctype="multipart/form-data" method="post" id="lofform">
        <input type="submit" name="submit" value="<?php echo $this->l('Update'); ?>" class="button" />
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1" ><?php echo $this->l('Global'); ?></a></li>
                <li><a href="#tabs-2" ><?php echo $this->l('Images'); ?></a></li>
                <li><a href="#tabs-3"><?php echo $this->l('Gallery Option'); ?></a></li>
                <li><a href="#tabs-4"><?php echo $this->l('Information'); ?></a></li>
            </ul>    
            <div id="tabs-1">
                <div class="lof_config_wrrapper clearfix">
                    <ul>
                        <?php
                        echo $this->_params->inputTag("md_title", $this->getParamValue("md_title", 'Images Gallery'), $this->l('Module title'), 'class="text_area"', 'class="row"', '');
                        echo $this->_params->radioBooleanTag("show_title", $yesNoLang, $this->getParamValue("show_title", 0), $this->l('Show title'), 'class="select-option"', 'class="row"', '', $this->l('show/hide module title'));
                        echo $this->_params->inputTag("md_width", $this->getParamValue("md_width", 195), $this->l('Module Width'), 'class="text_area"', 'class="row"', '');
                        echo $this->_params->selectTag("module_theme", $themes, $this->getParamValue("module_theme", 'basic'), $this->l('Theme - Layout'), 'class="inputbox"', 'class="row" title="' . $this->l('Select a theme') . '"');
                        echo $this->_params->selectTag("module_group", $groups, $this->getParamValue("module_group", 'product'), $this->l('Select Group'), 'class="inputbox select-group"', 'class="row" title="' . $this->l('Select a group') . '"');
                        echo $this->_params->inputTag("readmore_txt", $this->getParamValue("readmore_txt", '[More...]'), $this->l('Readmore text'), 'class="text_area"', 'class="row"', '');
                        ?>      	                   	        
                        <li class="row module_group-product">
                            <div class="lof_group_options_header"><h3><?php echo $this->l('Group Product Options'); ?></h3></div>
                            <?php
                            //echo $this->_params->lofGroupTag($this->l('Group Product'), "lof-group");

                            $homeSorceArr = array("selectcat" => $this->l('Select category'), "homefeatured" => $this->l('Home Featured'), "productids" => $this->l('Product IDs'));
                            echo $this->_params->selectTag("home_sorce", $homeSorceArr, $this->getParamValue("home_sorce", "selectcat"), $this->l('Get Product From'), 'class="inputbox select-group"', '', 'class="row"');
                            echo $this->_params->getCategory("category[]", $this->getParamValue("category", ""), $this->l('Select category'), 'size="10" multiple="multiple" style="width: 90%;" class="inputbox"', '', 'class="row home_sorce-selectcat"', '', $this->l('All Categories'));
                            echo $this->_params->selectTag("order_by", $arrOder, $this->getParamValue("order_by", "p.date_add"), $this->l('Order By'), 'class="inputbox select-group"', '', 'class="row home_sorce-selectcat"');
                            echo $this->_params->inputTag("limit_items", $this->getParamValue("limit_items", "12"), $this->l('Limit items'), 'class="text_area"', '', 'class="home_sorce-selectcat"');
                            echo $this->_params->inputTag("des_limit", $this->getParamValue("des_limit", "500"), $this->l('Limit description(on characters)'), 'class="text_area"', '', 'class="home_sorce-selectcat"');
                            echo $this->_params->inputTag("timenewslide", $this->getParamValue("timenewslide", "2"), $this->l('Time to set new product(Days, Ex: 2)'), 'class="text_area"', '', '', $this->l('Disable with the value as 0 or null.'));
                            echo $this->_params->inputTag("productids", $this->getParamValue("productids", "1,2,3,4,5"), $this->l('Product IDs'), 'class="text_area"', '', 'class="home_sorce-productids"');
                            ?>
                        </li>
                        <li class="row module_group-custom">
                            <div class="lof_group_options_header"><h3><?php echo $this->l('Group Custom Options'); ?></h3></div>
                            <?php
                            echo "<br/>";
                            echo $this->_params->inputTag("custom-num", $this->getParamValue("custom-num", 5), $this->l('Number of Article'), 'class="text_area"', '', 'class="row"');
                            echo "<br/>";
                            ?>
                            <div id="gci_tab" class="lof_tab">
                                <ul>
                                    <?php
                                    foreach ($languages as $lan) {
                                        ?>
                                        <li><a href="#gci_tab<?php echo $lan["id_lang"]; ?>"><?php echo $lan["name"]; ?></a></li>
                                        <?php
                                    }
                                    ?>                   
                                </ul>
                                <?php
                                foreach ($languages as $lan) {
                                    ?>
                                    <div id="gci_tab<?php echo $lan["id_lang"]; ?>" class="image_info_contain">
                                        <?php
                                        for ($i = 1; $i <= $this->getParamValue("custom-num", 5); $i++) {
                                            $name = 'gci_' . $lan["id_lang"] . "-" . $i;
                                            $fileValues = array(
                                                "enable" => $this->getParamValue($name . "-enable", 0),
                                                "image" => $this->getParamValue($name . "-image", ""),
                                                "link" => $this->getParamValue($name . "-link", ""),
                                                "desc" => $this->getParamValue($name . "-desc", ""),
                                                "title" => $this->getParamValue($name . "-title", ""),
                                                "price" => $this->getParamValue($name . "-price", ""),
                                                "classicon" => $this->getParamValue($name . "-type", "")
                                            );
                                            echo $this->_params->fileTag($name, $fileOption, $fileValues, $fileLangArr, $this->l('Article') . ' ' . $i, 'class="text_area"', '', 'class="lof-config-full"');
                                        }
                                        ?>
                                    </div>                                            
                                    <?php
                                }
                                ?>
                            </div>   
                        </li>   
                        <li class="row module_group-folder">
                            <div class="lof_group_options_header"><h3><?php echo $this->l('Group Folder Options'); ?></h3></div>
                            <?php
                            echo $this->_params->browerFolder("folder_path", $this->getParamValue("folder_path", ''), $this->l('Images Folder'), $this->_path . 'assets/admin/images/open.png', 'popup_container', '', 'class="row"');
                            ?> 
                            <div class="lof_group_folder_no_file">                                   
                                <a href="javascript:void(0)" onClick="addFileInput()" name="btn_add_file" id="btn_add_file" ><?php echo $this->l('Add Image'); ?></a>
                                <ul id="upload_list">
                                    <li><span>File 1 : </span><input type="file" name="upload_image_gfi_1" value="" /> </li>
                                </ul>
                                <input type="hidden" id="count_files" name="count_files" value="1" id="count_file" />
                                <input type="submit" id="upload_images" name="submit" value="<?php echo $this->l('Upload All'); ?>" class="button" />
                            </div>   
                            <div class="clearfix" ></div>
                            <div id="gfi_tab" class="lof_tab">
                                <ul>
                                    <?php
                                    foreach ($languages as $lan) {
                                        ?>
                                        <li><a href="#gfi_tab<?php echo $lan["id_lang"]; ?>"><?php echo $lan["name"]; ?></a></li>
                                        <?php
                                    }
                                    ?>                   
                                </ul>
                                <br />                              
                                <?php
                                $image_path = _PS_ROOT_DIR_ . '/' . $this->getParamValue('folder_path', 'img/');
                                $image_url = __PS_BASE_URI__ . $this->getParamValue('folder_path', 'img/');
                                $gfi_images = $this->getFilesFromFolder($image_path);
                                $imageNum = intval(count($gfi_images));
                                if ($imageNum > 0) {
                                    foreach ($languages as $lan) {
                                        ?>
                                        <div id="gfi_tab<?php echo $lan["id_lang"]; ?>" class="image_info_contain">
                                            <?php
                                            foreach ($gfi_images as $i => $image) {
                                                $name = 'gfi_' . $lan["id_lang"] . "-" . $i;
                                                $fileValues = array(
                                                    "enable" => $this->getParamValue($name . "-enable", 0),
                                                    "image" => $image_url . $image,
                                                    "link" => $this->getParamValue($name . "-link", ""),
                                                    "desc" => $this->getParamValue($name . "-desc", ""),
                                                    "title" => $this->getParamValue($name . "-title", ""),
                                                    "price" => $this->getParamValue($name . "-price", ""),
                                                    "classicon" => $this->getParamValue($name . "-type", "")
                                                );
                                                echo $this->_params->imageInfoTag($name, $fileOption, $fileValues, $fileLangArr, $image);
                                            }
                                            ?>
                                        </div>                                            
                                        <?php
                                    }
                                }
                                ?>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="tabs-2">
                <div class="lof_config_wrrapper clearfix">
                    <ul>
                        <?php
                        echo $this->_params->radioBooleanTag("cre_main_size", $yesNoLang, $this->getParamValue("cre_main_size", 0), $this->l('Create Size of Main Image'), 'class="select-option"', 'class="row"', '', $this->l('You can create a new size or use available size.'));
                        $mainImgSize = array();
                        //echo "<pre>";print_r($formats);die;
                        foreach ($formats as $k => $format):
                            $mainImgSize[$format['name']] = $format['name'] . '(' . $format['width'] . "x" . $format['height'] . ')';
                        endforeach;
                        echo $this->_params->selectTag("main_img_size", $mainImgSize, $this->getParamValue("main_img_size", "thickbox_default"), $this->l('Main Image Size'), 'class="inputbox select-group"', 'class="row cre_main_size-0"', '', $this->l('You can create a new size via Menu <b>Preferences/Image</b>.'));
                        echo $this->_params->inputTag("main_height", $this->getParamValue("main_height", 600), $this->l('Main Image Height'), 'class="text_area"', 'class="row cre_main_size-1"', '');
                        echo $this->_params->inputTag("main_width", $this->getParamValue("main_width", 600), $this->l('Main Image Width'), 'class="text_area"', 'class="row cre_main_size-1"', '');
                        echo $this->_params->radioBooleanTag("cre_thumb", $yesNoLang, $this->getParamValue("cre_thumb", 1), $this->l('Create Size of thumbnail'), 'class="select-option"', 'class="row"', '', $this->l('You can create a new size or use main image size.'));
                        echo $this->_params->inputTag("thumb_height", $this->getParamValue("thumb_height", 55), $this->l('Thumbnail Height'), 'class="text_area"', 'class="row"', '');
                        echo $this->_params->inputTag("thumb_width", $this->getParamValue("thumb_width", 58), $this->l('Thumbnail Width'), 'class="text_area"', 'class="row"', '');
                        ?>
                    </ul>
                </div>
            </div>
            <br />        
            <?php
            //prepare some data :
            //options of Ainimation Speed :
            $animationSpeedOptions = array(
                'slow' => 'Slow',
                'normal' => 'Normal',
                'fast' => 'Fast'
            );

            //options of popup themes :
            $themeOptions = array(
                'light_rounded' => 'Light rounded',
                'dark_rounded' => 'Dark rounded',
                'light_square' => 'Light square',
                'dark_square' => 'Dark square',
                'facebook' => 'Facebook',
            );
            $trueFalseLang = array('false' => $this->l('No'), 'true' => $this->l('Yes'));

            //options of thumbnails theme :
            $thumbThemeOptions = array(
                'dark' => 'Dark',
                'light' => 'Light'
            );
            ?>
            <div id="tabs-3">
                <div class="lof_config_wrrapper clearfix">
                    <ul>
                        <?php
                        echo $this->_params->radioBooleanTag("autoplay", $trueFalseLang, $this->getParamValue("autoplay", 'false'), $this->l('Auto play'), 'class="select-option"', 'class="row"');
                        echo $this->_params->selectTag("a_speed", $animationSpeedOptions, $this->getParamValue("a_speed", "normal"), $this->l('Animation speed'), 'class="inputbox select-group"', 'class="row"');
                        echo $this->_params->selectTag("g_theme", $themeOptions, $this->getParamValue("g_theme", "dark_rounded"), $this->l('Popup theme'), 'class="inputbox select-group"', 'class="row"');
                        echo $this->_params->selectTag("gthumb_theme", $thumbThemeOptions, $this->getParamValue("gthumb_theme", "light"), $this->l('Thumbnails theme'), 'class="inputbox select-group"', 'class="row"');
                        echo $this->_params->inputTag("slideshow", $this->getParamValue("slideshow", 3000), $this->l('Slide speed'), 'class="text_area"', 'class="row"', '');
                        ?>
                    </ul>
                </div>
            </div>        
            <div id="tabs-4">            
                <ul class="module_infor">
                    <li>+ <a target="_blank" href="http://landofcoder.com/prestashop/slider/lof-slideshowpro.html"><?php echo $this->l('Detail Information'); ?></li>
                    <li>+ <a target="_blank" href="http://landofcoder.com/supports/forum.html?id=78"><?php echo $this->l('Forum support'); ?></a></li>
                    <li>+ <a target="_blank" href="http://www.landofcoder.com/submit-request.html"><?php echo $this->l('Customization/Technical Support Via Email'); ?>.</a></li>
                    <li>+ <a target="_blank" href="http://landofcoder.com/prestashop/guides/lof-slideshow-pro"><?php echo $this->l('UserGuide '); ?></a></li>
                    <li>+ @Copyright: <a target="_blank" href="http://www.facebook.com/LeoTheme">leotheme.com</a></li>
                    <li>+ <a target="_blank" href="http://www.facebook.com/LeoTheme">Like us on Facebook</a></li>
                    <li>+ <a target="_blank" href="https://twitter.com/#!/leotheme">Follow us on Twitter</a></li>
                </ul>
            </div> 
        </div>
        <input type="submit" name="submit" value="<?php echo $this->l('Update'); ?>" class="button" />
    </form>
</div>
<input type="hidden" id="lof_hidden_image_root" name="lof_hidden_image_root" value="<?php echo _PS_ROOT_DIR_ . '/'; ?>" />
<div id="popup_container">
    <div id="lof_folder_mainview">There's not any folder or file !</div>
    <div class="popup_panel">
        <label>Directory Path</label>
        <span id="path_info" ></span>
        <input type="button" name="btn_get_info" onClick="getInfo('#params_folder_path');" id="btn_get_info" class="popup_browser_button" value="<?php echo $this->l('Ok'); ?>" />
        <input type="button" name="btn_get_info" onClick="closePopup('#popup_container');" id="btn_cancel_info" class="popup_browser_button" value="<?php echo $this->l('Cancel'); ?>" />
    </div>
</div>
<div id="overlay_back_office" class="popup_overlay"></div>
