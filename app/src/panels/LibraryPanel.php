<?php


namespace panels;

use objects\Book;
use objects\BookAuthor;
use objects\BookCopy;
use objects\Genre;
use SilverStripe\Admin\ModelAdmin;

class LibraryPanel extends ModelAdmin {

    private static $menu_title = 'Library Dashboard';

    private static $url_segment = 'library-dashboard';

    private static $managed_models = [
        Book::class,
        BookCopy::class,
        BookAuthor::class,
        Genre::class
    ];


}


?>