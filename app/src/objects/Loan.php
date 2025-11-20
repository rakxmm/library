<?php

namespace objects;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\GraphQL\Schema\Field\Field;
use SilverStripe\ORM\DataObject;

class Loan extends DataObject {

    private static $has_one = [
        'User' => User::class,
        'BookCopy' => BookCopy::class
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            DropdownField::create(
                'UserID', 
                'Choose the user',
                User::get()->map('ID', 'FullName')
            ),
            DropdownField::create(
                'BookCopyID',
                'Choose the copy',
                BookCopy::get()->map('ID', 'Title')
            )
        );

        return $fields;
    }

}


?>