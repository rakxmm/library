<?php


namespace objects;

use pages\LibraryPage;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class BookAuthor extends DataObject {

    private static $db = [
        'FirstName' => 'Varchar',
        'LastName' => 'Varchar',
    ];

    private static $has_many = [
        'Book' => Book::class
    ];

    private static $has_one = [
        'Library' => LibraryPage::class
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('FirstName', 'First name of the author'),
            TextField::create('LastName', 'Last name of the author')
        );
        return $fields;
        
    }

    public function getFullName() {
        return $this->FirstName . ' ' . $this->LastName;
    }

    private static $summary_fields =[
        'FirstName' => "First name",
        'LastName' => "Last name"
        
    ];

};


?>