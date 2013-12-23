<?php

/**
 * Admin class - LofPscontentPublication
 * 
 * @Project Lof Content
 * @todo Get articles data.
 */
require_once LOFCONTENT_LIBS_FOLDER . 'lof_content_helper.php';

class LofPsblogsCommentEmoticons extends ObjectModel {

    //table fields :
    public $filename;
    public $key;
    public $id;
    protected $allowedUpload = array("jpg", "bmp", "gif", "png");
    protected $table = 'lofblogs_comment_emoticons';
    protected $identifier = 'id';
	
	public static $definition = array(
		'table' => 'lofblogs_comment_emoticons',
		'primary' => 'id',
		'fields' => array(
			'filename' => 		array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'key' => 				array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			
			
		),
	);
	
    public function __construct($id = NULL, $id_lang = NULL) {
        $module = new lofblogs();

        $this->helper = new lofContentHelper();
        $this->params = new LOFXParams($module);
        parent::__construct($id, $id_lang);
    }
	
    function removeSelectedImages() {
        $images = isset($_POST['removing_emoticons']) ? $_POST['removing_emoticons'] : null;
        
        if (is_array($images) && count($images)) {
            foreach ($images as $imageName) {
                
                //remove origin image :
                $filename = LOFCONTENT_IMAGES_ADMIN . 'emoticons/' . $imageName; 
                if (file_exists($filename)) { 
                    @unlink($filename);
                } 
                
                //remove image information in database : 
                $name = $name = str_replace('.', '__', $imageName);     
                $query = 'DELETE FROM '._DB_PREFIX_.'lofblogs_comment_emoticons WHERE `filename` = '.lofContentHelper::sqlQuote($name);                
                Db::getInstance()->execute($query);    
                
            }
        }
    }

    function saveAll() {
        $db = Db::getInstance();
        unset($_POST['emoticons_update']);
        foreach ($_POST as $name => $key) {
            if (is_string($key) && trim($key)) {
                $field = array();
                $field['filename'] = $name;
                $field['key'] = $key;
                $check = $this->getType($name);
                $db->autoExecute(_DB_PREFIX_ . 'lofblogs_comment_emoticons', $field, $check['type'], $check['where']);
            }
        }
    }

    function getInformation() {
        $query = 'SELECT * FROM ' . _DB_PREFIX_ . 'lofblogs_comment_emoticons';
        $object = Db::getInstance()->ExecuteS($query);
        $emoticons = array();
        if (count($object)) {
            foreach ($object as $imgInfo) {
                if (isset($imgInfo['key']) && $imgInfo['key']) {
                    $emoticons[$imgInfo['filename']] = $imgInfo['key'];
                }
            }
        }
        return $emoticons;
    }

    function getType($name) {
        $query = 'SELECT id FROM ' . _DB_PREFIX_ . 'lofblogs_comment_emoticons WHERE filename=' . $this->helper->sqlQuote($name);
        $exist = intval(Db::getInstance()->getValue($query));

        $where = '';
        if ($exist) {
            $type = 'UPDATE';
            $where = 'id = ' . $exist;
        } else {
            $type = 'INSERT';
        }

        return array('type' => $type, 'where' => $where);
    }   
    
    function addEmoticon() {
        $name = 'file';
        //upload image to folder : 
		if(isset($_FILES[$name])){
			$file = $_FILES[$name]['name'];
			if (isset($file) && $file != NULL) {
				$ext = strtolower(substr($file, strrpos($file, '.') + 1));
				if (in_array($ext, $this->allowedUpload)) {
					$imageFullPath = LOFCONTENT_IMAGES_ADMIN.'emoticons/' . $file;
					//upload image
					if (move_uploaded_file($_FILES[$name]['tmp_name'], $imageFullPath)) {
						return true;
					}
					
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
    }    

}
