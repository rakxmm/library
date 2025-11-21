<?php


namespace objects;

use objects\User;
use objects\BookCopy;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\SearchableDropdownField;
use SilverStripe\ORM\DataObject;

class BookLoan extends DataObject {

    private static $db =
    [
        'hasExpired' => 'Boolean'
    ];

    private static $has_one = [
        'User' => User::class, 
        'BookCopy' => BookCopy::class
    ];


    public function onAfterWrite()
    {
        
        parent::onAfterWrite();
        
        $userID = $this->UserID;
        $bookCopy = $this->BookCopy();
        $bookCopy->UserID = $userID;
        $bookCopy->write();

    }

    public function getCMSFields()
    {   

        $fields = FieldList::create(
            SearchableDropdownField::create(
                'UserID',
                'Pass the user',
                User::get()
            )->setLabelField('FullName'),
            SearchableDropdownField::create(
                'BookCopyID',
                'Pass the bookcopy',
                BookCopy::get()
            )->setLabelField('Title'));

        return $fields;
     
    }

    public function canEdit($member = null)
    {
        // Ak už bol záznam uložený (existuje ID), zakáž editáciu
        if ($this->ID) {
            return false;
        }

        return parent::canEdit($member);
    }

    public function validate()
    {
        $result = parent::validate();

        if (!$this->BookCopyID) {
            $result->addError('BookCopy is required field!');
        } 
        if (!$this->UserID) {
            $result->addError('User is required field!');
        }

        return $result;

    }

    private static $summary_fields = [
        'User.Fullname' => "User's name",
        'BookCopy.Title' => "Title of the book",
        'hasExpired.Nice' => 'Has expired?'
    ];


    

};


?>