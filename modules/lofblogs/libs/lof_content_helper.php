<?php

/**
 * ***** Lof Content Helper ************
 * @author LandOfCoder
 * @subpackage LofContent
 * @todo Help building system
 * 
 */
class lofContentHelper {

    function createThumb($imagePath, $thumbname, $width = 100, $height = 100) {
        $thumb = PhpThumbFactory::create($imagePath);
        $thumb->adaptiveResize($width, $height);
        $thumb->save($thumbname);
        return true;
    }

    public static function likeQuote($query) {
        return "'%" . $query . "%'";
    }

    public static function sqlQuote($string) {
        return "'" . $string . "'";
    }

    public static function getArticleLink($article_id, $article_rewrite) {
        global $cookie;
        $rewrite_conf = Configuration::get('PS_REWRITING_SETTINGS');
        if ($rewrite_conf == true && $article_rewrite != '') {
            $iso = Language::getIsoById(intval($cookie->id_lang));
            return __PS_BASE_URI__ . 'blogs/' . $article_id . '-' . $article_rewrite . '.html';
        } else {
            return __PS_BASE_URI__ . 'index.php?view=content&id=' . $article_id.'&fc=module&module=lofblogs&controller=articles';
        }
    }

    public static function getCategoryLink($id, $alias) {
        global $cookie;
        $rewrite_conf = Configuration::get('PS_REWRITING_SETTINGS');
        if ($rewrite_conf == true && $alias != '') {
            $iso = Language::getIsoById(intval($cookie->id_lang));
            return __PS_BASE_URI__ . 'blogs/category/' . $id . '-' . $alias . '.html';
        } else {
            return __PS_BASE_URI__ . 'index.php?view=category&id=' . $id.'&fc=module&module=lofblogs&controller=articles';
        }
    }
    public static function getTagLink($tag) {
        global $cookie;
        $rewrite_conf = Configuration::get('PS_REWRITING_SETTINGS');
        if ($rewrite_conf == true && $tag != '') {
            $iso = Language::getIsoById(intval($cookie->id_lang));
            return __PS_BASE_URI__ . 'blogs/tags/'. $tag.'.html';
        } else {
            return __PS_BASE_URI__ . 'index.php?view=tag&tag=' . str_replace(' ', '_', trim(strtolower($tag))).'&fc=module&module=lofblogs&controller=articles';
        }
    }
    public static function getSearchLink($data = array()) {
        global $cookie;
        $rewrite_conf = Configuration::get('PS_REWRITING_SETTINGS');
        $condition = '';
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $condition .= $key.'='.$value.'&';
            }
            $condition = rtrim($condition,'&');
        }
        if ($rewrite_conf == true) {
            $iso = Language::getIsoById(intval($cookie->id_lang));
            return __PS_BASE_URI__ . 'blogs/search/search.html'.($condition ? '?'.$condition : '');
        } else {
            return __PS_BASE_URI__ . 'index.php?view=search'.($condition ? '&'.$condition : '').'&fc=module&module=lofblogs&controller=articles';
        }
    }

    public static function getAccess($customer = '', $group = 0) {
        //if set group to all then everyone can access
        if (!$group)
            return 1;

        //if some this permision was limited, the guest can not access
        if (!$customer)
            return 0;

        $query = 'SELECT COUNT(id_group) FROM `' . _DB_PREFIX_ . 'customer_group` ';
        $query .= ' WHERE id_group IN(' . $group . ') AND id_customer = ' . pSQL($customer);
        return Db::getInstance()->getValue($query);
    }

    public static function getFileContent($path) {
        ob_start();
        require $path;
        $content = ob_get_contents();
        ob_clean();
        return $content;
    }

    public static function getClientId() {
        if (isset($_SERVER["REMOTE_ADDR"])) {
            return $_SERVER["REMOTE_ADDR"];
        } else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
    }

    function getImages($path) {
        $items = array();
        $handle = opendir($path);
        if (!$handle) {
            return $items;
        }
        while (false !== ($file = readdir($handle))) {
            if ($this->isImages($file)) {
                $items[] = $file;
            }
        }
        return $items;
    }

    function isImages($file, $allowed = array('png', 'jpg', 'gif'), $disallowed = array('.', '..', '.svn')) {
        if (!is_dir($file) && !in_array($file, $disallowed)) {
            $ext = preg_replace('/^.*\./', '', $file);
            if (in_array($ext, $allowed)) {
                return true;
            } else
                return false;
        } else {
            return false;
        }
    }

    public static function buildEmoticons($string) {
        $query = 'SELECT * FROM ' . _DB_PREFIX_ . 'lofblogs_comment_emoticons';
        $emoticons = Db::getInstance()->ExecuteS($query);
        $search = array();
        $replace = array();
        foreach ($emoticons as $k => $image) {
            $search[$k] = $image['key'];
            $replace[$k] = '<img src="' . LOFCONTENT_IMAGES_ADMIN_URI . 'emoticons/' . str_replace('__', '.', $image['filename']) . '" />';
        }

        return str_replace($search, $replace, $string);
    }

    public static function getImageUri($name) {
        return LOFCONTENT_IMAGES_ADMIN_URI . 'emoticons/' . str_replace('__', '.', $name);
    }

    public static function getRatingPage($rating, $num, $label = '') {
        $ratingclass = intval($rating) > 0 ? 'lofcontent_article_rate' . $rating : '';
        return '<div class="listing_rating">
                    <div class="rating_star ' . $ratingclass . '"></div>
                    <div class="rating_infor">' . $num . $label . '</div>
               </div>';
    }

    public static function limitString($string, $limit = 30, $endchar = ' ...') {
        if (strlen($string) > $limit) {
            return substr($string, 0, $limit) . $endchar;
        } else {
            return $string;
        }
    }

    public static function getCustomerGroups() {
        global $cookie;
        $object = array();
        if (isset($cookie->id_customer) && $cookie->id_customer) {
            $query = 'SELECT id_group FROM  ' . _DB_PREFIX_ . 'customer_group WHERE id_customer = ' . $cookie->id_customer;
            $object = Db::getInstance()->ExecuteS($query);
        }
        $groups[] = 0;
        if (is_array($object) && count($object)) {
            foreach ($object as $group) {
                $groups[] = $group['id_group'];
            }
        }
        return $groups;
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

    function getSelectList($name, $data, $default = '', $attr = '') {
        $multiple = false;
        if ($attr) {
            $attrArray = explode(' ', $attr);
        }
        if (!$default) {
            $default = Tools::getValue($name);
        }

        if ($attr && in_array('multiple="1"', $attrArray)) {
            $multiple = true;
            $name = $name . '[]';
            $default = $default != '' ? explode(',', $default) : '';
        }

        $html = '<select name="' . $name . '" ' . $attr . ' >';
        foreach ($data as $opt) {
            if ($multiple) {
                $selected = in_array($opt['value'], $default) ? 'selected="selected"' : '';
            } else {
                $selected = $opt['value'] == $default ? 'selected="selected"' : '';
            }

            $html .= '<option value="' . $opt['value'] . '" ' . $selected . ' >' . $opt['text'] . '</option>';
        }
        $html .= '</select>';

        return $html;
    }

    function getThemeInfo($themename, $value = '') {
        $theme = array();
        $theme['error'] = array();
        if (!$themename) {
            $themename = 'default';
        }
        $xml = LOFCONTENT_THEMES_FOLDER . $themename . '/theme.xml';
        if (file_exists($xml)) {
            $xmlObj = simplexml_load_file($xml);
            $options = array();

            //get block position :
            if (count($xmlObj->blocks->block)) {
                foreach ($xmlObj->blocks->block as $block) {
                    $theme['blocks'][] = $block;
                    $options[] = array('text' => $block, 'value' => $block);
                }
                $theme['list'] = $this->getSelectList('position', $options, $value);
            } else {
                $theme['error'][] = '---- no position found in theme ' . $themename;
            }

            //get theme info :
            $theme['info'] = array();
            if (count($xmlObj->info)) {
                foreach ($xmlObj->info->children() as $key => $val) {
                    $theme['info'][(string) $key] = (string) $val;
                }
            }
        } else {
            $theme['error'][] = '---------- file theme.xml not found ------------';
        }
        return $theme;
    }

    function getModuleMedia($moduleName, $template = 'default') {
        $mediaPath = _PS_MODULE_DIR_ . $moduleName . '/themes/' . $template . '/assets/';
        $theme_assets = __PS_BASE_URI__ . 'modules/' . $moduleName . '/themes/' . $template . '/assets/';
        $moduleUri = __PS_BASE_URI__ . 'modules/' . $moduleName . '/';
        $moduleCssPath = _PS_MODULE_DIR_ . $moduleName . '/css/';
        $moduleJsPath = _PS_MODULE_DIR_ . $moduleName . '/js/';


        $mediaFiles = array();

        //get module css :
        if (file_exists($moduleCssPath)) {
            $modCssFiles = $this->getFilesFromFolder($moduleCssPath);

            if (count($modCssFiles) && is_array($modCssFiles)) {
                foreach ($modCssFiles as $filename) {
                    $ext = strtolower(preg_replace('/^.*\./', '', $filename));
                    if ($ext == 'css') {
                        $mediaFiles['css'][] = $moduleUri . 'css/' . $filename;
                    }
                }
            }
        }
        //get module js :
        if (file_exists($moduleJsPath)) {
            $modJsFiles = $this->getFilesFromFolder($moduleJsPath);

            if (count($modJsFiles) && is_array($modJsFiles)) {
                foreach ($modJsFiles as $filename) {
                    $ext = strtolower(preg_replace('/^.*\./', '', $filename));
                    if ($ext == 'js') {
                        $mediaFiles['js'][] = $moduleUri . 'js/' . $filename;
                    }
                }
            }
        }
        //get theme css :
        $mediaFiles = array();
        if (file_exists($mediaPath . 'css')) {
            $cssFiles = $this->getFilesFromFolder($mediaPath . 'css');

            if (count($cssFiles) && is_array($cssFiles)) {
                foreach ($cssFiles as $filename) {
                    $ext = strtolower(preg_replace('/^.*\./', '', $filename));
                    if ($ext == 'css') {
                        $mediaFiles['css'][] = $theme_assets . 'css/' . $filename;
                    }
                }
            }
        }

        //get theme js :
        if (file_exists($mediaPath . 'js')) {
            $jsFiles = $this->getFilesFromFolder($mediaPath . 'js');

            if (count($jsFiles) && is_array($jsFiles)) {
                foreach ($jsFiles as $filename) {
                    $ext = strtolower(preg_replace('/^.*\./', '', $filename));
                    if ($ext == 'js') {
                        $mediaFiles['js'][] = $theme_assets . 'js/' . $filename;
                    }
                }
            }
        }
        return $mediaFiles;
    }

    function getFilesFromFolder($path) {
        $items = array();
        $handle = opendir($path);
        if (!$handle) {
            return $items;
        }
        while (false !== ($file = readdir($handle))) {
            if ($this->isValidFile($file)) {
                $items[] = $file;
            }
        }
        return $items;
    }

    function isValidFile($file, $allowed = array('css', 'js', 'php'), $disallowed = array('.', '..', '.svn')) {
        if (!is_dir($file) && !in_array($file, $disallowed)) {
            $ext = preg_replace('/^.*\./', '', $file);
            if (in_array($ext, $allowed)) {
                return true;
            } else
                return false;
        } else {
            return false;
        }
    }

    function linkMedia($src, $type = 'css') {
        if ($type == 'css') {
            return '<link type="text/css" rel="stylesheet" href="' . $src . '" />';
        } else {
            return '<script type="text/javascript" src="' . $src . '"></script>';
        }
    }

    function moduleMedia($module, $template = 'default') {
        
        $medias = $this->getModuleMedia($module, $template);
        
        $theme_assets = __PS_BASE_URI__ . 'modules/' . $module . '/themes/' . $template . '/assets/';

		//add style sheet :
		$context = Context::getContext();
		if (isset($medias['css']) && count($medias['css'])) {
			foreach ($medias['css'] as $css) {
				$context->controller->addCSS($css);
			}
		}
		//add script :
		if (isset($medias['js']) && count($medias['js'])) {
			foreach ($medias['js'] as $js) {
				$context->controller->addJS($js);
			}
		}
	
    }

    public static function makeSafeLinkRewrite($title) {
        $alias = trim($title);
        $bad_chars = array('/', '?', '&', ',', ':');
        $alias = str_replace($bad_chars, '', $alias);
        $alias = str_replace(' ', '-', $alias);
        //remove duplicate char e.g : ---- to -
        $alias = preg_replace('{(.)\1+}', '$1', $alias);
        return $alias;
    }

    public function getUpdate($name, $version) {
        $link = 'http://landofcoder.com/demo/prestashop14x/version.xml';
        $xmlContent = $this->curlGetContent($link);
        $xmlObj = simplexml_load_string($xmlContent);
        $extensions = array();

        if (count($xmlObj->extensions)) {
            foreach ($xmlObj->extensions->children() as $object) {
                $extensionName = (string) $object['name'];
                $extensions[$extensionName] = $this->getArrayAttributes($object);
            }
        }

        if (count($extensions) && array_key_exists($name, $extensions)) {
            if (floatval($extensions[$name]['release']) > floatval($version)) {
                return $extensions[$name];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //convert xml attributes to array :
    function getArrayAttributes($object) {
        $res = array();
        foreach ($object->attributes() as $key => $val) {
            $res[(string) $key] = (string) $val;
        }
        return $res;
    }

    function curlGetContent($link) {
        if (function_exists('curl_init')) {
            $crl = curl_init();
            curl_setopt($crl, CURLOPT_URL, $link);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);
            $ret = curl_exec($crl);
            curl_close($crl);
        } else {
            $ret = file_get_contents($link);
        }

        return $ret;
    }

    public static function createFolderIfNotExist($path) {         
        if (!is_dir($path)) {
            if(!mkdir($path, 0755)) {
                return false;                 
            } else {
                return true;
            }
        } else {            
            return true;
        }        
    }

    public function autoCompleteImages($imagename, $params) {
        $primaryWidth = $params->get('primary_width', 500);
        $primaryheight = $params->get('primary_height', 500);
        $thumbWidth = $params->get('thumb_width', 100);
        $thumbHeight = $params->get('thumb_height', 100);

        //some path :
        $imageFullPath = LOFCONTENT_IMAGES_ORIGIN_FOLDER . $imagename;
        $imagePrimaryPath = LOFCONTENT_IMAGES_FOLDER . $imagename;
        $thumbFullPath = LOFCONTENT_THUMBS_FOLDER . $imagename;

        //if we have at least a origin image, we can make other from it
        if (file_exists($imageFullPath)) {

            //create primary image if not exist :
            if (!file_exists($imagePrimaryPath)) {
                $this->createThumb($imageFullPath, $imagePrimaryPath, $primaryWidth, $primaryheight);
            }

            //create thumbnail if not exist :
            if (!file_exists($thumbFullPath)) {
                $this->createThumb($imageFullPath, $thumbFullPath, $thumbWidth, $thumbHeight);
            }
        }
    }

    function lofblogsTableExist($shortname) {
        $query = "SHOW TABLES LIKE '" . _DB_PREFIX_ . "lofblogs_" . $shortname . "'";
        $tableExist = Db::getInstance()->executeS($query);
        return intval(count($tableExist));
    }

}

?>