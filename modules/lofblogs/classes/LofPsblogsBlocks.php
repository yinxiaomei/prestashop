<?php

/**
 * Admin class - LofPscontentPublication
 * 
 * @Project Lof Content
 * @todo Get articles data.
 */
class LofPsblogsBlocks extends ObjectModel {

    //table fields :
    public $published;
    public $position;
    public $template;
    public $title;
    public $content;


    public $params = null;
   
	
	public static $definition = array(
		'table' => 'lofblogs_blocks',
		'primary' => 'id_lofblogs_blocks',
		'multilang' => true,
		'fields' => array(
			'position' => 		array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'published' => 		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'template' => 				array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'ordering' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			
			// Lang fields
			'title' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
			'content' => 		array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHTML', 'size'=>65536)
		),
	);
	
    public function __construct($id = NULL, $id_lang = NULL) {
        $module = new lofblogs();
        $this->lang = $id_lang;
        $this->params = new LOFXParams($module);
        parent::__construct($id, $id_lang);
    }

    public function getContent($position, $template='default'){
        $query = 'SELECT lbbl.content as content, lbbl.title as title
                    FROM '._DB_PREFIX_.'lofblogs_blocks lbb
                    LEFT JOIN '._DB_PREFIX_.'lofblogs_blocks_lang lbbl ON (lbb.id_lofblogs_blocks = lbbl.id_lofblogs_blocks) 
                    WHERE lbb.position='.lofContentHelper::sqlQuote($position)
                 .' AND lbb.template = '.lofContentHelper::sqlQuote($template)
                 .' AND lbb.published = 1 AND lbbl.id_lang = '.$this->lang;
        return Db::getInstance()->executeS($query);
    }

    public function getTranslationsFieldsChild() {
        global $cookie;
        parent::validateFieldsLang();

        $fields = array();
        $languages = Language::getLanguages(false);
        $defaultLanguage = Configuration::get('PS_LANG_DEFAULT') ? Configuration::get('PS_LANG_DEFAULT') : $cookie->id_lang;

        $fieldsLang = array_keys($this->fieldsValidateLang);
        foreach ($languages as $language) {
            $langid = $language['id_lang'];
            $fields[$langid]['id_lang'] = $language['id_lang'];
            $fields[$langid][$this->identifier] = intval($this->id);
            $fields[$langid]['content'] = (isset($this->content[$langid])) ? $this->content[$langid] : '';
            foreach ($fieldsLang as $field) {
                if (!Validate::isTableOrIdentifier($field))
                    die(Tools::displayError());
                if (isset($this->{$field}[$language['id_lang']]) AND !empty($this->{$field}[$language['id_lang']]))
                    $fields[$language['id_lang']][$field] = $this->{$field}[$language['id_lang']];
                elseif (in_array($field, $this->fieldsRequiredLang)) {
                    $fields[$language['id_lang']][$field] = $this->{$field}[$defaultLanguage];
                } else
                    $fields[$language['id_lang']][$field] = '';
            }
        }
        return $fields;
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
