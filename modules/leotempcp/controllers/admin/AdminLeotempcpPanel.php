<?php 
class AdminLeotempcpPanelController extends ModuleAdminControllerCore {
	var $display_key = 0;
	var $hookspos = array();
	var $ownPositions = array();
	var $theme_name;
	public function __construct() {
        $this->table = 'leohook';
        $this->className = 'LeotempcpPanel';
        $this->lang = true;
        $this->context = Context::getContext();
        parent::__construct();
		$this->display_key = (int)Tools::getValue('show_modules');
		$this->ownPositions = array(
			'displayHeaderRight',
			'displaySlideshow',
			'topNavigation',
			'displayPromoteTop',
			'displayBottom'
		);
		$this->hookspos = array(
				'displayTop',
				'displayHeaderRight',
				'displaySlideshow',
				'topNavigation',
				'displayPromoteTop',
				'displayRightColumn',
				'displayLeftColumn',
				'displayHome',
				'displayFooter',
				'displayBottom',
				'displayContentBottom',
				'displayFootNav',
				'leftcolumn',
				'rightcolumn'
			); 
		$this->theme_name = Context::getContext()->shop->getTheme();
    }
	
	 public function initToolbarTitle() {
        parent::initToolbarTitle();
		$this->toolbar_title = $this->l("LeoTheme Positions Control: ".$this->theme_name );
        $this->toolbar_btn['save'] = array(
                    'href' => 'index.php?tab=AdminLeotempcpPanel&token='.Tools::getAdminTokenLite('AdminLeotempcpPanel').'&action=savepos',
					'id'   => 'savepos',
                    'desc' => $this->l('Save Positions')
                );
 
		$this->toolbar_btn['controlpanel'] = array(
                    'href' => 'index.php?controller=adminmodules&configure=leotempcp&token='.Tools::getAdminTokenLite('AdminModules').'&tab_module=Home&module_name=leotempcp',
					'id'   => 'controlpanel',
                    'desc' => $this->l('Theme Control Panel')
                );
		$admin_dir = basename(_PS_ADMIN_DIR_);
		$live_edit_params = array(
									'live_edit' => true, 
									'ad' => $admin_dir, 
									'liveToken' =>Tools::getAdminTokenLite('AdminModulesPositions') ,
									'id_employee' => (int)$this->context->employee->id
									);
		
		$this->toolbar_btn['liveedit'] = array(
                    'href' => $this->getLiveEditUrl($live_edit_params),
					'id'   => 'liveedit',
                    'desc' => $this->l('Live Edit')
		);			
		$helpURL =  __PS_BASE_URI__.str_replace("//","/",'modules/leotempcp')."/help/help.pdf";
		$this->toolbar_btn['help'] = array(
                    'href' => $helpURL ,
					'id'   => 'help',
					'jsddd'=>'showHelp(\''. $helpURL.'\')',
                    'desc' => $this->l('Help')
		);		
    }
	public function getLiveEditUrl($live_edit_params)
	{
		$url = $this->context->shop->getBaseURL().Dispatcher::getInstance()->createUrl('index', (int)$this->context->language->id, $live_edit_params);
		if (Configuration::get('PS_REWRITING_SETTINGS'))
			$url = str_replace('index.php', '', $url);
		return $url;
	}
    public function initToolbar() {
		$this->context->smarty->assign('toolbar_scroll', 1);
        $this->context->smarty->assign('show_toolbar', 1);
        $this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);
        $this->context->smarty->assign('title', $this->toolbar_title);
		
	}
	public function renderList(){
		//echo $this->theme_name; die;
		$filePath = _PS_ALL_THEMES_DIR_.$this->theme_name.'';
		$showed = true;
		$info = simplexml_load_file( $filePath.'/config.xml' );
		
		if( isset($info->author) && strtolower($info->author) == 'leotheme' ) {
		
			$this->initToolbarTitle();
			$this->initToolbar();
			$hookspos = $this->hookspos;
		
			foreach( $hookspos as $hook ){
				if( Hook::getIdByName($hook) ){
					
				} else {
					$new_hook = new Hook();
					$new_hook->name = pSQL($hook);
					$new_hook->title = pSQL($hook);
					$new_hook->add();
					$id_hook = $new_hook->id;
				}
			}
			
			Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('
				UPDATE `'._DB_PREFIX_.'hook` SET position=1, live_edit=1
						WHERE name in ("'.implode('","',$hookspos).'")  '
			);
			
			
			$modules = Module::getModulesInstalled(0);
			$assoc_modules_id = array();
			 
		
			
			$assoc_modules_id = array();
			foreach ($modules as $module)
				if ($tmp_instance = Module::getInstanceById((int)$module['id_module']))
				{
					// We want to be able to sort modules by display name
					$module_instances[$tmp_instance->displayName] = $tmp_instance;
					// But we also want to associate hooks to modules using the modules IDs
					$assoc_modules_id[(int)$module['id_module']] = $tmp_instance->displayName;
				}
				
			
			
			$hooks = Hook::getHooks(!(int)Tools::getValue('hook_position') );
			$hookModules = array();
			$hookedModules = array();
			foreach ($hooks as $key => $hook)
			{
			
				// $key = $hook['name'];
				$k = $hook['name'];
				if( in_array($k , $hookspos) ){
					// Get all modules for this hook or only the filtered module
					$hookModules[$k]['modules'] = Hook::getModulesFromHook($hook['id_hook'], $this->display_key);
					$hookModules[$k]['module_count'] = count($hookModules[$k]['modules']);
					
					if (is_array($hookModules[$k]['modules']) && !empty($hookModules[$k]['modules'])) {
						 foreach ($hookModules[$k]['modules'] as $module_key => $module) {
							if (isset($assoc_modules_id[$module['id_module']])) {
								$hookedModules[] = $module['id_module'];	
								$hookModules[$k]['modules'][$module_key]['instance'] = $module_instances[$assoc_modules_id[$module['id_module']]];
							}
						}
					}	
				}	
			}

				
		
			
		 // 	echo '<pre>'.print_r($hookedModules,1); die;
			$instances = array();
			foreach ($modules as $module) {  
				if ($tmp_instance = Module::getInstanceById($module['id_module']) ) {
					if( !in_array($module['id_module'],$hookedModules) ) {
						foreach( $hookspos as $hk ) {
							$retro_hook_name = Hook::getRetroHookName( $hk );
							$hook_callable = is_callable(array($tmp_instance, 'hook'.$hk));
							$hook_retro_callable = is_callable(array($tmp_instance, 'hook'.$retro_hook_name));
							if( $hook_retro_callable || $hook_callable ){
								$instances[$tmp_instance->displayName] = $tmp_instance;
								break;
							}
						}
						
					//	echo '<pre>'.print_r( $instances, 1 ); die;
					}
				}
			}
			ksort($instances);
			$modules = $instances;
			
				
			$tpl = $this->createTemplate('panel.tpl');
	 
			$this->context->controller->addCss( __PS_BASE_URI__.str_replace("//","/",'modules/leotempcp').'/assets/admin/style.css', 'all');
			$this->context->controller->addJs( __PS_BASE_URI__.str_replace("//","/",'modules/leotempcp/assets/admin/jquery-ui-1.10.3.custom.min.js'), 'all');
			$tpl->assign( array(
				'showed' => $showed,
				'toolbar' => $this->context->smarty->fetch('toolbar.tpl'),
				'modules'=> $modules,
				'hookspos'=>$hookspos,
				'URI' => __PS_BASE_URI__.'modules/',
				'hookModules' => $hookModules,
				'currentURL' =>  'index.php?tab=AdminLeotempcpPanel&token='.Tools::getAdminTokenLite('AdminLeotempcpPanel').''
			));
	 
			  
			return   $tpl->fetch();
		}else {
		
			$tpl = $this->createTemplate('error.tpl');
			$tpl->assign( array(
				'showed' => false, 
				'themeURL'=>'index.php?controller=AdminThemes&token='. Tools::getAdminTokenLite('AdminThemes')
				)
			);
			return   $tpl->fetch();
		}		
	}
	
	public function postProcess() {
	
		if( Tools::getValue('action') && Tools::getValue('action') == 'modulehook' ){		
			$id = (int)Tools::getValue('id');
			
			$tmp_instance = Module::getInstanceById($id);
			$hooks = array();
			
			foreach( $this->hookspos as $hk ) {
				$retro_hook_name = Hook::getRetroHookName( $hk );
				$hook_callable = is_callable(array($tmp_instance, 'hook'.$hk));
				$hook_retro_callable = is_callable(array($tmp_instance, 'hook'.$retro_hook_name));
				
				if( $hook_retro_callable || $hook_callable ){
					$hooks[] = $hk;
				//	break;
				}
			}
			$hooks = implode("|",$hooks);
			$sql = 'SELECT *
				FROM `'._DB_PREFIX_.'leohook` WHERE id_module='.$id.' AND theme="'.$this->theme_name.'" AND id_shop='.(int)($this->context->shop->id);

			if ( $row = Db::getInstance()->getRow($sql)){
 
				die('{"hasError" : false, "hook" : "'.$row['name_hook'].'","hooks":"'.$hooks.'"}');
			}else {
				die('{"hasError" : true, "errors" : "Can not update module position","hooks":"'.$hooks.'"}');
			}
		}
		if( Tools::getValue('action') && Tools::getValue('action') == 'overridehook' ){		
			$id_module = (int)Tools::getValue('hdidmodule');
			$name_hook = Tools::getValue('name_hook');
			if( is_numeric($name_hook) ){
				$sql = 'DELETE  FROM`'._DB_PREFIX_.'leohook` WHERE id_module='.$id_module.' AND theme="'.$this->theme_name.'" AND id_shop='.(int)($this->context->shop->id);

				Db::getInstance(_PS_USE_SQL_SLAVE_)->execute( $sql );
				die('{"hasError" : false, "errors" : done!delete module position"}');	
			}
			elseif( $name_hook ){ 
				$sql = 'SELECT *
					FROM `'._DB_PREFIX_.'leohook` WHERE id_module='.$id_module.' AND theme="'.$this->theme_name.'" AND id_shop='.(int)($this->context->shop->id);

				if ( $row = Db::getInstance()->getRow($sql)){
					$sql = ' UPDATE `'._DB_PREFIX_.'leohook`  SET name_hook="'.$name_hook.'" 
						 WHERE id_module='.$id_module.' AND theme="'.$this->theme_name.'" AND id_shop='.(int)($this->context->shop->id)
					;
					
					Db::getInstance(_PS_USE_SQL_SLAVE_)->execute( $sql );
				}else {
					$sql = ' INSERT INTO `'._DB_PREFIX_.'leohook` (id_module,id_shop,theme, name_hook) 
						VALUES('.$id_module.','.(int)($this->context->shop->id).',"'.$this->theme_name.'","'.$name_hook.'")
					';
					
					Db::getInstance(_PS_USE_SQL_SLAVE_)->execute( $sql );
				}
				die('{"hasError" : false, "errors" : done!update module position"}');	
			}
			die('{"hasError" : true, "errors" : "Can not update module position"}');			
		}
		if( Tools::getValue('action') && Tools::getValue('action') == 'savepos' ){
			
			$positions =  Tools::getValue('position');
			$way = (int)(Tools::getValue('way'));
			$unhook =  Tools::getValue('unhook');
			$id_shop = Context::getContext()->shop->id;
			
			if( is_array($unhook) ){
				foreach( $unhook as $id_module=>$hookId ){
					$module = Module::getInstanceById($id_module);
					if ( Validate::isLoadedObject($module) ) {
						!$module->unregisterHook( (int)$hookId, array($id_shop) );
					}
				}
			}
			
			if( is_array($positions) && !empty($positions) ){
				foreach( $positions as $pos ){
					$tmp = explode("|",$pos);
					if( count($tmp) == 2 && $tmp[0] && $tmp[1] ){
						$position = $tmp[0];
						$hookId = Hook::getIdByName( $position );
						$oldhooks = explode(",", Tools::getValue( $position ) );
				
						$ids = explode(",",$tmp[1]);
						if( $hookId && count($oldhooks) ){	
							foreach( $ids as $index => $id_module ) { 
								$module = Module::getInstanceById($id_module);
									
								if (Validate::isLoadedObject($module) && isset($oldhooks[$index]) && is_numeric($oldhooks[$index]) && $oldhooks[$index]!=$hookId) { 
						 
								 	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('
								 		UPDATE `'._DB_PREFIX_.'hook_module` SET id_hook='.$hookId.' 
								 				WHERE id_module='.$id_module.' AND id_hook='.(int)$oldhooks[$index].' AND id_shop='.(int)($id_shop)
								 	);
							  	
								//	echo '<pre>'.print_r( $idshooks ,1);
								echo $oldhooks[$index].'<br>';
								 	echo '<br>update:'.$id_module."-";
								} elseif(Validate::isLoadedObject($module) && ( !isset($oldhooks[$index]) || !(int)$oldhooks[$index] )  ){
									 $this->registerHook( $id_module, $hookId, array($id_shop)); 
									echo 'new:'.$id_module;
								}
								$module->updatePosition( $hookId, $way, $index+1 );
							}
						}
					//	echo '<pre>'.print_r( $hookId, 1 ); die;
					}
					
				}
			}
			// echo '<pre>'.print_r( $position, 1 ); die;
			die("done done");
		}
	}
	
	public function registerHook( $id_module, $id_hook, $shop_list = null ){
		// If shop lists is null, we fill it with all shops
		if (is_null($shop_list))
			$shop_list = Shop::getShops(true, null, true);

		$return = true;
		foreach ($shop_list as $shop_id)
		{
			// Check if already register
			$sql = 'SELECT hm.`id_module`
				FROM `'._DB_PREFIX_.'hook_module` hm, `'._DB_PREFIX_.'hook` h
				WHERE hm.`id_module` = '.(int)($id_module).' AND h.`id_hook` = '.$id_hook.'
				AND h.`id_hook` = hm.`id_hook` AND `id_shop` = '.(int)$shop_id;
				
		
			if (Db::getInstance()->getRow($sql))
				continue;

			// Get module position in hook
			$sql = 'SELECT MAX(`position`) AS position
				FROM `'._DB_PREFIX_.'hook_module`
				WHERE `id_hook` = '.(int)$id_hook.' AND `id_shop` = '.(int)$shop_id;
			if (!$position = Db::getInstance()->getValue($sql))
				$position = 0;
			
			
			// Register module in hook
			$return &= Db::getInstance()->insert('hook_module', array(
				'id_module' => (int)$id_module,
				'id_hook' => (int)$id_hook,
				'id_shop' => (int)$shop_id,
				'position' => (int)($position + 1),
			));
		}
	}
}
?>