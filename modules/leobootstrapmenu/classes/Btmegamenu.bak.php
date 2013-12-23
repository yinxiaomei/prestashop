<?php
/**
 * Leo bootstrap menu Module
 * 
 * @version		$Id: file.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) September 2012 LeoTheme.Com <@emai:leotheme@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */
 
 
class Btmegamenu extends ObjectModel
{
	public $id;
	public $image;
	public $id_parent = 1;
	public $is_group = 0;
	public $width;
	public $submenu_width;
	public $colum_width;
	public $submenu_colum_width;
	public $item;
	public $colums =1;
	public $type;
	public $is_content = 0;
	public $show_title = 1;
	public $type_submenu;
	public $level_depth;
	public $active = 1;
	public $position;
	public $show_sub;
	public $url;
	public $target;
	public $privacy;
	public $position_type;
	public $menu_class;
	public $content;
	public $submenu_content;
	public $level;
	public $left;
	public $right;
	public $date_add;
	public $date_upd;
	
	// Lang
	public $title;
	public $description;
	public $content_text;
	public $submenu_content_text;
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'btmegamenu',
		'primary' => 'id_btmegamenu',
		'multilang' => true,
		'fields' => array(
			'image' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName'),
			'id_parent' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
			'is_group' => 			array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'width' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'submenu_width' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'colum_width' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'submenu_colum_width' => 	array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
			'item' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'colums' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'type' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'is_content' => 			array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'show_title' => 			array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'type_submenu' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 10),
			'level_depth' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'active' => 			array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'position' => 			array('type' => self::TYPE_INT),
			'show_sub' => 			array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'url' => 			array('type' => self::TYPE_STRING, 'validate' => 'isUrl', 'size' => 255),
			'target' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
			'privacy' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'size' => 6),
			'position_type' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
			'menu_class' => 			array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
			'content' => 			array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'submenu_content' => 			array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'level' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'left' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'right' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'date_add' => 			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'date_upd' => 			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),

			// Lang fields
			'title' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'required' => true, 'size' => 255),
			'description' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
			'content_text' => 	array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString'),
			'submenu_content_text' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString'),
		),
	);

	public	function add($autodate = true, $null_values = false)
	{
		$this->position = Btmegamenu::getLastPosition((int)$this->id_parent);
		$this->level_depth = $this->calcLevelDepth();
		$context = Context::getContext();
		$id_shop = $context->shop->id;
		$res = parent::add($autodate, $null_values);
		$res &= Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'btmegamenu_shop` (`id_shop`, `id_btmegamenu`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')'
		);
		$this->cleanPositions($this->id_parent);
		return $res;
	}

	public	function update($null_values = false) {
		$this->level_depth = $this->calcLevelDepth();
		return parent::update($null_values);
	}
	
	protected function recursiveDelete(&$to_delete, $id_btmegamenu) {
	 	if (!is_array($to_delete) || !$id_btmegamenu)
	 		die(Tools::displayError());

		$result = Db::getInstance()->executeS('
		SELECT `id_btmegamenu`
		FROM `'._DB_PREFIX_.'btmegamenu`
		WHERE `id_parent` = '.(int)$id_btmegamenu);
		foreach ($result as $row) {
			$to_delete[] = (int)$row['id_btmegamenu'];
			$this->recursiveDelete($to_delete, (int)$row['id_btmegamenu']);
		}
	}
	
	public function delete()
	{
		if ($this->id == 1) return false;
		$this->clearCache();
		
		// Get children categories
		$to_delete = array((int)$this->id);
		$this->recursiveDelete($to_delete, (int)$this->id);
		$to_delete = array_unique($to_delete);

		// Delete CMS Category and its child from database
		$list = count($to_delete) > 1 ? implode(',', $to_delete) : (int)$this->id;
		Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'btmegamenu` WHERE `id_btmegamenu` IN ('.$list.')');
		Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'btmegamenu_shop` WHERE `id_btmegamenu` IN ('.$list.')');
		Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'btmegamenu_lang` WHERE `id_btmegamenu` IN ('.$list.')');
		Btmegamenu::cleanPositions($this->id_parent);
		return true;
	}
	
	public function deleteSelection($menus) {
		$return = 1;
		foreach ($menus as $id_btmegamenu){
			$objMenu = new Btmegamenu($id_btmegamenu);
			$return &= $objMenu->delete();
		}
		return $return;
	}
	
	public function calcLevelDepth()
	{
		$parentBtmegamenu = new Btmegamenu($this->id_parent);
		if (!$parentBtmegamenu)
			die('parent Menu does not exist');
		return $parentBtmegamenu->level_depth + 1;
	}
	
	public function updatePosition($way, $position)
	{
		if (!$res = Db::getInstance()->executeS('
			SELECT cp.`id_btmegamenu`, cp.`position`, cp.`id_parent`
			FROM `'._DB_PREFIX_.'btmegamenu` cp
			WHERE cp.`id_parent` = '.(int)$this->id_parent.'
			ORDER BY cp.`position` ASC'
		))
			return false;
		foreach ($res as $menu)
			if ((int)$menu['id_btmegamenu'] == (int)$this->id)
				$moved_menu = $menu;

		if (!isset($moved_menu) || !isset($position))
			return false;
		// < and > statements rather than BETWEEN operator
		// since BETWEEN is treated differently according to databases
		return (Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'btmegamenu`
			SET `position`= `position` '.($way ? '- 1' : '+ 1').'
			WHERE `position`
			'.($way
				? '> '.(int)$moved_menu['position'].' AND `position` <= '.(int)$position
				: '< '.(int)$moved_menu['position'].' AND `position` >= '.(int)$position).'
			AND `id_parent`='.(int)$moved_menu['id_parent'])
		&& Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'btmegamenu`
			SET `position` = '.(int)$position.'
			WHERE `id_parent` = '.(int)$moved_menu['id_parent'].'
			AND `id_btmegamenu`='.(int)$moved_menu['id_btmegamenu']));
	}

	public static function cleanPositions($id_parent)
	{
		$result = Db::getInstance()->executeS('
		SELECT `id_btmegamenu`
		FROM `'._DB_PREFIX_.'btmegamenu`
		WHERE `id_parent` = '.(int)$id_parent.'
		ORDER BY `position`');
		$sizeof = count($result);
		for ($i = 0; $i < $sizeof; ++$i)
		{
			$sql = '
			UPDATE `'._DB_PREFIX_.'btmegamenu`
			SET `position` = '.(int)$i.'
			WHERE `id_parent` = '.(int)$id_parent.'
			AND `id_btmegamenu` = '.(int)$result[$i]['id_btmegamenu'];
			Db::getInstance()->execute($sql);
		}
		return true;
	}

	public static function getLastPosition($id_parent) {
		return (Db::getInstance()->getValue('SELECT MAX(position)+1 FROM `'._DB_PREFIX_.'btmegamenu` WHERE `id_parent` = '.(int)$id_parent));
	}
	
	public function getInfo( $id_btmegamenu, $id_lang = null, $id_shop = null ){
		if(!$id_lang) $id_lang = Context::getContext()->language->id;
		if(!$id_shop) $id_shop = Context::getContext()->shop->id;
		$sql = 'SELECT m.*, md.title, md.description, md.content_text, md.submenu_content_text 
				FROM '. _DB_PREFIX_ .'megamenu m 
				LEFT JOIN '._DB_PREFIX_.'btmegamenu_lang md ON m.id_btmegamenu = md.id_btmegamenu AND md.id_lang = '.(int)$id_lang 
				.' JOIN '._DB_PREFIX_.'btmegamenu_shop bs ON m.id_btmegamenu = bs.id_btmegamenu AND bs.id_shop = '.(int)($id_shop);
		$sql .= ' WHERE m.id_btmegamenu='.(int)$id_btmegamenu;
		
		return Db::getInstance()->executeS($sql);
	}
	
	public function getChild( $id_btmegamenu = null, $id_lang = null, $id_shop = null, $active = false ){
		if(!$id_lang) $id_lang = Context::getContext()->language->id;
		if(!$id_shop) $id_shop = Context::getContext()->shop->id;
		
		$sql = ' SELECT m.*, md.title, md.description, md.content_text, md.submenu_content_text
				FROM ' . _DB_PREFIX_ . 'btmegamenu m 
				LEFT JOIN '._DB_PREFIX_.'btmegamenu_lang md ON m.id_btmegamenu = md.id_btmegamenu AND md.id_lang = '.(int)$id_lang
				.' JOIN '._DB_PREFIX_.'btmegamenu_shop bs ON m.id_btmegamenu = bs.id_btmegamenu AND bs.id_shop = '.(int)($id_shop);
		if($active)
			$sql .= ' WHERE m.`active`=1 ';
		
		if( $id_btmegamenu != null ) {
			$sql .= ' WHERE id_parent='.(int)$id_btmegamenu;						
		}
		$sql .= ' ORDER BY `position` ';
		return Db::getInstance()->executeS($sql);
	}
	
	public function hasChild( $id ){
		return isset($this->children[$id]);
	}
	
	public function getNodes( $id ){
		return $this->children[$id];
	}
	
	public function getTree( $id=null ){
		$childs = $this->getChild( $id );
		
		foreach($childs as $child ){
			$this->children[$child['id_parent']][] = $child;	
		}
		$parent = 1 ;
		$output = $this->genTree( $parent, 1 );
		return $output;
	}
	
	public function getDropdown( $id=null, $selected=1 ){
		$this->children = array();
		$childs = $this->getChild( $id );
		foreach($childs as $child ){
			$this->children[$child['id_parent']][] = $child;	
		}
		
		$output = '<select name="id_parent" >';
		$output .='<option value="1">ROOT</option>';	
		$output .= $this->genOption( 1 ,1, $selected );
		$output .= '</select>';
		return $output ;
	}
	
	public function genOption( $parent, $level=0, $selected ){
		$output = '';
		if( $this->hasChild($parent) ){
			$data = $this->getNodes( $parent );
			foreach( $data as $menu ){
				$select = $selected == $menu['id_btmegamenu'] ? 'selected="selected"':"";
				$output .= '<option value="'.$menu['id_btmegamenu'].'" '.$select.'>'.str_repeat("-",$level) ." ".$menu['title'].' (ID:'.$menu['id_btmegamenu'].')</option>';
				$output .= $this->genOption(  $menu['id_btmegamenu'],$level+1, $selected );
			}				
		}
		
		return $output;
	}
	
	public function genTree( $parent, $level ){
		if( $this->hasChild($parent) ){
			$data = $this->getNodes( $parent );
			$t = $level == 1 ? " sortable" : "";
			$output = '<ol class="level'.$level. $t.' ">';
			
			foreach( $data as $menu ){
				$output .='<li id="list_'.$menu['id_btmegamenu'].'">
				<div><span class="disclose"><span></span></span>'.($menu['title'] ? $menu['title']:"").' (ID:'.$menu['id_btmegamenu'].') <span class="quickedit" rel="id_'.$menu['id_btmegamenu'].'">E</span><span class="quickdel" rel="id_'.$menu['id_btmegamenu'].'">D</span></div>';
				$output .= $this->genTree( $menu['id_btmegamenu'], $level+1 );
				$output .= '</li>';
			}
			
			$output .= '</ol>';
			return $output;
		}
		return ;
	}
	
	public function getFrontTree( $parent=1 ){
	
		$childs = $this->getChild( null, null, null, true );
		
		foreach($childs as $child ){
			$this->children[$child['id_parent']][] = $child;	
		}
		$parent = 1 ;
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$this->image_base_url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__).'modules/leobootstrapmenu/icons/' ;
		$output = '';
		if( $this->hasChild($parent) ){
			$data = $this->getNodes( $parent );
			// render menu at level 0
			$output = '<ul class="nav megamenu">';
			$page_name = Dispatcher::getInstance()->getController();
			$true = false;
			foreach( $data as $menu ){
				$selected = $this->getSelect($menu);
				if( $this->hasChild($menu['id_btmegamenu']) || $menu['type_submenu'] == 'html'){
					$output .= '<li class="parent dropdown '.$menu['menu_class'].$selected.'">
					<a class="dropdown-toggle" data-toggle="dropdown" href="'.$this->getLink( $menu ).'">';
					
					if( $menu['image']){ $output .= '<span class="menu-icon" style="background:url(\''.$this->image_base_url.$menu['image'].'\') no-repeat;">';	}
					$output .= '<span class="menu-title">'.htmlentities(stripslashes($menu['title']), ENT_COMPAT, 'UTF-8')."</span>";
					if( $menu['description'] ){
						$output .= '<span class="menu-desc">' . htmlentities(stripslashes($menu['description']), ENT_COMPAT, 'UTF-8'). "</span>";
					}
					$output .= "<b class=\"caret\"></b></a>";
					if( $menu['image']){  $output .= '</span>'; }
					
					$output .= $this->genFrontTree( $menu['id_btmegamenu'], 1, $menu );
					$output .= '</li>';
				}else {
					$output .= '<li class="'.$menu['menu_class'].$selected.'">
					<a href="'.$this->getLink( $menu ).'">';
					
					if( $menu['image']){ $output .= '<span class="menu-icon" style="background:url(\''.$this->image_base_url.$menu['image'].'\') no-repeat;">';	}
					
					$output .= '<span class="menu-title">'.htmlentities(stripslashes($menu['title']), ENT_COMPAT, 'UTF-8')."</span>";
					if( $menu['description'] ){
						$output .= '<span class="menu-desc">' . htmlentities(stripslashes($menu['description']), ENT_COMPAT, 'UTF-8') . "</span>";
					}
					if( $menu['image']){ $output .= '</span>';	}
					$output .= '</a></li>';
				}
			}
			$output .= '</ul>';
			
		}

		 return $output;
	
	}
	public function getSelect( $menu ){
		global $link, $cookie;
		$page_name = Dispatcher::getInstance()->getController();
		$value = (int)$menu['item'];
		$result = '';
		switch ( $menu['type'] ){
			case 'product':
				if($value == Tools::getValue('id_product') &&  $page_name== 'product')
					$result = ' active';
			break;
			case 'category':
				if($value == Tools::getValue('id_category') && $page_name == 'category')
					$result = ' active';
			break;
			case 'cms':
				if($value == Tools::getValue('id_cms') && $page_name == 'cms')
					$result = ' active';
			break;
			case 'manufacturer':
				if($value == Tools::getValue('id_manufacturer') && $page_name == 'manufacturer')
					$result = ' active';
			break;
			case 'supplier':
				if($value == Tools::getValue('id_supplier') && $page_name == 'supplier')
					$result = ' active';
			break;
			default:
				$result = '';
			break;
		}
		return $result;
		
	}
	
	public function genFrontTree( $id_parent, $level, $parent ){
		$class = $parent['is_group']?"dropdown-mega":"dropdown-menu";
		
		if( $parent['type_submenu'] == 'html' ){
			$output = '<div class="'.$class.'"><div class="menu-content">';
			$output .= html_entity_decode($parent['submenu_content_text']);
			$output .= '</div></div>';
			return $output;
		}elseif( $this->hasChild($id_parent) ){
			$data = $this->getNodes( $id_parent );			
			$parent['colums'] = (int)$parent['colums'];
			if( $parent['colums'] > 1  ){
				$output = '<div class="'.$class.' menu-content mega-cols cols'.$parent['colums'].'"><div class="row-fluid">';
				$cols = array_chunk( $data, ceil(count($data)/$parent['colums'])  );
				$oSpans = $this->getColWidth( $parent, (int)$parent['colums'] );
			
				foreach( $cols as $i =>  $menus ){

					$output .='<div class="mega-col '.$oSpans[$i+1].' col-'.($i+1).'"><ul>';
						foreach( $menus as $menu ) {
							$output .= $this->renderMenuContent( $menu );
						}
					$output .='</ul></div>';
				}
				$output .= '</div></div>';
				return $output;
			}else {
				$output = '<ul class="'.$class.' level'.$level.'">';

				foreach( $data as $menu ){
					$output .= $this->renderMenuContent( $menu );
				}	
				
				$output .= '</ul>';
			}
			return $output;
		}
		return ;
	}
	
	public function renderMenuContent( $menu ){
		
		$output = '';
		$class = $menu['is_group']?"mega-group":"";
		
		
		$menu['menu_class'] = ' '.$class;
		if( $menu['type'] == 'html' ){ 
			$output .= '<li class="'.$menu['menu_class'].'">';	
			$output .= '<div class="menu-content">'.html_entity_decode($menu['content_text']).'</div>'; 
			$output .= '</li>';
			return $output;
		}
		if( $this->hasChild($menu['id_btmegamenu']) ){
			$output .= '<li class="parent dropdown-submenu'.$menu['menu_class'].'">';
			if( $menu['show_title'] ){
				$output .= '<a class="dropdown-toggle" data-toggle="dropdown" href="'.$this->getLink( $menu ).'">';
				$t = '%s';
				if( $menu['image']){ $output .= '<span class="menu-icon" style="background:url(\''.$this->image_base_url.$menu['image'].'\') no-repeat;">';	}
				$output .= '<span class="menu-title">'.htmlentities(stripslashes($menu['title']), ENT_COMPAT, 'UTF-8')."</span>";
				if( $menu['description'] ){
					$output .= '<span class="menu-desc">' . htmlentities(stripslashes($menu['description']), ENT_COMPAT, 'UTF-8') . "</span>";
				}
				$output .= "<b class=\"caret\"></b></a>";
				if( $menu['image']){ 
					$output .= '</span>';
				}
			}	
			$output .= $this->genFrontTree( $menu['id_btmegamenu'], 1, $menu );
			$output .= '</li>';
		}else {
			$output .= '<li class="'.$menu['menu_class'].'">';
			if( $menu['show_title'] ){ 
				$output .= '<a href="'.$this->getLink( $menu ).'">';
			
				if( $menu['image']){ $output .= '<span class="menu-icon" style="background:url(\''.$this->image_base_url.$menu['image'].'\') no-repeat;">';	}
				$output .= '<span class="menu-title">'.htmlentities(stripslashes($menu['title']), ENT_COMPAT, 'UTF-8')."</span>";
				if( $menu['description'] ){
					$output .= '<span class="menu-desc">' . htmlentities(stripslashes($menu['description']), ENT_COMPAT, 'UTF-8') . "</span>";
				}
				if( $menu['image']){ 
					$output .= '</span>';
				}

				$output .= '</a>';
			}
			$output .= '</li>';
		}
		return $output;
	}
	
	
	public function getLink( $menu ){
		global $link, $cookie;
		$value = (int)$menu['item'];
		$result = '';
		switch ( $menu['type'] ){
			case 'product':
				if(Validate::isLoadedObject($objPro = new Product($value,true, $cookie->id_lang))){
					$result = $link->getProductLink((int)$objPro->id, $objPro->link_rewrite, NULL, NULL, $cookie->id_lang);
				}
			break;
			case 'category':
				if(Validate::isLoadedObject($objCate = new Category($value, $cookie->id_lang))){
					$result = $link->getCategoryLink((int)$objCate->id, $objCate->link_rewrite, $cookie->id_lang);
				}
			break;
			case 'cms':
				if(Validate::isLoadedObject($objCMS = new CMS($value, $cookie->id_lang))){
					$result = $link->getCMSLink((int)$objCMS->id, $objCMS->link_rewrite, $cookie->id_lang);
				}
			break;
			case 'url':
				$value = $menu['url'];
				if(strpos($value, 'http') !== false){
					$result = $value;
				}else{
					$result = $link->getPageLink($value, false, $cookie->id_lang);
				}
			break;
			case 'manufacturer':
				if(Validate::isLoadedObject($objManu = new Manufacturer($value, $cookie->id_lang))){
					$result = $link->getManufacturerLink((int)$objManu->id, $objManu->link_rewrite, $cookie->id_lang);
				}
			break;
			case 'supplier':
				if(Validate::isLoadedObject($objSupp = new Supplier($value, $cookie->id_lang))){
					$result = $link->getSupplierLink((int)$objSupp->id, $objSupp->link_rewrite, $cookie->id_lang);
				}
			break;
		}
		return $result;
		
	}
	
	public function getColWidth( $menu, $cols ){
		$output = array();
		
		$split = preg_split('#\s+#',$menu['submenu_colum_width'] );
		if( !empty($split) && !empty($menu['submenu_colum_width']) ){
			foreach( $split as $sp ) {
				$tmp = explode("=",$sp);
				if( count($tmp) > 1 ){
					$output[trim(preg_replace("#col#","",$tmp[0]))]=(int)$tmp[1];
				}
			}
		}
		$tmp = array_sum($output);
		$spans = array();
		$t = 0; 
		for( $i=1; $i<= $cols; $i++ ){
			if( array_key_exists($i,$output) ){
				$spans[$i] = 'span'.$output[$i];
			}else{		
				if( (12-$tmp)%($cols-count($output)) == 0 ){
					$spans[$i] = "span".((12-$tmp)/($cols-count($output)));
				}else {
					if( $t == 0 ) {
						$spans[$i] = "span".( ((11-$tmp)/($cols-count($output))) + 1 ) ;
					}else {
						$spans[$i] = "span".( ((11-$tmp)/($cols-count($output))) + 0 ) ;
					}
					$t++;
				}					
			}
		}
		return $spans;
	}
	
	
}





