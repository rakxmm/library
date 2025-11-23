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


    private static $db = [
        'hasExpired' => 'Boolean'
    ];

    private static $has_one = [
        'User' => User::class, 
        'BookCopy' => BookCopy::class
    ];      

    public function getCMSFields() {            
        

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

    // public function canEdit($member = null) {
    //     if ($this->ID) {
    //         return false;
    //     }

    //     return parent::canEdit($member);
    // }

    private static $summary_fields = [
        'ID'=>'ID',
        'User.FullName' => "User's name",
        'BookCopy.ID_Title' => "Title of the book",
        'hasExpired.Nice' => 'Has expired?'
    ];

    public function canDelete($member = null) {
        return false;
    }

    public function validate()
    {
        $res = parent::validate();

        if (!$this->UserID) {
            $res->addError('User field was not filled!');
        } 
        if (!$this->BookCopyID) {
            $res->addError('Book field was not filled!');
        } 
        


        

        if (!$this->isInDB()) {
            $bookID = BookCopy::getBooksID($this->BookCopyID);

            if (!$bookID) {
                return $res;
            }
            $already_borrowed = BookCopy::get()->filter([
                'UserID' => $this->UserID,
                'BookID' => $bookID,
                // 'hasExpired' => false // treba odkomentovat
            ])->exists() ? true : false; 

            if ($already_borrowed) {
                $res->addError('User has already such book borrowed!');
            }
        }

        

        return $res;
    }


    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        
        if (!$this->isInDB()) {
            $book = BookCopy::get()->byID($this->BookCopyID);
            if ($book && $book->exists()) {
                $book->setUser($this->UserID)->write();
            }
        }
    

    }



    public function end() {
        
        $copy = $this->BookCopy();
   
        $copy->setUser(null)->write();
        echo $this->hasExpired;
        
        $this->expire()->write();
    }

    private function expire() {
        $this->hasExpired = true;;
        return $this;
    }



    

};


?>