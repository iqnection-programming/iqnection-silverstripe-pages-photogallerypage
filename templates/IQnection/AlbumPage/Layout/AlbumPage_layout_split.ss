<h1>$Title</h1>
$Content
<% if $AlbumPageImages.Count %>
	<div class="split">
		<div id="gallery_left">
			<ul id="thumbs">
				<% loop $AlbumPageImages %>
					<li>
						<a href="$Link" class="album-image" rel="fancy_group" data-photo-id="$ID">
							<img src="$Thumbnail.URL" alt="$Alt" title="$Title" />
						</a>
						<div style="display:none;" class="photo-content">
							<% if $Title %><h3>$Title</h3><% end_if %>
							$Description
						</div>
					</li>
				<% end_loop %>
			</ul><!--thumbs-->
			<div id="image-text">
				<% with $AlbumPageImages.First %>
					<% if $Title %><h3>$Title</h3><% end_if %>
					$Description
				<% end_with %>
			</div><!--ajax_text-->
		</div><!--gallery_left-->
		<div id="gallery_right"><img id="ajax-loader" src="/iq-photogallerypage/images/ajax-loader.gif" width="25" height="25" />
			<div id="preview_image">
				<a href="javascript:;" data-photo-id="$AlbumPageImages.First.ID">
					<img src="$AlbumPageImages.First.LargeImage.URL" />
				</a>
			</div><!--ajax_image-->
		</div><!--gallery_right-->
	</div>
<% else %>
    <p>No images found in this gallery.</p>
<% end_if %>