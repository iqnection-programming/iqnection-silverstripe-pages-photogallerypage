<h1>$MenuTitle</h1>
<div id="left">
    <a id="back" href="$AbsoluteLink">&larr; Back to Gallery</a>
</div><!--left-->
<div id="right">
    <p id="count">$Number of $Count</p>
</div><!--right-->
<div id="nav">
    <a id="prev" href="{$AbsoluteLink}photo/$Prev">&larr; Previous</a>
    <a id="next" href="{$AbsoluteLink}photo/$Next">Next &rarr;</a>
</div><!--nav-->
<% include AlbumPage_PhotoArea %>

<script language="javascript" type="text/javascript">
(function($){
		
		$(document).ready(function(){
			$('#photo_wrap a').fancybox();
		});		
		
})(jQuery)
</script>