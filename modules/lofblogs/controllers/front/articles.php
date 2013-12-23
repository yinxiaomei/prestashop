<?php

/**
 * * * Lof Blogs Articles Controller * * *
 * @author LandOfcoder.com
 * @todo Switch view base on url request.
 * @subpackage Lof Blogs Module
 * 
 */
require_once _PS_MODULE_DIR_ . 'lofblogs/defined.php';
//init model :
require_once LOFCONTENT_MODELS_FOLDER . 'LofPsblogsCategory.php';
require_once LOFCONTENT_MODELS_FOLDER . 'LofPsblogsPublication.php';
require_once LOFCONTENT_MODELS_FOLDER . 'LofPsblogsComment.php';
require_once LOFCONTENT_MODELS_FOLDER . 'LofPsblogsBlocks.php';
require_once LOFCONTENT_ROOT . 'lofblogs.php';
require_once LOFCONTENT_LIBS_FOLDER . 'lof_content_helper.php';

//init tabs : 
require LOFBLOGS_CONTROLLERS_ADMIN_FOLDER . 'AdminLofblogsController.php';

class LofblogsArticlesModuleFrontController extends ModuleFrontController {

    public $view;
    public $id;
    public $object;
    public $template;
    public $allow = null;
    public $helper = null;
    public $category = null;

    function __construct() {

        parent::__construct();
        //echo '<pre>'; die(print_r($_REQUEST));
        $module = new lofBlogs();
        $this->module = $module;
        $this->params = new LOFXParams($module);

        $this->view = Tools::getValue('view');
        $this->id = Tools::getValue('id', 0);
        $this->theme = $this->params->get('template', 'default');
        $this->format = Tools::getValue('format', 'normal');
        $this->lang = isset(self::$cookie->id_lang) ? self::$cookie->id_lang : 1;
        $this->object = null;
        $this->helper = new lofContentHelper();                
                
        parent::__construct();
        //**************************** only for development ****************************
        //ini_set('error_reporting', E_ALL);
    }

    public function canonicalRedirection($canonical_url = '') {
        // Automatically redirect to the canonical URL if the current in is the right one
        // $_SERVER['HTTP_HOST'] must be replaced by the real canonical domain

        if (Configuration::get('PS_CANONICAL_REDIRECT') && strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') {
            if (Validate::isLoadedObject($this->object) AND $canonicalURL = $this->helper->getArticleLink($this->object->id, $this->object->link_rewrite))
                if (!preg_match('/^' . Tools::pRegexp($canonicalURL, '/') . '([&?].*)?$/', Tools::getProtocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) {
                    header('HTTP/1.0 301 Moved');
                    header('Cache-Control: no-cache');


                    if (_PS_MODE_DEV_)
                        die('[Debug] This page has moved<br />Please use the following URL instead: <a href="' . $canonicalURL . '">' . $canonicalURL . '</a>');
                    Tools::redirectLink($canonicalURL);
                }
            if (Validate::isLoadedObject($this->category) AND $canonicalURL = $this->helper->getCategoryLink($this->category->id, $this->category->link_rewrite))
                if (!preg_match('/^' . Tools::pRegexp($canonicalURL, '/') . '([&?].*)?$/', Tools::getProtocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) {
                    header('HTTP/1.0 301 Moved');
                    header('Cache-Control: no-cache');
                    if (_PS_MODE_DEV_)
                        die('[Debug] This page has moved<br />Please use the following URL instead: <a href="' . $canonicalURL . '">' . $canonicalURL . '</a>');
                    Tools::redirectLink($canonicalURL);
                }
        }
    }

    public function initContent() {
        parent::initContent();
        $this->prepareData();
        $this->initPageMetadata();
    }

    /**
     * prepare data
     */
    public function prepareData() {


        $this->lang = isset(self::$cookie->id_lang) ? self::$cookie->id_lang : 1;

        //prepare custom html blocks :
        $this->blocks = new LofPsblogsBlocks(null, $this->lang);

        //select theme :
        if ($this->view == 'category' || $this->view == 'content') {
            if ($this->view == 'category') {
                $this->category = new LofPsblogsCategory($this->id, $this->lang);
            } else {
                $this->object = new LofPsblogsPublication($this->id, $this->lang);
                $this->category = new LofPsblogsCategory($this->object->id_lofblogs_category, $this->lang);
            }
            //overide category template if it exist :
            if (isset($this->category->template) && $this->category->template != '') {
                $this->theme = $this->category->template;
            }
        }
		if(is_dir( LOFBLOGS_THEMES_OVERRIDE_FOLDER. $this->theme . '/assets/images/' )){
			$this->theme_images = LOFCONTENT_OVERRIDE_THEMES_URI . $this->theme . '/assets/images/';
		}else{
			$this->theme_images = LOFCONTENT_THEMES_URI . $this->theme . '/assets/images/';
		}
        $lang_id = $this->context->language->id;
        $this->context->smarty->assign('rootUri', __PS_BASE_URI__);

        $this->context->smarty->assign('config', $this->params->getValues($this->lang));
        //select view :
		
        switch ($this->view) {

            case 'ajax':
                $id_lang = self::$cookie->id_lang;
                $start = 0;
                $limit = -1;
                $orderBy = 'name';
                $orderWay = 'ASC';
                $this->model = new LofPsblogsPublication($this->id, $lang_id);

                $catid = Tools::getValue('catid', false);
                $productModel = new ProductCore();
                $products = $productModel->getProducts($id_lang, $start, $limit, $orderBy, $orderWay, $catid, true);

                require LOFCONTENT_HTML_FOLDER . 'ajax.view.product.php';
                die(); //for ajax request 
                break;
            case 'loadposition':
                $themename = Tools::getValue('theme', 'default');
                $value = Tools::getValue('value', '');
                if (!$themename)
                    $themename = 'default';
                $theme = $this->helper->getThemeInfo($themename, $value);
                if (is_array($theme['error']) && count($theme['error'])) {
                    echo implode('<br />', $theme['error']);
                } else {
                    $list = $theme['list'];
					if(is_dir( LOFBLOGS_THEMES_OVERRIDE_FOLDER. $themename . '/' )){
						$themeUri = LOFCONTENT_OVERRIDE_THEMES_URI . $themename . '/';
					}else{
						$themeUri = LOFCONTENT_THEMES_URI . $themename . '/';
					}
					
                    $themeinfo = $theme['info'];
                    require LOFCONTENT_HTML_FOLDER . 'ajax_themeinfo.php';
                }
                die(); //for ajax request.
                break;
            case 'comment':
				if(!isset($_SESSION))
					session_start();
                $captcha = $_SESSION['random_number'];

                $this->model = new LofPsblogsPublication($this->id, $lang_id);
                $customer = self::$cookie->id_customer;
                $group = $this->params->get('ipt_mem');
                $allowPublished = lofContentHelper::getAccess($customer, $group);
                if ($allowPublished) {
                    $comment_note = $this->params->get('cmPublish');
                } else {
                    $comment_note = $this->params->get('cmUnpublish');
                }
                if ((strtolower(Tools::getValue('captcha')) == $captcha && $this->params->get('showCaptcha', 1)) || !$this->params->get('showCaptcha', 1)) {
                    $this->model->addComment($allowPublished);
                } else {
                    $comment_note = 'please enter a valid captcha before submit a comment !';
                }

                $comments = $this->model->getComments();
                foreach ($comments as $k => $cm) {
                    $comments[$k]['vote_buttons'] = $this->getVoteButtons($cm);
                }

                require LOFCONTENT_HTML_FOLDER . 'ajax_comments.php';
                die(); //for ajax request 
            case 'content':


                //check if valid object :
                if ($this->object->id_lofblogs_category) {

                    //check permison :
                    if ($this->object->allowedAccess()) {

                        if (!isset(self::$cookie->hited)) {
                            $this->object->updateHit();
                            self::$cookie->hited = 1;
                        }
                        $this->object->date_add = Tools::displayDate($this->object->date_add);
                        $ratingclass = intval($this->object->rating) > 0 ? 'class="lofcontent_article_rate' . $this->object->rating . '" ' : '';
                        $this->context->smarty->assign('lof_products', $this->object->getRelated());
                        $this->tags = $this->getTagList($this->object->tags);
                        $this->context->smarty->assign('lofcontent_tags', $this->tags);
                        $this->context->smarty->assign('ratingClass', $ratingclass);
                        $this->context->smarty->assign('captchar_uri', LOFCONTENT_LIBS_URI . 'captcha/');
                        $customer = array('fullname' => '', 'email' => '');
                        if (isset(self::$cookie->id_customer)) {
                            $customer['fullname'] = self::$cookie->customer_firstname . ' ' . self::$cookie->customer_lastname;
                            $customer['email'] = self::$cookie->email;
                        }
                        $this->context->smarty->assign('images', $this->object->getImages());
                        $this->context->smarty->assign('editor_config', $this->getEditorConfig());
                        $this->context->smarty->assign('customer', $customer);
                    }
                }
                break;
            case 'vote':
                $comment_id = Tools::getValue('comment_id', 0);
                $type = Tools::getValue('vote', 'up');
                $votename = 'vote_' . $type;
                $comment = new LofPsblogsComment($comment_id);
                $isVoted = $this->isVoted($comment_id);
                if ($isVoted) {
                    $comment->$votename = $type == 'up' ? $comment->vote_up : $comment->vote_down;
                } else {
                    $comment->$votename = $comment->vote($type);
                    $comment->addClient();
                }

                echo $this->getVoteButtons($comment->getFields());
                die(); //for ajax request 
                break;
            case 'rating':
                $article_id = Tools::getValue('article_id');
                $rate = Tools::getValue('rate');
                $model = new LofPsblogsPublication($article_id, $lang_id);
                $isRated = $this->isRated($article_id);
                $json = array();
                $json['error'] = 'NOTHING';
                if ($isRated) {
                    $json['error'] = $this->params->get('rateError');
                } else {
                    $model->addClient();
                    $model->updateRating($rate);
                    $json['star'] = $model->calculateRating();
                    $json['total'] = $model->rating_num;
                    $json['note'] = $this->params->get('rateFinish');
                }

                //json output :
                echo json_encode($json);

                die(); // for ajax request :)
                break;

            case 'category':
                $hasRewritten = Configuration::get('PS_REWRITING_SETTINGS');
                $feedParam = $hasRewritten ? '?format=rss' : '&format=rss';
                $this->category = new LofPsblogsCategory($this->id, $lang_id);
                $list = $this->category->getItems($lang_id, $this->format);
                $this->category->link = lofContentHelper::getCategoryLink($this->category->id, $this->category->link_rewrite);
                $this->category->rssFeedLink = $this->category->link . $feedParam;
                $introLimit = $this->format == 'rss' ? $this->params->get('rssIntro', 200) : $this->params->get('introLimit', 200);

                //make article link :
                for ($i = 0; $i < count($list); $i++) {
                    $list[$i]['link'] = $this->helper->getArticleLink($list[$i]['id_lofblogs_publication'], $list[$i]['link_rewrite']);
                    $list[$i]['ratingPage'] = $this->helper->getRatingPage($list[$i]['rating'], $list[$i]['rating_num'], $this->l(' Vote'));
                    $list[$i]['displayDate'] = Tools::displayDate($list[$i]['date_add']);
                    $text = $list[$i]['short_desc'] ? trim($list[$i]['short_desc']) : trim(strip_tags($list[$i]['content']));
                    $list[$i]['introtext'] = $this->helper->limitString($text, $introLimit);
                }

                $this->object = $list;

                if ($this->format == 'rss') {
                    header("Content-Type: application/rss+xml");
                    $body = $this->displayRssFeed();
                    die($body);
                }
                $this->context->smarty->assign('themeImage', $this->theme_images);
                $this->context->smarty->assign('category', $this->category);
                break;                
            case 'tag':
                $introLimit = $this->format == 'rss' ? $this->params->get('rssIntro', 200) : $this->params->get('introLimit', 200);
                $model = new LofPsblogsPublication();
                $fields = is_array($_GET) ? $_GET : $_POST;
				$n = (int)Tools::getValue('n', $this->params->get('itemsLimit', 10));
				$p = (int)Tools::getValue('p',1);
                $articles = $model->filterArticles($fields, $p, $n);
                for ($i = 0; $i < count($articles); $i++) {
                    $articles[$i]['link'] = $this->helper->getArticleLink($articles[$i]['id_lofblogs_publication'], $articles[$i]['link_rewrite']);
                    $articles[$i]['ratingPage'] = $this->helper->getRatingPage($articles[$i]['rating'], $articles[$i]['rating_num'], $this->l(' Vote'));
                    $articles[$i]['displayDate'] = Tools::displayDate($articles[$i]['date_add'], $lang_id);
                    $text = $articles[$i]['short_desc'] ? trim($articles[$i]['short_desc']) : trim(strip_tags($articles[$i]['content']));
                    $articles[$i]['introtext'] = $this->helper->limitString($text, $introLimit);
                }
                $this->object = $articles;
                $module = new lofBlogs();
                $this->pagetitle = $this->l('Articles with tag : ') . Tools::getValue('tag');

                $this->context->smarty->assign('pagetitle', $this->pagetitle);
                break;
            case 'search':
                $introLimit = $this->format == 'rss' ? $this->params->get('rssIntro', 200) : $this->params->get('introLimit', 200);
                $model = new LofPsblogsPublication();
                $fields = is_array($_GET) ? $_GET : $_POST;
                $n = (int)Tools::getValue('n', $this->params->get('itemsLimit', 10));
                $p = (int)Tools::getValue('p',1);
                $articles = $model->filterArticles($fields, $p, $n);
                for ($i = 0; $i < count($articles); $i++) {
                    $articles[$i]['link'] = $this->helper->getArticleLink($articles[$i]['id_lofblogs_publication'], $articles[$i]['link_rewrite']);
                    $articles[$i]['ratingPage'] = $this->helper->getRatingPage($articles[$i]['rating'], $articles[$i]['rating_num'], $this->l(' Vote'));
                    $articles[$i]['displayDate'] = Tools::displayDate($articles[$i]['date_add'], $lang_id);
                    $text = $articles[$i]['short_desc'] ? trim($articles[$i]['short_desc']) : trim(strip_tags($articles[$i]['content']));
                    $articles[$i]['introtext'] = $this->helper->limitString($text, $introLimit);
                }
                $this->object = $articles;
                $module = new lofBlogs();
                $this->pagetitle = $this->l('Articles search result: ');

                $this->context->smarty->assign('pagetitle', $this->pagetitle);
                break;
            default :
                //do some thing
                break;
        }
        $this->setThemeMedia();
        $this->context->smarty->assign('thumbUri', LOFCONTENT_THUMB_URI);
        $this->context->smarty->assign('imageUri', LOFCONTENT_IMAGES_URI);
        $this->context->smarty->assign('LBObject', $this->object);
    }

    /**
     * Function to add some media file e.g : css, js ...
     */
    public function setMedia() {
        parent::setMedia();

        //set global medias :
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'lofblogs_frontend.css');
        $this->context->controller->addCSS(LOFCONTENT_CSS_URI . 'smartpaginator.css');
        $this->context->controller->addJS(LOFCONTENT_JS_URI . 'smartpaginator.js');
        $this->context->controller->addJS(LOFCONTENT_JS_URI . 'lofblogs_frontend.js');
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://".$_SERVER['HTTP_HOST'];
		
        $this->context->controller->addJS( $protocol.__PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js' );
        
    }

    /**
     * Function to add some media file e.g : css, js ...
     */
    public function setThemeMedia() {
        //add css and javascript for specific theme :
        $medias = $this->getThemeMedia();

        //add style sheet :
        foreach ($medias['css'] as $css) {
            $this->context->controller->addCSS($css);
        }
        //add script :
        foreach ($medias['js'] as $js) {
            $this->context->controller->addJS($js);
        }
    }

    /**
     * Display front content :
     */
    public function displayContent() {
        parent::displayContent();
        $this->context->smarty->assign('imgPrimaryUri', LOFCONTENT_IMAGES_URI);
        $this->context->smarty->assign('galleryUri', LOFCONTENT_IMAGES_GALLERY_URI);
        $this->context->smarty->assign('thumbUri', LOFCONTENT_IMAGES_THUMBS_URI);
        $this->assignBlocks();
		
        switch ($this->view) {
            case 'category':

                if ($this->format == 'normal') {
                    //$this->params->debug($this->category);
                    //if ($this->category->name) {
                        $this->context->smarty->assign('LOFSYSTEM_LIST', null);
                        $this->context->smarty->assign('LOFSYSTEM_PAGINATION', null);

                        //display main content 
						$id = (int)(Tools::getValue('id'));
						$link_paging =  '';;
						if(Validate::isLoadedObject($objCate = new LofPsblogsCategory($id, $this->context->language->id)))
							$link_paging = lofContentHelper::getCategoryLink($id, $objCate->link_rewrite );
                        $this->pagination($this->category->total, $link_paging);
                        $this->context->smarty->assign('LOFSYSTEM_LIST', $this->context->smarty->fetch($this->getThemeFile('list.tpl')));
                        $this->context->smarty->assign('LOFSYSTEM_PAGINATION', $this->context->smarty->fetch($this->getThemeFile('paging.tpl')));
                        //$this->context->smarty->assign('LOFSYSTEM_PAGINATION', $this->context->smarty->fetch(_PS_THEME_DIR_ . 'pagination.tpl'));
						
                        $this->context->smarty->display($this->getThemeFile('index.tpl'));
                    /*
                    } else {
                        $this->context->smarty->display($this->getThemeFile('404.tpl'));
                    }
                    */
                }

                break;
            case 'tag':
                //display main content 
                $fields = is_array($_GET) ? $_GET : $_POST;
                $model = new LofPsblogsPublication();
                $articles = $model->filterArticles($fields, 0);
                
                $tag = pSQL(Tools::getValue('tag'));
                $link_paging = lofContentHelper::getTagLink($tag );
                $this->pagination( count($articles), $link_paging);
                //echo $this->context->smarty->fetch($this->getThemeFile('paging.tpl')); die;
                $this->context->smarty->assign('LOFSYSTEM_PAGINATION', $this->context->smarty->fetch($this->getThemeFile('paging.tpl')));
                $this->context->smarty->display($this->getThemeFile('default.tpl'));
                
                break;

            case 'search':
                //display main content 
				$fields = is_array($_GET) ? $_GET : $_POST;
				$model = new LofPsblogsPublication();
                $articles = $model->filterArticles($fields, 0);
				$link = New Link();
                $year = (int)(Tools::getValue('year'));
                $month = (int)(Tools::getValue('month'));
				$title = pSQL(Tools::getValue('title'));
                $attr = array();
                if ($year)
                    $attr['year'] = $year;
                if($month)
                    $attr['month'] = $month;
                if($title)
                    $attr['title'] = $title;
				$link_paging = lofContentHelper::getSearchLink($attr);
				$this->pagination( count($articles), $link_paging);
				//echo $this->context->smarty->fetch($this->getThemeFile('paging.tpl')); die;
				$this->context->smarty->assign('LOFSYSTEM_PAGINATION', $this->context->smarty->fetch($this->getThemeFile('paging.tpl')));
                $this->context->smarty->display($this->getThemeFile('default.tpl'));
				
                break;

            case 'content':
            default :

                //check if page exist : 
                if ($this->object->id_lofblogs_category) {

                    //check access :
                    if ($this->object->allowedAccess()) {

                        $imgLoadingVote = $this->iconLink('loading.gif');
                        $this->context->smarty->assign('imgLoadingVote', $imgLoadingVote);

                        //define var :
                        $this->context->smarty->assign('LOFSYSTEM_CONTENT', null);
                        $this->context->smarty->assign('LOFSYSTEM_SOCIAL', null);
                        $this->context->smarty->assign('LOFSYSTEM_TAGS', null);
                        $this->context->smarty->assign('LOFSYSTEM_PRODUCTS', null);
                        $this->context->smarty->assign('LOFSYSTEM_COMMENTS', null);
                        $this->context->smarty->assign('LOFSYSTEM_GALLERY', null);

                        $this->context->smarty->assign('imgloading', $this->iconLink('loading.gif'));

                        //display gallery : 
                        if ($this->params->get('showGallery') && count($this->object->getImages())) {
                            $this->context->smarty->assign('LOFSYSTEM_GALLERY', $this->context->smarty->fetch($this->getThemeFile('gallery.tpl')));
                        }

                        //display main content 
                        $this->context->smarty->assign('LOFSYSTEM_CONTENT', $this->context->smarty->fetch($this->getThemeFile('content.tpl')));


                        //display add this buttons :    
                        if ($this->params->get('showSocial')) {
                            $this->context->smarty->assign('LOFSYSTEM_SOCIAL', $this->context->smarty->fetch($this->getThemeFile('social.tpl')));
                        }

                        //display tags list link :
                        if (count($this->tags) && $this->params->get('showTags')) {
                            $this->context->smarty->assign('LOFSYSTEM_TAGS', $this->context->smarty->fetch($this->getThemeFile('tags.tpl')));
                        }

                        //display related products :
                        if (count($this->object->getRelated()) && $this->params->get('showProduct')) {
                            $this->context->smarty->assign('LOFSYSTEM_PRODUCTS', $this->context->smarty->fetch($this->getThemeFile('products.tpl')));
                        }
                        //display comment form
                        if ($this->params->get('showComment')) {
                            $comments = $this->object->getComments();
                            foreach ($comments as $k => $cm) {
                                $comments[$k]['vote_buttons'] = $this->getVoteButtons($cm);
                            }

                            ob_start();
                            require LOFCONTENT_HTML_FOLDER . 'ajax_comments.php';
                            $comments_list = ob_get_contents();
                            ob_clean();

                            $this->context->smarty->assign('comments_list', $comments_list);
                            $this->context->smarty->assign('LOFSYSTEM_COMMENTS', $this->context->smarty->fetch($this->getThemeFile('comment.tpl')));
                        }

                        $this->context->smarty->display($this->getThemeFile('index.tpl'));
                    } else {
                        $this->context->smarty->display($this->getThemeFile('article403.tpl'));
                    }
                } else {
                    $this->context->smarty->display($this->getThemeFile('404.tpl'));
                }
                break;
        }
    }

    /**
     * prepare some header tag :
     */
    public function initPageMetadata() {
        if ($this->object) {
            switch ($this->view) {
                case 'content' :
                    $meta_title = $this->object->meta_title ? $this->object->meta_title : $this->object->title;
                    if (!$meta_title)
                        $meta_title = 'Article not found !';
                    $meta_desc = $this->object->meta_description;
                    $meta_key = $this->object->meta_keywords;
                    break;
                case 'category' :
                    $meta_title = $this->category->meta_title ? $this->category->meta_title : $this->category->name;
                    if (!$meta_title)
                        $meta_title = $this->l('Articles!');
                    $meta_desc = $this->category->meta_description;
                    $meta_key = $this->category->meta_keywords;
                    break;
                case 'tag':
                    $meta_title = $this->pagetitle;
                    $meta_desc = $this->pagetitle;
                    $meta_key = $this->pagetitle;
                default :
                    $meta_title = $this->pagetitle;
                    $meta_desc = $this->pagetitle;
                    $meta_key = $this->pagetitle;
                    break;
            }
            $this->context->smarty->assign('meta_title', $meta_title);
            $this->context->smarty->assign('meta_description', $meta_desc);
            $this->context->smarty->assign('meta_keywords', $meta_key);
        }
    }

    function getThemeFile($file, $inView = true) {
        $view = $inView ? '/' . $this->view . '/' : '/';
        $path = LOFCONTENT_THEMES_FOLDER . $this->theme . $view . $file;
        $path_themes = LOFBLOGS_THEMES_OVERRIDE_FOLDER . $this->theme . $view . $file;
		if(file_exists($path_themes))
			return $path_themes;
        //if file is not available in this theme, then get it in default theme :
        if (!file_exists($path)) {
            $path = LOFCONTENT_THEMES_FOLDER . 'default' . $view . $file;
        }
        return $path;
    }

    function getThemeMedia() {
		
		
        $mediaPath = LOFCONTENT_THEMES_FOLDER . $this->theme . '/assets/';
        $cssFiles = $this->params->getFilesFromFolder($mediaPath . 'css');
        $jsFiles = $this->params->getFilesFromFolder($mediaPath . 'js');
        $mediaFiles = array();
        foreach ($cssFiles as $filename) {
            $ext = strtolower(preg_replace('/^.*\./', '', $filename));
            if ($ext == 'css') {
				if(is_file( LOFBLOGS_THEMES_OVERRIDE_FOLDER. $this->theme . '/assets/css/' . $filename )){
					$mediaFiles['css'][] = LOFCONTENT_OVERRIDE_THEMES_URI . $this->theme . '/assets/css/' . $filename;
				}else{
					$mediaFiles['css'][] = LOFCONTENT_THEMES_URI . $this->theme . '/assets/css/' . $filename;
				}
                
            }
        }

        foreach ($jsFiles as $filename) {
            $ext = strtolower(preg_replace('/^.*\./', '', $filename));
            if ($ext == 'js') {
                
				if(is_file( LOFBLOGS_THEMES_OVERRIDE_FOLDER. $this->theme . '/assets/js/' . $filename )){
					$mediaFiles['js'][] = LOFCONTENT_OVERRIDE_THEMES_URI . $this->theme . '/assets/js/' . $filename;
				}else{
					$mediaFiles['js'][] = LOFCONTENT_THEMES_URI . $this->theme . '/assets/js/' . $filename;
				}
            }
        }
        return $mediaFiles;
    }

    function getTagList($tags) {
        $list = array();
        $id_lang = (int)$this->context->language->id;
        if(isset($tags[$id_lang]) && $tags[$id_lang]){
            $tagsList = explode(',', $tags[$id_lang]);
            if (count($tagsList)) {
                foreach ($tagsList as $tag) {
                    $list[] = array('text' => $tag, 'link' => $this->helper->getTagLink($tag));
                }
            }
        }
        return $list;
    }

    function getVoteButtons($comment) {
        $isVoted = $this->isVoted($comment['id']);
        if ($isVoted > 0) {
            $img_up = 'vote_up_disable.png';
            $img_down = 'vote_down_disable.png';
        } else {
            $img_up = 'vote_up.png';
            $img_down = 'vote_down.png';
        }

        $img_down = $this->iconLink($img_down);
        $img_up = $this->iconLink($img_up);

        ob_start();
        require LOFCONTENT_HTML_FOLDER . 'vote_buttons.php';
        $buttons = ob_get_contents();
        ob_clean();

        return $buttons;
    }

    function isVoted($comment_id) {
        $ip = lofContentHelper::getClientId();
        $query = 'SELECT COUNT(id) FROM ' . _DB_PREFIX_ . 'lofblogs_comment_clients WHERE client_ip = ' . lofContentHelper::sqlQuote($ip) . ' AND comment_id = ' . pSQL($comment_id);
        return intval(Db::getInstance()->getValue($query));
    }

    function isRated($itemid) {
        $ip = lofContentHelper::getClientId();
        $query = 'SELECT COUNT(id) FROM ' . _DB_PREFIX_ . 'lofblogs_rate_clients WHERE client_ip = ' . lofContentHelper::sqlQuote($ip) . ' AND itemid = ' . pSQL($itemid);
        return intval(Db::getInstance()->getValue($query));
    }

    function l($string) {
        return $this->module->l($string, 'LofblogsController');
    }

    function getEditorConfig() {
        global $cookie;
        $query = 'SELECT * FROM ' . _DB_PREFIX_ . 'lofblogs_comment_emoticons';
        $emoticonData = Db::getInstance()->ExecuteS($query);
        foreach ($emoticonData as $k => $image) {
            $image['filename'] = str_replace('__', '.', $image['filename']);
            if (file_exists(LOFCONTENT_IMAGES_ADMIN . 'emoticons/' . $image['filename'])) {
                $emoticons[] = $image;
            }
        }
        $ad = dirname($_SERVER["PHP_SELF"]);
        $iso = Language::getIsoById($cookie->id_lang);
        $isoTinyMCE = (file_exists(_PS_ROOT_DIR_ . '/js/tiny_mce/langs/' . $iso . '.js') ? $iso : 'en');
        $buttons = array();
        $buttonNames = array();

        //lof emoticons button control
        $buttons[] = "        
                    ed.addButton('lof_emoticons', {
                        title : 'lof-emoticons',
                        image : '" . lofContentHelper::getImageUri('img1.gif') . "',
                        onclick : function() {
                            toogleSmile();
                        }
                    });";

        //smile collection :
        if (is_array($emoticons) && count($emoticons)) {
            foreach ($emoticons as $k => $smile) {
                $buttonNames[] = 'smile' . $k;
                $buttons[] = "        
                    ed.addButton('smile" . $k . "', {
                        title : 'lofsmiles',
                        image : '" . lofContentHelper::getImageUri($smile['filename']) . "',
                        onclick : function() {
                            ed.focus();
                            ed.selection.setContent('" . $smile['key'] . "');
                            toogleSmile();
                        }
                    });";
            }
        }

        $width = 420;
        $skin = 'default';
        if ($this->theme == 'clean') {
            $width = 535;
            $skin = 'cirkuit';
        }

        $labels = array_chunk($buttonNames, 18);
        $maintoolbarindex = count($labels) + 1;
        $config = '    
                    theme : "advanced",
                    skin:"' . $skin . '",
                    mode : "specific_textareas",
                    oninit : toogleSmile,
                    editor_selector : "rte",
                    width: "' . $width . '",
                    content_css : "' . _THEME_CSS_DIR_ . 'global.css",
                    editor_deselector : "noEditor", 
                    document_base_url : "' . $ad . '",
                    language : "' . $isoTinyMCE . '",
                    entity_encoding: "raw",
                    convert_urls : false,                        
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left",
                    theme_advanced_resizing : true,
                    theme_advanced_statusbar_location : "bottom",';
        $config .= 'theme_advanced_buttons3_add : "lof_emoticons",';

        //set up toolbar for smile
        foreach ($labels as $k => $names) {
            $config .= 'theme_advanced_buttons' . ($k + 4) . ' : "' . implode(',', $names) . '",';
        }


        //set up smile button action
        $config .= 'setup : function(ed) {' . implode(' ', $buttons) . '}';
		
		
        //$script = __PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js';
        //$this->context->controller->addJS($script);
        //$tinyDefined = '<script type="text/javascript" src="' . $script . '"></script>';
        $lofconfig = '<script type="text/javascript">$(document).ready(function(){tinyMCE.init({' . $config . '});}); </script>';

        return $lofconfig;
    }

    public function pagination($nbProducts = 10, $link_paging = '') {
        if (!self::$initialized)
            $this->init();

        $nArray = (int) (Configuration::get('PS_PRODUCTS_PER_PAGE')) != 10 ? array((int) (Configuration::get('PS_PRODUCTS_PER_PAGE')), 10, 20, 50) : array(10, 20, 50);
        // Clean duplicate values
        $nArray = array_unique($nArray);
        asort($nArray);
        $this->n = abs((int) (Tools::getValue('n', $this->params->get('itemsLimit', 10))));
        $this->p = abs((int) (Tools::getValue('p', 1)));

        if (!is_numeric(Tools::getValue('p', 1)) || Tools::getValue('p', 1) < 0)
            Tools::redirect('404.php');

        $current_url = tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']);
        //delete parameter page
        $current_url = preg_replace('/(\?)?(&amp;)?p=\d+/', '$1', $current_url);
		if(!$link_paging)
			$link_paging = $current_url;
        $range = 2; /* how many pages around page selected */

        if ($this->p < 0)
            $this->p = 0;

        if (isset(self::$cookie->nb_item_per_page) AND $this->n != self::$cookie->nb_item_per_page AND in_array($this->n, $nArray))
            self::$cookie->nb_item_per_page = $this->n;

        if ($this->p > (($nbProducts / $this->n) + 1))
            Tools::redirect(preg_replace('/[&?]p=\d+/', '', $_SERVER['REQUEST_URI']));

        $pages_nb = ceil($nbProducts / (int) ($this->n));

        $start = (int) ($this->p - $range);
        if ($start < 1)
            $start = 1;
        $stop = (int) ($this->p + $range);
        if ($stop > $pages_nb)
            $stop = (int) ($pages_nb);
        $this->context->smarty->assign('nb_products', $nbProducts);
		
        $pagination_infos = array(
            'products_per_page' => (int) Configuration::get('PS_PRODUCTS_PER_PAGE'),
            'pages_nb' => $pages_nb,
            'p' => $this->p,
            'n' => $this->n,
            'nArray' => $nArray,
            'range' => $range,
            'start' => $start,
            'stop' => $stop,
            'link_paging' => $link_paging,
            'lof_pathway' => ((int)Configuration::get('PS_REWRITING_SETTINGS') == 1 ? '?' : '&'),
            'current_url' => $current_url
        );
		
        $this->context->smarty->assign($pagination_infos);
    }

    function assignBlocks() {
        $themeinfo = $this->helper->getThemeInfo($this->theme);

        if (count($themeinfo['blocks'])) {
            foreach ($themeinfo['blocks'] as $blockname) {
                $blockname = trim(strtolower($blockname));
                $html = '';
                $position = $this->blocks->getContent($blockname, $this->theme);

                if (count($position)) {
                    $content = array();
                    foreach ($position as $block) {
                        $content[] = '<div class="lofblogs_custom_block"><h4>' . $block['title'] . '</h4><div class="lofblocks_content">' . $block['content'] . '</div></div>';
                    }
                    $html = '<div class="lofblogsCustomBlocksContainer" >' . implode(' ', $content) . '</div>';
                }
                $this->context->smarty->assign('lofblock_' . $blockname, $html);
            }
        }
    }

    /**
     * using theme's icons (or image) instead default icon.
     */
    function iconLink($name) {
	
        if (file_exists(LOFCONTENT_THEMES_FOLDER . $this->theme . '/assets/images/' . $name)) {
            return $this->theme_images . $name;
        } else {
            return LOFCONTENT_THEMES_URI . 'default/assets/images/' . $name;
        }
    }

    function displayRssFeed() {

        $xml = '<?xml version="1.0" encoding="UTF-8" ?>
                <?xml-stylesheet type="text/css" href="' . htmlentities(_PS_BASE_URL_ . LOFCONTENT_CSS_URI . 'feed.css') . '" ?>
                <rss version="2.0">
                    <channel>
                        <generator>NFE/1.0</generator>
                        <title>' . htmlentities($this->category->name) . ' - Lastest News</title>
                        <link>' . htmlentities(_PS_BASE_URL_ . __PS_BASE_URI__) . '</link>
                        <language>en</language>
                        <webMaster>' . htmlentities(_PS_BASE_URL_ . __PS_BASE_URI__) . '</webMaster>';

        foreach ($this->object as $item) {
            $xml .= '       <item>
                            <title>' . htmlentities($item['title']) . '</title>
                            <link>' . htmlentities(_PS_BASE_URL_ . $item['link']) . '</link>                                  
                            <category>' . htmlentities($this->category->name) . '</category>
                            <pubDate>' . htmlentities($item['displayDate']) . '</pubDate>
                            <description><![CDATA[ <a  href="' . htmlentities(_PS_BASE_URL_ . $item['link']) . '"><img src="' . _PS_BASE_URL_ . LOFCONTENT_THUMB_URI . $item['image'] . '" /></a> ' . htmlentities($item['introtext']) . ']]></description>
                       </item>';
        }
        $xml .= '
                    </channel>
                </rss>';


        return $xml;
    }

}
