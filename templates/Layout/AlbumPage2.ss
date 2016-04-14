<h1>$MenuTitle</h1>
$Content
<ul id="thumbs">
    <% if AlbumPage_Images %>
        <% loop AlbumPage_Images %>
            <li><a href="#photo_$ID" class="fancy_link" rel="fancy_group"><img src="$GetAlbumThumbURL" alt="$Alt" title="$Title" /></a>
                <div style="display:none;">
                    <div id="photo_$ID">
                        <div class="photo_wrap<% if NeedsContent %> shared<% else %> full<% end_if %>">
                            <img class="photo" src="$GetBigImage.URL" alt="$Alt" title="$Title" style="width:{$GetDivWidth}px" />
                        </div><!--photo_wrap-->
                        <% if NeedsContent %>
                            <div class="content_wrap typography">
                                <div class="content_padding">
                                    <% if Title %><h3>$Title</h3><% end_if %>
                                    $Description
                                </div><!--content_padding-->
                            </div><!--content_wrap-->
                        <% end_if %>
                    </div><!--photo_id-->
                </div><!--div display none-->
            </li>
        <% end_loop %>
    <% else %>
        <li>No images found in this gallery.</li>
    <% end_if %>
</ul><!--thumbs-->