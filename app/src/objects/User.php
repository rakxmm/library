<?php

namespace objects;

use SilverStripe\ORM\DataObject;

class User extends DataObject {

    private static $db = [
        'Name' => 'Varchar',
        'Surname' => 'Varchar'
    ];

    private static $has_many = [
        'Book'=>Book::class
    ];

    public function getFullName() {
        return $this->Name . ' ' . $this->Surname;
    }

};



?>