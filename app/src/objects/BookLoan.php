<?php

use objects\User;
use objects\BookCopy;
use SilverStripe\ORM\DataObject;

class BookLoan extends DataObject {


    private static $has_one = [
        'User' => User::class, 
        'BookCopy' => BookCopy::class
    ];


};


?>