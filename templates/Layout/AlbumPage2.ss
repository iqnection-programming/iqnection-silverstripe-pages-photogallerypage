<h1>$MenuTitle</h1>
$Content
<ul id="thumbs">
    <% if AlbumPage_Images %>
        <% loop AlbumPage_Images %>
            <li><a href="$ImagePageLink" class="fancy_link" rel="fancy_group"><img src="$GetAlbumThumbURL" alt="$Alt" title="$Title" /></a></li>
        <% end_loop %>
    <% else %>
        <li>No images found in this gallery.</li>
    <% end_if %>
</ul><!--thumbs-->