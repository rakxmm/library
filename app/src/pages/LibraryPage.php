<?php 

namespace pages;

use objects\Book;
use Page;
use objects\BookAuthor;
use objects\BookCopy;
use objects\Genre;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

use function PHPSTORM_META\map;

class LibraryPage extends Page 
{

    private static $allowed_children = [
        BookPage::class
    ];

    private static $has_many = [
        'Books' => Book::class,
        'Authors' => BookAuthor::class,
        'Genres' => Genre::class,
        'BookCopies' => BookCopy::class
    ];


    
}



?>