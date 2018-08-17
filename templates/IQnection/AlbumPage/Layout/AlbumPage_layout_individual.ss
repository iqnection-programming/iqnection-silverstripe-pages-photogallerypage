<h1>$Title</h1>
$Content
<div class="indv">
	<ul id="thumbs">
		<% if $AlbumPageImages %>
			<% loop $AlbumPageImages %>
				<li>
					<a href="$Link" class="album-image" rel="fancy_group" data-photo-id="$ID">
						<img src="$Thumbnail.URL" alt="$Alt" title="$Title" />
					</a>
				</li>
			<% end_loop %>
		<% else %>
			<li>No images found in this gallery.</li>
		<% end_if %>
	</ul><!--thumbs-->
</div>