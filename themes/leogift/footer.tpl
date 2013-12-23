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

		{if !$content_only}
		{include file="$tpl_dir./layout/{$LEO_LAYOUT_DIRECTION}/footer.tpl"  }
	</div></div></section>

<!-- Footer -->
			{if $HOOK_BOTTOM &&  in_array($page_name,array('index'))}
			<section id="bottom">
				<div class="container">
					<div class="row-fluid">
						 {$HOOK_BOTTOM}
					</div>
				</div>
			</section>
			{/if}
			<footer id="footer" class="omega clearfix">
				<section class="footer">
					<div class="container"><div class="row-fluid">
					{$HOOK_FOOTER}
					{if $PS_ALLOW_MOBILE_DEVICE}
						<p class="center clearBoth hidden-desktop"><a href="{$link->getPageLink('index', true)}?mobile_theme_ok">{l s='Browse the mobile site'}</a></p>
					{/if}
					</div></div>
				</section>	
				<section id="footer-bottom">
					<div class="container"><div class="row-fluid">
						<div class="span8">
							<div class="copyright">
								<p class="fs12">{$LEO_COPYRIGHT}</p>
							</div>
						</div>
						{if $HOOK_FOOTNAV}
						<div class="span4"><div class="footnav">{$HOOK_FOOTNAV}</div></div>		
						{/if}
					</div></div>	
				</section>
				
			</footer>
		</div>
	{/if}
	{if $LEO_PANELTOOL}
    	{include file="$tpl_dir./info/paneltool.tpl"}
    {/if}

		<script type="text/javascript">
			var classBody = "{$LEO_PATTERN}";
			$("body").addClass( classBody.replace(/\.\w+$/,"")  );
			
		</script>
	</body>
</html>
