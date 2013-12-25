<?php

if (!defined('_PS_VERSION_'))
	exit;
	
class leoCategoryQuicklink extends Module {
    
    public $_html;
    public $_display;
    public $_tabs;
    public $_fields;
    public $menu = array();

    public function __construct() {
        
        $this->name = 'leocategoryquicklink';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'xiaomei';
        $this->need_instance = 0;
        parent::__construct();
        $this->displayName = $this->l('LEO CATEGORY QUICKLINK');
        $this->description = $this->l('Show Product Search on Home page.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall your details ?');
        $this->secure_key = Tools::encrypt($this->name);
        $this->setMenu();
    }
    
    public function install() {
        if (!parent::install() || 
        !Configuration::updateGlobalValue('COLOUR', 'RED,BLUE,GREEN,BLACK') || 
        !Configuration::updateGlobalValue('STYLE', 'CLASSIC,CLUE,FUNNY') || 
        !Configuration::updateGlobalValue('SHAPE', 'BIG,MEDDLE,SMALL') || 
        !Configuration::updateGlobalValue('POPULAR', 'P1,P2,P3') || 
        !Configuration::updateGlobalValue('INDUSTRY', 'SPRING,SUMMER,AUTUMN,WINTER') || 
        !$this->registerHook('home') || 
        !$this->registerHook('header'))
            return false;
        return true;
    }
    
    public function uninstall() {
		if(!parent::uninstall() ||
		!Configuration::deleteByName('COLOUR') ||
		!Configuration::deleteByName('STYLE') ||
		!Configuration::deleteByName('SHAPE') ||
		!Configuration::deleteByName('POPULAR') ||
		!Configuration::deleteByName('INDUSTRY'))
			 return false;
        return true;
    }
    
    public function getContent() {
    	$update_cache = false;
    	$this->_includeFile();
    	
    	if (Tools::isSubmit('submitCategories')) {
    		if(Configuration::updateValue('COLOUR', Tools::getValue('COLOUR_items'))&&
    			Configuration::updateValue('STYLE', Tools::getValue('STYLE_items'))&&
    			Configuration::updateValue('SHAPE', Tools::getValue('SHAPE_items'))&&
    			Configuration::updateValue('POPULAR', Tools::getValue('POPULAR_items'))&&
    			Configuration::updateValue('INDUSTRY', Tools::getValue('INDUSTRY_items')))
    			$this->_html .= $this->displayConfirmation($this->l('Settings Updated'));
    		else
    			$this->_html .= $this->displayError($this->l('Unable to update settings'));
    	
    		$update_cache = true;
    	}
            
        return $this->_html.$this->displayForm();
       
    }
    
    private function setMenu() {
        
        $menuArray = array("COLOUR","STYLE","SHAPE","POPULAR","INDUSTRY");
        $this->menu = $menuArray;
    }
    
    private function _includeFile() {

        $this->_html = '
	<link href="' . __PS_BASE_URI__ . 'modules/leocategoryquicklink/css/bootstrap-trim.min.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/leocategoryquicklink/js/prettify.js"></script>
	<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/leocategoryquicklink/js/bootstrap-trim.min.js"></script>
	<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/leocategoryquicklink/js/options-custom.js"></script>
    ';
    }
	public function displayForm()
	{
		return '
		<form action="" method="post">
			<fieldset>
				<legend><img src="" alt="" title="" />'.$this->l('leo category quicklink Settings').'</legend>
				<label>'.$this->l('order those categories:').'</label>
				<div class="margin-form">
					<lable class="t">1</lable>
					<select id="s1">
						<option value="Wedding Banner">Wedding Banner</option>
						<option value="Wedding Banner">Christmas Banner</option>
						<option value="Wedding Banner">Birthday Banner</option>
					</select>
				</div>
				<div class="margin-form">
					<lable class="t">2</lable>
					<select id="s2">
						<option value="Wedding Banner">Wedding Banner</option>
						<option value="Wedding Banner">Christmas Banner</option>
						<option value="Wedding Banner">Birthday Banner</option>
					</select>
				</div>
				<div class="margin-form">
					<lable class="t">3</lable>
					<select id="s3">
						<option value="Wedding Banner">Wedding Banner</option>
						<option value="Wedding Banner">Christmas Banner</option>
						<option value="Wedding Banner">Birthday Banner</option>
					</select>
				</div>
				<div class="margin-form">
					<lable class="t">4</lable>
					<select id="s4">
						<option value="Wedding Banner">Wedding Banner</option>
						<option value="Wedding Banner">Christmas Banner</option>
						<option value="Wedding Banner">Birthday Banner</option>
					</select>
				</div>
				<div class="margin-form">
					<lable class="t">5</lable>
					<select id="s5">
						<option value="Wedding Banner">Wedding Banner</option>
						<option value="Wedding Banner">Christmas Banner</option>
						<option value="Wedding Banner">Birthday Banner</option>
					</select>
				</div>
				<center><input type="submit" name="submitCategories" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>';
	}
    private function _sccOptionForm() {
        
        $menu = $this->menu;
        $this->_tabs = '';
        foreach($menu as $item) {
           $this->_tabs .= '<li class="' . $item . ' "><a  data-toggle="tab" title="' .$item . '" href="#' . $item . '">' . $item . '</a></li>';
           $this->_fields .= '
          <div class="tab-pane" id="'.$item.'">
           	<div style="display: none">
				<label>' . $item . '</label>
				<div class="margin-form">
					<input type="text" name="'.$item.'_items" id="'.$item.'_itemsInput" value="' . Tools::safeOutput(Configuration::get($item)) . '" size="70" />
				</div>
			</div>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <select multiple="multiple" id="'.$item.'_items" style="width: 300px; height: 160px;">';
$this->makeMenuOption($item);		                
$this->_fields .= '</select>				                
                        </td>
                        <td valign="top">
                            <div>
                                <label style="width: 92px; margin-bottom: 15px;">'.$this->l('add new label').'</label>
                                <p>
                                    <input type="text" id="'.$item.'_id" />
                                    <a href="#" id="add'.$item.'" style="border: 1px solid rgb(170, 170, 170); margin: 2px; padding: 2px; text-align: center; text-decoration: none; background-color: rgb(250, 250, 250); color: rgb(18, 52, 86);" onclick="add_'.$item.'();">' . $this->l('Add') . ' </a>
                                </p>
                                </div>
                            <div>
                                <label style="width:85px;">'.$this->l('remove label').'</label>
                                <p>
                                    <a href="#" id="remove'.$item.'" style="border: 1px solid rgb(170, 170, 170); margin: 2px; padding: 2px; text-align: center; text-decoration: none; background-color: rgb(250, 250, 250); color: rgb(18, 52, 86);" onclick="remove_'.$item.'();"> ' . $this->l('Remove') . '</a>
                                </P>
                                
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <script type="text/javascript">
                $("#'.$item.'_items").dblclick(remove_'.$item.');                    		
                function add_'.$item.'(){
                    //alert("'.$item.'");
                    var text = $("#'.$item.'_id").val();
                    /*alert(text);*/
                    if(text.length != 0){
                        $("#'.$item.'_items").append("<option value=\"'.$item.'\">"+text+"</option>");
                    }
                    $("#'.$item.'_id").val("");
                    serialize_'.$item.'();
                    return false;
                }
                function remove_'.$item.'() {
                	$("#'.$item.'_items option:selected").each(function(i){
							$(this).remove();
					});
                	serialize_'.$item.'();
                    return false;
                }
                function serialize_'.$item.'() {
        			var options = "";
					$("#'.$item.'_items option").each(function(i){
						options += $(this).text()+",";
					});
					$("#'.$item.'_itemsInput").val(options.substr(0, options.length - 1));
					//alert($("#'.$item.'_itemsInput").val());		
        		}
             </script>
            
           </div>'. "\n";
           
        }
        
        $this->_html .= '<div class="container custome-bg">
		<form action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" method="post" id="form">
				<div class="page-header">
                <h2>' . $this->displayName . '</h2>
                <span></span>
            </div>
            <div class="row-fluid">
                <div id="sidebar" class="tabbable">
                    <div class="span3">
                        <div class="well">
                            <ul id="sidenav" class="nav nav-pills nav-stacked">
                                    ' . $this->_tabs . ' 
                            </ul>
                        </div>
                           
                    </div>
                    <div class="span9" style="margin-left: 0px;">
                        <div class="tab-content content-gbcolr">
                         
                        ' . $this->_fields . '     
                        
                        </div>
                    </div>
               </div>
            </div>
            <p class="center">
                <input type="submit" name="submitBlocktopmenu" value="' . $this->l('	Save	') . '" class="button" />
			</p>
        </form>
        </div>
        ';
        
    }
    
    private function makeMenuOption($item) {
        $menu_item = explode(',', Configuration::get($item));
        foreach($menu_item as $subItem) {
            $this->_fields .= '<option value="' . $item . '">' . $subItem . '</option>';
        }
    }
    
    public function getProductId($attribute_name, $attribute_value)
    {
    	$sql = 'SELECT DISTINCT ppa.id_product
				FROM '._DB_PREFIX_.'attribute_group_lang AS pagl,'._DB_PREFIX_.'attribute_lang AS pal,'._DB_PREFIX_.'product_attribute AS ppa,'._DB_PREFIX_.'product_attribute_combination AS ppac
				WHERE ppa.id_product_attribute = ppac.id_product_attribute AND ppac.id_attribute = pal.id_attribute 
				AND pagl.`name` = \''.$attribute_name.'\' AND pal.`name` = \''.$attribute_value.'\' AND pagl.id_lang = 1 AND pal.id_lang = 1';
    	$sql2 = 'select * from '._DB_PREFIX_.'attribute_lang AS pal';	
    
    	$result =  Db::getInstance()->executeS($sql);
    	$arr = array();
    	foreach($result as $item) 
    	{
    		array_push($arr, $item['id_product']);
    	}
    	return $arr;
    }
    
    public function getProductIdByTags($tags)
    {
    	$pid = array();
    	foreach($tags as $key => $each){
    		$arr = array();
    		$result = Db::getInstance()->executeS('select pt.id_product 
    				from '._DB_PREFIX_.'product_tag pt, '._DB_PREFIX_.'tag t 
    				where pt.id_tag = t.id_tag and t.name = \''.$each.'\'');
    		foreach($result as $one){
    			array_push($arr, $one['id_product']);
    		}
    		$pid[$key] = $arr;
    	}
    	if($key == 0) return $pid[0];
    	else{
	    	$resultId = $pid[0];
	    	for($i=0;$i<$key;$i++){
	    		$resultId = array_intersect($resultId, $pid[$i+1]);
	    	}
	    	return $resultId;
    	}
    }
    
    public function hookHome($params) {
   		global $smarty;

   		$Products = Product::getProducts((int)($params['cookie']->id_lang), 0, 1000, 'id_product', 'ASC');
   		$Products = Product::getProductsProperties((int)($params['cookie']->id_lang), $Products);
   		$count = 0;
   		foreach($Products as $item)
   		{
//    			if(in_array($item['id_product'], $result))
//    			{
   				//---check id_image add it to the $item
   				$aa = Product::getCover($item['id_product']);
   				$bb = $aa['id_image'];
   				$item['id_image'] = $bb;
   				//-----------------------------
   				$item['link'] = '?id_product='.$item['id_product'].'&controller=product&id_lang='.(int)($params['cookie']->id_lang);
   				$item['quantity'] = Product::getQuantity($item['id_product']);
   				$Products_display[$count++] = $item;
//    			}
   		}
   		
   		$this->context->controller->addCSS($this->_path . 'css/typepicker.css');
   		$this->context->controller->addCSS($this->_path . 'css/pagination.css');
    		$this->context->controller->addJS($this->_path . 'js/pagination.js');
   		$this->context->controller->addJS($this->_path . 'js/jquery-paged-scroll.js');


   		
   		$smarty->assign(array(
   				"COLOUR" => explode(',', Configuration::get("COLOUR")),
   				"STYLE" => explode(',', Configuration::get("STYLE")),
   				"SHAPE" => explode(',', Configuration::get("SHAPE")),
   				"POPULAR" => explode(',', Configuration::get("POPULAR")),
   				"INDUSTRY" => explode(',', Configuration::get("INDUSTRY")),
   				'id_lang' => (int)($params['cookie']->id_lang),
   				'products' => $Products_display
   				));
   		
   		return $this->display(__FILE__, 'leocategoryquicklink.tpl');
    }
}