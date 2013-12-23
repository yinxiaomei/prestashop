<?php

/**
 * Admin class - LofPscontentPublication
 * 
 * @Project Lof Content
 * @todo Get articles data.
 */
class LofPsblogsComment extends ObjectModel {

    //table fields :
    public $name;
    public $content;
    public $email;
    public $website;
    public $published;
    public $item_id;
    public $date_add;
    public $vote_up;
    public $vote_down;
    public $id;
    protected $allowedUpload = array("jpg", "bmp", "gif", "png");
	
	public static $definition = array(
		'table' => 'lofblogs_comment',
		'primary' => 'id',
		'fields' => array(
			'item_id' => 		array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'name' => 				array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'content' => 		array('type' => self::TYPE_HTML, 'validate' => 'isCleanHTML', 'size'=>65536),
			'email' => 		array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'size'=>255),
			'website' => 		array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size'=>255),
			'date_add' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'published' => 		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'vote_up' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'size'=>5),
			'vote_down' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'size'=>5),
			
		),
	);
	
	
    public function __construct($id = NULL, $id_lang = NULL) {
        $module = new lofblogs();

        $this->params = new LOFXParams($module);
        parent::__construct($id, $id_lang);
    }
	
    function vote($type='up') {
        $ip = lofContentHelper::getClientId();
        $voted = $this->addClient($ip);
        if ($type == 'up') {
            $value = $this->vote_up + 1;
            $field = 'vote_up';
        } else {
            $value = $this->vote_down + 1;
            $field = 'vote_down';
        }
        $query = 'UPDATE ' . _DB_PREFIX_ . $this->table . ' SET ' . $field . '=' . pSQL($value) . ' WHERE id = ' . $this->id;
        Db::getInstance()->Execute($query);

        return $value;
    }

    function addClient() {
        $client['client_ip'] = lofContentHelper::getClientId();
        $client['comment_id'] = $this->id;
        Db::getInstance()->autoExecute(_DB_PREFIX_ . $this->table . '_clients', $client, 'INSERT');
    }
        
    public function toggleStatus() {
        if (!Validate::isTableOrIdentifier($this->identifier) OR !Validate::isTableOrIdentifier($this->table))
            die(Tools::displayError());

        /* Object must have a variable called 'active' */
        elseif (!key_exists('published', $this))
            die(Tools::displayError());

        /* Update active status on object */
        $this->published = (int) (!$this->published);

        /* Change status to active/inactive */
        return Db::getInstance()->Execute('
		UPDATE `' . pSQL(_DB_PREFIX_ . $this->table) . '`
		SET `published` = !`published`
		WHERE `' . pSQL($this->identifier) . '` = ' . (int) ($this->id));
    }
}
