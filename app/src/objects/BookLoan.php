<?php


namespace objects;

use objects\User;
use objects\BookCopy;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
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

    public function getCMSFields()
    {   
        $fields = FieldList::create(
            DropdownField::create(
                'UserID',
                'Pass the user',
                User::get()->map('ID', 'FullName')
            ),
            SearchableDropdownField::create(
                'BookCopyID',
                'Pass the bookcopy',
                BookCopy::get()
            )->setLabelField('Title')
        );

        return $fields;
    }

    private static $summary_fields = [
        'User.Fullname' => "User's name",
        'BookCopy.Title' => "Title of the book",
        'hasExpired.Nice' => 'Has expired?'
    ];


    

};


?>