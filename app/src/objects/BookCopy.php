<?php

namespace objects;

use pages\LibraryPage;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;

use function PHPSTORM_META\map;

class BookCopy extends DataObject {

    private static $db = [
        'ID_Title'=>'Varchar',
        'isBorrowed' => 'Boolean'
    ];

    private static $has_one = [
        'LibraryPage' => LibraryPage::class,
        'Book' => Book::class,
        'User' => User::class,
        
    ];

    public function onAfterWrite()
    {
        parent::onAfterWrite();
        $updated_title = '('. $this->ID . ') ' . Book::getTitleById($this->BookID);    
        if ($this->ID_Title != $updated_title) {
            $this->ID_Title = $updated_title;
            $this->write(false, false);
        }

    }

    public function validate()
    {
        return parent::validate();
    }

    public function getCMSFields() {
        $fields = FieldList::create(DropdownField::create(
            'BookID',
            'Title of a book',
            Book::get()->map('ID', 'Title')
        ));

        return $fields;
    }


    public function canEdit($member = null) {
        if ($this->ID) {
            return false;
        }
        return parent::canEdit($member);
    }


    private static $summary_fields = [
        'ID' => "Copy ID",
        'Book.Title' => 'Book title',
        'isBorrowed.Nice' => 'Is borrowed?',
        'User.FullName' =>'Borrowed by who?'
    ];

    public function setUser($userID) {
        $this->UserID = $userID;
        if ($this->UserID) {
            $this->isBorrowed = true;
        } else {
            $this->isBorrowed = false;
        }
        return $this;
    }

    public static function getBooksID($bookCopyID) {
        $bookcopy =  BookCopy::get()->byID($bookCopyID);

        return ($bookcopy && $bookcopy->exists()) ? $bookcopy->BookID : null;
    }

    



};



?>