<h1>$Title</h1>
$Content
<% if Children %>
    <ul id="gallery_thumbs">
        <% loop Children %>
            <li><a href="$Link" $NavNoFollow><img src="$GalleryThumbnailURL" alt="$AlbumPage_Images.First.Alt" title="$Title"><h4>$Title</h4></a></li>
        <% end_loop %>  
    </ul><!--gallery_thumbs-->
<% end_if %>