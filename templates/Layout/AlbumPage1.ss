<h1>$MenuTitle</h1>
$Content
<% if AlbumPage_Images %>
    <div id="gallery_left">
        <ul id="thumbs">
            <% loop AlbumPage_Images %>
                <li><a href="$ImagePageLink" class="fancy_link" rel="fancy_group" data-id="$ID"><img src="$GetAlbumThumbURL" alt="$Alt" title="$Title" /></a></li>
            <% end_loop %>
        </ul><!--thumbs-->
        <div id="ajax_text">
            <!-- ajax title and desc here -->
        </div><!--ajax_text-->
    </div><!--gallery_left-->
    <div id="gallery_right"><img id="ajax-loader" src="/themes/mysite/css/images/ajax-loader.gif" width="25" height="25" />
        <div id="ajax_image">
            <!-- ajax image here -->
        </div><!--ajax_image-->
    </div><!--gallery_right-->
<% else %>
    <p>No images found in this gallery.</p>
<% end_if %>