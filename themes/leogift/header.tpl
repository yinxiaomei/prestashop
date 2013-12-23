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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_iso}">
	<head>
		<title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
{if isset($meta_description) AND $meta_description}
		<meta name="description" content="{$meta_description|escape:html:'UTF-8'}" />
{/if}
{if isset($meta_keywords) AND $meta_keywords}
		<meta name="keywords" content="{$meta_keywords|escape:html:'UTF-8'}" />
{/if}
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		<meta http-equiv="content-language" content="{$meta_language}" />
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
		<link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />
		<script type="text/javascript">
			var baseDir = '{$content_dir|addslashes}';
			var baseUri = '{$base_uri|addslashes}';
			var static_token = '{$static_token|addslashes}';
			var token = '{$token|addslashes}';
			var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
			var priceDisplayMethod = {$priceDisplay};
			var roundMode = {$roundMode};
		</script>

<link rel="stylesheet" type="text/css" href="{$BOOTSTRAP_CSS_URI}"/>		
{if isset($css_files)}
	{foreach from=$css_files key=css_uri item=media}
	<link href="{$css_uri}" rel="stylesheet" type="text/css" media="{$media}" />
	{/foreach}
{/if}
{if $LEO_SKIN_DEFAULT &&  $LEO_SKIN_DEFAULT !="default"}
	<link rel="stylesheet" type="text/css" href="{$content_dir}themes/{$LEO_THEMENAME}/skins/{$LEO_SKIN_DEFAULT}/css/skin.css"/>
{/if}
 	
{$LEO_CUSTOMWIDTH}
{if $LEO_RESPONSIVE}
	<link rel="stylesheet" type="text/css" href="{$BOOTSTRAP_RESPONSIVECSS_URI}"/>
	<link rel="stylesheet" type="text/css" href="{$content_dir}themes/{$LEO_THEMENAME}/css/theme-responsive.css"/>
{/if}
{if isset($js_files)}
	{foreach from=$js_files item=js_uri}
	<script type="text/javascript" src="{$js_uri}"></script>
	{/foreach}
{/if}
{if !$LEO_CUSTOMFONT}
	<link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'/>
{/if}
<link rel="stylesheet" type="text/css" href="{$content_dir}themes/{$LEO_THEMENAME}/css/font-awesome.css"/>
<script type="text/javascript" src="{$content_dir}themes/{$LEO_THEMENAME}/js/custom.js"></script>


{if $hide_left_column||in_array($page_name,array('index'))}{$HOOK_LEFT_COLUMN=null}{/if}
{if $hide_right_column||in_array($page_name,array('index'))}{$HOOK_RIGHT_COLUMN=null}{/if}


<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
	{$HOOK_HEADER}
	</head>
	<body {if isset($page_name)}id="{$page_name|escape:'htmlall':'UTF-8'}"{/if} class="{$LEO_BGPATTERN} fs{$FONT_SIZE}">
	{if !$content_only}
		{if isset($restricted_country_mode) && $restricted_country_mode}
		<div id="restricted-country">
			<p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country}</span></p>
		</div>
		{/if}
		<div id="page" class="clearfix">
			 
				<header id="header" class="header-wrap"> 
						<section class="topbar">
							<div class="container">
							{$HOOK_TOP}	
							</div>
						</section>
						<section class="header">
							<div class="container" >
								<div class="row-fluid">
									<div class="span3 logo-wrapper text-center">
										<a id="header_logo" href="{$base_dir}" title="{$shop_name|escape:'htmlall':'UTF-8'}">
											<img class="logo" src="{$logo_url}" alt="{$shop_name|escape:'htmlall':'UTF-8'}" {if $logo_image_width}width="{$logo_image_width}"{/if} {if $logo_image_height}height="{$logo_image_height}" {/if} />
										</a>
									</div>
									<div class="span7">
										{if !empty($HOOK_HEADERRIGHT)}
										<div id="header_right" class="row-fuild">
											{$HOOK_HEADERRIGHT}	
										</div>
										{/if}
										<div class="row-fuild clear">
											{if !empty($HOOK_TOPNAVIGATION) }
											<nav id="topnavigation">
												{$HOOK_TOPNAVIGATION}
											</nav>
											{/if}
										</div>
									</div>
								</div>
							</div>
						</section>
					 
				</header>
			
			{if $HOOK_SLIDESHOW &&  in_array($page_name,array('index'))}
			<section id="slideshow" class="hidden-phone">
				<div class="container">
					<div class="row-fluid">
						 {$HOOK_SLIDESHOW}
					</div>
				</div>
			</section>
			{/if}
			{if $HOOK_PROMOTETOP &&  in_array($page_name,array('index'))}
			<section id="promotetop">
				<div class="container">
					<div class="row-fluid">
						 {$HOOK_PROMOTETOP}
					</div>
				</div>
			</section>
			{/if} 
			<section id="columns" class="clearfix"><div class="container"><div class="row-fluid">
			{include file="$tpl_dir./layout/{$LEO_LAYOUT_DIRECTION}/header.tpl" hide_left_column=$hide_left_column hide_right_column=$hide_right_column }
	{/if}
