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
require_once LOFCONTENT_LIBS_FOLDER . 'lof_content_helper.php';
require_once LOFCONTENT_MODELS_FOLDER . 'LofPsblogsThemes.php';

class AdminLofblogsThemesController extends AdminController {

    public $tabs = array();
    public $successMsg = '';

    public function __construct() {
        $this->table = 'lofblogs_category';
        $this->className = 'LofPsblogsThemes';
        $this->lang = true;
        parent::__construct();
        $this->helper = new lofContentHelper();
        $this->module = new lofBlogs();
		/*
		$id_parent = Tab::getCurrentParentId();
		$this->tabAccess = Profile::getProfileAccess($this->context->employee->id_profile, $id_parent);
		*/
    }

    function init() {
        parent::init();
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs.css');
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lof_themes.css');

        //remove theme if needed :
        $this->uninstallTheme();

        //updating information :
        if (Tools::getValue('installTheme')) {
            if (isset($_FILES['file']['tmp_name']) OR !empty($_FILES['file']['tmp_name'])) {
                $this->installTheme('file');
            }
        }

        $this->initMsg();
    }

    public function renderList() {

        $this->initToolbarTitle();
        $this->initToolbar();        
        $toolbar = $this->context->smarty->fetch('toolbar.tpl');

        $lofAdminHtml = new lofPrestaHtml();
        $themesInfo = array();
        $themes = $lofAdminHtml->getFolderList(LOFCONTENT_THEMES_FOLDER);
        if (count($themes)) {
            foreach ($themes as $theme) {
                $themesInfo[$theme] = $this->helper->getThemeInfo($theme);
            }
        }
        $formAction = self::$currentIndex . '&token=' . $this->token;
        $removeBaseLink = $formAction . '&deleteTheme=';

        $lofAdminHtml->setTranslateFile('lof_theme');

        ob_start();
        require _PS_MODULE_DIR_ . "lofblogs/html/lof_themes.php";
        $list = ob_get_clean();
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

    function installTheme($fieldname) {

        if (substr($_FILES['file']['name'], -4) != '.tar' AND substr($_FILES['file']['name'], -4) != '.zip' AND substr($_FILES['file']['name'], -4) != '.tgz' AND substr($_FILES['file']['name'], -7) != '.tar.gz')
            $this->_errors[] = 'Unknown archive type';
        elseif (!@copy($_FILES['file']['tmp_name'], LOFCONTENT_THEMES_FOLDER . $_FILES['file']['name']))
            $this->_errors[] = 'An error occurred while copying archive to theme directory.';
        else {
            $file = LOFCONTENT_THEMES_FOLDER . $_FILES['file']['name'];
            $success = false;
            if (substr($file, -4) == '.zip') {
                if (Tools::ZipExtract($file, LOFCONTENT_THEMES_FOLDER))
                    $success = true;
                else
                    $this->_errors[] = 'File may be corrupted or theme already exist.';
            }
            else {
                $archive = new Archive_Tar($file);
                if ($archive->extract(LOFCONTENT_THEMES_FOLDER))
                    $success = true;
                else
                    $this->_errors[] = 'File may be corrupted or theme already exist.';
            }

            @unlink($file);
            if ($success) {
                $this->successMsg = 'Theme has installed successfully';
            }
        }
    }

    function uninstallTheme() {
        if (Tools::getValue('deleteTheme')) {
            $themename = Tools::getValue('deleteTheme');
            $themeInfo = $this->helper->getThemeInfo($themename);
            $themeTitle = $themeInfo['info']['name'];
            $themepath = LOFCONTENT_THEMES_FOLDER . $themename;
            if (file_exists($themepath) && is_dir($themepath)) {
                Tools::deleteDirectory($themepath);
                $this->successMsg = 'Theme "' . $themeTitle . '" has uninstalled ';
            } else {
                $this->_errors[] = '"' . $themename . '" is not installed or not a directory';
            }
        }
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