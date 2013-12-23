<?php
/**
 * $ModDesc
 * 
 * @version		$Id: file.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */
if (!defined('_CAN_LOAD_FILES_')){
	define('_CAN_LOAD_FILES_',1);
}    
/**
 * loftwitter Class
 */	
class leocustomhtml3 extends Module
{
	/**
	 * @var LofParams $_params;
	 *
	 * @access private;
	 */
	public $_params = '';	
	public $site_url = '';	
	public $divLangName;	
	public $languages = array();	
	public $_languages = NULL;
    public $_defaultFormLanguage = NULL;
	/**
	 * @var array $_postErrors;
	 *
	 * @access private;
	 */
	private $_postErrors = array();		
	
	/**
	 * @var string $__tmpl is stored path of the layout-theme;
	 *
	 * @access private 
	 */	
	
   /**
    * Constructor 
    */
	function __construct(){
		$this->name = 'leocustomhtml3';
		parent::__construct();			
		$this->author = 'leotheme';				
		$this->version = '1.1';
		$this->displayName = $this->l('Home Custom HTML 2');
		$this->description = $this->l('Home Custom HTML 2, Support All hooks');
		if( file_exists( _PS_ROOT_DIR_.'/modules/'.$this->name.'/libs/params.php' ) && !class_exists("LofParams", false) ){
			if( !defined("LOF_LOAD_LIB_PARAMS") ){				
				require( _PS_ROOT_DIR_.'/modules/'.$this->name.'/libs/params.php' );
				define("LOF_LOAD_LIB_PARAMS",true);
			}
		}		
		$this->divLangName = 'module_title-ccontent';
		$this->initLanguages();
		$this->Languages();
		$this->_params = new LofParams( $this->name );		   
	}
	function initLanguages(){
		$this->languages = array(
			'choose_language' => $this->l('Choose language:')
		);
	}
	public function Languages(){
		global $cookie;
		$allowEmployeeFormLang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		if ($allowEmployeeFormLang && !$cookie->employee_form_lang)
			$cookie->employee_form_lang = (int)(Configuration::get('PS_LANG_DEFAULT'));
		$useLangFromCookie = false;
		$this->_languages = Language::getLanguages(false);
		if ($allowEmployeeFormLang)
			foreach ($this->_languages AS $lang)
				if ($cookie->employee_form_lang == $lang['id_lang'])
					$useLangFromCookie = true;
		if (!$useLangFromCookie)
			$this->_defaultFormLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		else
			$this->_defaultFormLanguage = (int)($cookie->employee_form_lang);
	}
   /**
    * process installing 
    */
	function install(){
		if (!parent::install())
			return false;
		if(!$this->registerHook('home'))
			return false;
		return true;
	}
	/*
	 * register hook right comlumn to display slide in right column
	 */
	function hookRightColumn($params){		
		return $this->processHook( $params,"rightColumn");
	}
	/*
	 * register hook left comlumn to display slide in left column
	 */
	function hookLeftColumn($params){		
		return $this->processHook( $params,"leftColumn");
	}
	
	function hooktop($params){		
		return $this->processHook( $params,"top");
	}
	
	function hookfooter($params){		
		return $this->processHook( $params,"footer");
	}
	function hookDisplaySlideshow($params){ 		
		return $this->processHook( $params,"slideshow");
	}
	function hookDisplayPromoteTop($params){ 		
		return $this->processHook( $params,"ptop");
	}
	function hookDisplayBottom($params){ 		
		return $this->processHook( $params,"bottom");
	}
	function hookDisplayContentBottom($params){ 		
		return $this->processHook( $params,"cbottom");
	}
	function hookDisplayFootNav($params){ 		
		return $this->processHook( $params,"footnav");
	}
 
				
	function hookHome($params){
		return $this->processHook( $params,"home");
	}
	function contentDefault() {
		foreach( $this->_languages as $language ){
			$contentDefault[$language['iso_code']] ="<p><img src=\"".__PS_BASE_URI__."modules/leocustomhtml3/images/img-free2.png\" alt=\"\" /></p>
<div class=\"content3\">
<h1>Free</h1>
<h3>shipping</h3>
<p><a>Donec accumsan hendrerit orci id congue it</a><br /> Lorem ipsum dolor sit amet, consectetur adipiscing elit nulla blandit nulla felis semper sit amet. facilisis tristique ante lectus eu sem. Integer ipsum leo.</p>
</div>
<p><img src=\"".__PS_BASE_URI__."modules/leocustomhtml3/images/img-free1.png\" alt=\"\" /></p>";
		}
			return $contentDefault;
	}
	/**
    * Proccess module by hook
    * $pparams: param of module
    * $pos: position call
    */
	function processHook($pparams, $pos="home"){
		global $smarty,$cookie;                  
		//load param
		
		$params = $this->_params;
		$this->site_url = Tools::htmlentitiesutf8('http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);
		
		$module_title 	= $params->get( 'module_title_'.$cookie->id_lang, 'Custom HTML' );
		$show_title 	= $params->get( 'show_title', '' );
		$class_prefix 	= $params->get( 'class_prefix', '');
		$content 	 	= str_replace('LOF_DEMO_CUSTOM_URL/',__PS_BASE_URI__,$params->get( 'content_'.$cookie->id_lang, '' ));
		
		$objLang = new Language($cookie->id_lang);
		$defaultC = $this->contentDefault();
		if($content =="") {
			$content = ($objLang->iso_code == 'fr' ? $defaultC['fr'] : $defaultC['en']);
		}
		
		// template asignment variables
		$smarty->assign( array(	
							  'pos'		    	=> $pos,
							  'module_title'	=> $module_title,
							  'show_title'		=> $show_title,
							  'class_prefix'	=> $class_prefix,
							  'content'			=> $content
						));
	    return $this->display(__FILE__, 'tmpl/default.tpl');					
	}
   /**
    * Render processing form && process saving data.
    */	
	public function getContent()
	{
		$html = "";
		if (Tools::isSubmit('submit'))
		{
			//$this->_postValidation();

			if (!sizeof($this->_postErrors))
			{													
		        $definedConfigs = array(
                  'show_title'  	  => '',                                  
                  'class_prefix'  	  => ''                                  
		        );
				foreach( $this->_languages as $language ){
					 $definedConfigs['module_title_'.$language['id_lang']] = '';
					 $definedConfigs['content_'.$language['id_lang']] = '';
				}
		        foreach( $definedConfigs as $config => $key ){
		            if(strlen($this->name.'_'.$config)>=32){
		              echo $this->name.'_'.$config;
		            }else{
		              Configuration::updateValue($this->name.'_'.$config, 'aa'); 
		              Configuration::updateValue($this->name.'_'.$config, Tools::getValue($config), true);  
		            } 		      		
		    	}
		        $html .= '<div class="conf confirm">'.$this->l('Settings updated successful').'</div>';
			}
			else
			{
				foreach ($this->_postErrors AS $err)
				{
					$html .= '<div class="alert error">'.$err.'</div>';
				}
			}
			// reset current values.
			$this->_params = new LofParams( $this->name );	
		}
		return $html.$this->_getFormConfig();
	}
	/**
	 * Render Configuration From for user making settings.
	 *
	 * @return context
	 */
	private function _getFormConfig(){
		$html = '';
		
	    ob_start();
	    include_once dirname(__FILE__).'/config/lofcustom.php'; 
	    $html .= ob_get_contents();
	    ob_end_clean(); 
		return $html;
	}
	/**
     * Process vadiation before saving data 
     */
	private function _postValidation(){
		if (!Validate::isCleanHtml(Tools::getValue('module_height')))
			$this->_postErrors[] = $this->l('The module height you entered was not allowed, sorry');                							
	}
   /**
    * Get value of parameter following to its name.
    * 
	* @return string is value of parameter.
	*/
	public function getParamValue($name, $default=''){
		return $this->_params->get( $name, $default );	
	}	  	  		
} 