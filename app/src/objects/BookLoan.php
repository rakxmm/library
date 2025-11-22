<?php


namespace objects;

use objects\User;
use objects\BookCopy;
use SebastianBergmann\Environment\Console;
use Sheadawson\DependentDropdown\Forms\DependentDropdownField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\SearchableDropdownField;
use SilverStripe\ORM\DataObject;

class BookLoan extends DataObject {


    private bool $canWrite = false;

    private static $db =
    [
        'hasExpired' => 'Boolean'
    ];

    private static $has_one = [
        'User' => User::class, 
        'BookCopy' => BookCopy::class
    ];


    public function setExpired($bool) {
        $this->hasExpired = $bool;
        return $this;
    }        

    public function onBeforeWrite()
    {
        
        parent::onBeforeWrite(); 
        
        $_first_time = $this->isInDB();
            
        if (!$_first_time) {
            $this->BookCopy()->setUser($this->UserID)->updateStatus()->write();
        } 
    }

    public function end() {
        $this->BookCopy()->resetUser()->updateStatus()->write();
        $this->setExpired(true)->write();
    }

    public function getCMSFields()
    {            
        

        $fields = FieldList::create(
            SearchableDropdownField::create(
                'UserID',
                'User',
                User::get()
            )->setLabelField('FullName'),
            SearchableDropdownField::create(
                'BookCopyID',
                'Book',
                BookCopy::get()->exclude(['isBorrowed'=>true])
            )->setLabelField('ID_Title')

        );

        if ($this->UserID) {
            $fields->replaceField('UserID', ReadonlyField::create(
                'UserID_FullName', 'User',  $this->User()->FullName
            ));
            
        }
        if ($this->BookCopyID) {
            $fields->replaceField('BookCopyID', ReadonlyField::create(
                'BookCopyID_ID', "Copy's ID",  $this->BookCopy()->ID_Title
            ));
        }

        return $fields;
    }

    public function canEdit($member = null) {
        if ($this->ID) {
            return false;
        }

        return parent::canEdit($member);
    }



    public function validate() {
        $result = parent::validate();
        
        $userID = $this->UserID;
        $bookCopyID = $this->BookCopyID;

        if (!$bookCopyID) {
            $result->addError('Book copy is a required field!');
        } 
        if (!$userID) {
            $result->addError('User is a required field!');
        }

        $bookCopy = BookCopy::get()->byID($bookCopyID);
        $bookID = $bookCopy ? $bookCopy->BookID : null;

        $copy = User::getBorrowedCopy($userID, $bookID);
        

        if ($copy && $copy->exists()) {

            $result->addError("User can't borrow a book with such ISBN!");
        }

        return $result;

    }

    private static $summary_fields = [
        'ID'=>'ID',
        'User.FullName' => "User's name",
        'BookCopy.ID_Title' => "Title of the book",
        'hasExpired.Nice' => 'Has expired?'
    ];

    public function canDelete($member = null)
    {
        return false;
    }

    

};


?>