<?php 

namespace pages;

use Exception;
use objects\Book;

use Page;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\SearchableDropdownField;


class BookPage extends Page 
{
    
    
    private static $has_one = [
        'Book' => Book::class
    ];

    private static $can_be_root = false;

    private static $allowed_children = [
        'none'
    ];
    
    protected function onBeforeWrite()
    {
         parent::onBeforeWrite();

        if ($this->Book()->exists()) {
            $this->Title = $this->Book()->Title;

            $link = explode(' ', $this->Title);
            $link = implode('-', $link);
            $this->URLSegment = $link;
        };

    }

    private static $allowed_parents = [
        LibraryPage::class
    ];

    

    public function getCMSFields()
    {   

        $fields = FieldList::create(
            SearchableDropdownField::create(
                'BookID',
                'Book',
                Book::get()
            )
            );

        return $fields;
    }

    public function validate()
    {
        $result = parent::validate();

        $existing = BookPage::get()->filter('BookID', $this->BookID)->exclude('ID', $this->ID);

        if ($existing->exists()) {
            $result->addError('Page with such book already exists!');
        }

        $parent = $this->Parent();
        if ($parent && ! $parent instanceof LibraryPage) {
            $result->addError('BookPage can be inserted only as child of LibraryPage!');
        }

        return $result;
    }
}



?>