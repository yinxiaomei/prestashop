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

class BlockLeoproductTabs extends Module {

    private $_html = '';
    private $_postErrors = array();

    function __construct() {
        $this->name = 'blockleoproducttabs';
        $this->tab = 'pricing_promotion';
        $this->version = '1.1';
        $this->author = 'leotheme';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Leo Product Tabs Block');
        $this->description = $this->l('Adds a block with current product specials.');
    }

    public function install() {
        $a = (parent::install() AND $this->registerHook('displayPromoteTop') AND $this->registerHook('header'));
        Configuration::updateValue('LEOMOD_ITEMS_PAGE', 4);
        Configuration::updateValue('LEOMOD_COLUMNS_PAGE', 4);
        Configuration::updateValue('LEOMOD_ITEMS_TAB', 8);
        Configuration::updateValue('LEOMOD_SPECIAL_DISPLAY', 1);
        Configuration::updateValue('LEOMOD_FEATURED_DISPLAY', 1);
        Configuration::updateValue('LEOMOD_NEWARRIALS_DISPLAY', 0);
        Configuration::updateValue('LEOMOD_BESTSELLER_DISPLAY', 1);
        $this->_clearBLCCache();
        return $a;
    }

    public function uninstall() {
        $this->_clearBLCCache();
        return parent::uninstall();
    }

    public function getContent() {
        $output = '<h2>' . $this->displayName . '</h2>';
        if (Tools::isSubmit('submitSpecials')) {
            Configuration::updateValue('LEOMOD_ITEMS_PAGE', (int) (Tools::getValue('items_page')));
            Configuration::updateValue('LEOMOD_COLUMNS_PAGE', (int) (Tools::getValue('columns_page')));
            Configuration::updateValue('LEOMOD_ITEMS_TAB', (int) (Tools::getValue('items_tab')));
            Configuration::updateValue('LEOMOD_SPECIAL_DISPLAY', (int) (Tools::getValue('special_display')));
            Configuration::updateValue('LEOMOD_FEATURED_DISPLAY', (int) (Tools::getValue('featured_display')));
            Configuration::updateValue('LEOMOD_NEWARRIALS_DISPLAY', (int) (Tools::getValue('newarrivals_display')));
            Configuration::updateValue('LEOMOD_BESTSELLER_DISPLAY', (int) (Tools::getValue('bestseller_display')));
            $this->_clearBLCCache();
            $output .= '<div class="conf confirm">' . $this->l('Settings updated') . '</div>';
        }
        return $output . $this->displayForm();
    }

    public function displayForm() {
        return '
		<form action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" method="post">
			<fieldset>
				<legend><img src="' . $this->_path . 'logo.gif" alt="" title="" />' . $this->l('Settings') . '</legend>
				
				<label>' . $this->l('Number of Items In Page') . '</label>				
				<div class="margin-form">
					<input type="text" size="5" name="items_page" value="' . Tools::safeOutput(Tools::getValue('items_page', (int) (Configuration::get('LEOMOD_ITEMS_PAGE')))) . '" />
					<p class="clear">' . $this->l('The maximum number of products in each page tab (default: 3).') . '</p>
				</div>
				<label>' . $this->l('Number of Columns In Page') . '</label>				
				<div class="margin-form">
					<input type="text" size="5" name="columns_page" value="' . Tools::safeOutput(Tools::getValue('columns_page', (int) (Configuration::get('LEOMOD_COLUMNS_PAGE')))) . '" />
					<p class="clear">' . $this->l('The maximum number of products in each page tab (default: 3).') . '</p>
				</div>
				<label>' . $this->l('Number of products displayed In Tab') . '</label>				
				<div class="margin-form">
					<input type="text" size="5" name="items_tab" value="' . Tools::safeOutput(Tools::getValue('nbr', (int) (Configuration::get('LEOMOD_ITEMS_TAB')))) . '" />
					<p class="clear">' . $this->l('The maximum number of products in each tab (default: 6).') . '</p>
				</div>
				
				<label>' . $this->l('Special Tab') . '</label>
				<div class="margin-form">
					<input type="radio" name="special_display" id="special_display_on" value="1" ' . (Tools::getValue('special_display', Configuration::get('LEOMOD_SPECIAL_DISPLAY')) ? 'checked="checked" ' : '') . '/>
					<label class="t" for="special_display_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
					<input type="radio" name="special_display" id="special_display_off" value="0" ' . (!Tools::getValue('special_display', Configuration::get('LEOMOD_SPECIAL_DISPLAY')) ? 'checked="checked" ' : '') . '/>
					<label class="t" for="special_display_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
					<p class="clear">' . $this->l('Show the block even if no product is available.') . '</p>
				</div>
				<label>' . $this->l('BestSeller Tab') . '</label>
				<div class="margin-form">
					<input type="radio" name="bestseller_display" id="bestseller_display_on" value="1" ' . (Tools::getValue('bestseller_display', Configuration::get('LEOMOD_BESTSELLER_DISPLAY')) ? 'checked="checked" ' : '') . '/>
					<label class="t" for="bestseller_display_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
					<input type="radio" name="bestseller_display" id="bestseller_display_off" value="0" ' . (!Tools::getValue('bestseller_display', Configuration::get('LEOMOD_BESTSELLER_DISPLAY')) ? 'checked="checked" ' : '') . '/>
					<label class="t" for="bestseller_display_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
					<p class="clear">' . $this->l('Show the block even if no product is available.') . '</p>
				</div>
				<label>' . $this->l('Featured Tab') . '</label>
				<div class="margin-form">
					<input type="radio" name="featured_display" id="featured_display_on" value="1" ' . (Tools::getValue('featured_display', Configuration::get('LEOMOD_FEATURED_DISPLAY')) ? 'checked="checked" ' : '') . '/>
					<label class="t" for="featured_display_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
					<input type="radio" name="featured_display" id="featured_display_off" value="0" ' . (!Tools::getValue('featured_display', Configuration::get('LEOMOD_FEATURED_DISPLAY')) ? 'checked="checked" ' : '') . '/>
					<label class="t" for="featured_display_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
					<p class="clear">' . $this->l('Show the block even if no product is available.') . '</p>
				</div>
				<label>' . $this->l('New Arrials Tab') . '</label>
				<div class="margin-form">
					<input type="radio" name="newarrivals_display" id="newarrivals_display_on" value="1" ' . (Tools::getValue('newarrivals_display', Configuration::get('LEOMOD_NEWARRIALS_DISPLAY')) ? 'checked="checked" ' : '') . '/>
					<label class="t" for="newarrivals_display_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
					<input type="radio" name="newarrivals_display" id="newarrivals_display_off" value="0" ' . (!Tools::getValue('newarrivals_display', Configuration::get('LEOMOD_NEWARRIALS_DISPLAY')) ? 'checked="checked" ' : '') . '/>
					<label class="t" for="newarrivals_display_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
					<p class="clear">' . $this->l('Show the block even if no product is available.') . '</p>
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
        if (!$this->isCached('blockleoproducttabs.tpl', $this->getCacheId())) {
            $special = '';
            $bestseller = '';
            $featured = '';
            $newProducts = '';



            $category = new Category(Context::getContext()->shop->getCategory(), (int) Context::getContext()->language->id);
            $nb = (int) (Configuration::get('LEOMOD_ITEMS_TAB'));
            $nb = ($nb ? $nb : 6);

            if (Configuration::get('LEOMOD_FEATURED_DISPLAY')) {
                $featured = $category->getProducts((int) Context::getContext()->language->id, 1, $nb);
            }
            if (Configuration::get('LEOMOD_NEWARRIALS_DISPLAY')) {
                $newProducts = Product::getNewProducts((int) ($params['cookie']->id_lang), 0, $nb);
            }
            if (Configuration::get('LEOMOD_SPECIAL_DISPLAY')) {
                $special = Product::getPricesDrop((int) ($params['cookie']->id_lang), 0, $nb);
            }

            if (Configuration::get('LEOMOD_BESTSELLER_DISPLAY')) {
                $bestseller = ProductSale::getBestSales((int) ($params['cookie']->id_lang), 0, $nb);
            }
            $items_page = (int) (Configuration::get('LEOMOD_ITEMS_PAGE'));
            $items_page = ($items_page ? $items_page : 3);

            $columns_page = (int) (Configuration::get('LEOMOD_COLUMNS_PAGE'));
            $columns_page = ($columns_page ? $columns_page : 3);




            $dir = dirname(__FILE__) . "/products.tpl";
            $tdir = _PS_ALL_THEMES_DIR_ . _THEME_NAME_ . '/modules/' . $this->name . '/products.tpl';

            if (file_exists($tdir)) {
                $dir = $tdir;
            }

            $this->smarty->assign(array(
                'itemsperpage' => $items_page,
                'columnspage' => $columns_page,
                'product_tpl' => $dir,
                'special' => $special,
                'bestseller' => $bestseller,
                'featured' => $featured,
                'newproducts' => $newProducts,
                'scolumn' => 12 / $columns_page,
                'mediumSize' => Image::getSize(ImageType::getFormatedName('medium')),
            ));
        }
        return $this->display(__FILE__, 'blockleoproducttabs.tpl', $this->getCacheId());
    }

    public function hookLeftColumn($params) {
        return $this->hookRightColumn($params);
    }

    public function hookHeader($params) {
        $this->context->controller->addCSS(($this->_path) . 'blockleoproducttabs.css', 'all');
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
    
    public function _clearBLCCache(){
        $this->_clearCache('blockleoproducttabs.tpl');
        $this->_clearCache('product.tpl');
    }
    public function hookAddProduct($params) {
        $this->_clearBLCCache();
    }

    public function hookUpdateProduct($params) {
        $this->_clearBLCCache();
    }

    public function hookDeleteProduct($params) {
        $this->_clearBLCCache();
    }

}

