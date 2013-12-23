<?php

/**
 * $ModDesc
 * 
 * @version		$Id: file.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */
if (!defined('_CAN_LOAD_FILES_')) {
    define('_CAN_LOAD_FILES_', 1);
}

/**
 * lofcordion Class
 */
class lofminigallery extends Module {

    /**
     * @var LofParams $_params;
     *
     * @access private;
     */
    private $_params = '';

    /**
     * @var array $_postErrors;
     *
     * @access private;
     */
    private $_postErrors = array();
    /**
     * @var string $__tmpl is stored path of the layout-theme;
     *
     * @access private 
     */

    /**
     * Constructor 
     */
    function __construct() {
        $this->name = 'lofminigallery';
        parent::__construct();
        $this->tab = 'LandOfCoder';
        $this->version = '1.0';
        $this->displayName = $this->l('Lof Mini Gallery Module');
        $this->description = $this->l('display product images or some images you want in a nice template');
        if (file_exists(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/params.php') && !class_exists("LofParams", false)) {
            if (!defined("LOF_SLIDE_SHOW_LOAD_LIB_PARAMS")) {
                require( _PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/params.php' );
                define("LOF_SLIDE_SHOW_LOAD_LIB_PARAMS", true);
            }
        }
        $this->_params = new LofParams($this->name);
        $this->confirmUninstall = $this->l('OooP ! do u realy wanna to uninstall it?');
    }

    /**
     * process installing 
     */
    function install() {
        if (!parent::install())
            return false; 
        if (!$this->registerHook('header'))
            return false;
        return true;
    }

    /*
     * Add Position for site
     */

    function hooklofPresDemo($params) {
        return $this->processHook($params, "lofPresDemo");
    }

    /*
     * register hook right comlumn to display slide in right column
     */

    function hookrightColumn($params) {
        return $this->processHook($params, "rightColumn");
    }

    /*
     * register hook left comlumn to display slide in left column
     */

    function hookleftColumn($params) {
        return $this->processHook($params, "leftColumn");
    }

    function hooktop($params) {
        return '</div><div class="clearfix">' . $this->processHook($params, "top");
    }

    function hookfooter($params) {
        return $this->processHook($params, "footer");
    }

    function hookcontenttop($params) {
        return $this->processHook($params, "contenttop");
    }

    function hookHeader($params) {
        if (_PS_VERSION_ <= "1.4") {
            $header = '<link type="text/css" rel="stylesheet" href="' . ($this->_path) . 'assets/style.css' . '" />
			 		   <link type="text/css" rel="stylesheet" href="' . ($this->_path) . 'tmpl/' . $this->getParamValue('module_theme', 'basic') . '/assets/style.css' . '" />
			           <script type="text/javascript" src="' . ($this->_path) . 'assets/jlofScripts.js' . '"></script>';
            return $header;
        } elseif (_PS_VERSION_ < "1.5"){
            Tools::addCSS(($this->_path) . 'assets/style.css', 'all');
            Tools::addCSS(($this->_path) . 'tmpl/' . $this->getParamValue('module_theme', 'basic') . '/assets/style.css', 'all');
            Tools::addJS(($this->_path) . 'assets/jquery.prettyPhoto.js', 'all');
            Tools::addCSS(($this->_path) . 'assets/css/prettyPhoto.css', 'all');
        } else{
            $this->context->controller->addCSS(($this->_path) . 'assets/style.css', 'all');
            $this->context->controller->addCSS(($this->_path) . 'tmpl/' . $this->getParamValue('module_theme', 'basic') . '/assets/style.css', 'all');
            $this->context->controller->addJS(($this->_path) . 'assets/jquery.prettyPhoto.js', 'all');
            $this->context->controller->addCSS(($this->_path) . 'assets/css/prettyPhoto.css', 'all');
        }
    }

    function hooklofTop($params) {
        return $this->processHook($params, "lofTop");
    }

    function hookHome($params) {
        return $this->processHook($params, "home");
    }

    function hooklofslide1($params) {
        return $this->processHook($params, "lofslide1");
    }

    function hooklofslide2($params) {
        return $this->processHook($params, "lofslide2");
    }

    function hooklofslide3($params) {
        return $this->processHook($params, "lofslide3");
    }

    function hooklofslide4($params) {
        return $this->processHook($params, "lofslide4");
    }

    function getListCatId($parent_id) {
        global $cookie, $link;
        $id_lang = intval($cookie->id_lang);
        $query = 'SELECT c.`id_category`, c.`id_parent`, cl.`name`, cl.`description`, cl.`link_rewrite`' .
                ' FROM `' . _DB_PREFIX_ . 'category` c' .
                ' LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON cl.`id_category` = c.`id_category` ' .
                ' WHERE c.id_category IN (' . $parent_id . ') GROUP BY id_category';
        $result = Db::getInstance()->ExecuteS($query);
        return $result;
    }

    /**
     * get list of subcategories by id
     */
    function getListCategories($params, $idds) {
        global $cookie, $link;
        $id_lang = intval($cookie->id_lang);
        $ids = implode(",", $idds);
        $cate = array();
        $query = 'SELECT c.`id_category`, c.`id_parent`, cl.`name`, cl.`description`, cl.`link_rewrite`' .
                ' FROM `' . _DB_PREFIX_ . 'category` c' .
                ' LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON cl.`id_category` = c.`id_category` ' .
                ' WHERE c.id_category IN (' . $ids . ') GROUP BY id_category';
        $data = Db::getInstance()->ExecuteS($query);
        $ids = array();
        return $data;
    }

    /**
     * Proccess module by hook
     * $pparams: param of module
     * $pos: position call
     */
    function processHook($params) {
        global $smarty, $cookie;
        //load param
        $params = $this->_params;
        $site_url = Tools::htmlentitiesutf8('http://' . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__);
        if (_PS_VERSION_ <= "1.4") {
            // create thumbnail folder	 						
            $thumbPath = _PS_IMG_DIR_ . $this->name;
            if (!file_exists($thumbPath)) {
                mkdir($thumbPath, 0777);
            };
            $thumbUrl = $site_url . "img/" . $this->name;
        } else {
            // create thumbnail folder	 			
            $thumbPath = _PS_CACHEFS_DIRECTORY_ . $this->name;
            if (!file_exists(_PS_CACHEFS_DIRECTORY_)) {
                mkdir(_PS_CACHEFS_DIRECTORY_, 0777);
            };
            if (!file_exists($thumbPath)) {
                mkdir($thumbPath, 0777);
            };
            $thumbUrl = $site_url . "cache/cachefs/" . $this->name;
        }
        if (file_exists(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/group_base.php') && !class_exists("LofMiniGalleryDataSourceBase", false)) {
            if (!defined("LOF_MINI_GALLERY_LOAD_LIB_GROUP")) {
                require_once( _PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/group_base.php' );
                define("LOF_MINI_GALLERY_LOAD_LIB_GROUP", true);
            }
        }
        if (file_exists(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/phpthumb/ThumbLib.inc.php') && !class_exists('PhpThumbFactory', false)) {
            if (!defined("LOF_MINI_GALLERY_LOAD_LIB_PHPTHUMB")) {
                require( _PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/phpthumb/ThumbLib.inc.php' );
                define("LOF_MINI_GALLERY_LOAD_LIB_PHPTHUMB", true);
            }
        }
        /*
         * Config Param
         */
        $pparam = '';
        $imgFolder = _PS_IMG_DIR_ . $this->name;

        $moduleId = rand() . time();
        $moduleHeight = $params->get("md_height", 250);
        $moduleWidth = $params->get("md_width", 195);
        $theme = $params->get("module_theme", "basic");
        $target = $params->get('target', '_self');
        $class = $params->get('navigator_pos', 0) ? '' : 'lof-snleft';
        $blockid = $this->id;
        $limititem = $params->get("limit_items", 9);
        $showPrice = $params->get("show_price", 1);
        $showTipBox = $params->get("show_box_tips", 1);
        $thumbmainWidth = $params->get('main_width', 600);
        $thumbmainHeight = $params->get('main_height', 600);
        $thumbnailWidth = $params->get('thumb_width', 58);
        $thumbnailHeight = $params->get('thumb_height', 55);
        $image_path = _PS_ROOT_DIR_ . '/' . $params->get('folder_path');
        $speed = $params->get('speed', 200);
        $params->set('auto_renderthumb', 0);
        $selectCat = $params->get("category", "");
        $token = Tools::getToken(false);
        $source = $params->get('module_group', 'product');
        if (strtolower($source) == 'folder') {
            $pparam = $this->getFilesFromFolder($image_path);
        }
        $path = dirname(__FILE__) . '/libs/groups/' . strtolower($source) . "/" . strtolower($source) . '.php';
        if (!file_exists($path)) {
            return array();
        }
        require_once $path;
        //require_once $path;
        $objectName = "LofMiniGallery" . ucfirst($source) . "DataSource";
        $object = new $objectName();
        $object->setThumbPathInfo($thumbPath, $thumbUrl)
                ->setImagesRendered(array('mainImage' => array((int) $params->get('main_width', 550), (int) $params->get('main_height', 250))));
        $products = $object->getListByParameters($params, $pparam);

        $total = count($products);


        $widthDesc = $moduleWidth - $thumbmainWidth - 35;
        /*
         * Add check status of products
         */
        $curLang = Language::getLanguage(intval($cookie->id_lang));


        /*
         * End check status of products
         */
        $module_content = '';
        ob_start();
        require( dirname(__FILE__) . '/tmpl/' . $this->getParamValue('module_theme', 'basic') . '/_content.php' );
        $module_content = ob_get_contents();
        ob_end_clean();
        $lofScript = '';
        ob_start();
        require( dirname(__FILE__) . '/initjs.php' );
        $lofScript = ob_get_contents();
        ob_end_clean();

        // template asignment variables
        $smarty->assign(array(
            'moduleId' => $moduleId,

            'source' => $source,
            'module_content' => $module_content,
            'lofScript' => $lofScript,
            'viewDetail' => $params->get('view_detail', 1),
            'object' => $object,
            'showAddCart' => $params->get('add_cart', 1),
            'showDesc' => $params->get("show_desc", 1),
            'showPrice' => $showPrice,
            'perPage' => $params->get("per_page", 4),
            'speed' => $speed,
            'showCaption' => $params->get('show_caption', 1),
            'widthTooltip' => $params->get('width_tooltip', 160),
            'moduleHeight' => $moduleHeight,
            'moduleWidth' => $moduleWidth,
            'autoPlay' => $params->get('auto_play', 0),
            'theme' => $theme,
            'limititem' => $limititem,
            'lofSpeed' => $params->get('lof_speed', 2000),
            'lofDuration' => $params->get('lof_duration', 500),
            'thumbnailWidth' => $thumbnailWidth,
            'thumbnailHeight' => $thumbnailHeight,
            'lofeffect' => $params->get('lofeffect', ""),
            'showIconItem' => $params->get('show_icon', 1),
            'params' => $params,
            'miniproducts' => $products,
            'site_url' => $site_url,
            'token' => $token,
            'checkVersion' => _PS_VERSION_,
            'target' => $target,
            'captionWidth' => $params->get('caption_width', 250),
            'postCaption' => $params->get('pos_caption', 'lof-cap-bottom'),
            'showTooltip' => $params->get("show_tooltip", 1),
            'showButton' => $params->get('show_button', 1),
            'showDate' => $params->get("show_date", 1),
            'showTitle' => $params->get("show_title", 0),
            'moduleTitle' => $params->get('md_title', 'Images Gallery'),
            'thumbTheme' => $params->get('gthumb_theme', 'light')
        ));

        return $this->display(__FILE__, $this->getLayoutPath($theme)) . $lofScript;
    }

    public function getLayoutPath($theme) {
        $layout = 'tmpl/' . $theme . '/default.tpl';
        if( file_exists(_PS_MODULE_DIR_.$this->name."/".$layout)){
            return $layout;
        }
        return 'tmpl/default.tpl';
    }

    public function splitingCols($products) {
        return $output;
    }

    /**
     * Get list of sub folder's name 
     */
    public function getFolderList($path) {
        $items = array();
        $handle = opendir($path);
        if (!$handle) {
            return $items;
        }
        while (false !== ($file = readdir($handle))) {
            if (is_dir($path . $file))
                $items[$file] = $file;
        }
        unset($items['.'], $items['..'], $items['.svn']);
        return $items;
    }

    function getFilesFromFolder($path) {
        $items = array();
        $handle = opendir($path);
        if (!$handle) {
            return $items;
        }
        while (false !== ($file = readdir($handle))) {

            if ($this->isImages($file)) {
                $items[] = $file;
            }
        }
        return $items;
    }

    /**
     * 10/04/2012 Added by Risk
     * @todo check if file is a standard image
     * @param type $file
     * @param type $allowed
     * @param type $disallowed
     * @return type 
     */
    function isImages($file, $allowed=array('png', 'jpg', 'gif'), $disallowed=array('.', '..', '.svn')) {
        if (!is_dir($file) && !in_array($file, $disallowed)) {
            $ext = preg_replace('/^.*\./', '', $file);
            if (in_array($ext, $allowed)) {
                return true;
            } else
                return false;
        } else {
            return false;
        }
    }

    /**
     * Render processing form && process saving data.
     */
    public function getContent() {
        $html = "";
        if (Tools::isSubmit('submit')) {

            $this->_postValidation();

            if (!sizeof($this->_postErrors)) {
                $definedConfigs = array(
                    /* general config */
                    'module_theme' => '',
                    'readmore_txt' => '',
                    //image group
                    'module_group' => 'product',
                    'image_folder' => '',
                    'image_category' => '',
                    'image_ordering' => '',
                    'cre_main_size' => '',
                    'main_img_size' => '',
                    'main_height' => '',
                    'main_width' => '',
                    'cre_thumb' => '',
                    'thumb_height' => '',
                    'thumb_width' => '',
                    'folder_path' => 'img/',
                    //product group
                    'home_sorce' => '',
                    'order_by' => '',
                    'des_limit' => '',
                    'publicfixicon' => '',
                    'productids' => '',
                    'show_caption' => '',
                    'show_icon' => '',
                    'limit_cols' => '',
                    'per_page' => '',
                    'speed' => '200',
                    'md_width' => '',
                    'view_detail' => 'View',
                    'width_tooltip' => '',
                    'limit_items' => '',
                    /* Navigator Setting */
                    'show_price' => '',
                    'show_title' => '',
                    'show_date' => '',
                    'timenewslide' => '',
                    /* Gallery Setting */
                    'a_speed' => '',
                    'g_theme' => '',
                    'slideshow' => '',
                    'autoplay' => '',
                    'gthumb_theme' => '',
                    /* Customize Style */
                    'show_title' => '',
                    'md_title' => '',
                    'enable_caption' => '',
                    'caption_bg' => '',
                    'cap_opacity' => '',
                    'cap_fontcolor' => '',
                    'cap_linkcolor' => '',
                    'price_color' => '',
                    'pos_caption' => '',
                    'caption_width' => '',
                    'show_price' => '',
                    'custom-num' => '',
                    'file_path' => ''
                );
                $listarticle = Tools::getValue('custom-num');
                $languages = Language::getLanguages();
                $image_path = _PS_ROOT_DIR_ . '/' . $this->getParamValue('folder_path');
                $image_url = __PS_BASE_URI__ . $this->getParamValue('folder_path', 'img/');
                $gfi_images = $this->getFilesFromFolder($image_path);
                $deleteFiles = Tools::getValue('remove_images');

                //delete images :
                if (is_array($deleteFiles) && count($deleteFiles) > 0) {
                    foreach ($deleteFiles as $file) {
                        unlink($image_path . $file);
                    }
                }

                //upload file for group "Folder" :
                $baseName = 'upload_image_gfi';
                $countFiles = Tools::getValue('count_files');
                $this->_lofUploadFlexibleFile($image_path, $baseName, $countFiles);


                foreach ($languages as $lan) {

                    //update group custom image value with lofname is 'gci' :
                    for ($i = 1; $i <= $listarticle; $i++) {
                        $name = 'gci_' . $lan["id_lang"] . "-" . $i;
                        //upload file
                        if (isset($_FILES[$name . "-image"]['name']) && $_FILES[$name . "-image"]['name'] != NULL) {

                            $result = $this->_lofUpload($name . "-image");
                            if ($result) {
                                $imgFolder = _PS_IMG_DIR_ . $this->name;
                                $imgFolder = str_replace(_PS_ROOT_DIR_, "", $imgFolder);
                                $imageLink = __PS_BASE_URI__ . $imgFolder . "/" . $result;
                                $imageLink = str_replace("//", "/", $imageLink);

                                $_POST[$name . "-image"] = $imageLink;
                                $definedConfigs[$name . "-image"] = '';
                            } else {
                                $html .= "<div>" . $this->l("Can't upload file in article") . " " . $i . "</div>";
                            }
                        }
                        $definedConfigs[$name . "-image"] = "";
                        $definedConfigs[$name . "-title"] = "";
                        $definedConfigs[$name . "-link"] = "";
                        $definedConfigs[$name . "-desc"] = "";
                    }
                    //update group folder images value :                                        
                    foreach ($gfi_images as $k => $image) {
                        echo $image_url . $image . '<br />';
                        $name = 'gfi_' . $lan["id_lang"] . "-" . $k;
                        $definedConfigs[$name . "-image"] = $image_url . $image;
                        $definedConfigs[$name . "-title"] = "";
                        $definedConfigs[$name . "-link"] = "";
                        $definedConfigs[$name . "-desc"] = "";
                    }
                }

                $specialParams = array('folder_path');
                foreach ($definedConfigs as $config => $key) {
                    if (in_array($config, $specialParams)) {
                        $value = $_POST[$config];
                    } else {
                        $value = Tools::getValue($config);
                    }
                    Configuration::updateValue($this->name . '_' . $config, $value, true);
                }

                if (Tools::getValue('category')) {
                    if (in_array("", Tools::getValue('category'))) {
                        $catList = "";
                    } else {
                        $catList = implode(",", Tools::getValue('category'));
                    }
                    Configuration::updateValue($this->name . '_category', $catList, true);
                }
                $linkArray = Tools::getValue('override_links');
                if ($linkArray) {
                    foreach ($linkArray as $key => $value) {
                        if (is_null($value) || $value == "") {
                            unset($linkArray[$key]);
                        }
                    }
                    $override_links = implode(",", $linkArray);
                    Configuration::updateValue($this->name . '_override_links', $override_links, true);
                }
                $delText = '';
                if (Tools::getValue('delCaImg')) {
                    if (_PS_VERSION_ <= "1.4") {
                        $cacheFol = _PS_IMG_DIR_ . $this->name;
                    } else {
                        $cacheFol = _PS_CACHEFS_DIRECTORY_ . $this->name;
                    }
                    if (file_exists(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/group_base.php') && !class_exists("LofMiniGalleryDataSourceBase", false)) {
                        if (!defined("LOF_MINI_GALLERY_LOAD_LIB_GROUP")) {
                            require_once( _PS_ROOT_DIR_ . '/modules/' . $this->name . '/libs/group_base.php' );
                            define("LOF_MINI_GALLERY_LOAD_LIB_GROUP", true);
                            die('File is included');
                        }
                    }
                    if (LofDataSourceBase::removedir($cacheFol)) {
                        $delText = $this->l('. Cache folder has been deleted');
                    } else {
                        $delText = $this->l('. Cache folder can\'tdeleted');
                    }
                }
                $html .= '<div class="conf confirm">' . $this->l('Settings updated') . $delText . '</div>';
            } else {
                foreach ($this->_postErrors AS $err) {
                    $html .= '<div class="alert error">' . $err . '</div>';
                }
            }
            // reset current values.
            $this->_params = new LofParams($this->name);
        }
        return $html . $this->_getFormConfig();
    }

    private function _lofUpload($name) {
        if (isset($_FILES[$name]['name']) && $_FILES[$name]['name'] != NULL) {
            $ext = substr($_FILES[$name]['name'], strrpos($_FILES[$name]['name'], '.') + 1);
            $attachFileTypes = array("jpg", "bmp", "gif", "png");
            if (in_array($ext, $attachFileTypes)) {
                $uploadFolder = _PS_IMG_DIR_ . $this->name;
                if (!is_dir($uploadFolder)) {
                    mkdir($uploadFolder, 0777);
                }
                if (@move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFolder . "/" . $_FILES[$name]["name"])) {
                    return $_FILES[$name]["name"];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    private function _lofUploadFlexibleFile($path, $baseName, $count) {
        $errors = array();
        $allowType = array("jpg", "bmp", "gif", "png");
        for ($i = 1; $i <= $count; $i++) {
            $name = $baseName . '_' . $i;
            $file = $_FILES[$name]['name'];
            if (isset($file) && $file != NULL) {
                $ext = substr($file, strrpos($file, '.') + 1);
                $filename = $path . $file;
                if (in_array($ext, $allowType) && !file_exists($filename)) {
                    if (@move_uploaded_file($_FILES[$name]['tmp_name'], $filename)) {
                        //do nothing
                    } else {
                        $errors[] = 'Can not move file <span>' . $file . '</span> to folder <span>' . $path . '</span> !';
                    }
                } else {
                    $errors[] = 'File <span>' . $file . '</span> already exist !';
                }
            }
        }
        //display error :
        if (count($errors) > 0) {
            echo '<ul class="lof_display_upload_errors">';
            foreach ($errors as $error) {
                echo '<li>' . $error . '</li>';
            }
            echo '</ul>';
        }
    }

    /**
     * Render Configuration From for user making settings.
     *
     * @return context
     */
    private function _getFormConfig() {
        $html = '';
        $formats = ImageType::getImagesTypes('products');
        $themes = $this->getFolderList(dirname(__FILE__) . "/tmpl/");
        $groups = $this->getFolderList(dirname(__FILE__) . "/libs/groups/");
        ob_start();
        include_once dirname(__FILE__) . '/config/lofminigallery.php';
        $html .= ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public function getProFeature() {
        $sql = 'SELECT DISTINCT p.id_product FROM `' . _DB_PREFIX_ . 'category_product` cp '
                . 'LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON p.`id_product` = cp.`id_product` '
                . 'WHERE cp.`id_category` =1';
        return Db::getInstance()->ExecuteS($sql);
    }

    /**
     * Process vadiation before saving data 
     */
    private function _postValidation() {
        if (!Validate::isCleanHtml(Tools::getValue('module_height')))
            $this->_postErrors[] = $this->l('The module height you entered was not allowed, sorry');
        if (!Validate::isCleanHtml(Tools::getValue('module_width')))
            $this->_postErrors[] = $this->l('The module width you entered was not allowed, sorry');
        if (!Validate::isCleanHtml(Tools::getValue('main_height')) || !is_numeric(Tools::getValue('main_height')))
            $this->_postErrors[] = $this->l('The Main Image Height you entered was not allowed, sorry');
        if (!Validate::isCleanHtml(Tools::getValue('main_width')) || !is_numeric(Tools::getValue('main_width')))
            $this->_postErrors[] = $this->l('The Main Image Width you entered was not allowed, sorry');
    }

    /**
     * Get value of parameter following to its name.
     * 
     * @return string is value of parameter.
     */
    public function getParamValue($name, $default='') {
        return $this->_params->get($name, $default);
    }

    function test($var) {
        echo '==================== debug ==========================<br />';
        if (is_string($var) || is_numeric($var)) {
            echo '========>' . $var . '<=========<br />';
        } else {
            echo '<pre>';
            print_r($var);
            echo '</pre>';
        }
        die('===================== end debug ====================');
    }

}
