<?php

/**
 * PrestapressCategory class, PrestapressCategory.php
 * Prestapress module
 * @category classes
 *
 * @author AppSide
 * @copyright AppSide
 *
 */
//init phpthumb library :
require LOFCONTENT_LIBS_FOLDER . 'phpthumb/ThumbLib.inc.php';

class LofPsblogsCategory extends ObjectModel {

    public $name;
    public $link_rewrite;
    public $id_parent;
    public $level_depth;
    public $active;
    public $image;
    public $short_desc;
    public $description;
    public $meta_description;
    public $meta_title;
    public $meta_keywords;
    public $total;
    public $template;
    public $position;
    protected $allowedUpload = array("jpg", "bmp", "gif", "png");
    public static $definition = array(
        'table' => 'lofblogs_category',
        'primary' => 'id_lofblogs_category',
        'multilang' => true,
        'fields' => array(
            'id_parent' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'level_depth' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'position' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'image' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
            'template' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
            // Lang fields
            'name' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'required' => true, 'size' => 255),
            'link_rewrite' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'size' => 128),
            'short_desc' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString'),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString'),
            'meta_title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'size' => 128),
            'meta_keywords' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'size' => 255),
            'meta_description' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'size' => 255)
        ),
    );

    public function __construct($id_lofblogs_category = NULL, $id_lang = NULL) {
        $module = new lofblogs();
        $this->params = new LOFXParams($module);
        $helper = new lofContentHelper();
        if ($this->image) {
            $helper->autoCompleteImages($this->image, $this->params);
        }

        parent::__construct($id_lofblogs_category, $id_lang);
    }

    public function getSubCategories() {
        
    }

    public function clearCatCache() {
        if (file_exists(_PS_MODULE_DIR_ . "lofblogscategory/lofblogscategory.php")) {
            require_once _PS_MODULE_DIR_ . "lofblogscategory/lofblogscategory.php";
            $lofBlogC = new lofBlogsCategory();
            if(method_exists($lofBlogC,'clearBLCCache')) $lofBlogC->clearBLCCache();
        }
    }

    public function update($nullValues = false) {
        if (parent::update()) {
            $this->clearCatCache();
            return true;
        }
        return false;
    }

    function getChildren() {
        global $cookie;
        $query = '
		SELECT c.id_lofblogs_category as value, cl.name as text, cl.level_depth as level 
		FROM  ' . _DB_PREFIX_ . 'lofblogs_category c
		JOIN ' . _DB_PREFIX_ . 'lofblogs_category_lang cl ON (c.id_lofblogs_category  = cl.id_lofblogs_category)
		WHERE cl.id_lang = ' . intval($cookie->id_lang) . ' AND c.id_parent = ' . intval($this->id);
        return Db::getInstance()->ExecuteS($query);
    }

    public static function getCategoryLink($rewrite_conf, $category_id, $category_rewrite, $p = null) {
        global $cookie;

        if ($rewrite_conf == true && $category_rewrite != '') {
            $iso = Language::getIsoById(intval($cookie->id_lang));
            return __PS_BASE_URI__ . $iso . '/articles/' . $category_id . '-' . $category_rewrite . (!is_null($p) ? '?p=' . $p : '');
        } else {
            return _MODULE_DIR_ . 'lofblogs/showarticles.php?category=' . $category_id . (!is_null($p) ? '?p=' . $p : '');
        }
    }

    public static function hideCategoryPosition($name) {
        return preg_replace('/^[0-9]+\./', '', $name);
    }

    public function add($autodate = true, $nullValues = false) {
        if (parent::add($autodate, true)) {
            $this->clearCatCache();
            return true;
        }
        return false;
    }

    public function getName($id_lang = NULL) {
        if (!$id_lang) {
            global $cookie;

            if (isset($this->name[$cookie->id_lang]))
                $id_lang = $cookie->id_lang;
            else
                $id_lang = (int) (Configuration::get('PS_LANG_DEFAULT'));
        }
        return isset($this->name[$id_lang]) ? $this->name[$id_lang] : '';
    }

    function getTranslateFields() {
        return array_keys($this->fieldsValidateLang);
    }

    function addImage($name) {

        $primaryWidth = $this->params->get('primary_width', 500);
        $primaryheight = $this->params->get('primary_height', 500);
        //upload image to folder : 
        $file = $_FILES[$name]['name'];
        if (isset($file) && $file != NULL) {
            $ext = strtolower(substr($file, strrpos($file, '.') + 1));
            if (in_array($ext, $this->allowedUpload)) {

                $imageFullPath = LOFCONTENT_IMAGES_ORIGIN_FOLDER . $file;
                $imagePrimaryPath = LOFCONTENT_IMAGES_FOLDER . $file;
                $thumbFullPath = LOFCONTENT_THUMBS_FOLDER . $file;

                lofContentHelper::createFolderIfNotExist(LOFCONTENT_IMAGES_ORIGIN_FOLDER);
                lofContentHelper::createFolderIfNotExist(LOFCONTENT_IMAGES_FOLDER);
                lofContentHelper::createFolderIfNotExist(LOFCONTENT_THUMBS_FOLDER);

                //remove old image :
                $this->removeOldImageIfExist();

                //upload image
                move_uploaded_file($_FILES[$name]['tmp_name'], $imageFullPath);

                //push image name to main object (database store)
                $this->image = $file;

                //create thumbnail if not exist :
                $helper = new lofContentHelper();
                //create thumbnail if not exist :
                if (!file_exists($thumbFullPath)) {
                    $helper->createThumb($imageFullPath, $thumbFullPath, $this->params->get('thumb_width', 100), $this->params->get('thumb_height', 100));
                }

                //create primary image if not exist :
                if (!file_exists($imagePrimaryPath)) {
                    $helper->createThumb($imageFullPath, $imagePrimaryPath, $primaryWidth, $primaryheight);
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function removeOldImageIfExist() {
        //echo '-------------del------------'.$this->image.'<br />';
        //remove last image
        if ($this->image != '' && is_string($this->image)) {

            $oldOrigin = LOFCONTENT_IMAGES_ORIGIN_FOLDER . $this->image;
            $oldImage = LOFCONTENT_IMAGES_FOLDER . $this->image;
            $oldThumb = LOFCONTENT_THUMBS_FOLDER . $this->image;

            if (is_file($oldImage)) {
                unlink($oldImage);
            }
            if (is_file($oldThumb)) {
                unlink($oldThumb);
            }
            if (is_file($oldOrigin)) {
                unlink($oldOrigin);
            }
        }
    }

    public function updatePosition($way, $position) {
        $query = '
			SELECT cp.`id_lofblogs_category`, cp.`position`, cp.`id_parent`
			FROM `' . _DB_PREFIX_ . 'lofblogs_category` cp
			WHERE cp.`id_parent` = ' . (int) $this->id_parent . '
			ORDER BY cp.`position` ASC';

        if (!$res = Db::getInstance()->ExecuteS($query))
            return false;


        foreach ($res AS $category)
            if ((int) ($category['id_lofblogs_category']) == (int) ($this->id))
                $movedCategory = $category;

        if (!isset($movedCategory) || !isset($position))
            return false;
        // < and > statements rather than BETWEEN operator
        // since BETWEEN is treated differently according to databases
        $query1 = '
			UPDATE `' . _DB_PREFIX_ . 'lofblogs_category`
			SET `position`= `position` ' . ($way ? '- 1' : '+ 1') . '
			WHERE `position`
			' . ($way ? '> ' . (int) ($movedCategory['position']) . ' AND `position` <= ' . (int) ($position) : '< ' . (int) ($movedCategory['position']) . ' AND `position` >= ' . (int) ($position)) . '
			AND `id_parent`=' . (int) ($movedCategory['id_parent']);

        $query2 = '
			UPDATE `' . _DB_PREFIX_ . 'lofblogs_category`
			SET `position` = ' . (int) ($position) . '
			WHERE `id_parent` = ' . (int) ($movedCategory['id_parent']) . '
			AND `id_lofblogs_category`=' . (int) ($movedCategory['id_lofblogs_category']);

        $result = (Db::getInstance()->Execute($query1) AND Db::getInstance()->Execute($query2));
        return $result;
    }

    function getItems($lang_id, $format = 'normal') {

        if ($format == 'normal') {
            $orderField = $this->params->get('rssOrdering', 'date_upd, a.id_lofblogs_publication');
            $limit = Tools::getValue('n', abs((int) (Tools::getValue('n', $this->params->get('itemsLimit', 10)))));
        } else {
            $orderField = $this->params->get('aOrdering', 'date_upd, a.id_lofblogs_publication');
            $limit = $this->params->get('itemsFeedLimit', 10);
        }
        $orderWay = 'DESC';

        $query = 'SELECT a.*, al.* , CONCAT(e.`firstname`, \' \', e.`lastname`) AS authorname 
                    FROM ' . _DB_PREFIX_ . 'lofblogs_publication a 
                    LEFT JOIN ' . _DB_PREFIX_ . 'lofblogs_publication_lang al ON (a.id_lofblogs_publication = al.id_lofblogs_publication) 
                    LEFT JOIN ' . _DB_PREFIX_ . 'employee e ON (e.id_employee = a.id_author) 
                    WHERE 1 ' . (intval($this->id) ? ' AND a.id_lofblogs_category = ' . intval($this->id) : '')
                . ' AND al.id_lang = ' . intval($lang_id)
                . ' AND a.status ="published"';
        $groups = lofContentHelper::getCustomerGroups();

        foreach ($groups as $group) {
            $access[] = $group . ' IN (a.access)';
        }

        $query .= ' AND (' . implode(' OR ', $access) . ')';
        $query .= ' ORDER BY ' . $orderField . ' ' . $orderWay;

        $this->total = count(Db::getInstance()->ExecuteS($query));

        //get item by pagination :        
        $p = (int) Tools::getValue('p', 0);
        if ($p <= 1)
            $p = 1;
        $query .= ' LIMIT ' . (($p - 1) * (int) $limit) . ', ' . (int) $limit;

        return Db::getInstance()->ExecuteS($query);
    }

    function getPosition($parent = -1) {
        $current = DbCore::getInstance()->getValue('SELECT MAX(position) FROM ' . _DB_PREFIX_ . 'lofblogs_category WHERE id_parent = ' . $parent);
        return intval($current) + 1;
    }

    public function toggleStatus() {
        if (!Validate::isTableOrIdentifier($this->identifier) OR !Validate::isTableOrIdentifier($this->table))
            die(Tools::displayError());

        /* Object must have a variable called 'active' */
        elseif (!key_exists('active', $this))
            die(Tools::displayError());

        /* Update active status on object */
        $this->active = (int) (!$this->active);

        /* Change status to active/inactive */
        return Db::getInstance()->Execute('
		UPDATE `' . pSQL(_DB_PREFIX_ . $this->table) . '`
		SET `active` = !`active`
		WHERE `' . pSQL($this->identifier) . '` = ' . (int) ($this->id));
    }

    function viewAccess($disabled) {
        return true;
    }

}

?>
