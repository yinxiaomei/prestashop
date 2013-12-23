<?php

/**
 * Leo bootstrap menu Module
 * 
 * @version		$Id: file.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) September 2012 LeoTheme.Com <@emai:leotheme@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */
if (!defined('_PS_VERSION_'))
    exit;

include_once(_PS_MODULE_DIR_ . 'leobootstrapmenu/classes/Btmegamenu.php');
include_once(_PS_MODULE_DIR_ . 'leobootstrapmenu/libs/Helper.php');
include_once(_PS_MODULE_DIR_ . 'leobootstrapmenu/libs/Params.php');

class leobootstrapmenu extends Module {

    private $_html = '';
    private $_configs = '';
    protected $params = null;
    public $_languages;
    public $_defaultFormLanguage;
    public $base_config_url;

    public function __construct() {
        global $currentIndex;
        $this->name = 'leobootstrapmenu';
        $this->tab = 'LeoTheme';
        $this->version = '1.0';
        $this->author = 'LeoTheme';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);

        parent::__construct();
        $this->base_config_url = $currentIndex . '&configure=' . $this->name . '&token=' . Tools::getValue('token');

        $this->displayName = $this->l('Leo bootstrap megamenu');
        $this->description = $this->l('Leo bootstrap megamenu.');
        $this->_prepareForm();
        $this->Languages();
        $this->params = new LeoParams($this, $this->name, $this->_configs);
    }

    public function _prepareForm() {
        $this->_configs = array(
            'theme' => 'default'
        );
    }

    public function Languages() {
        //global $cookie;
        $cookie = $this->context->cookie;
        $allowEmployeeFormLang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        if ($allowEmployeeFormLang && !$cookie->employee_form_lang)
            $cookie->employee_form_lang = (int) (Configuration::get('PS_LANG_DEFAULT'));
        $useLangFromCookie = false;
        $this->_languages = Language::getLanguages(false);
        if ($allowEmployeeFormLang)
            foreach ($this->languages AS $lang)
                if ($cookie->employee_form_lang == $lang['id_lang'])
                    $useLangFromCookie = true;
        if (!$useLangFromCookie)
            $this->_defaultFormLanguage = (int) (Configuration::get('PS_LANG_DEFAULT'));
        else
            $this->_defaultFormLanguage = (int) ($cookie->employee_form_lang);
    }

    public function getParams() {
        return $this->params;
    }

    /**
     * @see Module::install()
     */
    public function install() {
        /* Adds Module */
        if (parent::install() && $this->registerHook('topNavigation') 
                && Configuration::updateValue('btmenu_iscache', 1)
                && Configuration::updateValue('btmenu_cachetime', 24)) {
            $res = true;
            /* Creates tables */
            $res &= $this->createTables();
            return $res;
        }
        return false;
    }

    /**
     * @see Module::uninstall()
     */
    public function uninstall() {
        /* Deletes Module */
        if (parent::uninstall() && Configuration::deleteByName('btmenu_iscache') && Configuration::deleteByName('btmenu_cachetime')) {
            $res = true;
            /* Deletes tables */

            $res = $this->deleteTables();

            /* Unsets configuration */
            $res &= $this->getParams()->delete();
            return $res;
        }
        return false;
    }

    /**
     * Creates tables
     */
    protected function createTables() {
        $res = 1;
        include_once( dirname(__FILE__) . '/install/install.php' );
        return $res;
    }

    /**
     * deletes tables
     */
    protected function deleteTables() {
        return Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'btmegamenu`, `' . _DB_PREFIX_ . 'btmegamenu_lang`, `' . _DB_PREFIX_ . 'btmegamenu_shop`;');
    }

    public function getContent() {

        $this->_html .= $this->headerHTML();
        $this->_html .= '<h2>' . $this->displayName . '.</h2>';
        if(Tools::isSubmit('savecache')){
            
            Configuration::updateValue('btmenu_iscache', Tools::getValue('btmenu_iscache'));
            Configuration::updateValue('btmenu_cachetime', Tools::getValue('btmenu_cachetime'));
            
            //delete all file in cache folder
            if(!Tools::getValue('btmenu_iscache')){
                $this->clearCache();
            }
        }
        /* Validate & process */
        else if(Tools::isSubmit('saveMenu') || Tools::isSubmit('saveMenuAndEdit') || Tools::isSubmit('submitUpdateConfig') || Tools::getValue('deleteMenu')) {
            if ($this->_postValidation())
                $this->_postProcess();
        }
        $this->_displayForm();
        return $this->_html;
    }
    
    private function clearCache(){
        $cacheFolder = _PS_MODULE_DIR_.'leobootstrapmenu/cache/';
        if ($handle = opendir($cacheFolder)) {
            while (false !== ($file = readdir($handle))){
                if(is_file($file)){
                    unlink($file);
                }
            }
            closedir($handle);
        }
    }

    private function _displayForm() {
        $params = $this->params;
        $id_lang = $this->context->language->id;
        $id_btmegamenu = (int) (Tools::getValue('id_btmegamenu'));
        $obj = new Btmegamenu($id_btmegamenu);
        $tree = $obj->getTree();
        $categories = LeoBtmegamenuHelper::getCategories();
        $manufacturers = Manufacturer::getManufacturers(false, $id_lang, true);
        $suppliers = Supplier::getSuppliers(false, $id_lang, true);
        $cmss = CMS::listCms($this->context->language->id, false, true);
        $menus = $obj->getDropdown(null, $obj->id_parent);
        require_once ( dirname(__FILE__) . '/form.php' );
    }

    private function _postValidation() {
        $errors = array();
        /* Validation for Slider configuration */
        if (Tools::isSubmit('saveMenu') || Tools::isSubmit('saveMenuAndEdit')) {
            /* Checks title/url/legend/description/image */
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                if (strlen(Tools::getValue('title_' . $language['id_lang'])) > 255)
                    $errors[] = $this->l('Title is too long');
            }
            /* Checks title/url/legend/description for default lang */
            $id_lang_default = (int) Configuration::get('PS_LANG_DEFAULT');
            if (strlen(Tools::getValue('title_' . $id_lang_default)) == 0)
                $errors[] = $this->l('Title is not set');
            switch (Tools::getValue('type')) {
                case 'url':
                    if (strlen(Tools::getValue('url')) == 0)
                        $errors[] = $this->l('Url is not set');
                    break;
                case 'category':
                    if (!(Validate::isLoadedObject($obj = new Category((int) Tools::getValue('type_category')))))
                        $errors[] = $this->l('Category is not set');
                    break;
                case 'product':
                    if (!(Validate::isLoadedObject($obj = new Product((int) Tools::getValue('type_product')))))
                        $errors[] = $this->l('product is not set');
                    break;
                case 'manufacturer':
                    if (!(Validate::isLoadedObject($obj = new Manufacturer((int) Tools::getValue('type_manufacturer')))))
                        $errors[] = $this->l('manufacturer is not set');
                    break;
                case 'supplier':
                    if (!(Validate::isLoadedObject($obj = new Supplier((int) Tools::getValue('type_supplier')))))
                        $errors[] = $this->l('supplier is not set');
                    break;
                case 'cms':
                    if (!(Validate::isLoadedObject($obj = new CMS((int) Tools::getValue('type_cms')))))
                        $errors[] = $this->l('cms is not set');
                    break;
            }
        }
        /* Display errors if needed */
        if (count($errors)) {
            $this->_html .= $this->displayError(implode('<br />', $errors));
            return false;
        }
        /* Returns if validation is ok */
        return true;
    }

    private function _postProcess() {
        $errors = array();
        /* Processes Slider */
        if (Tools::isSubmit('submitUpdateConfig')) {
            $res = $this->getParams()->batchUpdate($this->_configs);
            $this->getParams()->refreshConfig();
            if (!$res)
                $errors[] = $this->l('Configuration could not be updated');
            $this->_html .= $this->displayConfirmation($this->l('Configuration updated'));
        } /* Process Slide status */
        elseif (Tools::isSubmit('saveMenu') || Tools::isSubmit('saveMenuAndEdit')) {
            /* Sets ID if needed */
            if (Tools::getValue('id_btmegamenu')) {
                $objMenu = new Btmegamenu((int) Tools::getValue('id_btmegamenu'));
                if (!Validate::isLoadedObject($objMenu)) {
                    $this->_html .= $this->displayError($this->l('Invalid id_btmegamenu'));
                    return;
                }
                if (Tools::getValue('deleteIcon') == 1 && $objMenu->image) {
                    unlink(_PS_MODULE_DIR_ . $this->name . '/icons/' . $objMenu->image);
                    $objMenu->image = '';
                }
            }
            else
                $objMenu = new Btmegamenu();
            if (isset($_FILES['fileicon']) && $_FILES['fileicon']['name']) {
                $objMenu->image = $_FILES['fileicon']['name'];
                if (!$this->_lofUpload())
                    $errors[] = $this->l('Can\'t upload icon');
            }
            /* Sets position */
            $objMenu->active = (int) Tools::getValue('menu_active');
            $objMenu->type = Tools::getValue('type');
            if ($objMenu->type == 'url')
                $objMenu->url = Tools::getValue('url');
            if ($objMenu->type == 'category')
                $objMenu->item = Tools::getValue('type_category');
            if ($objMenu->type == 'product')
                $objMenu->item = Tools::getValue('type_product');
            if ($objMenu->type == 'manufacturer')
                $objMenu->item = Tools::getValue('type_manufacturer');
            if ($objMenu->type == 'supplier')
                $objMenu->item = Tools::getValue('type_supplier');
            if ($objMenu->type == 'cms')
                $objMenu->item = Tools::getValue('type_cms');

            $objMenu->id_parent = Tools::getValue('id_parent');
            $objMenu->target = Tools::getValue('target');
            $objMenu->menu_class = Tools::getValue('menu_class');
            $objMenu->show_title = Tools::getValue('show_title');
            $objMenu->is_group = Tools::getValue('is_group');
            $objMenu->is_content = Tools::getValue('is_content');
            $objMenu->colums = Tools::getValue('colums');
            $objMenu->submenu_colum_width = Tools::getValue('submenu_colum_width');
            $objMenu->type_submenu = Tools::getValue('type_submenu');
            /* Sets each langue fields */
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                if (Tools::getValue('title_' . $language['id_lang']) != '')
                    $objMenu->title[$language['id_lang']] = pSQL(Tools::getValue('title_' . $language['id_lang']));
                $objMenu->description[$language['id_lang']] = pSQL(Tools::getValue('description_' . $language['id_lang']));
                if (Tools::getValue('content_text_' . $language['id_lang']) != '' && Tools::getValue('type') == 'html')
                    $objMenu->content_text[$language['id_lang']] = Tools::getValue('content_text_' . $language['id_lang']);
                if (Tools::getValue('submenu_content_text_' . $language['id_lang']) != '' && Tools::getValue('type_submenu') == 'html')
                    $objMenu->submenu_content_text[$language['id_lang']] = Tools::getValue('submenu_content_text_' . $language['id_lang']);
            }

            //add category list
            $categoryBox = Tools::getValue('categoryBox');
            $categoryBox = array_filter($categoryBox);
            $objMenu->submenu_catids = implode($categoryBox, ",");
            
            $objMenu->is_cattree = Tools::getValue('is_cattree');
            
            /* Processes if no errors  */
            if (!$errors) {
                /* Adds */
                if (!Tools::getValue('id_btmegamenu')) {
                    if (!$objMenu->add())
                        $errors[] = $this->l('Menu could not be added');
                } /* Update */
                elseif (!$objMenu->update())
                    $errors[] = $this->l('Menu could not be updated');
                if (!$errors) {
                    if (Tools::isSubmit('saveMenuAndEdit'))
                        Tools::redirectAdmin($this->base_config_url . '&id_btmegamenu=' . $objMenu->id);
                    else
                        Tools::redirectAdmin($this->base_config_url);
                }
            }
        } /* Deletes */
        elseif (Tools::getValue('deleteMenu')) {
            $obj = new Btmegamenu((int) Tools::getValue('id_btmegamenu'));
            $res = $obj->delete();
            if (!$res)
                $this->_html .= $this->displayError('Could not delete');
            else
                $this->_html .= $this->displayConfirmation($this->l('menu deleted'));
        }

        /* Display errors if needed */
        if (count($errors))
            $this->_html .= $this->displayError(implode('<br />', $errors));
        elseif (Tools::isSubmit('submitSlide') && Tools::getValue('id_slide'))
            $this->_html .= $this->displayConfirmation($this->l('Slide updated'));
        elseif (Tools::isSubmit('submitSlide'))
            $this->_html .= $this->displayConfirmation($this->l('Slide added'));
    }

    private function _lofUpload($name = 'fileicon') {
        if (isset($_FILES[$name]['name']) && $_FILES[$name]['name'] != NULL) {
            $ext = substr($_FILES[$name]['name'], strrpos($_FILES[$name]['name'], '.') + 1);
            $attachFileTypes = array("jpg", "bmp", "gif", "png");
            if (in_array($ext, $attachFileTypes)) {
                $uploadFolder = _PS_MODULE_DIR_ . $this->name . '/icons/';
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

    function hookDisplayHeaderRight() {
        return $this->hookDisplayTop();
    }

    function hookDisplaySlideshow() {
        return $this->hookDisplayTop();
    }

    function hookTopNavigation() {
        return $this->hookDisplayTop();
    }

    function hookDisplayPromoteTop() {
        return $this->hookDisplayTop();
    }

    function hookDisplayBottom() {
        return $this->hookDisplayTop();
    }

    function hookDisplayContentBottom() {
        return $this->hookDisplayTop();
    }

    function hookRightColumn() {
        return $this->hookDisplayTop();
    }

    function hookLeftColumn() {
        return $this->hookDisplayTop();
    }

    function hookdisplayHome() {
        return $this->hookDisplayTop();
    }

    function hookFooter() {
        return $this->hookDisplayTop();
    }

    public function hookDisplayTop() {
        $theme = $this->getParams()->get('theme', 'default');
        $this->context->controller->addCSS($this->_path . 'themes/' . $theme . '/assets/styles.css');

        $tpl = 'themes/default/default.tpl';
        if (file_exists(dirname(__FILE__) . "/themes/" . $theme . '/default.tpl')) {
            $tpl = 'themes/' . $theme . '/default.tpl';
        }
        $menu_config = array();
        foreach ($this->_configs as $key => $config) {
            $menu_config[$key] = $this->getParams()->get($key, $config);
        }
        
        if(!Configuration::get('btmenu_iscache')){
            $obj = new Btmegamenu();
            $menu_tree = $obj->getFrontTree();
        }else{
            //cache by shop + language + group customer
            $groups = implode(', ', Customer::getGroupsStatic((int) $this->context->customer->id));
            $id_language = $this->context->language->id;
            $id_shop= $this->context->shop->id;

            $cacheFolder = _PS_MODULE_DIR_.'leobootstrapmenu/cache/';
            if(!is_dir($cacheFolder)) mkdir($cacheFolder, 0755);
            $timeToSecond = (int)(Configuration::get('btmenu_cachetime') *3600);
            
            $cachefile = $cacheFolder.'cached-'.$id_shop.'-'.$id_language.'-'.$groups.'.html';
            if (file_exists($cachefile) && time() - $timeToSecond < filemtime($cachefile)) {
                $menu_tree = @file_get_contents($cachefile);
            }else{
                $obj = new Btmegamenu();
                $menu_tree = $obj->getFrontTree();
                @file_put_contents($cachefile, $menu_tree);
            }
        }
        

        $this->smarty->assign('leobootstrapmenu_menu_tree', $menu_tree);
        $this->smarty->assign('leobootstrapmenu', $menu_config);

        return $this->display(__FILE__, $tpl);
    }

    public function headerHTML() {
        if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
            return;
        $this->context->controller->addJqueryUI('ui.sortable');
        /* Style & js for fieldset 'slides configuration' */
        $html = '
			<script type="text/javascript" src="' . __PS_BASE_URI__ . 'modules/' . $this->name . '/js/jquery.nestable.js"></script>
			<script type="text/javascript" src="' . __PS_BASE_URI__ . 'modules/' . $this->name . '/js/admin.js"></script>';
        return $html;
    }

}
