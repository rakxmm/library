<?php 

namespace pages;

use objects\Book;

use Page;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\SearchableDropdownField;

class BookPage extends Page 
{
    
    
    private static $has_one = [
        'Book' => Book::class
    ];

    private static $can_be_root = false;
    
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

    public function getCMSFields()
    {   
        $fields = parent::getCMSFields();
        
        $fields->addFieldToTab(
            'Root.Main', 
            SearchableDropdownField::create(
                'BookID',
                'Book',
                Book::get()
            ),
            'Metadata'
            
        );

        $fields->removeFieldsFromTab('Root.Main',
            [   
                // 'Metadata',
                'MenuTitle',
                'Title',
                'Content',
                'URLSegment'
            ]
        );

        return $fields;
    }
}



?>