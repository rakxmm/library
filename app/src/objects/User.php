<?php

namespace objects;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class User extends DataObject {

    private static $db = [
        'Name' => 'Varchar',
        'Surname' => 'Varchar'
    ];

    private static $has_many = [
        'Loan'=>BookLoan::class
    ];

    public function getFullName() {
        return $this->Name . ' ' . $this->Surname;
    } 

    public function getCMSFields()
    {   

        $name_field = TextField::create(
                'Name',
                'First name'
        );

        $surname_field = TextField::create(
                'Surname',
                'Last name'
        );

        $fields = FieldList::create(
            $name_field,
            $surname_field
        );
        
        return $fields;
    }

};



?>