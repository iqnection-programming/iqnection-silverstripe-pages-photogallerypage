<h1>$Title</h1>

$Content

<% if $AlbumPageImages.Count %>
	<div class="album-split">
		<ul class="album-thumbnails album-split-left cols-{$LayoutColumns}">
			<% loop $AlbumPageImages %>
				<li>
					<a href="$Link" class="album-image" data-photo-id="$ID">
						<img src="$Thumbnail.URL" alt="$Alt" title="$Title" />
					</a>
					<div style="display:none;" class="photo-content">
						<% if $Title %><h3>$Title</h3><% end_if %>
						$Description
					</div>
				</li>
			<% end_loop %>
		</ul><!--thumbs-->

		<div class="album-split-right album-preview">
			<img id="ajax-loader" src="$resourceURL('iqnection-pages/photogallerypage:images/ajax-loader.gif')" width="25" height="25" />
			<div class="album-preview-image">
				<a href="javascript:;" data-photo-id="$AlbumPageImages.First.ID">
					<img src="$AlbumPageImages.First.LargeImage.URL" class="album-image-large" />
				</a>
			</div>
		</div>
		
		<div class="album-image-content album-split-left" id="album-image-content">
			<% with $AlbumPageImages.First %>
				<% if $Title %><h3>$Title</h3><% end_if %>
				$Description
			<% end_with %>
		</div>

	</div>
<% else %>
    <p>No images found in this gallery.</p>
<% end_if %>