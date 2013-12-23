<?php

/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	$Subpackage
 * @copyright	Copyright (C) May 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website 	htt://landofcoder.com
 * @license		GNU General Public License version 2
 */
if (!defined('_CAN_LOAD_FILES_')) {
    define('_CAN_LOAD_FILES_', 1);
}
if (!class_exists('LofMiniGalleryProductDataSource', false)) {

    class LofMiniGalleryProductDataSource extends LofMiniGalleryDataSourceBase {

        /**
         * @var string $__name;
         *
         * @access private
         */
        var $__name = 'product';

        /**
         * override method: get list image from articles.
         */
        function getListByParameters($params, $ids) {
            if (_PS_VERSION_ <= "1.4") {
                $products = self::_getListv13($params, $ids);
            } elseif (_PS_VERSION_ < "1.5"){
                $products = self::_getListv14($params, $ids);
            } else {
                $products = self::_getListv15($params, $ids);
            }
            $isThumb = $params->get('auto_renderthumb', 1);
            $maxDesc = $params->get('des_limit', 100);
            if (empty($products))
                return array();
            foreach ($products as &$product) { 
                $product['description'] = substr(trim(strip_tags($product['description_short'])), 0, $maxDesc);
                $product['price'] = Tools::displayPrice($product['price']);
                if ($product['link']) {
                    $product['link'] = $this->addhttp($product['link']);
                    $product['description'] = $product['description'] . "<a href='" . $product['link'] . "' title='" . $product['name'] . "' >" . $params->get('readmore_txt', '[More...]') . "</a>";
                }
                $product = $this->parseImages($product, $params);
                $product = $this->generateImages($product, $params);
            }
            return $products;
        }

        /**
         * Get list in prestashop v13
         */
        private function _getListv13($params, $ids) {
            global $smarty;
            $homeSorce = $params->get("home_sorce", "selectcat");
            if ($homeSorce == "selectcat") {
                $where = "";
                $selectCat = $ids;
                $selectCat = !is_array($selectCat) ? $selectCat : implode(",", $selectCat);
                if ($selectCat != "") {
                    $catArray = explode(",", $selectCat);
                    if (count($catArray) == 1) {
                        $where = " AND cp.`id_category` = " . $catArray[0];
                    } else {
                        $where = " AND cp.`id_category` IN (" . $selectCat . ")";
                    }
                }
                $catArray = explode(",", $selectCat);
                $products = self::getProductsV13($where, 0, $params->get("limit_items", 12), "p.id_product");
            } elseif ($homeSorce == 'productids') {
                $productids = explode(",", trim($params->get("productids", "1,2,3,4,5")));
                $ids = array();
                foreach ($productids as $id) {
                    $ids = (int) $id;
                }
                $where = '';
                " AND p.`id_product` IN (" . implode(",", $ids) . ")";
                $products = self::getProductsV13($where, 0, $params->get("limit_items", 12), "p.id_product");
            } else {
                $category = new Category(1);
                $nb = intval($params->get("limit_items", 10)); //Number of product displayed
                $products = $category->getProducts(intval($smarty->_tpl_vars['cookie']->id_lang), 1, ($nb ? $nb : 10));
            }
            return $products;
        }

        /**
         * Get data source: 
         */
        function getProductsV13($where='', $limiStart=0, $limit=10, $order='') {
            global $cookie, $link;
            $id_lang = intval($cookie->id_lang);
            $sql = '
			SELECT DISTINCT p.id_product, p.*, c.`id_category` as lof_id_cat, c.`id_parent` as lof_id_parent, pa.`id_product_attribute`, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, i.`id_image`, il.`legend`, m.`name` AS manufacturer_name, tl.`name` AS tax_name, t.`rate`, cl.`name` AS category_default, DATEDIFF( now(), p.date_add) as newnumdays, DATEDIFF(p.`date_add`, DATE_SUB(NOW(), INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY)) > 0 AS new,
				(p.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1) - IF((DATEDIFF(`reduction_from`, CURDATE()) <= 0 AND DATEDIFF(`reduction_to`, CURDATE()) >=0) OR `reduction_from` = `reduction_to`, IF(`reduction_price` > 0, `reduction_price`, (p.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1) * `reduction_percent` / 100)),0)) AS orderprice 
			FROM `' . _DB_PREFIX_ . 'category_product` cp
			LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON p.`id_product` = cp.`id_product`
            LEFT JOIN `' . _DB_PREFIX_ . 'category` c ON c.`id_category` = cp.`id_category`
			LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute` pa ON (p.`id_product` = pa.`id_product` AND default_on = 1)
			LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = ' . intval($id_lang) . ')
			LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = ' . intval($id_lang) . ')
			LEFT JOIN `' . _DB_PREFIX_ . 'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
			LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = ' . intval($id_lang) . ')
			LEFT JOIN `' . _DB_PREFIX_ . 'tax` t ON t.`id_tax` = p.`id_tax`
			LEFT JOIN `' . _DB_PREFIX_ . 'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = ' . intval($id_lang) . ')
			LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
			WHERE  p.`active` = 1' . $where;
            $sql .= ' GROUP BY p.id_product ORDER BY ' . $order
                    . ' LIMIT ' . $limiStart . ',' . $limit;
            //echo $sql;die;
            $result = Db::getInstance()->ExecuteS($sql);
            return Product::getProductsProperties($id_lang, $result);
        }

        /**
         * Get list in prestashop v14
         */
        private function _getListv14($params, $ids) {
            $homeSorce = $params->get("home_sorce", "selectcat");
            if ($homeSorce == "selectcat") {
                $where = "";
                $selectCat = $ids;
                $selectCat = !is_array($selectCat) ? $selectCat : implode(",", $selectCat);
                if ($selectCat != "") {
                    $catArray = explode(",", $selectCat);
                    if (count($catArray) == 1) {
                        $where = " AND cp.`id_category` = " . $catArray[0];
                    } else {
                        $where = " AND cp.`id_category` IN (" . $selectCat . ")";
                    }
                }
                $catArray = explode(",", $selectCat);
                $order = $params->get("order_by", "p.date_add");
                $products = self::getProductsV14($where, 0, $params->get("limit_items", 12), $order);
            } elseif ($homeSorce == 'productids') {
                $productids = explode(",", trim($params->get("productids", "1,2,3,4,5")));
                $ids = array();
                foreach ($productids as $id) {
                    $ids[] = (int) $id;
                }
                $where = " AND p.`id_product` IN (" . implode(",", $ids) . ")";
                $products = self::getProductsV14($where, 0, $params->get("limit_items", 12), "p.id_product");
            } else {
                $category = new Category(1, Configuration::get('PS_LANG_DEFAULT'));
                $nb = (int) (Configuration::get('HOME_FEATURED_NBR'));
                $products = $category->getProducts((int) ($pparams['cookie']->id_lang), 1, ($nb ? $nb : 10));
            }
            return $products;
        }

        /**
         * Get data source: 
         */
        function getProductsV14($where='', $limiStart=0, $limit=10, $order='') {
            global $cookie, $link;
            $id_lang = intval($cookie->id_lang);
            $sql = '
    		SELECT DISTINCT p.id_product, p.*, c.`id_category`, c.`id_parent`, pa.`id_product_attribute`, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, i.`id_image`, il.`legend`, m.`name` AS manufacturer_name, tl.`name` AS tax_name, t.`rate`, cl.`name` AS category_default, DATEDIFF( now(), p.date_add) as newnumdays, DATEDIFF(p.`date_add`, DATE_SUB(NOW(), INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY)) > 0 AS new,
    			(p.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1)) AS orderprice       
    		FROM `' . _DB_PREFIX_ . 'category_product` cp
    		LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON p.`id_product` = cp.`id_product`
            LEFT JOIN `' . _DB_PREFIX_ . 'category` c ON c.`id_category` = cp.`id_category`
    		LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute` pa ON (p.`id_product` = pa.`id_product` AND default_on = 1)
    		LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = ' . (int) ($id_lang) . ')
    		LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = ' . (int) ($id_lang) . ')
    		LEFT JOIN `' . _DB_PREFIX_ . 'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
    		LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) ($id_lang) . ')
    		LEFT JOIN `' . _DB_PREFIX_ . 'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group`
    		                                           AND tr.`id_country` = ' . (int) Country::getDefaultCountryId() . '
    	                                           	   AND tr.`id_state` = 0)
    	    LEFT JOIN `' . _DB_PREFIX_ . 'tax` t ON (t.`id_tax` = tr.`id_tax`)
    		LEFT JOIN `' . _DB_PREFIX_ . 'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = ' . (int) ($id_lang) . ')
    		LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`		
    		WHERE  p.`active` = 1' . $where;
            $sql .= ' GROUP BY p.id_product ORDER BY ' . $order
                    . ' LIMIT ' . $limiStart . ',' . $limit;
            //echo $sql;		
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
            return Product::getProductsProperties($id_lang, $result);
        }
		private function _getListv15($params, $ids) {
            $homeSorce = $params->get("home_sorce", "selectcat");
            if ($homeSorce == "selectcat") {
                $where = "";
                $selectCat = $ids;
                $selectCat = !is_array($selectCat) ? $selectCat : implode(",", $selectCat);
                if ($selectCat != "") {
                    $catArray = explode(",", $selectCat);
                    if (count($catArray) == 1) {
                        $where = " AND cp.`id_category` = " . $catArray[0];
                    } else {
                        $where = " AND cp.`id_category` IN (" . $selectCat . ")";
                    }
                }
                $catArray = explode(",", $selectCat);
                $order = $params->get("order_by", "p.date_add");
                $products = self::getProductsV15($where, 0, $params->get("limit_items", 12), $order);
            } elseif ($homeSorce == 'productids') {
                $productids = explode(",", trim($params->get("productids", "1,2,3,4,5")));
                $ids = array();
                foreach ($productids as $id) {
                    $ids[] = (int) $id;
                }
                $where = " AND p.`id_product` IN (" . implode(",", $ids) . ")";
                $products = self::getProductsV15($where, 0, $params->get("limit_items", 12), "p.id_product");
            } else {
                $category = new Category(Context::getContext()->shop->getCategory(), (int)Context::getContext()->language->id);
                $nb = (int) (Configuration::get('HOME_FEATURED_NBR'));
                $products = $category->getProducts((int) ($pparams['cookie']->id_lang), 1, ($nb ? $nb : 10));
            }
            return $products;
        }
		public static function getProductsV15($where='', $limiStart=0, $limit=10, $order=''){		
    		global $cookie, $link;
        	$id_lang = intval($cookie->id_lang);
			
        	$context = Context::getContext();
			$id_country = (int)($context->country->id);
			$front = true;
			if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
				$front = false;
			
            $sql = 'SELECT DISTINCT p.`id_product`, p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, product_attribute_shop.`id_product_attribute`, pl.`description`, pl.`description_short`, pl.`available_now`,
					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, i.`id_image`,
					il.`legend`, m.`name` AS manufacturer_name, tl.`name` AS tax_name, t.`rate`, cl.`name` AS category_default,
					DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'
						DAY)) > 0 AS new,
					(product_shop.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1)) AS orderprice
				FROM `'._DB_PREFIX_.'category_product` cp
				LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
				'.Shop::addSqlAssociation('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product`)
				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (product_shop.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (product_shop.`id_tax_rules_group` = tr.`id_tax_rules_group` AND tr.`id_country` = '.(int)$context->country->id.'
					AND tr.`id_state` = 0
					AND tr.`zipcode_from` = 0)
				LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
				LEFT JOIN `'._DB_PREFIX_.'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
				WHERE product_shop.`id_shop` = '.(int)$context->shop->id.'
				AND ((product_attribute_shop.id_product_attribute IS NOT NULL OR pa.id_product_attribute IS NULL) 
					OR (product_attribute_shop.id_product_attribute IS NULL AND pa.default_on=1))
					AND product_shop.`active` = 1'.$where
					.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').
				' ORDER BY '.$order.' LIMIT '.$limiStart.','.$limit;
			
    		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
			return Product::getProductsProperties($id_lang, $result);
    	}
        /**
         * get main image and thumb
         *
         * @param poiter $row .
         * @return void
         */
        public  function parseImages( $product, $params ){
			global $link;
            
            $isRenderedMainImage = 	$params->get("cre_main_size",0);
            $mainImageSize       =  $params->get("main_img_size",'home_default');
            
            if( $isRenderedMainImage ) { 
				if((int)Configuration::get('PS_REWRITING_SETTINGS') == 1){
					$product["mainImge"] = $this->getImageLink($product["link_rewrite"], $product["id_image"] );
				}else{
					$product["mainImge"] = $link->getImageLink($product["link_rewrite"], $product["id_image"] );
				}
	        } else{
	        	$product["mainImge"] = $link->getImageLink($product["link_rewrite"], $product["id_image"], $mainImageSize ); 
	        }
            $product["thumbImge"] = $product["mainImge"];

            return $product; 
		}

    }

}
?>