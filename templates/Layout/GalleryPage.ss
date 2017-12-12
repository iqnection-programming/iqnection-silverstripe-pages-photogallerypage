<h1>$Title</h1>
$Content
<% if $Children.Count %>
    <ul id="gallery_thumbs">
        <% loop $Children %>
            <li>
				<a href="$Link" $NavNoFollow>
					<% if $GalleryThumbnail.Exists %>
						<img src="$GalleryThumbnail.URL" alt="$Title">
					<% end_if %>
					<h4>$Title</h4>
				</a>
			</li>
        <% end_loop %>  
    </ul><!--gallery_thumbs-->
<% end_if %>