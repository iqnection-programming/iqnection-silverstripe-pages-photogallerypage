<h1>$Title</h1>
$Content

<% if $AlbumPageImages %>
	<ul class="album-thumbnails cols-{$LayoutColumns}">
		<% loop $AlbumPageImages %>
			<li>
				<% include AlbumPage_layout_individual_thumbnail %>
			</li>
		<% end_loop %>
	</ul><!--thumbs-->
<% else %>
	<p>No images found in this gallery.</p>
<% end_if %>