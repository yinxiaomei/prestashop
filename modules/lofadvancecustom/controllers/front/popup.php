<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 17015 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.5.0
 */
class LofadvancecustomPopupModuleFrontController extends ModuleFrontController
{
	public $errors;
	public $expandForm = false;
	private $_postSuccess;
	private $_postErrors;

	public function __construct()
	{
		  parent::__construct();

		  $this->context = Context::getContext();
      include_once(dirname(__FILE__).'/../../classes/LofBlock.php');
      include_once(dirname(__FILE__).'/../../classes/LofItem.php');
      include_once(dirname(__FILE__).'/../../lofadvancecustom.php');
	}


	/**
	 * @see FrontController::initContent()
	 */
	public function initContent() {
		parent::initContent();

	}
  public function display(){
      require_once (dirname(__FILE__).'/../../popup.php');
      return true;
  }

}