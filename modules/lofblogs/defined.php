<?php
/**
 * @name defined.php
 * @author landOfCoder
 * @todo defined some path and link
 */
define('LOFBLOG_DEVNAME', 'lofblog');
define('LOFBLOG_VERSION', '1.1');

// *************** SOME PATHS ******************************
define('LOFCONTENT_ROOT', _PS_MODULE_DIR_ . 'lofblogs/');
define('LOFCONTENT_HTML_FOLDER', LOFCONTENT_ROOT.'html/');
define('LOFCONTENT_LIBS_FOLDER', LOFCONTENT_ROOT.'libs/');
define('LOFCONTENT_THEMES_FOLDER', LOFCONTENT_ROOT.'themes/');
define('LOFCONTENT_MODELS_FOLDER', LOFCONTENT_ROOT.'classes/');
define('LOFCONTENT_IMAGES_FOLDER', _PS_IMG_DIR_.'lofblogs/articles/');
define('LOFCONTENT_GALLERY_FOLDER', _PS_IMG_DIR_.'lofblogs/gallery/');
define('LOFCONTENT_THUMBS_FOLDER', _PS_IMG_DIR_.'lofblogs/thumbs/');
define('LOFCONTENT_IMAGES_ORIGIN_FOLDER', _PS_IMG_DIR_.'lofblogs/origin/');
define('LOFCONTENT_IMAGES_ADMIN', LOFCONTENT_ROOT.'images/admin/');
define('LOFBLOGS_CONTROLLERS_ADMIN_FOLDER', LOFCONTENT_ROOT.'controllers/admin/');
define('LOFBLOGS_CONTROLLERS_ADMIN_FRONT', LOFCONTENT_ROOT.'controllers/front/');

define('LOFBLOGS_THEMES_OVERRIDE_FOLDER', _PS_ALL_THEMES_DIR_._THEME_NAME_.'/modules/lofblogs/themes/');

// ***************** SOME LINKS ***************************************
define('LOFCONTENT_BASE_URI', __PS_BASE_URI__ . 'modules/lofblogs/');
define('LOFCONTENT_IMAGES_URI', __PS_BASE_URI__ . 'img/lofblogs/articles/');
define('LOFCONTENT_THUMB_URI', __PS_BASE_URI__ . 'img/lofblogs/thumbs/');
define('LOFCONTENT_IMAGES_ADMIN_URI', LOFCONTENT_BASE_URI . 'images/admin/');
define('LOFCONTENT_IMAGES_GALLERY_URI', __PS_BASE_URI__ . 'img/lofblogs/gallery/');
define('LOFCONTENT_IMAGES_THUMBS_URI', __PS_BASE_URI__ . 'img/lofblogs/thumbs/');
define('LOFCONTENT_JS_URI', LOFCONTENT_BASE_URI . 'js/');
define('LOFCONTENT_CSS_URI', LOFCONTENT_BASE_URI . 'css/');
define('LOFCONTENT_THEMES_URI', LOFCONTENT_BASE_URI.'themes/');
define('LOFCONTENT_LIBS_URI', LOFCONTENT_BASE_URI.'libs/');

define('LOFCONTENT_OVERRIDE_THEMES_URI', _THEME_DIR_.'modules/lofblogs/themes/');
?>
