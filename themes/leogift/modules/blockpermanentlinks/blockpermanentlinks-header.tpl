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
 
<!-- Block permanent links module HEADER -->
<div id="header_links" class="nav-top">
	
	{if $logged}
		<div class="nav-item">
			<a href="{$link->getPageLink('my-account', true)}" title="{l s='View my customer account' mod='blockpermanentlinks'}" class="account" rel="nofollow"><span>{l s='My Account' mod='blockpermanentlinks'}</span></a>		
		</div>
		<div class="nav-item">
			<a href="{$link->getPageLink('index', true, NULL, "mylogout")}" title="{l s='Log me out' mod='blockpermanentlinks'}" class="logout" rel="nofollow">{l s='Log out' mod='blockpermanentlinks'}</a>
		</div>
	{else}
		<div class="nav-item">
			<a href="{$link->getPageLink('my-account', true)}" title="{l s='Login to your customer account' mod='blockpermanentlinks'}" class="login" rel="nofollow">{l s='Login' mod='blockpermanentlinks'}</a>
		</div>
	{/if}
	
	<div class="nav-item hidden-phone"><a href="{$link->getPageLink('contact', true)}" title="{l s='contact' mod='blockpermanentlinks'}">{l s='Contact' mod='blockpermanentlinks'}</a></div>
	<div class="nav-item hidden-phone"><a href="{$link->getPageLink('sitemap')}" title="{l s='sitemap' mod='blockpermanentlinks'}">{l s='Sitemap' mod='blockpermanentlinks'}</a></div>
	
	<div class="nav-item hidden-phone">
		<script type="text/javascript">writeBookmarkLink('{$come_from}', '{$meta_title|addslashes|addslashes}', '{l s='Bookmark' mod='blockpermanentlinks' js=1}');</script>
	</div>
</div>
<!-- /Block permanent links module HEADER -->
