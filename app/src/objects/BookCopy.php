<?php

namespace objects;

use pages\LibraryPage;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataObject;

use function PHPSTORM_META\map;

class BookCopy extends DataObject {

    private static $has_one = [
        'LibraryPage' => LibraryPage::class,
        'Book' => Book::class,
        'User' => User::class
    ];

    

    public function getCMSFields()
    {
        $copy_field = DropdownField::create(
            'BookID',
            'Title of a book',
            Book::get()->map('ID', 'Title')
        );
        
        if ($this->exists()) {
            $copy_field = LiteralField::create('BookTitle', 'Title of the book: <b>' . $this->Book()->Title . '</b>');
        }

        $fields = FieldList::create($copy_field);


        return $fields;
    }


    private static $summary_fields = [
        'ID' => "Copy ID",
        'Book.Title' => 'Book title'
    ];
};



?>