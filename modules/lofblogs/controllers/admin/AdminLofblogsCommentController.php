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

require_once _PS_MODULE_DIR_.'lofblogs/defined.php';
require_once _PS_MODULE_DIR_.'lofblogs/lofblogs.php';
require_once LOFCONTENT_MODELS_FOLDER.'LofPsblogsComment.php';

class AdminLofblogsCommentController extends AdminController {

    protected $module;
    private $_category;
    
    public function __construct() {
        
        global $cookie;        
        
        $this->table = 'lofblogs_comment';
        $this->className = 'LofPsblogsComment';
        $this->lang = false;
		$this->addRowAction('edit');
		$this->addRowAction('delete');
        $this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected comments'), 'confirm' => $this->l('Delete selected comments?')));
        $this->module = 'lofblogs';

        $this->fields_list = array(
            'id' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 30),
            'published' => array('title' => $this->l('Published'), 'align' => 'center', 'icon' => array('1' => 'enabled.gif', '0' => 'forbbiden.gif'), 'orderby' => false, 'search' => true, 'active'=> 'status', 'type'=>'bool'),
            'content' => array('title' => $this->l('Comment'), 'width' => 400, 'callback' => 'cleanHtml'),
            'date_add' => array('title' => $this->l('Commented date'), 'width' => 120, 'type' => 'date', 'search' => false),   
            'articlename' => array('title' => $this->l('Article'), 'width' => 100)
        );
        $this->identifier = 'id';
        $this->_select = 'iteml.title as articlename';
        $this->_join = ' LEFT JOIN '._DB_PREFIX_.'lofblogs_publication item ON (item.id_lofblogs_publication = a.item_id ) ';
        $this->_join .= ' LEFT JOIN '._DB_PREFIX_.'lofblogs_publication_lang iteml ON(item.id_lofblogs_publication = iteml.id_lofblogs_publication) ';
        $this->_where = ' AND iteml.id_lang='.$cookie->id_lang;
        parent::__construct();
		/*
		$id_parent = Tab::getCurrentParentId();
		$this->tabAccess = Profile::getProfileAccess($this->context->employee->id_profile, $id_parent);
		*/
    }

    function init() {
        parent::init();
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI.'lofblogs.css');
    }

    public function renderForm($isMainTab = true) {
        global $currentIndex, $cookie;

        $this->initToolbarTitle();
        $this->initToolbar();
        $this->context->smarty->assign('title', $this->toolbar_title);
        $toolbar = $this->context->smarty->fetch('toolbar.tpl');
        
        $iso = Language::getIsoById((int) ($cookie->id_lang));
        $isoTinyMCE = (file_exists(_PS_ROOT_DIR_ . '/js/tiny_mce/langs/' . $iso . '.js') ? $iso : 'en');
        $tinymceFile = __PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js';

        $defaultLanguage = intval($cookie->id_lang);
        $obj = $this->loadObject(true);

        $divLangName = '';

        $lofAdminHtml = new lofPrestaHtml($divLangName, $obj);

        $backlink = Tools::getValue('back') ? Tools::safeOutput(Tools::getValue('back')) : $currentIndex.'&token='.$this->token;
        
        //prepare some data :
        $formAction = $currentIndex . '&submitAdd' . $this->table . 'AndStay=1&token=' . $this->token;
        $lofAdminHtml->setTranslateFile('lof_comment');
        
        ob_start();
        require _PS_MODULE_DIR_ . "lofblogs/html/lof_comment.php";
        $html = ob_get_contents();
        ob_clean();
        return $toolbar.$html;
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
                $this->toolbar_title[3] = $this->toolbar_title[3] . ' (' . $category->name[$this->context->language->id] . ')';
    }
    

}