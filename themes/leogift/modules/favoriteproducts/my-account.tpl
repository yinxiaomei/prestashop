{*
* 2007-2013 PrestaShop
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
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<li class="favoriteproducts item">
	<a href="{$link->getModuleLink('favoriteproducts', 'account')|escape:'htmlall':'UTF-8'}" title="{l s='My favorite products.' mod='favoriteproducts'}">
		{if !$in_footer}<img {if isset($mobile_hook)}src="{$module_template_dir}img/favorites.png" class="ui-li-icon ui-li-thumb"{else}src="{$module_template_dir}img/favorites.png" class="icon"{/if} alt="{l s='My favorite products.' mod='favoriteproducts'}"/>{/if}
		{l s='My favorite products.' mod='favoriteproducts'}
	</a>
</li>
