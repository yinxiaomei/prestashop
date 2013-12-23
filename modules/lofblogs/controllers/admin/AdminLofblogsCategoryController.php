<?php

require_once _PS_MODULE_DIR_ . 'lofblogs/defined.php';
require_once(LOFCONTENT_ROOT . "lofblogs.php");

require_once LOFBLOGS_CONTROLLERS_ADMIN_FOLDER . 'AdminLofblogsController.php';

//include model :
require_once LOFCONTENT_MODELS_FOLDER . "LofPsblogsCategory.php";
require_once LOFCONTENT_MODELS_FOLDER . "LofPsblogsPublication.php";

//include helpers
require_once LOFCONTENT_LIBS_FOLDER . 'lof_content_helper.php';

class AdminLofblogsCategoryController extends AdminController {

    private $_category;
    public $articlesManger = null;
    protected $position_identifier = 'id_category_to_move';

    public function __construct() {

		
        $this->table = 'lofblogs_category';
        $this->className = 'LofPsblogsCategory';
        $this->lang = true;
		$this->addRowAction('edit');
		$this->addRowAction('delete');
        $category_id = intval(Tools::getValue('id_lofblogs_category')) ? intval(Tools::getValue('id_lofblogs_category')) : 1;

        $this->_category = new LofPsblogsCategory($category_id);
        $this->articlesManger = new AdminLofblogsController();

        $id_parent = intval(Tools::getValue('id_parent')) ? intval(Tools::getValue('id_parent')) : $this->_category->id_parent;
        $this->_parent = new LofPsblogsCategory($id_parent);

        $this->fields_list = array(
            'id_lofblogs_category' => array('title' => $this->l('ID'), 'width' => 10, 'align' => 'center'),
            'position' => array('title' => $this->l('Position'), 'width' => 20, 'filter_key' => 'position', 'align' => 'center', 'position' => 'position'),
            'name' => array('title' => $this->l('Category name'), 'width' => 150),
            'description' => array('title' => $this->l('Description'), 'width' => 250, 'callback' => 'getDescriptionClean'),
            'active' => array('title' => $this->l('Published'), 'width' => 30, 'align' => 'center', 'icon' => array('1' => 'enabled.gif', '0' => 'forbbiden.gif', 'default' => 'unknown.gif'), 'orderby' => false, 'search' => true, 'active' => 'status', 'type' => 'bool'),
        );
        $this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected categories'), 'confirm' => $this->l('Delete selected categories?')));
        $this->identifier = 'id_lofblogs_category';

        if (intval($id_parent) > 0) {
            $this->_filter = ' AND id_parent = ' . $id_parent;
        } else {
            $this->_filter = 'AND `id_parent` = 1 ';
        }

        $this->_select = 'position';
        $this->_orderBy = 'position';

        parent::__construct();
		/*
		$id_parent = Tab::getCurrentParentId();
		$this->tabAccess = Profile::getProfileAccess($this->context->employee->id_profile, $id_parent);
		*/
    }

    public function renderForm() {
        global $currentIndex;

        $this->initToolbarTitle();
        $this->initToolbar();
        $this->context->smarty->assign('title', $this->toolbar_title);
        $toolbar = $this->context->smarty->fetch('toolbar.tpl');

        $defaultLanguage = intval($this->context->language->id);
        $obj = $this->loadObject(true);
        $langNames = array();
        foreach ($this->_category->getTranslateFields() as $lang_field) {
            $langNames[] = 'c' . $lang_field;
        }
        $divLangName = implode('¤', $langNames);

        $lofAdminHtml = new lofPrestaHtml($divLangName, $obj);
        $iso = Language::getIsoById((int) ($defaultLanguage));
        //editor behavior :
        $isoTinyMCE = (file_exists(_PS_ROOT_DIR_ . '/js/tiny_mce/langs/' . $iso . '.js') ? $iso : 'en');
        $tinymceFile = __PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js';
        $tinymceInit = __PS_BASE_URI__ . 'js/tinymce.inc.js';

        //add javascript & css :
        $this->context->controller->addJS(LOFCONTENT_JS_URI . 'lofblogs_admin_article.js');
        $this->context->controller->addJS(LOFCONTENT_JS_URI . 'lofblogs_admin.js');
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs.css');
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs_admin_category.css');
        $backlink = Tools::getValue('back') ? Tools::safeOutput(Tools::getValue('back')) : $currentIndex . '&token=' . $this->token . '&id_lofblogs_category=' . $obj->id_parent;

        //prepare some data :
        $formAction = $currentIndex . '&submitAdd' . $this->table . 'AndStay=1&token=' . $this->token;
        
        if($obj->image && file_exists(LOFCONTENT_IMAGES_FOLDER.$obj->image)) {
            $imageField = '<div class="image_preview"><img src="' . LOFCONTENT_IMAGES_URI . $obj->image . '" alt="Please upload image" /></div> <input type="checkbox" value="1" name="deleteImage"/> '.$this->l('Delete Image');
        } elseif(!$obj->image) {
            $imageField = '<div class="image_preview"><span>'.$this->l('No Image').'</span></div>';
        } elseif (!file_exists(LOFCONTENT_IMAGES_FOLDER.$obj->image)) {
            $imageField = '<div class="image_preview"><span>'.$this->l('Image has removed').'</span></div>';
        }
        ob_start();
        require _PS_MODULE_DIR_ . "lofblogs/html/lof_category.php";
        $html = ob_get_contents();
        ob_clean();

        return $toolbar . $html;
    }

    protected function copyFromPost(&$object, $table) {

        //auto generate default value if it's empty :
        $this->generateDefaultValuesLang();

        //build level depth :
        $_POST['level_depth'] = intval($this->_parent->level_depth) + 1;

        //build position :
        if (!isset($_POST['position']) || !$_POST['position']) {
            $_POST['position'] = $object->getPosition($_POST['id_parent']);
        }

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
            if (!$object->addImage('image'))
                $this->_errors[] = Tools::displayError('an error occurred while upload image');
        }
    }

    function generateDefaultValuesLang() {
        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {

            //prepare data :
            $title = $_POST['name_' . $lang['id_lang']];
            $alias = 'link_rewrite_' . $lang['id_lang'];
            $meta_title = 'meta_title_' . $lang['id_lang'];
            $meta_key = 'meta_keywords_' . $lang['id_lang'];
            $meta_desc = 'meta_description_' . $lang['id_lang'];

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
            }
        }
    }

    function init() {
        parent::init();
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs.css');
    }

    public static function getDescriptionClean($description) {
        return strip_tags(stripslashes($description));
    }

    public function initToolbar() {
        $token = Tools::getAdminTokenLite('AdminLofblogsPanel');
        
        switch ($this->display) {
            case 'add':
            case 'edit':

                // Default save button - action dynamically handled in javascript
                $this->toolbar_btn['save'] = array(
                    'href' => '#',
                    'desc' => $this->l('Save')
                );

                if ($this->display == 'edit') {
                    $category = $this->loadObject();
                    $numArticles = count($category->getItems($this->context->language->id));
                    $articleToken = Tools::getAdminTokenLite('AdminLofblogs');
                    $categoryToken = Tools::getAdminTokenLite('AdminLofblogsCategory');
                    $viewblogstext = intval($numArticles) ? $numArticles.' '.$this->l('Blogs') : $this->l('No Blogs');
                    
                    $this->toolbar_btn['addblog'] = array(
                        'href' => 'index.php?controller=AdminLofblogs&addlofblogs_publication&token=' . $articleToken . '&id_lofblogs_category=' . $category->id,
                        'desc' => $this->l('Add Blog')
                    );

                    $this->toolbar_btn['addchild'] = array(
                        'href' => 'index.php?controller=AdminLofblogsCategory&addlofblogs_category&token=' . $categoryToken . '&id_parent=' . $category->id,
                        'desc' => $this->l('Add Child')
                    );
                    $this->toolbar_btn['viewblogs'] = array(
                        'href' => 'index.php?controller=AdminLofblogs&token=' . $articleToken . '&id_lofblogs_category=' . $category->id,
                        'desc' => $viewblogstext
                    );                    
                }
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
                $category = Tools::getValue('id_parent') ? '&amp;id_parent='.Tools::getValue('id_parent') : '';
                $this->toolbar_btn['addchild'] = array(
                    'href' => self::$currentIndex . '&amp;add' . $this->table . '&amp;token=' . $this->token.$category,
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
    }

    public function initToolbarTitle() {
        parent::initToolbarTitle();
        $category = $this->loadObject(true);
        if ($category)
            if ((bool) $category->id && $this->display != 'list' && isset($this->toolbar_title[3]))
                $this->toolbar_title[3] = $this->toolbar_title[3] . ' (' . $category->name[$this->context->language->id] . ')';
    }

    /**
     * Function used to render the list to display for this controller
     */
    public function renderList() {
        $htmlHelper = new lofPrestaHtml();
        $htmlHelper->getNestedCategoriesData();
        $category_tree = $htmlHelper->getSelectList('id_parent', $htmlHelper->categoriesOptionList, Tools::getValue('id_parent'), 'onChange="submit();"');

        if (!($this->fields_list && is_array($this->fields_list)))
            return false;
        $this->getList($this->context->language->id);

        // Empty list is ok
        if (!is_array($this->_list))
            return false;

        $helper = new HelperList();

        $this->setHelperDisplay($helper);
        $helper->tpl_vars = $this->tpl_list_vars;
        $helper->tpl_vars['category_tree'] = '<label>Parent Category</label>' . $category_tree;
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

    public function ajaxProcessUpdatePositions() {
        $id_category_to_move = (int) (Tools::getValue('id'));
        $way = (int) (Tools::getValue('way'));
        $positions = Tools::getValue('lofblogs_category');
        if (is_array($positions))
            foreach ($positions as $key => $value) {
                $pos = explode('_', $value);
                if ((isset($pos[1]) && isset($pos[2])) && ($pos[2] == $id_category_to_move)) {
                    $position = $key + 1;
                    break;
                }
            }

        $category = new LofPsblogsCategory($id_category_to_move);
        if (Validate::isLoadedObject($category)) {
            if (isset($position) && $category->updatePosition($way, $position)) {
                die(true);
            }
            else
                die('{"hasError" : true, errors : "Can not update categories position"}');
        }
        else
            die('{"hasError" : true, "errors" : "This category can not be loaded"}');
    }

    public function processPosition() {
        if ($this->tabAccess['edit'] !== '1')
            $this->errors[] = Tools::displayError('You do not have permission to edit here.');
        else if (!Validate::isLoadedObject($object = new LofPsblogsCategory((int) Tools::getValue($this->identifier, Tools::getValue('id_category_to_move', 1)))))
            $this->errors[] = Tools::displayError('An error occurred while updating status for object.') . ' <b>' .
                    $this->table . '</b> ' . Tools::displayError('(cannot load object)');
        if (!$object->updatePosition((int) Tools::getValue('way'), (int) Tools::getValue('position')))
            $this->errors[] = Tools::displayError('Failed to update the position.');
        else {
            Tools::redirectAdmin(self::$currentIndex . '&' . $this->table . 'Orderby=position&' . $this->table . 'Orderway=asc&conf=5' . (($id_category = (int) Tools::getValue($this->identifier, Tools::getValue('id_category_parent', 1))) ? ('&' . $this->identifier . '=' . $id_category) : '') . '&token=' . Tools::getAdminTokenLite('AdminLofblogsCategory'));
        }
    }

}
