<?php

/**
 * Lofcontent Admin tab
 * @category admin
 *
 * @author AppSide
 * @copyright AppSide
 * @version 1.4
 *
 */
require_once _PS_MODULE_DIR_ . 'lofblogs/defined.php';
require_once(LOFCONTENT_ROOT . "lofblogs.php");
require_once LOFCONTENT_MODELS_FOLDER . 'LofPsblogsBlocks.php';
require_once LOFCONTENT_LIBS_FOLDER . 'lof_content_helper.php';

class AdminLofblogsBlocksController extends AdminController {

    protected $module;
    private $_category;

    public function __construct() {

        $this->table = 'lofblogs_blocks';
        $this->className = 'LofPsblogsBlocks';
        $this->lang = true;
        $this->edit = true;
        $this->view = false;
        $this->delete = true;
        $this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected blocks'), 'confirm' => $this->l('Delete selected blocks?')));
        $this->module = 'lofblogs';

        $this->fields_list = array(
            'id_lofblogs_blocks' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 30),
            'title' => array('title' => $this->l('Title'), 'search' => true),
            'position' => array('title' => $this->l('Block Position')),
            'template' => array('title' => $this->l('Theme')),
            'published' => array('title' => $this->l('Published'), 'align' => 'center', 'icon' => array('1' => 'enabled.gif', '0' => 'forbbiden.gif'), 'orderby' => false, 'search' => true, 'active' => 'status')
        );
        $this->identifier = 'id_lofblogs_blocks';
        parent::__construct();
		/*
		$id_parent = Tab::getCurrentParentId();
		$this->tabAccess = Profile::getProfileAccess($this->context->employee->id_profile, $id_parent);
		*/
    }

    function init() {
        parent::init();

        //add media :
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs.css');
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs_admin_blocks.css');
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lightbox.css');
        $this->context->controller->addJS(LOFCONTENT_JS_URI . 'jquery-1.7.2.min.js');
        $this->context->controller->addJS(LOFCONTENT_JS_URI . 'lofblogs_admin_article.js');
        $this->context->controller->addJS(LOFCONTENT_JS_URI . 'lightbox.js');
    }

    public function renderForm() {

        $this->initToolbarTitle();
        $this->initToolbar();
        $this->context->smarty->assign('title', $this->toolbar_title);
        $toolbar = $this->context->smarty->fetch('toolbar.tpl');

        $defaultLanguage = intval($this->context->language->id);
        $iso = Language::getIsoById($defaultLanguage);
        $isoTinyMCE = (file_exists(_PS_ROOT_DIR_ . '/js/tiny_mce/langs/' . $iso . '.js') ? $iso : 'en');
        $tinymceFile = __PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js';
        $tinymceInit = __PS_BASE_URI__ . 'js/tinymce.inc.js';


        $obj = $this->loadObject(true);
        $divLangName = 'ctitle¤ccontent';
        
        $lofAdminHtml = new lofPrestaHtml($divLangName, $obj);

        //prepare some data :
        $formAction = self::$currentIndex . '&submitAdd' . $this->table . 'AndStay=1&token=' . $this->token;
        $lofAdminHtml->setTranslateFile('lof_blocks');

        ob_start();
        require _PS_MODULE_DIR_ . "lofblogs/html/lof_blocks.php";
        $html = ob_get_contents();
        ob_clean();

        return $toolbar . $html;
    }

    /**
     * Overrider function
     * @param type $object
     * @param type $table 
     */
    protected function copyFromPost(&$object, $table) {
        $blogs = new lofBlogs();
        $params = new LOFXParams($blogs);
        //update template default :
        if (!$_POST['template'])
            $_POST['template'] = $params->get('template', 'clean');

        foreach ($_POST AS $key => $value)
            if (key_exists($key, $object) AND $key != 'id_' . $table) {

                /* Do not take care of password field if empty */
                if ($key == 'passwd' AND Tools::getValue('id_' . $table) AND empty($value))
                    continue;
                /* Automatically encrypt password in MD5 */
                if ($key == 'passwd' AND !empty($value))
                    $value = Tools::encrypt($value);

                $object->{$key} = $value;
            }

        /* Multilingual fields */
        $rules = call_user_func(array(get_class($object), 'getValidationRules'), get_class($object));
        if (sizeof($rules['validateLang'])) {
            $languages = Language::getLanguages(false);
            foreach ($languages AS $language)
                foreach (array_keys($rules['validateLang']) AS $k => $field) {
                    if (isset($_POST[$field . '_' . (int) ($language['id_lang'])]))
                        $object->{$field}[(int) ($language['id_lang'])] = $_POST[$field . '_' . (int) ($language['id_lang'])];
                }
        }

        //echo '<pre>'; die(print_r($object));
    }

    public static function cleanHtml($description) {
        return strip_tags(stripslashes($description));
    }

    public function initToolbar() {
        $token = Tools::getAdminTokenLite('AdminLofblogsPanel');

        switch ($this->display) {
            case 'add':
            case 'edit':

                // Default save button - action dynamically handled in javascript
                $this->toolbar_btn['save'] = array(
                    'href' => '#',
                    'desc' => $this->l('Save')
                );
            //no break
            case 'view':
                // Default cancel button - like old back link
                $back = Tools::safeOutput(Tools::getValue('back', ''));
                if (empty($back))
                    $back = self::$currentIndex . '&token=' . $this->token;
                if (!Validate::isCleanHtml($back))
                    die(Tools::displayError());
                if (!$this->lite_display)
                    $this->toolbar_btn['back'] = array(
                        'href' => $back,
                        'desc' => $this->l('Back to list')
                    );
                break;
            case 'options':
                $this->toolbar_btn['save'] = array(
                    'href' => '#',
                    'desc' => $this->l('Save')
                );
                break;
            case 'view':
                break;
            default: // list
                $this->toolbar_btn['new'] = array(
                    'href' => self::$currentIndex . '&amp;add' . $this->table . '&amp;token=' . $this->token,
                    'desc' => $this->l('Add new')
                );
                $this->toolbar_btn['back'] = array(
                    'href' => 'index.php?controller=AdminLofblogsPanel&token=' . $token,
                    'desc' => $this->l('Back to Panel')
                );
        }

        $this->context->smarty->assign('toolbar_scroll', 1);
        $this->context->smarty->assign('show_toolbar', 1);
        $this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);
    }

    public function initToolbarTitle() {
        parent::initToolbarTitle();
        $category = $this->loadObject(true);
        if ($category)
            if ((bool) $category->id && $this->display != 'list' && isset($this->toolbar_title[3]))
                $this->toolbar_title[3] = $this->toolbar_title[3] . ' (' . $category->title[$this->context->language->id] . ')';
    }

}