<?php

$useSSL = true;

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/wdproductsearch.php');
$context = Context::getContext();

	$module = new WdProductSearch();
	$id_lang = Tools::getValue('id_lang');
	
	
	$Products = Product::getProducts($id_lang, 0, 1000, 'id_product', 'ASC');
        $Products = Product::getProductsProperties((int)($params['cookie']->id_lang), $Products);
	$COLOUR = Tools::getValue('COLOUR');
	$STYLE = Tools::getValue('STYLE');
	$SHAPE = Tools::getValue('SHAPE');
	$POPULAR = Tools::getValue('POPULAR');
	$INDUSTRY = Tools::getValue('INDUSTRY');
	
	$search_arr = array();
	if($COLOUR) array_push($search_arr, $COLOUR);
	if($STYLE) array_push($search_arr, $STYLE);
	if($SHAPE) array_push($search_arr, $SHAPE);
	if($POPULAR) array_push($search_arr, $POPULAR);
	if($INDUSTRY) array_push($search_arr, $INDUSTRY);
	
	//-------------
	if(!$COLOUR && !$STYLE && !$SHAPE && !$POPULAR && !$INDUSTRY)
	{
		foreach($Products as $item)
		{
			//---check id_image add it to the $item
                        $aa = Product::getCover($item['id_product']);
			$bb = $aa['id_image'];
			$item['id_image'] = $bb;
			//-----------------------------
			$item['link'] = '?id_product='.$item['id_product'].'&controller=product&id_lang=1&COLOUR='.$COLOUR;
			$item['quantity'] = Product::getQuantity($item['id_product']);
			$Products_display[$count++] = $item;
		}
	}
	else{
		$result = $module->getProductIdByTags($search_arr);
		$count = 0;
		foreach($Products as $item)
		{
			if(in_array($item['id_product'], $result))
			{
				//---check id_image add it to the $item
				$aa = Product::getCover($item['id_product']);
				$bb = $aa['id_image'];
				$item['id_image'] = $bb;
				//-----------------------------
				$item['link'] = '?id_product='.$item['id_product'].'&controller=product&id_lang=1&COLOUR='.$COLOUR;
				$item['quantity'] = Product::getQuantity($item['id_product']);
				$Products_display[$count++] = $item;
			}
		}
	}
	
	$context->smarty->assign(array(
		'suppliers' => Supplier::getSuppliers(false, $id_lang),
   		'products' => $Products_display,
   		'homeSize' => Image::getSize('home_default'),
   		'link' => $context->link
	));
	

	$context->smarty->display(dirname(__FILE__).'/manageproducts.tpl');
	


