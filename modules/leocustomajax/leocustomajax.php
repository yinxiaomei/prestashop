<?php
/*
* 2011-2013 LeoTheme.com
*
*/

if (!defined('_PS_VERSION_'))
	exit;

class Leocustomajax extends Module
{
	public function __construct()
	{
		$this->name = 'leocustomajax';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'LeoTheme';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Leo Custom Ajax');
		$this->description = $this->l('Display product number of category and show rating.');
	}
	
	public function install()
	{
		if (parent::install() == false ||
			!$this->registerHook('footer') ||
			!Configuration::updateValue('leo_customajax_pn', 1) ||
			!Configuration::updateValue('leo_customajax_rt', 1))
				return false;
		return true;
		
		if (parent::install() == false
			|| $this->registerHook('header') == false)
			return false;
		return true;
	}
	
	public function uninstall()
	{
		if (!parent::uninstall() ||
			!$this->unregisterHook('footer') ||
			!Configuration::deleteByName('leo_customajax_pn') ||
			!Configuration::deleteByName('leo_customajax_rt')
			)
				return false;
		return true;
		
		return (parent::uninstall() || $this->unregisterHook('header'));
	}

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitCustomAjax'))
		{
			
			Configuration::updateValue('leo_customajax_pn', Tools::getValue('leo_customajax_pn'));
			Configuration::updateValue('leo_customajax_rt', Tools::getValue('leo_customajax_rt'));
			
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Your settings have been updated.'));
		}
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		return '<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
				<label>'.$this->l('Show number of Product.').'</label>
				<div class="margin-form">
					<input type="radio" name="leo_customajax_pn" id="pn_display_on" value="1" '.(Tools::getValue('leo_customajax_pn', Configuration::get('leo_customajax_pn')) ? 'checked="checked" ' : '').'/>
					<label class="t" for="pn_display_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
					<input type="radio" name="leo_customajax_pn" id="pn_display_off" value="0" '.(!Tools::getValue('leo_customajax_pn', Configuration::get('leo_customajax_pn')) ? 'checked="checked" ' : '').'/>
					<label class="t" for="pn_display_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
					<p class="clear">'.$this->l('Run script return number of product in category or not.').'
					<br/>It will count product for each category.
					<br/>Put this code in file modules/blockcategories/blockcategories_footer.tpl
					<br/><textarea style="width: 772px; height: 111px;">
					<span id="leo-cat-{$node.id}" style="display:none" class="leo-qty"></span>
					</textarea>
					</p>
				</div>
				<label>'.$this->l('Show rating of Product.').'</label>
				<div class="margin-form">
					<input type="radio" name="leo_customajax_rt" id="display_on" value="1" '.(Tools::getValue('leo_customajax_rt', Configuration::get('leo_customajax_rt')) ? 'checked="checked" ' : '').'/>
					<label class="t" for="display_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
					<input type="radio" name="leo_customajax_rt" id="display_off" value="0" '.(!Tools::getValue('leo_customajax_rt', Configuration::get('leo_customajax_rt')) ? 'checked="checked" ' : '').'/>
					<label class="t" for="display_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
					<p class="clear">'.$this->l('You have to make sure that you are using productcomment module of prestashop.').'
                                        <br/>You can add this code in tpl file of module you want to show comment:
                                        <br/>
                                        <textarea style="width: 772px; height: 111px;">
                                        <a class="rating_box leo-rating-{$product.id_product}" href="#" rel="{$product.id_product}" style="display:none">
                                            <i class="icon-star-empty"></i>
                                            <i class="icon-star-empty"></i>
                                            <i class="icon-star-empty"></i>
                                            <i class="icon-star-empty"></i>
                                            <i class="icon-star-empty"></i>        
                                        </a>
                                        </textarea>
                                        </p>
				</div>
				<center><input type="submit" name="submitCustomAjax" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>';
	}
	
	
	public function hookFooter()
	{
            $this->smarty->assign('leo_customajax_pn', Configuration::get('leo_customajax_pn'));
            $this->smarty->assign('leo_customajax_rt',  Configuration::get('leo_customajax_rt'));
            return $this->display(__FILE__, 'footer.tpl');
	}
        
        
        /**
	 * Get Grade By product
	 *
	 * @return array Grades
	 */
	public static function getGradeByProducts($listProduct)
	{
		$validate = Configuration::get('PRODUCT_COMMENTS_MODERATE');
                $id_lang = (int)Context::getContext()->language->id;    

		return (Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT pc.`id_product_comment`, pcg.`grade`, pccl.`name`, pcc.`id_product_comment_criterion`, pc.`id_product`
		FROM `'._DB_PREFIX_.'product_comment` pc
		LEFT JOIN `'._DB_PREFIX_.'product_comment_grade` pcg ON (pcg.`id_product_comment` = pc.`id_product_comment`)
		LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion` pcc ON (pcc.`id_product_comment_criterion` = pcg.`id_product_comment_criterion`)
		LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_lang` pccl ON (pccl.`id_product_comment_criterion` = pcg.`id_product_comment_criterion`)
		WHERE pc.`id_product` in ('.$listProduct.')
		AND pccl.`id_lang` = '.(int)$id_lang.
		($validate == '1' ? ' AND pc.`validate` = 1' : '')));
	}
        
        /**
	 * Return number of comments and average grade by products
	 *
	 * @return array Info
	 */
	public static function getGradedCommentNumber($listProduct)
	{
		$validate = (int)Configuration::get('PRODUCT_COMMENTS_MODERATE');
                
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT COUNT(pc.`id_product`) AS nbr, pc.`id_product` 
		FROM `'._DB_PREFIX_.'product_comment` pc
		WHERE `id_product` in ('.$listProduct.')'.($validate == '1' ? ' AND `validate` = 1' : '').'
		AND `grade` > 0 GROUP BY pc.`id_product`');
		return $result;
	}
        
        
        
        public static function getByProduct($id_product)
	{
		$id_lang = (int)Context::getContext()->language->id;
                
                if (!Validate::isUnsignedId($id_product) ||
			!Validate::isUnsignedId($id_lang))
			die(Tools::displayError());
		$alias = 'p';
		$table = '';
		// check if version > 1.5 to add shop association
		if (version_compare(_PS_VERSION_, '1.5', '>'))
		{
			$table = '_shop';
			$alias = 'ps';
		}
		return Db::getInstance()->executeS('
			SELECT pcc.`id_product_comment_criterion`, pccl.`name`
			FROM `'._DB_PREFIX_.'product_comment_criterion` pcc
			LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_lang` pccl
				ON (pcc.id_product_comment_criterion = pccl.id_product_comment_criterion)
			LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_product` pccp
				ON (pcc.`id_product_comment_criterion` = pccp.`id_product_comment_criterion` AND pccp.`id_product` = '.(int)$id_product.')
			LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_category` pccc
				ON (pcc.`id_product_comment_criterion` = pccc.`id_product_comment_criterion`)
			LEFT JOIN `'._DB_PREFIX_.'product'.$table.'` '.$alias.'
				ON ('.$alias.'.id_category_default = pccc.id_category AND '.$alias.'.id_product = '.(int)$id_product.')
			WHERE pccl.`id_lang` = '.(int)($id_lang).'
			AND (
				pccp.id_product IS NOT NULL
				OR ps.id_product IS NOT NULL
				OR pcc.id_product_comment_criterion_type = 1
			)
			AND pcc.active = 1
			GROUP BY pcc.id_product_comment_criterion
		');
	}
        
}