<?php

namespace objects;

use pages\LibraryPage;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataObject;

use function PHPSTORM_META\map;

class BookCopy extends DataObject {

    private static $db = [
        'isBorrowed' => 'Boolean'
    ];

    private static $has_one = [
        'LibraryPage' => LibraryPage::class,
        'Book' => Book::class,
        'User' => User::class,
        
    ];

    public function getTitle() {
        return $this->Book()->Title;
    }

    public function onBeforeWrite()
    {
    
        parent::onBeforeWrite();

        $user = $this->UserID;

        if ($user) {
            $this->isBorrowed = true;
        } else {
            $this->isBorrowed = false;
        }
    }
    

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
        'Book.Title' => 'Book title',
        'isBorrowed.Nice' => 'Is borrowed?'
    ];
};



?>