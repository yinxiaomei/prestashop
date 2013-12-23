<?php

/**
 * Admin class - LofPscontentPublication
 * 
 * @Project Lof Content
 * @todo Get articles data.
 */

class LofPsblogsPublication extends ObjectModel {

    //table fields :
    public $title;
    public $content;
    public $link_rewrite;
    public $excerpt;
    public $status;
    public $date_add;
    public $date_upd;
    public $tags;
    public $image;
    public $postion = 0;
    public $short_desc;
    public $meta_description;
    public $meta_title;
    public $meta_keywords;
    public $id_lofblogs_category;
    public $id_author;
    public $products;
    public $id_products;
    public $featured;
    public $hits = 0;
    public $rating = 0;
    public $rating_num = 0;
    public $rating_point = 0;
    public $access = 0;
    public $created_by;
    public $updated_by;
    public $position;
    private static $_category = NULL;
    //custom property

    public $allow = '';
    public $errors = array();
    public $module_params = null;
    public $gallery_upload_basename = 'ga_upload_field';
    public $tab = 'AdminLofblogsCategory';
    protected $imagePath = '';
    protected $galleryPath = '';
    protected $allowedUpload = array("jpg", "bmp", "gif", "png");

    public $str_tags;
	
	
	public static $definition = array(
		'table' => 'lofblogs_publication',
		'primary' => 'id_lofblogs_publication',
		'multilang' => true,
		'fields' => array(
			'date_add' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'status' => 		array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 20),
			'date_upd' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'created_by' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'size' => 3),
			'updated_by' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'size' => 3),
			'image' => 				array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'position' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'id_lofblogs_category' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
			'id_author' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			//'id_products' => 				array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'featured' => 		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'hits' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'rating' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'rating_num' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'rating_point' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'access' => 		array('type' => self::TYPE_STRING, 'size' => 255),
			
			// Lang fields
			'title' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
			'content' => 		array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString', 'size'=>65536),
			'excerpt' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHTML', 'size'=>65536),
			'link_rewrite' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'size' => 128),
			//'tags' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString', 'size' => 255),
			'short_desc' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString'),
			'meta_title' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'meta_keywords' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'meta_description' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255)
		),
	);
	
    public function __construct($id = NULL, $id_lang = NULL) {  
        $this->imageUrl = __PS_BASE_URI__ . "img/lofblogs/images/articles/";
		
        $id_lofblogs_category = (int) (Tools::getValue('id_lofblogs_category', Tools::getValue('id_lofblogs_category_parent', 1)));
        self::$_category = new LofPsblogsCategory($id_lofblogs_category);
        if (!Validate::isLoadedObject(self::$_category))
            die('Category cannot be loaded');
        $module = new lofBlogs();

        $this->module_params = new LOFXParams($module);
        parent::__construct($id, $id_lang);

        $this->authorname = $this->getEmployeName();
        $this->calculateRating();
        $helper = new lofContentHelper();
        if($this->image) {
            $helper->autoCompleteImages($this->image, $this->module_params);
        }
        $tags = $this->getTags($id_lang);
        $str_tags = '';
        if($tags){
            foreach ($tags as $key => $value) {
                $str = '';
                foreach ($value as $row) {
                    $str .= ",".$row['name'];
                }
                $str_tags[$key] = ltrim($str,",");
            }
        }
        $this->tags = $str_tags;
        
    }

    public function toggleStatus($fieldname='status') { 
        global $currentIndex, $cookie;
        $token = Tools::getAdminTokenLite('AdminLofblogs');
        
        if (!Validate::isTableOrIdentifier($this->identifier) OR !Validate::isTableOrIdentifier($this->table))
            die(Tools::displayError());

        /* Object must have a variable called 'status' */
        elseif (!key_exists($fieldname, $this))
            die(Tools::displayError());

        /* Update status on object */
        $this->$fieldname = (int)(!$this->$fieldname);
        /* Change status to active/inactive */
        $query = '
		UPDATE `' . pSQL(_DB_PREFIX_ . $this->table) . '`
		SET `'.$fieldname.'` = "'.$this->$fieldname.'"
		WHERE `' . pSQL($this->identifier) . '` = ' . (int) ($this->id);
        $executed= Db::getInstance()->Execute($query);
        if($executed) {
            Tools::redirectAdmin('index.php?controller=AdminLofblogs&conf=5&id_lofblogs_category='.$this->id_lofblogs_category.'&token='.$token);
        }
    }   

    public function add($autodate = true, $nullValues = false) {
        $tags = $this->tags;
        $products = $this->products;
        $res = parent::add($autodate, true);
        if ($res){
            $return = $this->saveProductRelate($products);
            $return &= $this->saveTag($tags);
            $this->clearArticleCache();
            return $return;
        }
        return false;
    }
    
    public function clearArticleCache() {
        return "";
        if (file_exists(_PS_MODULE_DIR_ . "leoblogsarticle/leoblogsarticle.php")) {
            require_once _PS_MODULE_DIR_ . "leoblogsarticle/leoblogsarticle.php";
            $lofBlogA = new LeoBlogsArticle();
            if(method_exists($lofBlogA,'clearCache')) $lofBlogA->clearCache();
        }
    }

    public function update($null_values = false) {
		$tags = $this->tags;
        $products = $this->products;
        $res = parent::update($null_values);
        if ($res){
            $return = $this->saveProductRelate($products);
            $return &= $this->saveTag($tags);
            $this->clearArticleCache();
            return $return;
        }
        return false;
    }

    function addImage($name) {

        $primaryWidth = $this->module_params->get('primary_width', 500);
        $primaryheight = $this->module_params->get('primary_height', 500);

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
                if (move_uploaded_file($_FILES[$name]['tmp_name'], $imageFullPath)) {

                    //push image name to main object (database store)                    
                    $this->image = $file;

                    if (file_exists($imageFullPath)) {
                        $helper = new lofContentHelper();

                        //create primary image if not exist :
                        if (!file_exists($imagePrimaryPath)) {
                            $helper->createThumb($imageFullPath, $imagePrimaryPath, $primaryWidth, $primaryheight);
                        } else {
                            $this->errors[] = 'ADD IMAGE - Exist primary ' . $imagePrimaryPath;
                        }

                        //create thumbnail if not exist :
                        if (!file_exists($thumbFullPath)) {
                            $helper->createThumb($imageFullPath, $thumbFullPath, $this->module_params->get('thumb_width', 100), $this->module_params->get('thumb_height', 100));
                        } else {
                            $this->errors[] = 'ADD IMAGE - Exist thumb ' . $thumbFullPath;
                        }
                    } else {
                        $this->errors[] = 'ADD IMAGE - Not Exist origin ' . $file;
                    }
                }
                $this->errorsReport();
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

    function getTranslateFields() {
        return array_keys($this->fieldsValidateLang);
    }

    public static function getCurrentCategory() {
        return self::$_category;
    }

    public function getTitle($id_lang = NULL) {
        if (!$id_lang) {
            global $cookie;

            if (isset($this->title[$cookie->id_lang]))
                $id_lang = $cookie->id_lang;
            else
                $id_lang = (int) (Configuration::get('PS_LANG_DEFAULT'));
        }
        return isset($this->title[$id_lang]) ? $this->name[$id_lang] : '';
    }

    function uploadGallery($files) {

        $imageWidth = $this->module_params->get('primary_width', 400);
        $imageHeight = $this->module_params->get('primary_height', 200);
        $thumbWidth = $this->module_params->get('thumb_width', 100);
        $thumbHeight = $this->module_params->get('thumb_height', 100);

        //echo '<pre>'; die(print_r($files));
        $helper = new lofContentHelper();
        lofContentHelper::createFolderIfNotExist(LOFCONTENT_IMAGES_ORIGIN_FOLDER);
        lofContentHelper::createFolderIfNotExist(LOFCONTENT_THUMBS_FOLDER);
        lofContentHelper::createFolderIfNotExist(LOFCONTENT_GALLERY_FOLDER);
        
        for ($i = 0; $i < count($files['name']); $i++) {
            $file = $files['name'][$i];
            $file_tmp = $files['tmp_name'][$i];

            if (isset($file) && $file != NULL) {
                $ext = strtolower(substr($file, strrpos($file, '.') + 1));
                $filename = LOFCONTENT_IMAGES_ORIGIN_FOLDER . $this->id . '_' . $file;
                if (in_array($ext, $this->allowedUpload)) {
                    if (move_uploaded_file($file_tmp, $filename)) {

                        $primayname = LOFCONTENT_GALLERY_FOLDER . $this->id . '_' . $file;
                        //create thumbnail if not exist :                        
                        if (!file_exists($primayname) && file_exists($filename)) {
                            $helper->createThumb($filename, $primayname, $imageWidth, $imageHeight);
                        } else {
                            $this->errors[] = 'Image already exist : ' . $primayname;
                        }

                        $thumbname = LOFCONTENT_THUMBS_FOLDER . $this->id . '_' . $file;
                        //create thumbnail if not exist :                        
                        if (!file_exists($thumbname) && file_exists($filename)) {
                            $helper->createThumb($filename, $thumbname, $thumbWidth, $thumbHeight);
                        } else {
                            $this->errors[] = 'Thumb already exist : ' . $thumbname;
                        }
                    } else {
                        $this->errors[] = 'CANT UPLOAD FILE ' . $file;
                    }
                } else {
                    $this->errors[] = 'File Type not allowed ' . $file;
                }
            } else {
                $this->errors[] = 'File is empty incorect data ' . $file;
            }

            $this->errorsReport();
        }
    }

    function errorsReport() {
        if (count($this->errors)) {
            $errorLogFile = LOFCONTENT_ROOT . "error_log.txt";
            $fh = fopen($errorLogFile, 'w') or die("can't open file");
            $space = "\r\n";
            $stringErrors = implode($space, $this->errors);
            fwrite($fh, $stringErrors);
            fclose($fh);
        }
    }

    function getGallery() {
        $items = $this->getImages();

        if (count($items) && is_array($items)) {
            $output = '<ul class="gallery_image">';
            foreach ($items as $imageName) {
                $output .= '<li class="lofblogs_gaimg_container">
                                <div class="deleted_img_label" >click update to remove</div>
                                <span><input onClick="selectImage(this);" type="checkbox" name="remove_images[]" value="' . $imageName . '" />Delete</span>
                                <img class="gallery_img_thumb" src="' . LOFCONTENT_IMAGES_THUMBS_URI . $imageName . '" />
                            </li>';
            }
            $output .= '</ul>';
            return $output;
        } else
            return '<div class="lofcontent_note">Gallery is empty !</div>';
    }

    function getImages() {
        $items = array();
        $handle = opendir(LOFCONTENT_GALLERY_FOLDER);
        if (!$handle) {
            return $items;
        }
        while (false !== ($file = readdir($handle))) {
            if ($this->isItemImage($file)) {
                $items[] = $file;
            }
        }
        return $items;
    }
    
    function getRelatedProducts() {

        $products = $this->getRelated();

        // --------- page output ---------
        $html = '<h3>Related products list</h3>';
        $html .= '<ul id="related_products">';
        if (count($products)) {
			
            foreach ($products as $product) {

                $html .= '<li onClick="removeMe(this);" id="selected_' . $product['id_product'] . '" class="product_item">';
                $html .= '<p>' . $product['name'] . '</p>';
                $html .= '<img src="' . $product['image'] . '" />';
                $html .= '<input class="rlt_product_data" type="hidden" name="products[]" value="' . $product['id_product'] . '" />';
                $html .= '<div class="deleted_img_label">Remove</div>';
                $html .= '</li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

    public function deleteProductRelate(){
        return Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'lofblogs_publication_product` WHERE `id_lofblogs_publication` = '.(int)($this->id));
    }

    public function saveProductRelate($products){
        $return = $this->deleteProductRelate();
        if(count($products) > 0){
            foreach ($products as $id_product) {
                $return &= Db::getInstance()->Execute('REPLACE INTO `'._DB_PREFIX_.'lofblogs_publication_product`(`id_lofblogs_publication`, `id_product`)
                        VALUES('.(int)($this->id).','.(int)($id_product).')');
            }
        }
        return $return;
    }

    function getRelated() {
        global $cookie;
        $query = 'SELECT DISTINCT p.id_product, pl.name, pl.link_rewrite 
                FROM ' . _DB_PREFIX_ . 'product p 
                LEFT JOIN ' . _DB_PREFIX_ . 'product_lang pl ON ( pl.id_product = p.id_product)  
                INNER JOIN `' . _DB_PREFIX_ . 'lofblogs_publication_product` pp ON(pl.`id_product` = pp.`id_product`)
                WHERE pp.id_lofblogs_publication = ' . (int)$this->id . '
                AND pl.`id_lang` = ' . (int) ($cookie->id_lang) . '
                AND p.active = 1';
        $result = $this->renderProduct(Db::getInstance()->ExecuteS($query));
        
        return $result;
    }

    function removeSelectedImages() {
        if(!isset($_POST['remove_images']))
            return true;
        $images = $_POST['remove_images'];
        if (is_array($images) && count($images)) {
            foreach ($images as $imageName) {
                //remove origin image :
                $filename = LOFCONTENT_IMAGES_ORIGIN_FOLDER . $imageName;
                if (file_exists($filename)) {
                    @unlink($filename);
                }

                //remove gallery image :
                $imagename = LOFCONTENT_GALLERY_FOLDER . $imageName;
                if (file_exists($imagename)) {
                    @unlink($imagename);
                }

                //remove thumb image :
                $thumbname = LOFCONTENT_THUMBS_FOLDER . $imageName;
                if (file_exists($thumbname)) {
                    @unlink($thumbname);
                }
            }
        }
    }

    function isItemImage($file, $disallowed = array('.', '..', '.svn')) {
        if (!is_dir($file) && !in_array($file, $disallowed)) {
            $ext = strtolower(preg_replace('/^.*\./', '', $file));
            $temp = explode('_', $file);
            $itemId = $temp[0]; //this is item id follow lofblogs image gallery named rule : id_imagname
            if (in_array($ext, $this->allowedUpload)) {
                if (intval($itemId) == $this->id) {
                    return true;
                } else {
                    return false;
                }
            } else
                return false;
        } else {
            return false;
        }
    }

    function getImageId($id_product) {
        $query = 'SELECT id_image FROM `' . _DB_PREFIX_ . 'image` WHERE id_product = ' . $id_product . ' AND cover = 1 ORDER BY id_image ';
        $id_image = Db::getInstance()->getValue($query);
        return $id_product . '-' . $id_image;
    }

    function renderProduct($products) {
        $list = array();
		$link = new Link;
        if (count($products)) {
            foreach ($products as $product) {
                $img_id = $this->getImageId($product['id_product']);
                $product['image'] =  'http://'.$link->getImageLink($product['link_rewrite'], $img_id, 'large_default');
                $product['link'] = $link->getProductLink($product['id_product']);
                $list[] = $product;
            }
        }
        //echo '<pre>'; die(print_r($list));
        return $list;
    }

    public function getEmployeName() {
        if(!$this->id_author) return '';
        $query = '
		SELECT CONCAT(`firstname`, \' \', `lastname`) AS "name"
		FROM `' . _DB_PREFIX_ . 'employee`
		WHERE `active` = 1 AND `id_employee` = ' . pSQL($this->id_author) . '
		ORDER BY `email`';
        
        return Db::getInstance()->getValue($query);
    }

    function filterArticles($fields, $p, $n = false) {
        global $cookie;
        $helper = new lofContentHelper();
        $query = 'SELECT a.*, al.* ';
        $query .= 'FROM ' . _DB_PREFIX_ . 'lofblogs_publication a ';
        $query .= 'LEFT JOIN ' . _DB_PREFIX_ . 'lofblogs_publication_lang al ON (a.id_lofblogs_publication = al.id_lofblogs_publication) ';
        $query .= 'WHERE al.id_lang = ' . intval($cookie->id_lang);
        //filter by title : 
        if (isset($fields['title']) && $fields['title']) {
            $query .= ' AND al.title LIKE ' . $helper->likeQuote($fields['title']);
        }

        //filter by tag : 
        if (isset($fields['tag']) && $fields['tag']) {
            $id_lang = Context::getContext()->language->id;
            $query .= ' AND a.id_lofblogs_publication IN 
                (SELECT lta.id_lofblogs_publication 
                    FROM `'._DB_PREFIX_.'lofblogs_tag_article` lta 
                    INNER JOIN `'._DB_PREFIX_.'lofblogs_tag` lt ON (lt.`id_lofblogs_tag` = lta.`id_lofblogs_tag`) 
                    WHERE lt.name LIKE ' . $helper->likeQuote($fields['tag']).' AND lt.`id_lang` = '.(int)$id_lang.'
                )';
        }
        if (isset($fields['year']) && $fields['year'] && Validate::isUnsignedInt($fields['year'])) {
            $query .= ' AND YEAR(a.`date_add`) = '.(int)($fields['year']);
        }
        if (isset($fields['month']) && $fields['month'] && Validate::isUnsignedInt($fields['month'])) {
            $query .= ' AND MONTH(a.`date_add`) = '.(int)($fields['month']);
        }
        $groups = lofContentHelper::getCustomerGroups();
        $access = array();
        foreach($groups as $id_group){
            $access[] = $id_group . ' IN (a.access)';
        }
        if(count($access))
            $query .= ' AND ('. implode(' OR ', $access) .') ';

		if($p <= 1)
			$p = 1;
		if($n)
			$query .= ' LIMIT '.($p-1)*$n.','.$n;
        return Db::getInstance()->ExecuteS($query);
    }

    function updateHit() {
        $hits = $this->hits + 1;
        $query = 'UPDATE ' . _DB_PREFIX_ . $this->table . ' SET hits=' . pSQL($hits) . ' WHERE id_lofblogs_publication = ' . $this->id;
        Db::getInstance()->Execute($query);
    }

    function updateRating($point) {
        $this->rating_num = $this->rating_num + 1;
        $this->rating_point = $this->rating_point + intval($point);
        $rating = $this->calculateRating();
        $query = 'UPDATE ' . _DB_PREFIX_ . $this->table .
                ' SET rating_num=' . pSQL($this->rating_num) . ', rating_point = ' . pSQL($this->rating_point) . ', rating = ' . pSQL($rating) .
                ' WHERE id_lofblogs_publication = ' . $this->id;
        Db::getInstance()->Execute($query);
    }

    function addComment($published = 0) {
        $fields = array();

        //field need to insert :  
        $fields['published'] = $published;
        $fields['item_id'] = Tools::getValue('item_id');
        $fields['name'] = pSQL(Tools::getValue('name'));
        $fields['email'] = Tools::getValue('email');
        $fields['website'] = Tools::getValue('website');
        $fields['content'] = $_GET['content'];
        $fields['date_add'] = date('Y-m-d H:i:s');

        Db::getInstance()->autoExecute(_DB_PREFIX_ . 'lofblogs_comment', $fields, 'INSERT');
    }

    function getComments() {
        $id = Tools::getValue('item_id');
        if (!$id)
            $id = $this->id;
        if ($id) {
            $query = 'SELECT *';
            $query .= ' FROM ' . _DB_PREFIX_ . 'lofblogs_comment ';
            $query .= ' WHERE item_id = ' . $id . ' AND published = 1';
            $query .= ' ORDER BY date_add DESC';
            return Db::getInstance()->ExecuteS($query);
        } else {
            return false;
        }
    }

    function calculateRating() {

        $this->rating = intval($this->rating_num) > 0 ? intval($this->rating_point / ($this->rating_num)) : 0;
        return $this->rating;
    }

    function addClient() {
        $client['client_ip'] = lofContentHelper::getClientId();
        $client['itemid'] = $this->id;
        Db::getInstance()->autoExecute(_DB_PREFIX_ . 'lofblogs_rate_clients', $client, 'INSERT');
    }

    function allowedAccess() {
        $groups = lofContentHelper::getCustomerGroups();
        $articleAllowed = explode(',', $this->access);
        $diff = array_diff($groups, $articleAllowed);

        foreach ($groups as $group) {
            if (in_array($group, $articleAllowed))
                return true;
        }
        return false;
    }
    /**
    * Functions Tag
    *
    */
    public function saveTag($tags){
        $languages = Language::getLanguages(false);
        $return = true;
        foreach ($languages as $lang) {
            if(isset($tags[$lang['id_lang']]) && $tags[$lang['id_lang']]){
                $ltags = explode(',', $tags[$lang['id_lang']]);
                foreach ($ltags as $tag) {
                    $tag = trim($tag);
                    $getTag = $this->getTag( $tag, $lang['id_lang'] );
                    if ( $getTag ) {
                        $id_tag =  $getTag['id_lofblogs_tag'];
                    }else{
                        $res = Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'lofblogs_tag` (`id_lang`,`name`) VALUES('.(int)$lang['id_lang'].',\''.pSQL($tag).'\')');
                        if (!$res)
                            return false;
                        $getTag = $this->getTag( $tag, $lang['id_lang'] );
                        $id_tag = $getTag['id_lofblogs_tag'];
                    }
                    $return &= Db::getInstance()->Execute('REPLACE INTO `'._DB_PREFIX_.'lofblogs_tag_article`( `id_lofblogs_tag`, `id_lofblogs_publication`)
                        VALUES( '.(int)($id_tag).', '.(int)($this->id).')');

                }
            }
        }
        return $return;
    }

    public function getTag($tag, $id_lang){
        return Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'lofblogs_tag` WHERE `name` = \''.pSQL($tag).'\' AND `id_lang` ='.(int)$id_lang );
    }

    public function getTags($id_lang){
        $tags = Db::getInstance()->ExecuteS('
            SELECT t.* FROM `'._DB_PREFIX_.'lofblogs_tag` t
            INNER JOIN `'._DB_PREFIX_.'lofblogs_tag_article` ta ON (ta.id_lofblogs_tag = t.id_lofblogs_tag)
            WHERE ta.`id_lofblogs_publication` = '.(int)$this->id.($id_lang ? ' AND t.`id_lang` = '.(int)$id_lang : '') );
        $return = array();
        if ($tags) 
            foreach ($tags as $key => $value) {
                $return[$value['id_lang']][] = $value;
            }
        return $return;
    }


}
