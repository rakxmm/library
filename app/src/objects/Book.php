<?php


namespace objects;

use pages\LibraryPage;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\SearchableDropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class Book extends DataObject {

    private static $db = [
        'Title' => 'Varchar',
        'Pages' => 'Int',
        'Date' => 'Date',
        'Description' => 'Text'
    ];

    private static $has_one = [
        'Library' => LibraryPage::class,
        'Author' => BookAuthor::class,
        'Cover' => Image::class
    ];

    private static $owns = [
        'Cover'
    ];

    private static $many_many = [
        'Genres' => Genre::class
    ];

    private static $summary_fields = [
        'Title' => 'Book Title',
        'AuthorFullName' => 'Author of the book',
        'Pages' => 'Number of pages'
    ];

    public function getAuthorFullName() {
        return $this->Author()->FullName;
    }




    public function getCMSFields()
    {   
      

        $fields = FieldList::create(
            TextField::create('Title', 'Book title'),
            NumericField::create('Pages', 'Number of pages'),
            DateField::create('Date', 'Date of publishing'),
            SearchableDropdownField::create('AuthorID', 'Author of the book')->setSource(BookAuthor::get())->setLabelField('FullName'),
            ListboxField::create('Genres', 'Genres of the book', Genre::get()->map('ID', 'Title')),
            TextareaField::create('Description'),
            $uploader = UploadField::create('Cover', 'Book cover (png / gif / jpeg / jpg)')
        );

        $uploader->setFolderName('book-covers');
        $uploader->getValidator()->setAllowedExtensions(['png','gif','jpeg','jpg']);

        return $fields;
    }

    
};



?>