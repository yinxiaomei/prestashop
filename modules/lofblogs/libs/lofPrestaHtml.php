<?php

/**
 * @category Lof HTML helper
 * @author LandOfCoder
 * @todo make some html element with same type
 */
class lofPrestaHtml {

    protected $languages = null;
    protected $langName = '';
    protected $defaultLanguage = '';
    protected $object = null;
    public $categoriesOptionList = array();
    protected $repeatTime = 0;
    public $modulename = 'lofblogs';
    public $module = null;
    public $filename = 'default';

    function lofPrestaHtml($divLangName = '', $object = null) {
        global $cookie;
        $this->defaultLanguage = intval($cookie->id_lang);
        $this->languages = Language::getLanguages(false);
        $this->langName = $divLangName;
        $this->object = $object;
        $this->module = new $this->modulename();
    }

    function setTranslateFile($name) {
        $this->filename = $name;
    }
    /**
     *
     * ****************************** IMPORTANT FUNCTION *********************************
     * ** Build HTML element **
     * 
     * @param type $tag - a string with format TAGNAME[OPTION] e.g input[type="text"], textarea[class="classname"] ....
     * 
     * @param type $name - a string name of element
     * @param type $label - a string
     * @param type $translate - boolean TRUE or FALSE
     *      +)TRUE create some field for prestashop language system
     *      +)FALSE only create field without language flag
     * 
     * @param type $breakLine - boolean TRUE or FALSE
     *      +)TRUE create this element in newline
     *      +)FALSE stay in line...
     * @return string - html element
     */
    function getHtml($tag, $name = '', $label = '', $translate = true, $breakLine = true) {
        $pos = strpos(trim($tag), '[');
        if ($pos) {
            $tagName = substr($tag, 0, $pos);
            $tagAtrributes = substr($tag, intval($pos + 1), -1);
        } else {
            $tagName = $tag;
            $tagAtrributes = '';
        }

        $flagName = 'c' . $name;
        $html = '<label>' . ucfirst($label) . '</label>';
        $html .= '<div class="lofcontent-right-column">';

        //translation fields :
        if ($translate) {
            foreach ($this->languages as $lang) {
                $langId = $lang['id_lang'];
                $display = $langId == $this->defaultLanguage ? 'block' : 'none';
                $value = $this->getFieldValue($name, intval($langId));
                $eName = $name . '_' . $langId;
                $html .= '<div id="' . $flagName . '_' . $langId . '" style="display: ' . $display . '; float: left;">';
                $html .= $this->getPrimaryObject($tagName, $eName, $value, $tagAtrributes);
                $html .= '</div>';
            }
            $html .= $this->displayFlags($flagName);
        } else {

            //no translation fields :
			
            $value = (($this->getFieldValue($name) && is_string($this->getFieldValue($name))) ? htmlentities($this->getFieldValue($name), ENT_COMPAT, 'UTF-8') : '');
            $html .= $this->getPrimaryObject($tagName, $name, $value, $tagAtrributes);
        }
        $html .= '</div>';
        if ($breakLine) {
            $html .= '<div class="clearfix"></div>';
        }
        return $html;
    }

    function getPrimaryObject($tagname, $name, $value, $attr) {
        switch (strtolower(trim($tagname))) {
            case 'textarea':
                return $this->getTextArea($name, $value, $attr);
                break;
            case 'status':
                return $this->getStateBox($value, $attr);
                break;
            case 'custom':
                return $attr;
                break;
            case 'feature':
                $image = '';
                if (intval($value) == 1) {
                    $attr .= ' checked="checked" ';
                    $image = '<img class="featured_item" src="' . LOFCONTENT_IMAGES_ADMIN_URI . 'featured.png" />';
                }
                return $this->getInput($name, 1, $attr) . $image;
                break;
            case 'product_categories':
                $data = $this->getProductCategoriesData();
                array_unshift($data, array('value' => '', 'text' => ' --- All ---'));
                return $this->getSelectList($name, $data, '', $attr);
                break;
            case 'categories_list':
                $this->getNestedCategoriesData();
                return $this->getSelectList($name, $this->categoriesOptionList, $value, $attr);
                break;
            case 'from_file':
                ob_start();
                require $attr;
                $html = ob_get_contents();
                ob_clean();
                return $html;
                break;
            case 'published' :
                $data = array(
                    array('text' => 'Published', 'value' => 1),
                    array('text' => 'Unpublished', 'value' => 0)
                );

                $value = (isset($value) && $value != null && $value != '') ? $value : 1;
                return $this->getSelectList($name, $data, $value, $attr);
                break;
            case 'access':
                $data = $this->getCustomerGroup();
                return $this->getSelectList($name, $data, $value, $attr);
                break;
            case 'theme' :
                $data = $this->getThemeOptions();
                return $this->getSelectList($name, $data, $value, $attr);
                break;
            case 'input':
            default :
                return $this->getInput($name, $value, $attr);
                break;
        }
    }

    function getProductCategoriesData() {
        global $cookie;
        $query = 'SELECT p.id_product as value, pl.name as text ';
        $query .= ' FROM ' . _DB_PREFIX_ . 'product p ';
        $query .= ' LEFT JOIN ' . _DB_PREFIX_ . 'product_lang pl ON(p.id_product = pl.id_product) ';
        $query .= ' WHERE pl.id_lang = ' . $cookie->id_lang;
        return Db::getInstance()->ExecuteS($query);
    }

    function getCustomerGroup() {
        global $cookie;
        $groups = Group::getGroups(intval($cookie->id_lang));
        $options[] = array('text' => '-- all --', 'value' => '0');
        foreach ($groups as $group) {
            $options[] = array('text' => $group['name'], 'value' => $group['id_group']);
        }
        return $options;
    }

    function getSelectList($name, $data, $default = '', $attr = '') {
        $multiple = false;
        if ($attr) {
            $attrArray = explode(' ', $attr);
        }
        if ($default == '' || !isset($default)) {
            $default = Tools::getValue($name);
        }

        if ($attr && in_array('multiple="1"', $attrArray)) {
            $multiple = true;
			$name_a = $name;
            $name = $name . '[]';
			$default = (($default && is_string($default)) ? trim($default) : '');
            $default = $default != '' ? explode(',', $default) : array();
			
        }
		
        $html = '<select name="' . $name . '" ' . $attr . ' >';
        foreach ($data as $opt) {
            if ($multiple == true) {
                $selected = in_array($opt['value'], $default) ? ' selected="selected"' : '';
            } else {
                $selected = $opt['value'] == $default ? ' selected="selected"' : '';
            }

            $html .= '<option value="' . $opt['value'] . '" ' . $selected . ' >' . $opt['text'] . '</option>';
        }
        $html .= '</select>';

        return $html;
    }

    /**
     * !imortant - Recursion function
     * if you want to edit this, pls make sure you have added limit repeat time 
     */
    function getNestedCategoriesData($id = 1) {
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
		WHERE cl.id_lang = ' . intval($cookie->id_lang) . ' AND c.id_lofblogs_category = ' . intval($id);
        $category = Db::getInstance()->getRow($query);
        //get data from english version if this empty:
        if (!count($category) || !is_array($category)) {
            $query = '
		SELECT c.id_lofblogs_category as value, cl.name as text, c.level_depth as level 
		FROM  ' . _DB_PREFIX_ . 'lofblogs_category c
		JOIN ' . _DB_PREFIX_ . 'lofblogs_category_lang cl ON (c.id_lofblogs_category  = cl.id_lofblogs_category)
		WHERE cl.id_lang = 1 AND c.id_lofblogs_category = ' . intval($id);            
            $category = Db::getInstance()->getRow($query);
        }
        //if($category['value'] != 1)
            $this->categoriesOptionList[] = array('value' => $category['value'], 'text' => $this->makeOptionText($category['level'], $category['text']));
    }

    function getCategoryChildren($id) {
        global $cookie;
        $query = '
		SELECT c.id_lofblogs_category as value, cl.name as text, c.level_depth as level 
		FROM  ' . _DB_PREFIX_ . 'lofblogs_category c
		JOIN ' . _DB_PREFIX_ . 'lofblogs_category_lang cl ON (c.id_lofblogs_category  = cl.id_lofblogs_category)
		WHERE cl.id_lang = ' . intval($cookie->id_lang) . ' AND c.id_parent = ' . intval($id);
        return Db::getInstance()->ExecuteS($query);
    }

    function getInput($name, $value, $attr = '') {
        $value = htmlentities($value, ENT_COMPAT, 'UTF-8');
        return '<input size="40" id="input_' . $name . '" ' . $attr . ' name="' . $name . '" value="' . $value . '" />';
    }

    function getTextArea($name, $value, $attr = '', $cols = 80, $rows = 3) {
        //$value = htmlentities(stripslashes($value), ENT_COMPAT, 'UTF-8');
        $id = '';
        if (strpos($attr, 'id=') == false) {
            $id = 'id="' . $name . '"';
        }
        return '<textarea ' . $attr . ' cols="' . $cols . '" rows="' . $rows . '" ' . $id . ' name="' . $name . '">' . $value . '</textarea>';
    }

    function getStateBox($value, $attr = '') {
        $options = array('published', 'drafted', 'suspended');
        foreach ($options as $opt) {
            $selected = $opt == $value ? 'selected="selected"' : '';
            $optionsTags[] = '<option value="' . $opt . '" ' . $selected . '>' . ucfirst($opt) . '</option>';
        }
        return '<select ' . $attr . ' name="status">' . implode(' ', $optionsTags) . '</select>';
    }

    protected function getFieldValue($key, $id_lang = NULL) {
        if ($id_lang)
            $defaultValue = ($this->object->id AND isset($this->object->{$key}[$id_lang])) ? $this->object->{$key}[$id_lang] : '';
        else
            $defaultValue = isset($this->object->{$key}) ? $this->object->{$key} : '';
        return Tools::getValue($key . ($id_lang ? '_' . $id_lang : ''), $defaultValue);
    }

    public function displayFlags($id, $use_vars_instead_of_ids = false) {
        if (sizeof($this->languages) == 1)
            return false;
        $output = '<div style="position:relative; float:left; width: 1px;">
		<div class="displayed_flag">
			<img src="../img/l/' . $this->defaultLanguage . '.jpg" class="pointer" id="language_current_' . $id . '" onclick="toggleLanguageFlags(this);" alt="" />
		</div>
		<div id="languages_' . $id . '" class="language_flags">
                <p>Choose language</p>';
        foreach ($this->languages as $language)
            if ($use_vars_instead_of_ids)
                $output .= '<img src="../img/l/' . (int) ($language['id_lang']) . '.jpg" class="pointer" alt="' . $language['name'] . '" title="' . $language['name'] . '" onclick="changeLanguage(\'' . $id . '\', ' . $this->langName . ', ' . $language['id_lang'] . ', \'' . $language['iso_code'] . '\');" /> ';
            else
                $output .= '<img src="../img/l/' . (int) ($language['id_lang']) . '.jpg" class="pointer" alt="' . $language['name'] . '" title="' . $language['name'] . '" onclick="changeLanguage(\'' . $id . '\', \'' . $this->langName . '\', ' . $language['id_lang'] . ', \'' . $language['iso_code'] . '\');" /> ';
        $output .= '</div></div>';

        return $output;
    }

    function addScript($url) {
        echo '<script type="text/javascript" src="' . $url . '"></script>';
    }

    function addStyleSheet($url) {
        echo '<link rel="stylesheet" href="' . $url . '" type="text/css" media="screen" charset="utf-8" />';
    }

    function getThemeOptions() {
        $helper = new lofContentHelper();
        $path = _PS_ROOT_DIR_ . '/modules/' . $this->modulename . '/themes/';
        $folders = $this->getFolderList($path);
        $options = array();
        $options[] = array('text' => '-- Use default --', 'value' => '');
        foreach ($folders as $folder) {
            $theme = $helper->getThemeInfo($folder);
            $options[] = array('text' => $theme['info']['name'], 'value' => $folder);
        }
        return $options;
    }

    public function getFolderList($path) {
        $items = array();
        $handle = opendir($path);
        if (!$handle) {
            return $items;
        }
        while (false !== ($file = readdir($handle))) {
            if (is_dir($path . $file))
                $items[$file] = $file;
        }
        unset($items['.'], $items['..'], $items['.svn']);
        return $items;
    }
    
    function l($string) {
        return $this->module->l($string, $this->filename);
    }
    
    function getCategoriesOptions(){
        return $this->categoriesOptionList;
    }

}