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

class lofBlogsCategory extends Module {
    /* @var boolean error */

    protected $error = false;
    private $_postErrors = array();
    private $_themeName = "default";

    public function __construct() {
        $this->name = 'lofblogscategory';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'LandOfCoder';
        $this->need_instance = 0;

        parent::__construct();
        $controller = Dispatcher::getInstance()->getController();
        if (strtolower($controller) == "adminmodules")
            $this->_includeFile();
        //assign theme
        if($theme=Configuration::get('lofblogscategory_template')) $this->_themeName =  $theme;

        $this->displayName = $this->l('Lof Blogs Category');
        $this->description = $this->l('Show list of link to category page for Lof Blogs content');
        $this->confirmUninstall = $this->l('do you realy want to uninstall Lof Blogs Category?');
    }

    public function _includeFile() {
        require_once(_PS_MODULE_DIR_ . "lofblogscategory/defined.php");
        if (!class_exists('LOFXParams')) {
            require LOFCONTENTMENU_ROOT . 'config/params.php';
        }

        if (!class_exists('lofContentHelper')) {
            require _PS_MODULE_DIR_ . 'lofblogs/libs/lof_content_helper.php';
        }
        $this->params = new LOFXParams($this);
    }

    public function install() {
        if (parent::install() == false OR !$this->registerHook('rightColumn')
        )
            return false;
        return true;
    }

    public function uninstall() {
        if (!parent::uninstall())
            return false;
        return true;
    }

    /**
     * Render processing form && process saving data.
     */
    public function getContent() {
        $html = "";
        if (Tools::isSubmit('submit')) {
            $this->_postValidation();
            if (is_array($this->_postErrors) && !count($this->_postErrors)) {

                $this->params->update();
                $html .= '<div class="conf confirm">' . $this->l('Settings updated') . '</div>';
            }
            $this->clearBLCCache();
        }
        if ($this->params->hasError())
            die($this->params->getErrorMsg());

        return $html . $this->params->displayForm();
    }


    function hookleftColumn($params) {
        return $this->processHook($params, 'left');
    }

    function hookrightColumn($params) {
        return $this->processHook($params, 'right');
    }

    /**
     * Process vadiation before saving data 
     */
    private function _postValidation() {
        
    }

    function processHook($params, $hook = '') {
        if (!$this->isCached('themes/'.$this->_themeName.'/default.tpl', $this->getCacheId())) {
            global $smarty;
            $this->_includeFile();    
            $items = null;
            $params = $this->params->getValues();

            $list = $this->getCategories();
            $items = array();
            self::treeCategory(1, $items, $list);
            //echo "<pre>".print_r($items,1); die;
            $smarty->assign(array(
                'items' => $items,
                'params' => $params,
            ));
            $theme = $this->params->get('template', 'default');
            if (file_exists(_PS_THEME_DIR_ . 'modules/' . $this->name . '/themes/' . $theme . '/default.tpl'))
                $this->smarty->assign('branche_tpl_path', _PS_THEME_DIR_ . 'modules/' . $this->name . '/themes/' . $theme . '/category-tree-branch.tpl');
            else
                $this->smarty->assign('branche_tpl_path', _PS_MODULE_DIR_ . $this->name . '/themes/' . $theme . '/category-tree-branch.tpl');
        }
        $this->context->controller->addCSS(($this->_path).'themes/'.$this->_themeName.'/assets/css/default.css', 'all');
        return $this->display(__FILE__, 'themes/'.$this->_themeName.'/default.tpl', $this->getCacheId());
    }

    function getCategories() {
        global $cookie;
        $lang = $cookie->id_lang ? $cookie->id_lang : $this->params->defaultLang;

        $query = 'SELECT c.id_lofblogs_category,c.id_parent, cl.name, cl.link_rewrite ';
        $query .= ' FROM ' . _DB_PREFIX_ . 'lofblogs_category c ';
        $query .= ' LEFT JOIN ' . _DB_PREFIX_ . 'lofblogs_category_lang cl ON (c.id_lofblogs_category = cl.id_lofblogs_category)';
        $query .= ' WHERE cl.id_lang = ' . pSQL($lang);
        $query .= ' AND c.level_depth > 0';
        $query .= ' AND c.active = 1';
        $catids = '';
        if ($catids) {
            //filter bt category id :
            $query .= ' AND c.id_lofblogs_category IN (' . $catids . ')';
        }

        //list ordering :
        $query .= ' ORDER BY ' . $this->params->get('ordering', 'c.id_lofblogs_category DESC');

        //list limit , zero mean no limit :
        if ($this->params->get('count', 0)) {
            $query .= ' LIMIT 0,' . $this->params->get('count', 0);
        }


        $items = Db::getInstance()->ExecuteS($query);
        foreach ($items as $k => $item) {
            $items[$k]['link'] = lofContentHelper::getCategoryLink($item['id_lofblogs_category'], $item['link_rewrite']);
        }

        $children = array();
        if ($items) {
            foreach ($items as $v) {
                $pt = $v["id_parent"];
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
            //echo "<pre>".print_r($children,1); die;
            return $children;
        }
        return array();
    }

    public static function treeCategory($id, &$list, $children, $tree = 0) {
        if (isset($children[$id])) {
            if ($id != 0) {
                $tree += 1;
            }
            foreach ($children[$id] as $v) {
                $v["tree"] = $tree;
                $list1 = array();
                self::treeCategory($v["id_lofblogs_category"], $list1, $children, $tree);
                //if(count($list1) > 0)
                $v['children'] = $list1;
                $list[] = $v;
            }
        }
    }

    public function getLayoutPath($layout = 'default') {
        $theme = $this->_themeName;
        $template = 'themes/' . $theme . '/' . $layout . '.tpl';
        if (!file_exists(__FILE__ . "/" . $template)) {
            return $template;
        }
    }
    protected function getCacheId($name = null, $hook = '') {
        $cache_array = array(
            $name !== null ? $name : $this->name,
            $hook,
            date('Ymd'),
            (int) Tools::usingSecureMode(),
            (int) $this->context->shop->id,
            (int) Group::getCurrent()->id,
            (int) $this->context->language->id,
            (int) $this->context->currency->id,
            (int) $this->context->country->id
        );
        return implode('|', $cache_array);
    }
    
    public function clearBLCCache(){
        $this->_clearCache('themes/'.$this->_themeName.'default.tpl');
        $this->_clearCache('themes/'.$this->_themeName.'category-tree-branch.tpl');
        $this->_clearCache('themes/'.$this->_themeName.'articles.tpl');
    }

}
