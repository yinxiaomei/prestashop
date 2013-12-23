<?php

/*
 * 2011 LandOfCoder
 *
 *  @author LandOfCoder 
 *  @copyright  2011 LandOfCoder
 *  @version  Release: $Revision: 1.0 $
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_'))
    exit;
require_once(_PS_MODULE_DIR_ . "lofblogs/defined.php");
require LOFCONTENT_LIBS_FOLDER . 'lofPrestaHtml.php';

if (!class_exists('LOFXParams')) {
    require LOFCONTENT_ROOT . 'config/params.php';
}
require_once LOFCONTENT_LIBS_FOLDER . 'lof_content_helper.php';

class lofBlogs extends Module {
    /* @var boolean error */

    protected $error = false;
    private $_postErrors = array();

    public function __construct() {
        $this->name = 'lofblogs';
        $this->tab = 'front_office_features';
        $this->version = '1.5';
        $this->author = 'LandOfCoder';
        $this->need_instance = 0;

        parent::__construct();
        $this->params = new LOFXParams($this);
        $this->displayName = $this->l('Lof Blogs Manager');
        $this->description = $this->l('This is blogs manager !');
        $this->confirmUninstall = $this->l('do you realy want to uninstall Lof blogs manager?');
    }

    public function install() {
        
        if (!parent::install())
            return false;
        
        //create admin tab
        $this->installModuleTab('Lof Blogs', 'catalog', '');
        $this->installModuleTab('Lofblogs Panel', 'panel', 'AdminLofBlogsCatalog');
        $this->installModuleTab('Articles Manager', '', 'AdminLofBlogsCatalog');
        $this->installModuleTab('Categories Manager', 'category', 'AdminLofBlogsCatalog');
        $this->installModuleTab('Comments Manager', 'comment', 'AdminLofBlogsCatalog');
        $this->installModuleTab('Emoticons Manager', 'commentEmoticons', 'AdminLofBlogsCatalog');
        $this->installModuleTab('Blocks Manager', 'blocks', 'AdminLofBlogsCatalog');
        $this->installModuleTab('Themes Manager', 'themes', 'AdminLofBlogsCatalog');

        //install update databe:
        require_once(dirname(__FILE__) . '/database/upgrade_db.php');
        
        //install database :

        require_once(dirname(__FILE__) . '/database/install_db.php');
        //install admin images :
        if (!copy(dirname(__FILE__) . '/images/admin/lof_featured.png', _PS_IMG_DIR_ . '/admin/lfeatured.png')) {
            parent::displayError('lofblogs - Can not install featured icon !');
            return false;
        }
        if (!copy(dirname(__FILE__) . '/images/admin/lof_unfeatured.png', _PS_IMG_DIR_ . '/admin/lunfeatured.png')) {
            parent::displayError('lofblogs - Can not install unfeatured icon !');
            return false;
        }
        //create image folder structure :
        if(!lofContentHelper::createFolderIfNotExist(_PS_IMG_DIR_ . 'lofblogs/')
                OR !lofContentHelper::createFolderIfNotExist(LOFCONTENT_IMAGES_ORIGIN_FOLDER)
                OR !lofContentHelper::createFolderIfNotExist(LOFCONTENT_IMAGES_FOLDER)
                OR !lofContentHelper::createFolderIfNotExist(LOFCONTENT_THUMBS_FOLDER)
                OR !lofContentHelper::createFolderIfNotExist(LOFCONTENT_GALLERY_FOLDER)) {
            parent::displayError('lofblogs - Create Images folder failed !'); 
            return false;
        }
        
        return true;
    }

    public function uninstall() {
        if (!parent::uninstall())
            return false;
        $this->uninstallModuleTab();
        $this->uninstallModuleTab('category');
        $this->uninstallModuleTab('panel');
        $this->uninstallModuleTab('comment');
        $this->uninstallModuleTab('commentEmoticons');
        $this->uninstallModuleTab('blocks');
        $this->uninstallModuleTab('themes');

        //remove old lofblogs database :
        if ($this->params->get('removeDb')) {
            require_once(dirname(__FILE__) . '/database/uninstall_db.php');
        }

        if ($this->params->get('removeImages')) {
            Tools::deleteDirectory(_PS_IMG_DIR_ . 'lofblogs/');
        }

        //uninstall configuration :
        if ($this->params->get('removeConfig')) {
            $this->params->clean();
        }


        return true;
    }

    private function installModuleTab($title, $class_sfx = '', $parent = '') {
        $class = 'Admin' . ucfirst($this->name) . ucfirst($class_sfx);
        @copy(_PS_MODULE_DIR_ . $this->name . '/logo.gif', _PS_IMG_DIR_ . 't/' . $class . '.gif');
        if ($parent == '') {
            $position = 0; //Tab::getCurrentTabId();
        } else {
            $position = Tab::getIdFromClassName($parent);
        }
        
        $tab1 = new Tab();
        $tab1->class_name = $class;
        $tab1->module = $this->name;
        $tab1->id_parent = intval($position);
        $langs = Language::getLanguages(false);
        foreach ($langs as $l) {
            $tab1->name[$l['id_lang']] = $title;
        }
        $id_tab1 = $tab1->add(true, false);
    }

    private function uninstallModuleTab($class_sfx = '') {
        $tabClass = 'Admin' . ucfirst($this->name) . ucfirst($class_sfx);
        $idTab = Tab::getIdFromClassName($tabClass);
        if ($idTab != 0) {
            $tab = new Tab($idTab);
            $tab->delete();
            return true;
        }
        return false;
    }

    /**
     * Render processing form && process saving data.
     */
    public function getContent() {
        ini_set('error_reporting', E_ALL);
        $html = "";

        if (Tools::isSubmit('submit')) {

            if (is_array($this->_postErrors) && !count($this->_postErrors)) {
                $specialParams = array();
                $this->params->update();
                $html .= '<div class="conf confirm">' . $this->l('Settings updated') . '</div>';
            }
        }

        return $html . $this->params->displayForm();
    }

}
