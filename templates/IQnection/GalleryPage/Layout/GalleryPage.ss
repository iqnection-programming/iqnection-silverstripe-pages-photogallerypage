<h1>$Title</h1>
$Content
<% if $Children.Count %>
    <ul id="gallery_thumbs">
        <% loop $Children %>
            <li>
				<% include GalleryPage_thumbnail %>
			</li>
        <% end_loop %>  
    </ul><!--gallery_thumbs-->
<% end_if %>