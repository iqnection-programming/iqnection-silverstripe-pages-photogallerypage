<% control Photo %>
    <div id="photo_wrap" class="<% if NeedsContent %>shared<% else %>full<% end_if %>">
        <img id="photo" src="$GetBigURL" alt="$Alt" title="$Title" />
    </div><!--photo_wrap-->
    <% if NeedsContent %>
        <div id="content_wrap" class="typography">
            <div id="content_padding">
                <% if Title %><h3>$Title</h3><% end_if %>
                $Description
            </div><!--content_padding-->
        </div><!--content_wrap-->
    <% end_if %>
<% end_control %>