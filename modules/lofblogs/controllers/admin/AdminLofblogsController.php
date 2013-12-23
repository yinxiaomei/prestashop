<?php

/**
 * Lofcontent Admin tab
 * @category admin
 *
 * @author AppSide
 * @copyright AppSide
 * @version 1.4
 *
 */
require_once _PS_MODULE_DIR_ . 'lofblogs/defined.php';
//include module :
require_once(LOFCONTENT_ROOT . "lofblogs.php");

//include models :
require_once LOFCONTENT_MODELS_FOLDER . 'LofPsblogsCategory.php';
require_once LOFCONTENT_MODELS_FOLDER . 'LofPsblogsPublication.php';

class AdminLofblogsController extends AdminController {

    protected $module;
    private $_category;

    public function __construct() {
        global $cookie;

        $this->table = 'lofblogs_publication';
        $this->className = 'LofPsblogsPublication';
        $this->lang = true;
		$this->addRowAction('edit');
		$this->addRowAction('delete');
        $this->module = 'lofblogs';
        $this->context = Context::getContext();

        //if no already exist a catetory set category id to 1 (home) :
        $category_id = intval(Tools::getValue('id_lofblogs_category', Tools::getValue('id', 0)));

        $this->_category = new LofPsblogsCategory($category_id);

        $this->fields_list = array(
            'id_lofblogs_publication' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 30),
            'status' => array('title' => $this->l('Status'), 'width' => 10, 'type' => 'bool', 'align' => 'center', 'icon' => array('published' => 'enabled.gif', 'drafted' => 'warning.gif', 'suspended' => 'forbbiden.gif', 'default' => 'unknown.gif'), 'orderby' => false, 'search' => true, 'active' => 'status'),
            'title' => array('title' => $this->l('Title'), 'width' => 300),
            'categoryname' => array('title' => $this->l('Category'), 'width' => 200),
            'date_add' => array('title' => $this->l('Publication date'), 'width' => 120, 'type' => 'date', 'search' => false),
            'featured' => array('title' => $this->l('is Featured'), 'width' => 30, 'icon' => array('1' => 'lfeatured.png', '0' => 'lunfeatured.png', 'default' => 'unknown.gif'), 'active' => 'featured', 'type' => 'bool'),
            'hits' => array('title' => $this->l('Hits'), 'search' => false, 'width' => 30)
        );

        $this->_join = ' LEFT JOIN `' . _DB_PREFIX_ . 'lofblogs_category` c ON (c.`id_lofblogs_category` = a.`id_lofblogs_category`)';
        $this->_join .= ' LEFT JOIN `' . _DB_PREFIX_ . 'lofblogs_category_lang` cl ON (cl.`id_lofblogs_category` = a.`id_lofblogs_category`)';
        $this->_select = 'cl.name as categoryname';

        if ($category_id) {
            $this->_filter = 'AND c.id_lofblogs_category = ' . (int) ($category_id);
        }
        $this->_filter .= ' AND cl.id_lang = ' . $this->context->language->id;
        $this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected articles'), 'confirm' => $this->l('Delete selected articles?')));
        parent::__construct();
		/*
		$id_parent = Tab::getCurrentParentId();
		$this->tabAccess = Profile::getProfileAccess($this->context->employee->id_profile, $id_parent);
		*/
    }

    public function renderForm() {
        global $currentIndex, $cookie;

        $this->initToolbarTitle();
        $this->initToolbar();
        $toolbar = $this->context->smarty->fetch('toolbar.tpl');

        $defaultLanguage = intval($this->context->language->id);
        $iso = Language::getIsoById($defaultLanguage);
        $isoTinyMCE = (file_exists(_PS_ROOT_DIR_ . '/js/tiny_mce/langs/' . $iso . '.js') ? $iso : 'en');
        $tinymceFile = __PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js';
        $tinymceInit = __PS_BASE_URI__ . 'js/tinymce.inc.js';


        $obj = $this->loadObject(true);
        
        foreach ($obj->getTranslateFields() as $lang_field) {
            $langNames[] = 'c' . $lang_field;
        }
        $langNames[] = 'ctags';
        $divLangName = implode('¤', $langNames);

        $lofAdminHtml = new lofPrestaHtml($divLangName, $obj);

        //add javascript & css :
        $this->context->controller->addJS(LOFCONTENT_JS_URI . 'lofblogs_admin.js');
        $this->context->controller->addJS(LOFCONTENT_JS_URI . 'textextjs.js');
        $this->context->controller->addJS(LOFCONTENT_JS_URI . 'lofblogs_admin_article.js');
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs.css');
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs_admin_articles.css');
        $this->addjQueryPlugin(array('autocomplete'));

        $backlink = Tools::getValue('back') ? Tools::safeOutput(Tools::getValue('back')) : $currentIndex . '&token=' . $this->token . '&id_lofblogs_category=' . $obj->id_lofblogs_category;
        //prepare some data :
        $formAction = $currentIndex . '&submitAdd' . $this->table . 'AndStay=1&token=' . $this->token;
        $lofAdminHtml->setTranslateFile('lof_article');
        if($obj->image && file_exists(LOFCONTENT_IMAGES_FOLDER.$obj->image)) {
            $imageField = '<div class="image_preview"><img src="' . LOFCONTENT_IMAGES_URI . $obj->image . '" alt="Please upload image" /></div> <input type="checkbox" value="1" name="deleteImage"/> '.$this->l('Delete Image');
        } elseif(!$obj->image) {
            $imageField = '<div class="image_preview"><span>'.$this->l('No Image').'</span></div>';
        } elseif (!file_exists(LOFCONTENT_IMAGES_FOLDER.$obj->image)) {
            $imageField = '<div class="image_preview"><span>'.$this->l('Image has removed').'</span></div>';
        }
        $languages = Language::getLanguages(false);
        $relate_products = $obj->getRelated();
        ob_start();
        require _PS_MODULE_DIR_ . "lofblogs/html/lof_article.php";
        $html = ob_get_contents();
        ob_clean();

        return $toolbar . $html;
    }

    /**
     * Overrider function
     * @param type $object
     * @param type $table 
     */
    protected function copyFromPost(&$object, $table) {

        global $cookie;

        //update access (multiple group) :
        if(!isset($_POST['access']))
            $_POST['access'] = 0;
        if (is_array($_POST['access'])) {
            $_POST['access'] = trim(implode(',', $_POST['access']), ' ,');
        }

        //update feature state :
        if (!isset($_POST['featured']) || !$_POST['featured'])
            $_POST['featured'] = 0;

        //update author information :
        if (!$object->id_author) {
            $object->id_author = $cookie->id_employee;
        }

        //generate products id : 
        if ($accessories = Tools::getValue('inputAccessories'))
        {
            $accessories_id = array_unique(explode('-', trim($accessories,'-')));
            $_POST['products'] = $accessories_id;
            
        }

        //auto generate default value if it's empty :
        $this->generateDefaultValuesLang();

        foreach ($_POST AS $key => $value)
            if (key_exists($key, $object) AND $key != 'id_' . $table) {

                /* Do not take care of password field if empty */
                if ($key == 'passwd' AND Tools::getValue('id_' . $table) AND empty($value))
                    continue;
                /* Automatically encrypt password in MD5 */
                if ($key == 'passwd' AND !empty($value))
                    $value = Tools::encrypt($value);

                $object->{$key} = $value;
            }

        /* Multilingual fields */
        $rules = call_user_func(array(get_class($object), 'getValidationRules'), get_class($object));
        $rules['validateLang']['tags'] = 'isCleanHTML';
        if (sizeof($rules['validateLang'])) {
            $languages = Language::getLanguages(false);
            foreach ($languages AS $language)
                foreach (array_keys($rules['validateLang']) AS $k => $field) {
                    if (isset($_POST[$field . '_' . (int) ($language['id_lang'])]))
                        $object->{$field}[(int) ($language['id_lang'])] = $_POST[$field . '_' . (int) ($language['id_lang'])];
                }
        }

		if(Tools::getValue('deleteImage')){
			$object->removeOldImageIfExist();
			$object->image = '';
		}
		
        //upload image
        if ($_FILES['image']['name']) {
            $object->addImage('image');
        }

        if ($object->id && intval($object->id) > 0) {
            //upload gallery :
            $files = $_FILES['ga_upload_field'];
            if (is_array($files['name']) && count($files['name']) && $files['name'][0] != '') {
                $object->uploadGallery($files);
            }


            //remove selected images from gallery manager :
            $object->removeSelectedImages();
        }
    }

    public static function getEmployeName($id) {
        return Db::getInstance()->getValue('
		SELECT CONCAT(`firstname`, \' \', `lastname`) AS "name"
		FROM `' . _DB_PREFIX_ . 'employee`
		WHERE `active` = 1 AND `id_employee` = ' . pSQL($id) . '
		ORDER BY `email`');
    }

    function generateDefaultValuesLang() {
        global $cookie;
        $defaultTitle = $_POST['title_' . $cookie->id_lang];
        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {

            //prepare data :
            $title = $_POST['title_' . $lang['id_lang']] ? $_POST['title_' . $lang['id_lang']] : $defaultTitle;
            $alias = 'link_rewrite_' . $lang['id_lang'];
            $meta_title = 'meta_title_' . $lang['id_lang'];
            $meta_key = 'meta_keywords_' . $lang['id_lang'];
            $meta_desc = 'meta_description_' . $lang['id_lang'];
            $tags = 'tags_' . $lang['id_lang'];

            if ($title) {
                //link rewrite :
                if (!$_POST[$alias])
                    $_POST[$alias] = lofContentHelper::makeSafeLinkRewrite($title);

                //meta title :
                if (!$_POST[$meta_title])
                    $_POST[$meta_title] = $title;

                //meta description
                if (!$_POST[$meta_desc])
                    $_POST[$meta_desc] = $title;

                //meta keyworks :
                if (!$_POST[$meta_key])
                    $_POST[$meta_key] = str_replace(' ', ', ', trim($title));

                //tags :
                /*
                if (!$_POST[$tags])
                    $_POST[$tags] = str_replace(' ', ', ', trim($title));
                */
            }
            $_POST['title_' . $lang['id_lang']] = $title;
        }
        //echo '<pre>'; die(print_r($_POST));
    }
	

    public static function getCurrentCategory() {
        return self::$_category;
    }

    function viewAccess($disable = false) {
        return true;
    }

    function init() {
        parent::init();
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs.css');
    }

    public function initToolbar() {
        $token = Tools::getAdminTokenLite('AdminLofblogsPanel');
        $category = Tools::getValue('id_lofblogs_category') ? '&amp;id_lofblogs_category=' . Tools::getValue('id_lofblogs_category') : '';

        switch ($this->display) {
            case 'add':
            case 'edit':

                // Default save button - action dynamically handled in javascript
                $this->toolbar_btn['save'] = array(
                    'href' => '#',
                    'desc' => $this->l('Save')
                );
            //no break
            case 'view':
                // Default cancel button - like old back link
                $back = Tools::safeOutput(Tools::getValue('back', ''));
                if (empty($back))
                    $back = self::$currentIndex . '&token=' . $this->token;
                if (!Validate::isCleanHtml($back))
                    die(Tools::displayError());
                if (!$this->lite_display)
                    $this->toolbar_btn['back'] = array(
                        'href' => $back,
                        'desc' => $this->l('Back to list')
                    );
                break;
            case 'options':
                $this->toolbar_btn['save'] = array(
                    'href' => '#',
                    'desc' => $this->l('Save')
                );
                break;
            case 'view':
                break;
            default: // list                
                $link = 'index.php?controller=adminlofblogs&amp;add' . $this->table . '&amp;token=' . $this->token . $category;
                $this->toolbar_btn['addblog'] = array(
                    'href' => $link,
                    'desc' => $this->l('Add new')
                );
                $this->toolbar_btn['back'] = array(
                    'href' => 'index.php?controller=AdminLofblogsPanel&token=' . $token,
                    'desc' => $this->l('Back to Panel')
                );
        }

        $this->context->smarty->assign('toolbar_scroll', 1);
        $this->context->smarty->assign('show_toolbar', 1);
        $this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);
        $this->context->smarty->assign('title', $this->toolbar_title);
    }

    public function initToolbarTitle() {
        parent::initToolbarTitle();
        if ($this->display == 'edit' || $this->display == 'add') {
            $article = $this->loadObject(true);
            if ($article)
                if ((bool) $article->id && $this->display != 'list' && isset($this->toolbar_title[3]))
                    $this->toolbar_title[3] = $this->toolbar_title[3] . ' (' . $article->title[$this->context->language->id] . ')';
        }
    }

    public function initProcess() {
        parent::initProcess();
        if ((isset($_GET['featured' . $this->table]) || isset($_GET['featured'])) && Tools::getValue($this->identifier)) {
            if ($this->tabAccess['edit'] === '1')
                $this->action = 'featured';
            else
                $this->errors[] = Tools::displayError('You do not have permission to edit here.');
        }
    }

    public function processFeatured() {
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            if ($object->toggleStatus('featured')) {
                $id_category = (($id_category = (int) Tools::getValue('id_category')) && Tools::getValue('id_product')) ? '&id_category=' . $id_category : '';
                $this->redirect_after = self::$currentIndex . '&conf=5' . $id_category . '&token=' . $this->token;
            }
            else
                $this->errors[] = Tools::displayError('An error occurred while updating status.');
        }
        else
            $this->errors[] = Tools::displayError('An error occurred while updating status for object.') .
                    ' <b>' . $this->table . '</b> ' .
                    Tools::displayError('(cannot load object)');

        return $object;
    }

    /**
     * Function used to render the list to display for this controller
     */
    public function renderList() {
        $htmlHelper = new lofPrestaHtml();
        $htmlHelper->getNestedCategoriesData();
        array_shift($htmlHelper->categoriesOptionList);
        array_unshift($htmlHelper->categoriesOptionList, array('value' => '', 'text' => '.. Select All ..'));
        $category_tree = $htmlHelper->getSelectList('id_lofblogs_category', $htmlHelper->categoriesOptionList, Tools::getValue('id_lofblogs_category'), 'onChange="submit();"');

        if (!($this->fields_list && is_array($this->fields_list)))
            return false;
        $this->getList($this->context->language->id);

        // Empty list is ok
        if (!is_array($this->_list))
            return false;

        $helper = new HelperList();

        $this->setHelperDisplay($helper);
        $helper->tpl_vars = $this->tpl_list_vars;
        $helper->tpl_vars['category_tree'] = '<label>Category</label>' . $category_tree;
        $helper->tpl_vars['is_category_filter'] = 1;
        $helper->tpl_delete_link_vars = $this->tpl_delete_link_vars;
        $helper->override_folder = false;
        $helper->module = new lofBlogs();

        // For compatibility reasons, we have to check standard actions in class attributes
        foreach ($this->actions_available as $action) {
            if (!in_array($action, $this->actions) && isset($this->$action) && $this->$action)
                $this->actions[] = $action;
        }

        $list = $helper->generateList($this->_list, $this->fields_list);

        return $list;
    }

}