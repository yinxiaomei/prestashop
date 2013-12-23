<?php

/*
 * 2007-2012 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2012 PrestaShop SA
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_'))
    exit;

class LeoBlogsArticle extends Module {

    private $_html = '';
    private $_postErrors = array();
    private $_configs = array();
    private $catids = array();
    private $_themeName = "default";

    function __construct() {
        $this->name = 'leoblogsarticle';
        $this->tab = 'other';
        $this->version = '1.0';
        $this->author = 'leotheme';
        $this->need_instance = 0;

        parent::__construct();
        $controller = Dispatcher::getInstance()->getController();
        if (strtolower($controller) == "adminmodules")
            $this->_includeFile();

        $this->displayName = $this->l('Leo Blogs Article');
        $this->description = $this->l('Display Blogs Article.');
    }

    public function _includeFile() {
        include_once(_PS_MODULE_DIR_ . 'leoblogsarticle/Params.php');
        if (!class_exists('lofContentHelper')) {
            if (file_exists(_PS_MODULE_DIR_ . 'lofblogs/libs/lof_content_helper.php'))
                require _PS_MODULE_DIR_ . 'lofblogs/libs/lof_content_helper.php';
        }
        $this->_prepareForm();
        $this->params = new LeoParams($this, 'LEOBLOGA', $this->_configs);
    }

    public function _prepareForm() {

        $this->_configs = array(
            'catids' => 0,
            'itemspage' => 4,
            'columns' => 4,
            'itemstab' => 4,
            'showby' => 'lastest',
        );
    }

    public function install() {
        $a = (parent::install() AND $this->registerHook('displayBottom') AND $this->registerHook('header'));

        return $a;
    }

    public function uninstall() {
        if (!parent::uninstall() ||
                !Configuration::deleteByName('catids') ||
                !Configuration::deleteByName('itemspage') ||
                !Configuration::deleteByName('columns') ||
                !Configuration::deleteByName('itemstab') ||
                !Configuration::deleteByName('showby') ||
                !$this->unregisterHook('displayBottom') ||
                !$this->unregisterHook('header'))
            return false;
        $this->clearCache();
        return true;
    }

    public function getContent() {
        $output = '<h2>' . $this->displayName . '</h2>';
        if (Tools::isSubmit('submitSpecials')) {
            $res = $this->params->batchUpdate($this->_configs);
            $this->params->refreshConfig();

            $output .= '<div class="conf confirm">' . $this->l('Settings updated') . '</div>';
            $this->clearCache();
        }
        return $output . $this->displayForm();
    }

    public function displayForm() {
        $orders = array('lastest' => $this->l('Latest Article'), 'featured' => $this->l('Featured Articles'),
            'popular' => $this->l('Popular Articles'));

        return '
		<form action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" method="post">
			<fieldset>
				<legend><img src="' . $this->_path . 'logo.gif" alt="" title="" />' . $this->l('Settings') . '</legend>
				
			
				<div class="row-form">
					' . $this->params->blogCategoryTag('catids', $this->params->get('catids'), 'Categories', ' size="10" multiple="multiple"') . '
					<p class="clear">' . $this->l('Select category to display.') . '</p>
				</div>
				<div class="row-form">
					' . $this->params->selectTag($orders, "Show article by", 'lastest', $this->params->get('showby')) . '
					<p class="clear">' . $this->l('Select type of article.') . '</p>
				</div>
			
				<div class="row-form">
					' . $this->params->inputTag('Items Per Page', 'itemspage', $this->params->get('itemspage')) . '
					<p class="clear">' . $this->l('The maximum number of products in each page Carousel (default: 3).') . '</p>
				</div>
				<div class="row-form">
					' . $this->params->inputTag('Colums In Tab', 'columns', $this->params->get('columns')) . '
					<p class="clear">' . $this->l('The maximum column products in each page Carousel (default: 3).') . '</p>
				</div>
				<div class="row-form">
					' . $this->params->inputTag('Items In Tab', 'itemstab', $this->params->get('itemstab')) . '
					<p class="clear">' . $this->l('The maximum number of products in each Carousel (default: 6).') . '</p>
				</div>
				
				 
				<center><input type="submit" name="submitSpecials" value="' . $this->l('Save') . '" class="button" /></center>
			</fieldset>
		</form>';
    }

    public function hookDisplayHome($params) {
        return $this->hookRightColumn($params);
    }

    public function hookDisplaySlideshow($params) {
        return $this->hookRightColumn($params);
    }

    public function hookDisplayPromoteTop($params) {
        return $this->hookRightColumn($params);
    }

    public function hookDisplayBottom($params) {
        return $this->hookRightColumn($params);
    }

    public function hookDisplayContentBottom($params) {
        return $this->hookRightColumn($params);
    }

    public function hookRightColumn($params) {
        if (!$this->isCached('leoblogsarticle.tpl', $this->getCacheId())){
            $this->_includeFile();
            $nb = (int) $this->params->get('itemstab');

            $catids = $this->params->get('catids', '1,2,3');
            $catids = explode(",", $catids);
            $porder = $this->params->get('porder', 'date_add');
            $porder = preg_split("#\s+#", $porder);
            if (!isset($porder[1])) {
                $porder[1] = null;
            }


            $items_page = (int) $this->params->get('itemspage');
            $columns_page = (int) $this->params->get('columns');


            $this->catids = $catids;
            $filter = array();

            //switch layout :
            $type = $this->params->get('showby');
            switch ($type) {
                case 'lastest' :
                    $order = 'id_lofblogs_publication DESC';
                    $items = $this->getItems($order);
                    break;
                case 'featured' :
                    $filter = array('featured' => 1);
                    $order = 'id_lofblogs_publication DESC';
                    $items = $this->getItems($order, $filter);
                    break;
                case 'popular':
                default :
                    $order = 'hits DESC';
                    $items = $this->getItems($order);
                    break;
            }

            $this->smarty->assign(array(
                'itemsperpage' => $items_page,
                'columnspage' => $columns_page,
                'items' => $items,
                'scolumn' => 12 / $columns_page,
                'type' => $type,
                'thumbUri' => __PS_BASE_URI__ . 'img/lofblogs/thumbs/',
            ));
        }
        
        $this->context->controller->addCSS(($this->_path) . 'leoblogsarticle.css', 'all');
        return $this->display(__FILE__, 'leoblogsarticle.tpl', $this->getCacheId());
    }

    public function clearCache() {
        $this->_clearCache('leoblogsarticle.tpl');
    }

    protected function getCacheId($name = null) {
        $cache_array = array(
            $name !== null ? $name : $this->name,
            (int) Tools::usingSecureMode(),
            (int) $this->context->shop->id,
            (int) Group::getCurrent()->id,
            (int) $this->context->language->id,
            (int) $this->context->currency->id,
            (int) $this->context->country->id
        );
        return implode('|', $cache_array);
    }

    function getItems($order, $filter = array()) {
        $lang = Context::getContext()->language->id;
        ;

        $limit = (int) $this->params->get('itemstab');
        $groups = lofContentHelper::getCustomerGroups();

        $query = 'SELECT a.*, al.title, al.link_rewrite, al.short_desc, al.content, cl.name as categorytitle, cl.link_rewrite as categoryalias ';
        $query .= ' FROM ' . _DB_PREFIX_ . 'lofblogs_publication a ';
        $query .= ' LEFT JOIN ' . _DB_PREFIX_ . 'lofblogs_publication_lang al ON (a.id_lofblogs_publication = al.id_lofblogs_publication)';
        $query .= ' LEFT JOIN ' . _DB_PREFIX_ . 'lofblogs_category c ON (a.id_lofblogs_category = c.id_lofblogs_category)';
        $query .= ' INNER JOIN ' . _DB_PREFIX_ . 'lofblogs_category_lang cl ON (a.id_lofblogs_category = cl.id_lofblogs_category)';
        $query .= ' WHERE al.id_lang = ' . pSQL($lang)
                . ' AND cl.id_lang = ' . pSQL($lang)
                . ' AND a.status = \'published\' '
                . ' AND c.active = 1';
        $access = array();
        foreach ($groups as $id_group) {
            $access[] = $id_group . ' IN (a.access)';
        }
        if (count($access))
            $query .= ' AND (' . implode(' OR ', $access) . ') ';

        $catids = $this->params->get('catids', '1,2,3');
        if ($catids) {
            //filter bt category id :
            $query .= ' AND a.id_lofblogs_category IN (' . $catids . ')';
        }

        if (isset($filter['featured']) && $filter['featured']) {
            $query .= ' AND a.featured = 1';
        }

        //set order :
        $query .= ' ORDER BY ' . $order;

        //set limit :
        if ($limit) {
            $query .= ' LIMIT 0,' . $limit;
        }

        $items = Db::getInstance()->ExecuteS($query);
        foreach ($items as $k => $item) {
            $items[$k]['link'] = lofContentHelper::getArticleLink($item['id_lofblogs_publication'], $item['link_rewrite']);
        }
        return $items;
    }

    public function hookLeftColumn($params) {
        return $this->hookRightColumn($params);
    }
}

