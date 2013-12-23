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
require_once LOFCONTENT_LIBS_FOLDER . 'lof_content_helper.php';

class AdminLofblogsPanelController extends AdminController {

    public $tabs = array();

    public function __construct() {
        $this->table = 'lofblogs_category';
        $this->className = 'LofPsblogsCategory';
        $this->lang = true;
        $this->context = Context::getContext();
        parent::__construct();
    }

    public function renderList() {
        $helper = new lofContentHelper();
        $newRelease = ''; //$helper->getUpdate(LOFBLOG_DEVNAME, LOFBLOG_VERSION);

        echo '<link type="text/css" rel="stylesheet" href="' . __PS_BASE_URI__ . 'modules/lofblogs/css/lofblogs.css" />';
        $this->registerTab('AdminLofblogsCategory', $this->l('Categories Manager'), 'category.png');
        $this->registerTab('AdminLofblogs', $this->l('Articles Manager'), 'articles.png');
        $this->registerTab('AdminLofblogsComment', $this->l('Comments Manager'), 'comments.png');
        $this->registerTab('AdminLofblogsBlocks', $this->l('Blocks Manager'), 'blocks.png');
        $this->registerTab('AdminLofblogsThemes', $this->l('Theme Manager'), 'theme.png');
        $this->registerTab('AdminLofblogsCommentEmoticons', $this->l('Emoticons Manager'), 'emoticons.png');
        $this->registerTab('AdminModules', $this->l('Configuration'), 'configuration.png', '&configure=lofblogs&tab_module=front_office_features&module_name=lofblogs');

        $subTabs = $this->getTabLinks();
        ob_start();
        require _PS_MODULE_DIR_ . "lofblogs/html/lof_panel.php";
        $html = ob_get_contents();
        ob_clean();
        return $html;        
    }

    public function postProcess() {
        parent::postProcess();
    }

    public function displayForm($token = NULL) {
        parent::displayForm($token);
    }

    private function getTabLink($tabname) {
        global $cookie, $currentIndex;
        $token = Tools::getAdminToken($tabname . intval(Tab::getIdFromClassName($tabname)) . intval($cookie->id_employee));
        return '?controller=' . $tabname . '&token=' . $token;
    }

    function getTabLinks() {
        $links = array();
        if (count($this->tabs)) {
            foreach ($this->tabs as $tab) {
                $links[] = array(
                    'link' => $this->getTabLink($tab['class']) . $tab['params'],
                    'title' => $tab['title'],
                    'image' => LOFCONTENT_IMAGES_ADMIN_URI . 'tabs/' . $tab['image']
                );
            }
        }
        return $links;
    }

    function registerTab($class, $title, $image = 'default', $params = '') {
        $this->tabs[] = array('class' => $class, 'title' => $title, 'image' => $image, 'params' => $params);
    }

}