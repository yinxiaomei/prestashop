<div class="navbar">
<div class="navbar-inner">
		<a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</a>
	<div class="nav-collapse collapse">
		{$leobootstrapmenu_menu_tree}
	</div>
</div>
</div>
<script type="text/javascript">
// <![CDATA[
    var currentURL = window.location;
    currentURL = String(currentURL);
    currentURL = currentURL.replace("https://","").replace("http://","").replace("www.","");

    $(".megamenu > li > a").each(function() {
        menuURL = $(this).attr("href").replace("https://","").replace("http://","").replace("www.","");
        if(currentURL == menuURL){
            $(this).parent().addClass("active");
            return false;
        }
    });
// ]]>
</script>