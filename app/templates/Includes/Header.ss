<header>
    <nav class="nav">
        <ul class="nav-list">
            <% loop $Menu(1) %>
            <li class="list-item">
                <a class="$LinkingMode" href="$Link">$MenuTitle</a>
            </li>
        <% end_loop %>
        </ul>
    </nav>
</header>