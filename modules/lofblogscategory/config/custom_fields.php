<?php

/**
 * Custom field for LOFParamsField 
 * 
 * - Define some field for individual module -
 * 
 * How to named your field : <get><MyfieldName><Field>. e.g : getMyelementField($field) {}
 * 
 */

class LOFParamsFieldLofblogscategory extends LOFParamsField {
    
    var $categoriesOptionList = null;
    
    function getCategoriesField($field){
        $this->getNestedCategoriesData();
        if(count($this->categoriesOptionList) && $this->categoriesOptionList) {
            
            array_unshift($this->categoriesOptionList, array('text' => ' --- select All ---', 'value' => ''));
            $field['options'] = $this->categoriesOptionList;
            
            return $this->getListField($field);
        } else {
            return 'No category found';
        }
    }
    function getNestedCategoriesData($id=1) {               
        $category = $this->getCategoryOptions($id);        
        $children = $this->getCategoryChildren($id);
       
        //check if category has children :
        if (is_array($children) && count($children) > 0) {
            foreach ($children as $child) {
                $this->getNestedCategoriesData($child['value']);                
            }
        }
    }

    function makeOptionText($level, $text, $char = '...') {
        $prefix = '';
        for ($level; $level > 0; $level--) {
            $prefix .= $char;
        }
        return $prefix . ' ' . $text;
    }

    function getCategoryOptions($id) {
        global $cookie;
        $query = '
		SELECT c.id_lofblogs_category as value, cl.name as text, c.level_depth as level 
		FROM  ' . _DB_PREFIX_ . 'lofblogs_category c
		JOIN ' . _DB_PREFIX_ . 'lofblogs_category_lang cl ON (c.id_lofblogs_category  = cl.id_lofblogs_category)
		WHERE cl.id_lang = ' . intval($this->config->defaultLang) . ' AND c.id_lofblogs_category = ' . intval($id);
        
        $category = Db::getInstance()->getRow($query); 
        
        //get english version if empty :
        if (!count($category) || !is_array($category)) {
            $query = '
		SELECT c.id_lofblogs_category as value, cl.name as text, c.level_depth as level 
		FROM  ' . _DB_PREFIX_ . 'lofblogs_category c
		JOIN ' . _DB_PREFIX_ . 'lofblogs_category_lang cl ON (c.id_lofblogs_category  = cl.id_lofblogs_category)
		WHERE cl.id_lang = 1 AND c.id_lofblogs_category = ' . intval($id);

            $category = Db::getInstance()->getRow($query);
        }
        
        if(intval($id) == 1) { 
            $disable = true;
        } else {
            $disable = false;
        }
        //if($category['value'] != 1){
            $option = array('value' => $category['value'], 'text' => $this->makeOptionText($category['level'], $category['text']), 'disable' => $disable);
            $this->categoriesOptionList[] = $option;
        //}
    }

    function getCategoryChildren($id) {
        global $cookie;
        $query = '
		SELECT c.id_lofblogs_category as value, cl.name as text, c.level_depth as level 
		FROM  ' . _DB_PREFIX_ . 'lofblogs_category c
		JOIN ' . _DB_PREFIX_ . 'lofblogs_category_lang cl ON (c.id_lofblogs_category  = cl.id_lofblogs_category)
		WHERE cl.id_lang = ' . intval($this->config->defaultLang) . ' AND c.id_parent = ' . intval($id);
        $category = Db::getInstance()->ExecuteS($query);
        //get english version if empty :
        if (!count($category) || !is_array($category)) {
            $query = '
		SELECT c.id_lofblogs_category as value, cl.name as text, c.level_depth as level 
		FROM  ' . _DB_PREFIX_ . 'lofblogs_category c
		JOIN ' . _DB_PREFIX_ . 'lofblogs_category_lang cl ON (c.id_lofblogs_category  = cl.id_lofblogs_category)
		WHERE cl.id_lang = 1 AND c.id_parent = ' . intval($id);

            $category = Db::getInstance()->getRow($query);
        }
        return $category;
    }    
}