<% with Photo %>
    <% if NeedsContent(true) %>
        <div id="content_wrap" class="typography">
            <div id="content_padding">
               <% if Title %><h3>$Title</h3><% end_if %>
                $Description
                <% if FacebookImageLink %><p>View this photo on <a href="$FacebookImageLink" target="_blank">Facebook</a>!</p><% end_if %>
            </div><!--content_padding-->
        </div><!--content_wrap-->
    <% end_if %>
<% end_with %>