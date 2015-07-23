<% with Photo %>
    <div id="photo_wrap" class="<% if NeedsContent %>shared<% else %>full<% end_if %>">
        <img id="photo" src="$GetBigImage.URL" alt="$Alt" title="$Title" style="width:{$GetDivWidth}px" />
    </div><!--photo_wrap-->
    <% if NeedsContent %>
        <div id="content_wrap" class="typography">
            <div id="content_padding">
                <% if Title %><h3>$Title</h3><% end_if %>
                $Description
            </div><!--content_padding-->
        </div><!--content_wrap-->
    <% end_if %>
<% end_with %>