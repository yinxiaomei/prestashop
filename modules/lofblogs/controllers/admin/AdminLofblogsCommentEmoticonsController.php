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
require_once _PS_MODULE_DIR_ . 'lofblogs/lofblogs.php';
require_once LOFCONTENT_MODELS_FOLDER . 'LofPsblogsCommentEmoticons.php';

class AdminLofblogsCommentEmoticonsController extends AdminController {

    protected $module;
    public $successMsg = null;
    public $_errors = array();

    public function __construct() {

        global $cookie;

        $this->table = 'lofblogs_comment_emoticons';
        $this->className = 'LofPsblogsCommentEmoticons';
        $this->lang = false;
		$this->addRowAction('edit');
		$this->addRowAction('delete');

        $this->module = 'lofblogs';
        $this->helper = new lofContentHelper();

        $this->fieldsDisplay = array(
            'id' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 30),
            'published' => array('title' => $this->l('Published'), 'align' => 'center', 'icon' => array('1' => 'enabled.gif', '0' => 'forbbiden.gif'), 'orderby' => false, 'search' => true),
            'content' => array('title' => $this->l('Comment'), 'width' => 400),
            'date_add' => array('title' => $this->l('Commented date'), 'width' => 120, 'type' => 'date', 'search' => false),
        );
        $this->identifier = 'id';
        $this->model = $this->loadObject(true);
        parent::__construct();
		/*
		$id_parent = Tab::getCurrentParentId();
		$this->tabAccess = Profile::getProfileAccess($this->context->employee->id_profile, $id_parent);
		*/
    }

    function init() {
        parent::init();
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs.css');
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'emoticons.css');
        
        //updating information :
        if (Tools::getValue('emoticons_update')) {
            $this->model->removeSelectedImages();
            $this->model->saveAll();
            $this->displayInformation('Update successfuly');
        }
        if($this->model->addEmoticon()) {
            $this->displayInformation('An emoticon has uploaded successfully');
        }
        
        $this->initMsg();
    }

    public function renderList() {

        $this->initToolbarTitle();
        $this->initToolbar();
        $toolbar = $this->context->smarty->fetch('toolbar.tpl');

        $files = $this->helper->getImages(LOFCONTENT_IMAGES_ADMIN . 'emoticons/');
        $datas = array();
        $datas = $this->model->getInformation();
        $emoticons_uri = LOFCONTENT_IMAGES_ADMIN_URI . 'emoticons/';
        $formAction = self::$currentIndex . '&token=' . $this->token;

        ob_start();
        require LOFCONTENT_HTML_FOLDER . 'lof_emoticons.php';
        $list = ob_get_contents();
        ob_clean();

        return $toolbar . $list;
    }

    function initToolbar() {
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
        $this->context->smarty->assign('title', $this->toolbar_title);
        $this->context->smarty->assign('toolbar_scroll', 1);
        $this->context->smarty->assign('show_toolbar', 1);
        $this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);
    }
    
    function initMsg() {
        if (is_array($this->_errors) && count($this->_errors)) {
            foreach ($this->_errors as $error) {
                $this->displayWarning($error);
            }
        }
        if ($this->successMsg) {
            $this->displayInformation($this->successMsg);
        }
    }    

}