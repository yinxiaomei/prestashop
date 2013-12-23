<?php

/**
 * $ModDesc
 * 
 * @version   $Id: file.php $Revision
 * @package   modules
 * @subpackage  $Subpackage.
 * @copyright Copyright (C) November 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */
if (!class_exists('LofParams', false)) {

    class LofParams {

        /**
         * @var string name ;
         *
         * @access public;
         */
        public $name = '';

        /**
         * @var string name ;
         *
         * @protected public;
         */
        protected $_data = array();

        /**
         * Constructor
         */
        public function LofParams($name) {
            global $cookie;
            $this->name = $name;
            $id_lang = intval($cookie->id_lang);
            $result = Db::getInstance()->ExecuteS('
		SELECT c.name,IFNULL(' . ($id_lang ? 'cl' : 'c') . '.`value`, c.`value`) AS value
		FROM `' . _DB_PREFIX_ . 'configuration` c
		' . ($id_lang ? ('LEFT JOIN `' . _DB_PREFIX_ . 'configuration_lang` cl ON (c.`id_configuration` = cl.`id_configuration` AND cl.`id_lang` = ' . intval($id_lang) . ')') : '') . '
		WHERE `name` LIKE \'' . pSQL($name) . '%\'');

            foreach ($result as $row) {
                $this->_data[$row["name"]] = $row["value"];
            }
        }

        /**
         * Get configuration's value
         */
        public function get($name, $default="") {
            if (isset($this->_data[$this->name . '_' . $name])) {
                return $this->_data[$this->name . '_' . $name];
            } else {
                if (Configuration::get($this->name . '_' . $name) != '') {
                    $this->_data[$this->name . '_' . $name] = Configuration::get($this->name . '_' . $name);
                    return Configuration::get($this->name . '_' . $name);
                } elseif (isset($this->_data[$name])) {
                    return $this->_data[$name];
                }
            }

            return $default;
        }

        /**
         * Store configuration's value as temporary.
         */
        public function set($key, $value) {
            $this->_data[$key] = $value;
        }

        /**
         * Update value for single configuration.
         */
        public function update($name) {
            Configuration::updateValue($this->name . '_' . $name, Tools::getValue($name), true);
        }

        /**
         * Update value for list of configurations.
         */
        public function batchUpdate($configurations=array()) {
            foreach ($configurations as $config => $key) {
                Configuration::updateValue($this->name . '_' . $config, Tools::getValue($config), true);
            }
        }

        /**
         * render input.
         */
        public function fileTag($name, $fileOption, $fileValues, $fileLangArr, $title, $attr, $liAtrr="", $ulAttr = "", $canUplad=true) {

            $id = "params_" . $name;
            $options = '';
            $str = '<ul class="row hasLine" style="width:100%;"><li style="margin-top:10px;width:100%">
                    <ul>
                        <li ' . $ulAttr . ' style="width:15%;">
                            <div class="lof-group-article"><label>' . $title . '</label></div>                            
                        </li>
                        <li style="width:75%;">
                            <div class="property-container">
                            <div class="lof-cols full_height"><label>' . $fileLangArr["path_img"] . '</label>';
            if ($canUplad) {
                $str .= '<input type="file" name="' . $name . '-image" id="' . $name . '-image">';
            }
            if ($fileValues["image"]) {
                $str .='            <div style="width:200px;margin: 5px; overflow: hidden; height: 140px;">
                                    <img src="' . $fileValues["image"] . '" alt="" style="width:100%"/>
                                </div>';
            }
            $str .='                       
                            </div>                
                            <div class="lof-cols"><label>' . $fileLangArr["title"] . '</label>
                                <input type="text" name="' . $name . '-title" value="' . $fileValues["title"] . '">
                            </div>       
                            <div class="lof-cols"><label>' . $fileLangArr["link"] . '</label>
                                <input type="text" name="' . $name . '-link" value="' . $fileValues["link"] . '">
                            </div>                             
                            <div class="lof-cols">    
                                <label>Descriptions</label>
                                <textarea  class="rte textarea-input" rows="7" name="' . $name . '-desc">' . $fileValues["desc"] . '</textarea>
                            </div>
                            </div>
                        </li>                                                                                                             
                    </ul>                    
                </li></ul>';

            if ($liAtrr) {
                $str = '<li ' . $liAtrr . '>' . $str . '</li>';
            }
            return $str;
        }

        /**
         * 10/04/2012 Added by Risk
         * @param type $name
         * @param type $fileOption
         * @param type $fileValues
         * @param type $fileLangArr
         * @param type $title
         * @param type $attr
         * @param type $liAtrr
         * @param type $ulAttr
         * @param type $canUplad
         * @return string 
         */
        public function imageInfoTag($name, $fileOption, $fileValues, $fileLangArr, $title, $attr='') {
            $html = '';
            $html .= '<div class="image_info">';
            $html .= '<div class="image_box">
                        <h3>'.$title.'</h3>
                        <img src="'.$fileValues['image'].'" />
                        <div class="delete_image">
                            <input type="checkbox" name="remove_images[]" value="'.$title.'" />
                            <label>Delete</label>
                        </div>
                        <input type="hidden" name="' . $name . '-image" value="' . $fileValues["image"] . '">
                     </div>';
            $html .= '<div class="info_box">
                        <label>' . $fileLangArr["title"] . '</label>
                        <input type="text" name="' . $name . '-title" value="' . $fileValues["title"] . '">
                        <label>' . $fileLangArr["link"] . '</label>
                        <input type="text" name="' . $name . '-link" value="' . $fileValues["link"] . '">
                        <label>' . $fileLangArr["desc"] . '</label>
                        <textarea  class="rte textarea-input" rows="7" name="' . $name . '-desc">' . $fileValues["desc"] . '</textarea>
                     </div>';
            $html .= '</div>';
            return $html;
        }
        /**
         * render input.
         */
        public function textTag($name, $fileOption, $fileValues, $fileLangArr, $title, $attr, $liAtrr="", $ulAttr = "") {
            $id = "params_" . $name;
            $options = '';

            $str = '<ul class="row"><li style="margin-top:10px;">
                    <ul>
                        <li ' . $ulAttr . '>
                            <div class="lof-group-article">' . $title . '</div>                            
                        </li>
                        <li>
                            <div>                                     
                            <div class="lof-cols"><label>' . $fileLangArr["title"] . '</label>
                                <input type="text" name="' . $name . '-title" value="' . $fileValues["title"] . '">
                            </div>
                            <div class="lof-cols"><label>' . $fileLangArr["link"] . '</label>
                                <input type="text" name="' . $name . '-link" value="' . $fileValues["link"] . '">
                            </div>                        
                            <div style="clear:both;">                                                                                                                                                                                                                      
                                <textarea style="width:94%;min-height:60px" class="rte" name="' . $name . '-desc">' . $fileValues["desc"] . '</textarea>
                            </div>
                            </div>
                        </li>                                                                                                             
                    </ul>                    
                </li></ul>';

            if ($liAtrr) {
                $str = '<li ' . $liAtrr . '>' . $str . '</li>';
            }
            return $str;
        }

        /**
         * render input.
         */
        public function inputTag($name, $value, $title, $attr, $liAtrr="", $ulAttr = "", $tooltip="") {
            $id = "params_" . $name;
            $options = '';

            $str = '<ul ' . $ulAttr . '>
                    <li class="lof-config-left">
                        <label for="' . $id . '">' . $title . '</label>
                    </li>
                    <li class="lof-config-right">
                        <input name="' . $name . '" id="' . $id . '" value="' . $value . '" ' . $attr . ' type="text">';
            if ($tooltip) {
                $str .= '<i class="clearfix">' . $tooltip . '</i>';
            }
            $str .= '</li>
                </ul>    
                ';
            if ($liAtrr) {
                $str = '<li ' . $liAtrr . '>' . $str . '</li>';
            }
            return $str;
        }

        public function browerFolder($name, $value, $title, $button_image, $popup_id, $attr ='', $ulAttr='') {
            $id = "params_" . $name;
            $options = '';

            $str = '<ul ' . $ulAttr . '>
                    <li class="lof-config-left">
                        <label for="' . $id . '">' . $title . '</label>
                    </li>
                    <li class="lof-config-right">
                        <input name="' . $name . '" id="' . $id . '" value="' . $value . '" ' . $attr . ' type="text">';
            $str .= '<img src="' . $button_image . '" height="20" class="lof_brower_button" onClick="openPopup(\'#' . $popup_id . '\')"/>';
            $str .= '</li>
                </ul>    
                ';
            return $str;
        }

        /**
         * render textarea html tag.
         */
        public function getCategory($name, $value, $title, $attr, $liAtrr="", $ulAttr = "", $tooltip="", $textAllCat = "") {
            $children = $this->getIndexedCategories();
            $list = array();
            if(_PS_VERSION_ < "1.5")
				$this->treeCategory( 0, $list , $children );
			else
				$this->treeCategory( 1, $list , $children );
				
            $catArray = explode(",", $value);

            $id = "params_" . $name;
            $id = str_replace("[]", "", $id);

            $isSelected = (in_array("", $catArray)) ? 'selected="selected"' : "";
            $options = '<option value="" onclick="lofSelectAll(\'#params_category\');" ' . $isSelected . '>-- ' . $textAllCat . '</option>';
            foreach ($list as $cat) {
                $isSelected = (in_array($cat["id_category"], $catArray) || in_array("", $catArray)) ? 'selected="selected"' : "";
                $options .= '<option value="' . $cat["id_category"] . '" ' . $isSelected . '>---| ' . $cat["tree"] . $cat["name"] . '</option>';
            }

            $str = '<ul ' . $ulAttr . '>
                    <li class="lof-config-left">
                        <label for="' . $id . '">' . $title . '</label>
                    </li>
                    <li class="lof-config-right">
                        <select ' . $attr . ' id="' . $id . '" name="' . $name . '">' . $options . '</select>';

            if ($tooltip) {
                $str .= '<i class="clearfix">' . $tooltip . '</i>';
            }
            $str .= "</li></ul>";

            if ($liAtrr) {
                $str = '<li ' . $liAtrr . '>' . $str . '</li>';
            }
            return $str;
        }

        /**
         * render radio html tag.
         */
        public function radioBooleanTag($name, $yesNoLang, $value, $title, $attr, $liAtrr="", $ulAttr = "", $tooltip="") {
            $str = '<ul ' . $ulAttr . '>
                    <li class="lof-config-left">
                        <label>' . $title . '</label>
                    </li>
                    <li class="lof-config-right">';

            foreach ($yesNoLang as $key => $val) {
                $isChecked = ($key == $value) ? 'checked="checked"' : "";
                $str .= '<input type="radio" value="' . $key . '" id="params' . $name . $key . '" name="' . $name . '" ' . $attr . ' ' . $isChecked . '><label for="params' . $name . $key . '">' . $val . '</label>';
                $attr = "";
            }
            if ($tooltip) {
                $str .= '<i class="clearfix">' . $tooltip . '</i>';
            }
            $str .= "</li></ul>";

            if ($liAtrr) {
                $str = '<li ' . $liAtrr . '>' . $str . '</li>';
            }
            return $str;
        }

        /**
         * render textarea html tag.
         */
        public function textareaTag($name, $values=array(), $value, $title, $attr, $liAtrr="", $ulAttr = "", $tooltip="") {
            $string = __($title) . '<textarea name="%s" id="%s" %s>%s</textarea>';
            $id = $obj->get_field_id($name);
            return '<p class="">'
                    . $this->labelTag($id, sprintf($string, $obj->get_field_name($name), $id, '', $value))
                    . '</p>';
        }

        /**
         * render lof group tag.
         */
        public function lofGroupTag($title, $class, $liAtrr="", $ulAttr = "") {
            $str = '<ul ' . $ulAttr . '>
                    <li class="lof-config-left">&nbsp;</li>
                    <li class="lof-config-right">
                        <div class="' . $class . '">' . $title . '</div>                                    
                    </li>
                </ul>';
            if ($liAtrr) {
                $str = '<li ' . $liAtrr . '>' . $str . '</li>';
            }
            return $str;
        }

        /**
         * render lof group tag.
         */
        public function lofOverrideLinksTag($value, $title, $addRowText, $liAtrr="", $ulAttr = "", $tooltip="") {
            $str = '<ul ' . $ulAttr . '>
                    <li class="lof-config-left">
                        <label>' . $title . '</label>
                    </li>
                    <li class="lof-config-right">
                        <fieldset class="it-addrow-block">
                            <legend><span class="add" id="btna-override_links">' . $addRowText . '</span></legend>';

            if ($value) {
                $linkArray = explode(",", $value);
                $row = "";
                foreach ($linkArray as $key => $value) {
                    $str .= '
    				<div class="row">
    					<span class="spantext">' . ($key + 1) . '</span>
    					<input type="text" value="' . $value . '" name="override_links[]">
    					<span class="remove"></span>
    				</div>
    			';
                }
            }
            $str .= '</fieldset>';
            if ($tooltip) {
                $str .= '<i class="clearfix">' . $tooltip . '</i>';
            }
            $str .= "</li></ul>";

            if ($liAtrr) {
                $str = '<li ' . $liAtrr . '>' . $str . '</li>';
            }
            return $str;
        }

        /**
         * render select html tag.
         */
        public function selectTag($name, $values=array(), $value, $title, $attr, $liAtrr="", $ulAttr = "", $tooltip="") {
            $id = "params_" . $name;
            $options = '';

            foreach ($values as $val => $text) {
                $isSelected = ($val == $value) ? 'selected="selected"' : "";
                $options .= '<option ' . $isSelected . ' value="' . $val . '">' . $text . "</option>";
            }

            $str = '<ul ' . $ulAttr . '>
                    <li class="lof-config-left">
                        <label for="' . $id . '">' . $title . '</label>
                    </li>
                    <li class="lof-config-right">
                        <select ' . $attr . ' id="' . $id . '" name="' . $name . '">' . $options . '</select>';

            if ($tooltip) {
                $str .= '<i class="clearfix">' . $tooltip . '</i>';
            }
            $str .= "</li></ul>";

            if ($liAtrr) {
                $str = '<li ' . $liAtrr . '>' . $str . '</li>';
            }
            return $str;
        }

        /**
         * Build category tree list
         */
        public static function treeCategory($id, &$list, $children, $tree="") {
            if (isset($children[$id])) {
                if ($id != 0) {
                    $tree = $tree . " - ";
                }
                foreach ($children[$id] as $v) {
                    $v["tree"] = $tree;
                    $list[] = $v;
                    self::treeCategory($v["id_category"], $list, $children, $tree);
                }
            }
        }

        /**
         * Get List Categories Tree source
         * 
         * @access public
         * @static method
         * return array contain list of categories source 
         */
        public function getIndexedCategories() {
            global $cookie;
            $id_lang = intval($cookie->id_lang);
			if(_PS_VERSION_ < "1.5")
				$join = '';
			else
				$join = 'JOIN `'._DB_PREFIX_.'category_shop` cs ON(c.`id_category` = cs.`id_category` AND cs.`id_shop` = '.(int)(Context::getContext()->shop->id).')';
			
            $allCat = Db::getInstance()->ExecuteS('
		SELECT c.*, cl.id_lang, cl.name, cl.description, cl.link_rewrite, cl.meta_title, cl.meta_keywords, cl.meta_description
		FROM `' . _DB_PREFIX_ . 'category` c
		'.$join.'
		LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (c.`id_category` = cl.`id_category` AND `id_lang` = ' . intval($id_lang) . ')
		LEFT JOIN `' . _DB_PREFIX_ . 'category_group` cg ON (cg.`id_category` = c.`id_category`)
		WHERE `active` = 1		
		GROUP BY c.`id_category`
		ORDER BY `name` ASC');
            $children = array();
            if ($allCat) {
                foreach ($allCat as $v) {
                    $pt = $v["id_parent"];
                    $list = @$children[$pt] ? $children[$pt] : array();
                    array_push($list, $v);
                    $children[$pt] = $list;
                }
                return $children;
            }
            return array();
        }

        public function getCms_category($name, $value, $title, $attr, $liAtrr="", $ulAttr = "", $tooltip="", $textAllCat = "") {
            $children = $this->getIndexedCMSCategories();
            //echo "<pre>".var_dump($children);die;		
            $list = array();
            $this->treeCMSCategory(0, $list, $children);
            $catArray = explode(",", $value);


            $id = "params_" . $name;
            $id = str_replace("[]", "", $id);
            $isSelected = (in_array("", $catArray)) ? 'selected="selected"' : "";
            $options = '<option value="" onclick="lofSelectAll(\'#params_cms_category\');" ' . $isSelected . '>-- ' . $textAllCat . '</option>';
            foreach ($list as $cat) {
                $isSelected = (in_array($cat["id_cms_category"], $catArray) || in_array("", $catArray)) ? 'selected="selected"' : "";
                $options .= '<option value="' . $cat["id_cms_category"] . '" ' . $isSelected . '>---| ' . $cat["tree"] . $cat["name"] . '</option>';
            }

            $str = '<ul ' . $ulAttr . '>
                    <li class="lof-config-left">
                        <label for="' . $id . '">' . $title . '</label>
                    </li>
                    <li class="lof-config-right">
                        <select ' . $attr . ' id="' . $id . '" name="' . $name . '">' . $options . '</select>';

            if ($tooltip) {
                $str .= '<i class="clearfix">' . $tooltip . '</i>';
            }
            $str .= "</li></ul>";

            if ($liAtrr) {
                $str = '<li ' . $liAtrr . '>' . $str . '</li>';
            }
            return $str;
        }

        /**
         * Get List Categories Tree source
         * 
         * @access public
         * @static method
         * return array contain list of categories source 
         */
        public function getIndexedCMSCategories() {
            global $cookie;
            $id_lang = intval($cookie->id_lang);

            $allCat = Db::getInstance()->ExecuteS('
		SELECT c.*, cl.id_lang, cl.name, cl.description, cl.link_rewrite, cl.meta_title, cl.meta_keywords, cl.meta_description
		FROM `' . _DB_PREFIX_ . 'cms_category` c
		LEFT JOIN `' . _DB_PREFIX_ . 'cms_category_lang` cl ON (c.`id_cms_category` = cl.`id_cms_category` AND `id_lang` = ' . intval($id_lang) . ')
		WHERE `active` = 1		
		GROUP BY c.`id_cms_category`
		ORDER BY `name` ASC');
            $children = array();
            if ($allCat) {
                foreach ($allCat as $v) {
                    $pt = $v["id_parent"];
                    $list = @$children[$pt] ? $children[$pt] : array();
                    array_push($list, $v);
                    $children[$pt] = $list;
                }
                return $children;
            }

            return array();
        }

        /**
         * Build category tree list
         */
        public static function treeCMSCategory($id, &$list, $children, $tree="") {
            if (isset($children[$id])) {
                if ($id != 0) {
                    $tree = $tree . " - ";
                }
                foreach ($children[$id] as $v) {
                    $v["tree"] = $tree;
                    $list[] = $v;
                    self::treeCMSCategory($v["id_cms_category"], $list, $children, $tree);
                }
            }
        }

    }

}
?>