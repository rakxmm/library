<% include BreadcrumbsItems %>
    <section class="book">
            <div class="book-image">
                <% if $Book.Cover %>
                    <img src="$Book.Cover.URL" alt="Name of the Wind - book coverage">
                <% else %>
                    <span class="image-not-found">{Image not found}</span>
                <% end_if %>
            </div>

            <div class="meta-group">
                <div class="book-title">
                    <% if $Book.Title %>
                        $Book.Title
                    <% else %>
                        {Title not found}
                    <% end_if %>
                </div>
                <div class="book-author">
                    Written by
                    
                    <% if $Book.AuthorFullName %>
                        $Book.AuthorFullName
                    <% else %>
                        {Author not found}
                    <% end_if %>
                </div>
                 
                <div class="book-genres">
                    <ul>
                        <% loop $Book.Genres %>
                            <li>
                                $Title
                            </li>
                        <% end_loop %>
                    </ul>
                </div>

                <div class="book-description">
                    
                    <% if $Book.Description %>
                        $Book.Description
                    <% else %>
                        {Description not found}
                    <% end_if %>
                </div>

                
                <div class="book-meta2">
                    <div>
                        <div class="book-date">
                            

                            <% if $Book.Date %>
                                $Book.Date
                            <% else %>
                                {PublishDate not found}
                            <% end_if %>
                        </div>
                        <div class="book-pages">
                            $Book.Pages pages
                        </div>
                    </div>

                    <div class="buttons">
                        <button class="book-borrow">
                            Borrow
                        </button>
                    </div>
                </div>
            </div>
            
        </section>