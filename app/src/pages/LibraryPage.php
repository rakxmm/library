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


    public function getCMSFields()
    {   
        $fields = parent::getCMSFields();

        $fields->addFieldToTab(
            'Root.Books',
            GridField::create(
                'Books',
                'Books in the library',
                $this->Books(),
                GridFieldConfig_RecordEditor::create()
            )
        );

        $fields->addFieldToTab(
            'Root.Authors',
            GridField::create(
                'Authors',
                'Authors',
                $this->Authors(),
                GridFieldConfig_RecordEditor::create()
            )
        );

        $fields->addFieldToTab(
            'Root.Genres',
            GridField::create(
                'Genres',
                'Genres',
                $this->Genres(),
                GridFieldConfig_RecordEditor::create()
            )
        );

        $fields->addFieldToTab(
            'Root.BookCopies',
            GridField::create(
                'BookCopies',
                'BookCopies',
                $this->BookCopies(),
                GridFieldConfig_RecordEditor::create()
            )
        );


        return $fields;
    }
}



?>