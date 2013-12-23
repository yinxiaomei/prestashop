<div class="toolpanel" id="toolspanel">
  <form action="{$content_dir}index.php" method="get">
    <div style="min-height: 300px;   left: 0px;" class="pn-content inactive" id="toolspanelcontent">
      <div class="pn-button open"><span>&nbsp;</span> </div>
      <div id="template_theme"> 
      	 <h5>{l s="Theme skin"}</h5>
        <select name="skin">
        {foreach from=$LEO_THEMEINFO.skins item=skin}
          <option value="{$skin}" {if $LEO_SKIN_DEFAULT==$skin}selected="selected"{/if}>{$skin}</option>
        {/foreach} 
        </select>
       
      </div>
     
      {if isset($LEO_THEMEINFO.patterns)}
      <div id="pnpartterns">
        <h5>Pattern</h5>
		<input type="hidden" value="" name="bgpattern" id="bgpattern"/>
        {foreach from=$LEO_THEMEINFO.patterns item=p}
        	<a style="background:url('{$content_dir}themes/{$LEO_THEMENAME}/img/patterns/{$p}')" onclick="return false;" href="#" title="{$p}" id="{$p}" class="{if $LEO_PATTERN == $p}active{/if}">
                </a>
        {/foreach}
        <div class="clearfix"></div>
      </div>
      {/if}
      <div class="clearfix" id="bottombox">
        <input type="submit" name="usercustom" class="btn button btn-green" value="Apply" />
        <a href="{$content_dir}index.php?leoaction=reset" class="button btn">Reset</a></div>
      <div class="clearfix"></div>
    </div>
  </form>
</div>
<script type="text/javascript">
	$("#toolspanelcontent").animate( {ldelim}"left": -($("#toolspanelcontent").width()+7){rdelim} ).addClass("inactive");
	$("#toolspanel .pn-button").click(function(){ldelim} 
		if(  $("#toolspanelcontent").hasClass("inactive")  ){ldelim} 													 
			$("#toolspanelcontent").animate( {ldelim}"left": 0{rdelim} ).addClass("active").removeClass("inactive");
			$(this).removeClass("open").addClass("close");
		{rdelim}else {ldelim}
			$("#toolspanelcontent").animate( {ldelim}"left": -($("#toolspanelcontent").width()+7){rdelim} ).addClass("inactive").removeClass("active");
			$(this).removeClass("close").addClass("open");
		{rdelim}
	{rdelim}	);
	$("#pnpartterns a").click( function(){ldelim}   
			$("#pnpartterns a").removeClass("active");
			$(this).addClass("active");
 			  document.body.className = document.body.className.replace(/pattern\w*/,"");
			  $("body").addClass( $(this).attr("id").replace(/\.\w+$/,"")  );				
			$("#bgpattern").val( $(this).attr("id").replace(/\.\w+$/,"")  );
	{rdelim} );
</script>