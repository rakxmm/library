<?php

namespace objects;

use panels\LoanPanelReturnAction;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class User extends DataObject {

    private static $db = [
        'FullName' => 'Varchar',
        'Name' => 'Varchar',
        'Surname' => 'Varchar'
       
    ];

    private static $has_many = [
        'BookLoans'=>BookLoan::class
    ];

    public function onBeforeWrite() {
        parent::onBeforeWrite();
        $this->FullName = $this->Name . ' ' . $this->Surname;
    }

    public function getCMSFields() {   
        $fields = FieldList::create(TabSet::create('Root'));
        
        if ($this->isInDB()) {
            $fields->addFieldToTab('Root.Loans', $this->getLoansCMSFields());
        }
        $fields->addFieldsToTab('Root.Edit', $this->getEditCMSFields());

        return $fields;
    }

    private function getEditCMSFields() {
        $name_field = TextField::create(
                'Name',
                'First name'
        );

        $surname_field = TextField::create(
                'Surname',
                'Last name'
        );

        return [$name_field, $surname_field];
    } 

    private function getLoansCMSFields() {
        $gridfield = GridField::create(
            'BookLoans',
            "User's loans",
            $this->BookLoans(),
            GridFieldConfig_RecordEditor::create()
        )->setName('FullName');

        
        $gridfield->getConfig()->addComponent(new LoanPanelReturnAction());
            
        return $gridfield;
    }

    private static $summary_fields = [
        'ID' => "ID",
        'Name' => "Name",
        'Surname' => "Surname"
    ];

    public function canDelete($member = null)
    {
        return false;
    }



};



?>