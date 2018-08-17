<h1>$Photo.Title</h1>
<div id="left">
    <a id="back" href="$AbsoluteLink">&larr; Back to Gallery</a>
</div><!--left-->
<div id="right">
    <p id="count">$Number of $Count</p>
</div><!--right-->
<div id="nav">
    <% if $PrevPhoto.Exists %><a id="prev" href="$PrevPhoto.Link">&larr; Previous</a><% end_if %>
    <% if $NextPhoto.Exists %><a id="next" href="$NextPhoto.Link">Next &rarr;</a><% end_if %>
</div><!--nav-->

<% with Photo %>
    <div id="photo_wrap" class="<% if $Title || $Description %>shared<% else %>full<% end_if %>">
        <img id="photo" src="$LargeImage.URL" alt="$Alt" title="$Title" />
    </div><!--photo_wrap-->
    <% if $Title || $Description %>
        <div id="content_wrap" class="typography">
            <div id="content_padding">
                <% if Title %><h3>$Title</h3><% end_if %>
                $Description
            </div><!--content_padding-->
        </div><!--content_wrap-->
    <% end_if %>
<% end_with %>
