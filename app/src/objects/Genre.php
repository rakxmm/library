<?php 

namespace objects;

use pages\LibraryPage;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class Genre extends DataObject {

    private static $db = [
        'Title' => 'Varchar'
    ];

    private static $has_one = [
        'Library' => LibraryPage::class
    ];


    private static $belongs_many_many = [
        'Books' => Book::class
    ];


    private static $summary_fields = [
        'Title'
    ];

    public function validate()
    {
        $result = parent::validate();

        $existing = Genre::get()->filter(
            'Title', $this->Title
        )->exclude('ID', $this->ID);

        if ($existing->exists())
        {
            $result->addError('Genre already exists!');
        }

        return $result;
    }

    public function getCMSFields()
    {   
        $fields = FieldList::create(
            TextField::create('Title', 'Name of the genre')
        );
        return $fields;
    }

};
?>