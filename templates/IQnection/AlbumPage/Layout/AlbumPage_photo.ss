<h1>$Photo.Title</h1>
<div class="album-return">
	<div><a href="$AbsoluteLink">&larr; Back to Gallery</a></div>
	<div class="album-count">$Number of $Count</div>
</div>

<nav class="album-nav">
	<ul>
	    <% if $PrevPhoto.Exists %><li><a href="$PrevPhoto.Link">&larr; Previous</a></li><% end_if %>
    	<% if $NextPhoto.Exists %><li><a href="$NextPhoto.Link">Next &rarr;</a></li><% end_if %>
	</ul>
</nav>

<% with Photo %>
    <div class="album-photo-container photo-<% if $Description %>shared<% else %>full<% end_if %>">
		<div class="album-photo-image">
	        <img src="$LargeImage.URL" alt="$Alt" title="$Title" />
		</div>
		<% if $Description %>
			<div class="album-photo-content typography">
				$Description
			</div>
		<% end_if %>
	</div>
<% end_with %>
